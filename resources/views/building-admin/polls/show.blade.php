@extends('building-admin.layout')

@section('content')
<div class="min-h-screen bg-background-light dark:bg-background-dark">
    <!-- Header -->
    <header class="sticky top-0 z-30 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-5 py-4">
        <div class="flex items-center justify-between max-w-4xl mx-auto">
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Poll Results</h1>
            <a href="{{ route('building-admin.polls.index') }}" class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">
                <span class="material-symbols-outlined">close</span>
            </a>
        </div>
    </header>

    <!-- Content -->
    <section class="px-5 py-8 max-w-4xl mx-auto">
        <!-- Poll Details -->
        <div class="bg-white dark:bg-surface-dark rounded-xl shadow-sm border border-slate-100 dark:border-slate-800 p-6 mb-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">{{ $poll->question }}</h2>
                    <p class="text-slate-600 dark:text-slate-400">{{ $poll->description }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold text-white {{ $poll->status_badge['color'] ?? 'bg-slate-500' }}">
                        {{ $poll->status_badge['text'] ?? 'Unknown' }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6 pt-6 border-t border-slate-100 dark:border-slate-700">
                <div>
                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Category</p>
                    <p class="text-lg font-bold text-slate-900 dark:text-white mt-1 capitalize">{{ $poll->category }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Starts</p>
                    <p class="text-lg font-bold text-slate-900 dark:text-white mt-1">{{ \Carbon\Carbon::parse($poll->start_date)->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Ends</p>
                    <p class="text-lg font-bold text-slate-900 dark:text-white mt-1">{{ \Carbon\Carbon::parse($poll->end_date)->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Created By</p>
                    <p class="text-lg font-bold text-slate-900 dark:text-white mt-1">{{ $poll->creator->name }}</p>
                </div>
            </div>
        </div>

        <!-- Participation Stats -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white dark:bg-surface-dark rounded-lg p-4 border border-slate-100 dark:border-slate-800">
                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Total Residents</p>
                <p class="text-2xl font-bold text-slate-900 dark:text-white mt-2">{{ $poll->total_residents }}</p>
            </div>
            <div class="bg-white dark:bg-surface-dark rounded-lg p-4 border border-slate-100 dark:border-slate-800">
                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Votes Received</p>
                <p class="text-2xl font-bold text-slate-900 dark:text-white mt-2">{{ $poll->total_votes }}</p>
            </div>
            <div class="bg-white dark:bg-surface-dark rounded-lg p-4 border border-slate-100 dark:border-slate-800">
                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Participation</p>
                <p class="text-2xl font-bold text-primary mt-2">{{ $poll->vote_percentage }}%</p>
            </div>
        </div>

        <!-- Results -->
        <div class="space-y-4 mb-6">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Voting Results</h3>
            
            @forelse($poll->options as $option)
                <div class="bg-white dark:bg-surface-dark rounded-lg p-5 border border-slate-100 dark:border-slate-800">
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="font-semibold text-slate-900 dark:text-white">{{ $option->option_text }}</h4>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-primary">{{ $option->vote_percentage }}%</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $option->vote_count }} votes</p>
                        </div>
                    </div>
                    <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-3 overflow-hidden">
                        <div class="bg-primary h-full rounded-full transition-all" style="width: {{ $option->vote_percentage }}%"></div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-700 block mb-2">info</span>
                    <p class="text-slate-500 dark:text-slate-400">No options available</p>
                </div>
            @endforelse
        </div>

        <!-- Actions -->
        <div class="flex gap-3">
            <a href="{{ route('building-admin.polls.index') }}" class="flex-1 px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-700 font-semibold transition-colors text-center">
                Back to Polls
            </a>
            @if(now() < \Carbon\Carbon::parse($poll->start_date))
                <a href="{{ route('building-admin.polls.edit', $poll->id) }}" class="flex-1 px-4 py-2.5 rounded-lg bg-slate-900 dark:bg-slate-700 text-white hover:bg-slate-800 dark:hover:bg-slate-600 font-semibold transition-colors text-center flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">edit</span>
                    Edit Poll
                </a>
            @endif
        </div>
    </section>
</div>
@endsection
