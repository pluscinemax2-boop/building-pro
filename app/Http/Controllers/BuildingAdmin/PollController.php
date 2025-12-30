<?php

namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\PollVote;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PollController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Poll::where('building_id', $user->building_id)->with('options', 'creator', 'votes');

        // Search
        if ($request->filled('search')) {
            $query->where('question', 'like', '%' . $request->search . '%');
        }

        // Tabs (status)
        $tab = $request->input('tab', 'active');
        $now = now();
        
        // Get all polls for stats calculation
        $allPolls = Poll::where('building_id', $user->building_id)->get();
        
        if ($tab === 'active') {
            $query->where('status', 'active')
                  ->where('start_date', '<=', $now)
                  ->where('end_date', '>=', $now);
        } elseif ($tab === 'scheduled') {
            $query->where('status', 'scheduled')
                  ->where('start_date', '>', $now);
        } elseif ($tab === 'expired') {
            $query->whereIn('status', ['expired', 'closed'])
                  ->where('end_date', '<', $now);
        }

        $polls = $query->orderByDesc('created_at')->get();

        // Compute stats for each poll
        foreach ($polls as $poll) {
            $poll->total_residents = $user->building->flats->count();
            $poll->total_votes = $poll->votes()->count();
            $poll->vote_percentage = $poll->total_residents > 0 
                ? round(($poll->total_votes / $poll->total_residents) * 100) 
                : 0;

            // Determine status badge
            $poll->status_badge = $this->getStatusBadge($poll);

            // Check if poll ends soon (within 3 days)
            $poll->ends_soon = Carbon::parse($poll->end_date)->diffInDays($now) <= 3 && Carbon::parse($poll->end_date) > $now;
        }

        // Tab counts
        $counts = [
            'active' => Poll::where('building_id', $user->building_id)
                           ->where('status', 'active')
                           ->where('start_date', '<=', $now)
                           ->where('end_date', '>=', $now)
                           ->count(),
            'scheduled' => Poll::where('building_id', $user->building_id)
                               ->where('status', 'scheduled')
                               ->where('start_date', '>', $now)
                               ->count(),
            'expired' => Poll::where('building_id', $user->building_id)
                            ->whereIn('status', ['expired', 'closed'])
                            ->where('end_date', '<', $now)
                            ->count(),
        ];

        // Calculate stats
        $totalResidents = $user->building->flats->count();
        
        // Average turnout from all completed polls
        $completedPolls = $allPolls->whereIn('status', ['expired', 'closed']);
        $avgTurnout = 0;
        if ($completedPolls->count() > 0) {
            $totalTurnout = 0;
            foreach ($completedPolls as $poll) {
                $pollVotes = $poll->votes()->count();
                $turnout = $totalResidents > 0 ? round(($pollVotes / $totalResidents) * 100) : 0;
                $totalTurnout += $turnout;
            }
            $avgTurnout = round($totalTurnout / $completedPolls->count());
        }
        
        // Votes this month
        $thisMonth = now()->startOfMonth();
        $votesThisMonth = \App\Models\PollVote::whereIn(
            'poll_id',
            $allPolls->pluck('id')
        )->where('created_at', '>=', $thisMonth)->count();
        
        // Turnout trend (compare with previous month)
        $prevMonth = now()->subMonth()->startOfMonth();
        $prevMonthEnd = now()->subMonth()->endOfMonth();
        $votesPrevMonth = \App\Models\PollVote::whereIn(
            'poll_id',
            $allPolls->pluck('id')
        )->whereBetween('created_at', [$prevMonth, $prevMonthEnd])->count();
        
        $turnoutTrend = $votesPrevMonth > 0 ? round((($votesThisMonth - $votesPrevMonth) / $votesPrevMonth) * 100) : 0;

        // Get latest closed polls for recent results section
        $recentResults = Poll::where('building_id', $user->building_id)
                            ->whereIn('status', ['expired', 'closed'])
                            ->orderByDesc('end_date')
                            ->get();
        
        // Add vote stats to recent results
        foreach ($recentResults as $result) {
            $result->total_residents = $totalResidents;
            $result->total_votes = $result->votes()->count();
            $result->vote_percentage = $totalResidents > 0 
                ? round(($result->total_votes / $totalResidents) * 100) 
                : 0;
        }

        return view('building-admin.polls.index', compact('polls', 'counts', 'tab', 'avgTurnout', 'votesThisMonth', 'turnoutTrend', 'recentResults'));
    }

    public function create()
    {
        return view('building-admin.polls.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|in:maintenance,amenity,general,other',
            'options' => 'required|array|min:2|max:6',
            'options.*' => 'required|string|max:255|distinct',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Auto-determine status based on dates
        $now = now();
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        
        if ($startDate <= $now && $endDate >= $now) {
            $status = 'active';
        } elseif ($startDate > $now) {
            $status = 'scheduled';
        } else {
            $status = 'expired';
        }

        $poll = Poll::create([
            'question' => $request->question,
            'description' => $request->description,
            'category' => $request->category,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $status,
            'created_by' => Auth::user()->id,
            'building_id' => Auth::user()->building_id,
        ]);

        foreach ($request->options as $option) {
            $poll->options()->create(['option_text' => $option]);
        }

        return redirect()->route('building-admin.polls.index')->with('success', 'Poll created successfully!');
    }

    public function show($id)
    {
        $user = Auth::user();
        $poll = Poll::where('building_id', $user->building_id)->findOrFail($id);
        $poll->load('options.votes');

        // Compute stats
        $poll->total_residents = $user->building->flats->count();
        $poll->total_votes = $poll->votes()->count();
        $poll->vote_percentage = $poll->total_residents > 0 
            ? round(($poll->total_votes / $poll->total_residents) * 100) 
            : 0;

        // Get voting results for each option
        foreach ($poll->options as $option) {
            $option->vote_count = $option->votes()->count();
            $option->vote_percentage = $poll->total_votes > 0 
                ? round(($option->vote_count / $poll->total_votes) * 100) 
                : 0;
        }

        return view('building-admin.polls.show', compact('poll'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $poll = Poll::where('building_id', $user->building_id)->findOrFail($id);
        return view('building-admin.polls.edit', compact('poll'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $poll = Poll::where('building_id', $user->building_id)->findOrFail($id);

        $request->validate([
            'question' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|in:maintenance,amenity,general,other',
            'options' => 'required|array|min:2|max:6',
            'options.*' => 'required|string|max:255|distinct',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:scheduled,active,closed',
        ]);

        $poll->update([
            'question' => $request->question,
            'description' => $request->description,
            'category' => $request->category,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        // Update options
        $poll->options()->delete();
        foreach ($request->options as $option) {
            $poll->options()->create(['option_text' => $option]);
        }

        return redirect()->route('building-admin.polls.index')->with('success', 'Poll updated successfully!');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $poll = Poll::where('building_id', $user->building_id)->findOrFail($id);
        $poll->delete();

        return redirect()->route('building-admin.polls.index')->with('success', 'Poll deleted successfully!');
    }

    private function getStatusBadge(Poll $poll)
    {
        $now = now();
        if ($poll->status === 'closed' || Carbon::parse($poll->end_date) < $now) {
            return ['text' => 'Closed', 'color' => 'bg-gray-500'];
        } elseif (Carbon::parse($poll->start_date) > $now) {
            return ['text' => 'Scheduled', 'color' => 'bg-orange-500'];
        } else {
            return ['text' => 'Active', 'color' => 'bg-green-500'];
        }
    }
}

