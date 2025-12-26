<?php

namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\PollVote;

class PollController extends Controller
{
    public function index()
    {
        $polls = Poll::with('options')->latest()->paginate(10);
        return view('building-admin.polls.index', compact('polls'));
    }

    public function create()
    {
        return view('building-admin.polls.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:255',
            'expires_at' => 'nullable|date|after:now',
        ]);
        $poll = Poll::create([
            'question' => $request->question,
            'expires_at' => $request->expires_at,
        ]);
        foreach ($request->options as $option) {
            $poll->options()->create(['option_text' => $option]);
        }
        return redirect()->route('building-admin.polls.index')->with('success', 'Poll created successfully.');
    }

    public function show($id)
    {
        $poll = Poll::with('options.votes')->findOrFail($id);
        return view('building-admin.polls.show', compact('poll'));
    }
}
