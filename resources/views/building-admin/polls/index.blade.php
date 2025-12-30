@extends('building-admin.layout')

@section('content')
<div class="min-h-screen bg-background-light dark:bg-background-dark pb-8">
    <!-- Header -->
    <header class="sticky top-0 z-30 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-5 py-4 mb-6">
        <div class="flex items-center justify-between max-w-6xl mx-auto">
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Voting & Polls</h1>
            <a href="{{ route('building-admin.polls.create') }}" class="flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-full hover:bg-blue-600 active:scale-95 transition-all shadow-md shadow-primary/20">
                <span class="material-symbols-outlined text-[20px]">add</span>
                <span class="text-sm font-bold">New Poll</span>
            </a>
        </div>
    </header>

    <div class="max-w-6xl mx-auto px-5">
        <!-- Quick Stats Summary -->
        <section class="mb-8">
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl shadow-[0_2px_8px_-2px_rgba(0,0,0,0.05)] border border-slate-100 dark:border-slate-800 flex flex-col gap-2">
                    <span class="text-slate-500 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider">Avg. Turnout</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight">{{ $avgTurnout ?? 0 }}%</span>
                        <span class="text-xs font-bold {{ $turnoutTrend >= 0 ? 'text-emerald-600 bg-emerald-100 dark:bg-emerald-900/40 dark:text-emerald-400' : 'text-red-600 bg-red-100 dark:bg-red-900/40 dark:text-red-400' }} px-1.5 py-0.5 rounded-md flex items-center">
                            <span class="material-symbols-outlined text-[12px] mr-0.5">{{ $turnoutTrend >= 0 ? 'trending_up' : 'trending_down' }}</span> {{ abs($turnoutTrend ?? 0) }}%
                        </span>
                    </div>
                </div>
                <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl shadow-[0_2px_8px_-2px_rgba(0,0,0,0.05)] border border-slate-100 dark:border-slate-800 flex flex-col gap-2">
                    <span class="text-slate-500 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider">Votes This Month</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight">{{ $votesThisMonth ?? 0 }}</span>
                        <span class="text-xs font-medium text-slate-400 dark:text-slate-500">residents</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Segmented Control Tabs -->
        <nav class="mb-6">
            <div class="flex p-1 bg-slate-200/60 dark:bg-surface-dark border border-slate-200 dark:border-slate-700 rounded-xl gap-1">
                <a href="{{ route('building-admin.polls.index', ['tab' => 'active']) }}" class="flex-1 py-2 px-3 rounded-lg {{ $tab === 'active' ? 'bg-white dark:bg-slate-700 text-primary dark:text-white shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200' }} text-sm font-bold transition-all text-center">
                    Active ({{ $counts['active'] ?? 0 }})
                </a>
                <a href="{{ route('building-admin.polls.index', ['tab' => 'scheduled']) }}" class="flex-1 py-2 px-3 rounded-lg {{ $tab === 'scheduled' ? 'bg-white dark:bg-slate-700 text-primary dark:text-white shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200' }} text-sm font-bold transition-all text-center">
                    Scheduled ({{ $counts['scheduled'] ?? 0 }})
                </a>
                <a href="{{ route('building-admin.polls.index', ['tab' => 'expired']) }}" class="flex-1 py-2 px-3 rounded-lg {{ $tab === 'expired' ? 'bg-white dark:bg-slate-700 text-primary dark:text-white shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200' }} text-sm font-bold transition-all text-center">
                    Past ({{ $counts['expired'] ?? 0 }})
                </a>
            </div>
        </nav>

        <!-- Active Polls Section -->
        @if($tab === 'active' || !isset($tab))
            <section class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Active Polls</h3>
                    @if($polls->where('status', 'active')->count() > 3)
                        <a href="{{ route('building-admin.polls.index', ['tab' => 'active']) }}" class="text-xs font-semibold text-primary hover:underline">View All</a>
                    @endif
                </div>
                
                @if($polls->where('status', 'active')->count() > 0)
                    <div class="space-y-3">
                        @foreach($polls->where('status', 'active')->take(3) as $poll)
                            <article class="bg-white dark:bg-surface-dark rounded-2xl p-5 shadow-[0_4px_12px_-4px_rgba(0,0,0,0.05)] border border-slate-100 dark:border-slate-700 relative overflow-hidden group hover:border-primary/30 transition-colors">
                                <div class="absolute top-0 left-0 w-1.5 h-full {{ $poll->ends_soon ? 'bg-amber-500' : 'bg-primary' }}"></div>
                                
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex gap-3">
                                        <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-primary shrink-0">
                                            <span class="material-symbols-outlined text-[24px]">{{ 
                                                $poll->category === 'maintenance' ? 'build' :
                                                ($poll->category === 'amenity' ? 'apartment' :
                                                ($poll->category === 'general' ? 'comment' : 'help'))
                                            }}</span>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-slate-900 dark:text-white text-base leading-tight">{{ $poll->question }}</h4>
                                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Ends {{ \Carbon\Carbon::parse($poll->end_date)->format('M d') }} • {{ ucfirst($poll->category) }}</p>
                                        </div>
                                    </div>
                                    @if($poll->ends_soon)
                                        <span class="bg-amber-50 text-amber-700 border border-amber-100 dark:border-amber-900 dark:bg-amber-900/40 dark:text-amber-400 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">Ends Soon</span>
                                    @else
                                        <span class="bg-emerald-50 text-emerald-700 border border-emerald-100 dark:border-emerald-900 dark:bg-emerald-900/20 dark:text-emerald-400 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">Active</span>
                                    @endif
                                </div>
                                
                                <div class="mt-5">
                                    <div class="flex justify-between text-xs font-semibold mb-2">
                                        <span class="text-slate-600 dark:text-slate-300">{{ $poll->total_votes }}/{{ $poll->total_residents }} Residents Voted</span>
                                        <span class="text-primary">{{ $poll->vote_percentage }}%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-2.5 overflow-hidden">
                                        <div class="bg-primary h-full rounded-full transition-all duration-500 ease-out" style="width: {{ $poll->vote_percentage }}%"></div>
                                    </div>
                                </div>
                                
                                <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 flex justify-between items-center">
                                    <div class="flex -space-x-2">
                                        @foreach($poll->votes()->limit(3)->get() as $voter)
                                            <div class="w-6 h-6 rounded-full bg-blue-200 border-2 border-white dark:border-surface-dark flex items-center justify-center text-[8px] font-bold text-blue-600">
                                                {{ substr($voter->user->name ?? 'U', 0, 1) }}
                                            </div>
                                        @endforeach
                                        @if($poll->total_votes > 3)
                                            <div class="w-6 h-6 rounded-full bg-slate-100 border-2 border-white dark:border-surface-dark flex items-center justify-center text-[8px] text-slate-400 font-bold">+{{ $poll->total_votes - 3 }}</div>
                                        @endif
                                    </div>
                                    <a href="{{ route('building-admin.polls.show', $poll->id) }}" class="text-sm font-bold text-primary hover:text-blue-700 dark:hover:text-blue-400 flex items-center gap-1">
                                        View <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 bg-white dark:bg-surface-dark rounded-xl border border-slate-100 dark:border-slate-800">
                        <span class="material-symbols-outlined text-5xl text-slate-300 dark:text-slate-700 block mb-2">how_to_vote</span>
                        <p class="text-slate-500 dark:text-slate-400">No active polls at the moment</p>
                    </div>
                @endif
            </section>
        @endif

        <!-- Scheduled Polls Section -->
        @if($tab === 'scheduled')
            <section class="mb-8">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Scheduled Polls</h3>
                
                @if($polls->where('status', 'scheduled')->count() > 0)
                    <div class="space-y-3">
                        @foreach($polls->where('status', 'scheduled') as $poll)
                            <article class="bg-white dark:bg-surface-dark rounded-xl p-5 shadow-sm border border-slate-100 dark:border-slate-800 hover:shadow-md transition-all">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex gap-3 flex-1">
                                        <div class="w-12 h-12 rounded-lg bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-600 dark:text-orange-400 shrink-0">
                                            <span class="material-symbols-outlined">schedule</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-bold text-slate-900 dark:text-white truncate">{{ $poll->question }}</h3>
                                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Starts {{ \Carbon\Carbon::parse($poll->start_date)->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <span class="text-xs font-bold px-3 py-1 rounded-full bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400">Scheduled</span>
                                </div>
                                <div class="flex gap-2 pt-2">
                                    <a href="{{ route('building-admin.polls.show', $poll->id) }}" class="flex-1 px-3 py-2 text-xs font-semibold text-primary hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg">
                                        View
                                    </a>
                                    <a href="{{ route('building-admin.polls.edit', $poll->id) }}" class="px-3 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg">
                                        <span class="material-symbols-outlined text-[16px]">edit</span>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 bg-white dark:bg-surface-dark rounded-xl border border-slate-100 dark:border-slate-800">
                        <span class="material-symbols-outlined text-5xl text-slate-300 dark:text-slate-700 block mb-2">schedule</span>
                        <p class="text-slate-500 dark:text-slate-400">No scheduled polls</p>
                    </div>
                @endif
            </section>
        @endif

        <!-- Expired/Past Polls Section -->
        @if($tab === 'expired')
            <section class="mb-8">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Past Polls</h3>
                
                @if($polls->whereIn('status', ['expired', 'closed'])->count() > 0)
                    <div class="space-y-3">
                        @foreach($polls->whereIn('status', ['expired', 'closed']) as $poll)
                            <article class="bg-white dark:bg-surface-dark rounded-xl p-5 shadow-sm border border-slate-100 dark:border-slate-800 hover:shadow-md transition-all">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex gap-3 flex-1">
                                        <div class="w-12 h-12 rounded-lg bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-400 shrink-0">
                                            <span class="material-symbols-outlined">how_to_vote</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-bold text-slate-900 dark:text-white truncate">{{ $poll->question }}</h3>
                                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Ended {{ \Carbon\Carbon::parse($poll->end_date)->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <span class="text-xs font-bold px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-900/30 text-gray-700 dark:text-gray-400">Closed</span>
                                </div>
                                <a href="{{ route('building-admin.polls.show', $poll->id) }}" class="inline-block px-3 py-2 text-xs font-semibold text-primary hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg">
                                    View Results
                                </a>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 bg-white dark:bg-surface-dark rounded-xl border border-slate-100 dark:border-slate-800">
                        <span class="material-symbols-outlined text-5xl text-slate-300 dark:text-slate-700 block mb-2">archive</span>
                        <p class="text-slate-500 dark:text-slate-400">No past polls yet</p>
                    </div>
                @endif
            </section>
        @endif

        <!-- Recent Results Section (always visible) -->
        @if($recentResults->count() > 0)
            <section class="pt-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Recent Results</h3>
                    @if($recentResults->count() > 5)
                        <a href="{{ route('building-admin.polls.index', ['tab' => 'expired']) }}" class="text-xs font-semibold text-primary hover:underline">View All</a>
                    @endif
                </div>
                <div class="space-y-3">
                    @foreach($recentResults->take(5) as $poll)
                        <div class="bg-white dark:bg-surface-dark rounded-xl p-5 shadow-[0_2px_8px_-2px_rgba(0,0,0,0.05)] border border-slate-100 dark:border-slate-700 flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full {{ $poll->total_votes >= ($poll->total_residents / 2) ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400' : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400' }} flex items-center justify-center shrink-0 border-2 {{ $poll->total_votes >= ($poll->total_residents / 2) ? 'border-emerald-100 dark:border-emerald-800' : 'border-slate-200 dark:border-slate-600' }}">
                                <span class="material-symbols-outlined">{{ $poll->total_votes >= ($poll->total_residents / 2) ? 'check' : 'close' }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-slate-900 dark:text-white text-sm truncate">{{ $poll->question }}</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Ended {{ \Carbon\Carbon::parse($poll->end_date)->format('M d, Y') }} • {{ $poll->total_votes >= ($poll->total_residents / 2) ? 'Passed' : 'Not Passed' }}</p>
                                <div class="flex mt-2.5 h-2 w-full rounded-full overflow-hidden gap-0.5">
                                    <div class="bg-emerald-500 rounded-full transition-all" style="width: {{ $poll->vote_percentage }}%"></div>
                                    <div class="bg-slate-200 dark:bg-slate-700 rounded-full" style="width: {{ 100 - $poll->vote_percentage }}%"></div>
                                </div>
                                <div class="flex justify-between text-[10px] mt-1.5 font-medium text-slate-500 dark:text-slate-400">
                                    <span>{{ $poll->vote_percentage }}% Voted</span>
                                    <span>{{ 100 - $poll->vote_percentage }}% Not Voted</span>
                                </div>
                            </div>
                            <div class="shrink-0 text-right pl-2">
                                <span class="block text-xl font-bold text-slate-900 dark:text-white">{{ $poll->vote_percentage }}%</span>
                                <span class="text-[10px] {{ $poll->total_votes >= ($poll->total_residents / 2) ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-400' }} font-bold uppercase tracking-wide">{{ $poll->total_votes >= ($poll->total_residents / 2) ? 'Passed' : 'Closed' }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</div>

<script>
function deletePoll(pollId) {
    if (confirm('Are you sure you want to delete this poll?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/building-admin/polls/${pollId}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
