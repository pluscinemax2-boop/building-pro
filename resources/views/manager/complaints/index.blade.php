@extends('manager.layout')

@section('title', 'Complaints - Manager')

@section('content')
<div class="p-4">
    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 border border-green-200 rounded-lg text-green-700 flex items-center">
        <span class="material-symbols-outlined mr-2">check_circle</span>{{ session('success') }}
    </div>
    @endif

    <!-- Search Bar -->
    <div class="mb-4">
        <form method="GET" action="{{ route('manager.complaints.index') }}">
            <label class="flex flex-col h-11 w-full">
                <div class="flex w-full flex-1 items-stretch rounded-xl h-full shadow-sm">
                    <div class="text-[#617589] dark:text-gray-400 flex border-none bg-gray-100 dark:bg-gray-800 items-center justify-center pl-4 rounded-l-xl border-r-0">
                        <span class="material-symbols-outlined" style="font-size: 20px;">search</span>
                    </div>
                    <input name="search" value="{{ request('search') }}" class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111418] dark:text-white focus:outline-0 focus:ring-0 border-none bg-gray-100 dark:bg-gray-800 focus:border-none h-full placeholder:text-[#617589] dark:placeholder:text-gray-500 px-3 rounded-l-none border-l-0 text-sm font-medium leading-normal transition-all" placeholder="Search unit, issue, or tenant name" />
                </div>
            </label>
        </form>
    </div>

    <!-- Summary Stats -->
    <div class="mb-4">
        <div class="grid grid-cols-3 gap-3">
            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <p class="text-[#617589] dark:text-gray-400 text-xs font-medium uppercase tracking-wider mb-1 flex items-center gap-1">
                    <span class="inline-block w-2 h-2 rounded-full bg-red-500"></span> Pending
                </p>
                <div class="flex items-baseline gap-1">
                    <span class="text-2xl font-bold text-red-600">{{ $stats['open'] ?? 0 }}</span>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <p class="text-[#617589] dark:text-gray-400 text-xs font-medium uppercase tracking-wider mb-1 flex items-center gap-1">
                    <span class="inline-block w-2 h-2 rounded-full bg-blue-500"></span> In Progress
                </p>
                <div class="flex items-baseline gap-1">
                    <span class="text-2xl font-bold text-blue-600">{{ $stats['in_progress'] ?? 0 }}</span>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <p class="text-[#617589] dark:text-gray-400 text-xs font-medium uppercase tracking-wider mb-1 flex items-center gap-1">
                    <span class="inline-block w-2 h-2 rounded-full bg-green-500"></span> Resolved
                </p>
                <div class="flex items-baseline gap-1">
                    <span class="text-2xl font-bold text-green-600">{{ $stats['resolved'] ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Complaints List -->
    <div class="flex flex-col gap-3">
        @forelse($complaints as $complaint)
        <div class="flex flex-col gap-4 mb-3 rounded-2xl bg-white dark:bg-gray-800 p-4 border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="flex items-start gap-3">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        @if($complaint->priority === 'High')
                            <span class="inline-flex items-center rounded-md bg-red-50 dark:bg-red-900/30 px-2 py-1 text-xs font-medium text-red-700 dark:text-red-400 ring-1 ring-inset ring-red-600/10">High Priority</span>
                        @elseif($complaint->priority === 'Medium')
                            <span class="inline-flex items-center rounded-md bg-yellow-50 dark:bg-yellow-900/30 px-2 py-1 text-xs font-medium text-yellow-800 dark:text-yellow-400 ring-1 ring-inset ring-yellow-600/20">Medium Priority</span>
                        @else
                            <span class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-900/30 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20">Low Priority</span>
                        @endif
                        @if($complaint->status === 'Open')
                            <span class="inline-flex items-center rounded-md bg-red-50 dark:bg-red-900/30 px-2 py-1 text-xs font-medium text-red-700 dark:text-red-400 ring-1 ring-inset ring-red-600/10 ml-2">Open</span>
                        @elseif($complaint->status === 'In Progress')
                            <span class="inline-flex items-center rounded-md bg-blue-50 dark:bg-blue-900/30 px-2 py-1 text-xs font-medium text-blue-700 dark:text-blue-400 ring-1 ring-inset ring-blue-700/10 ml-2">In Progress</span>
                        @elseif($complaint->status === 'Resolved')
                            <span class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-900/30 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20 ml-2">Resolved</span>
                        @else
                            <span class="inline-flex items-center rounded-md bg-yellow-50 dark:bg-yellow-900/30 px-2 py-1 text-xs font-medium text-yellow-800 dark:text-yellow-400 ring-1 ring-inset ring-yellow-600/20 ml-2">{{ $complaint->status }}</span>
                        @endif
                        <span class="text-xs text-[#617589] dark:text-gray-400">• {{ $complaint->created_at->diffForHumans() }}</span>
                    </div>
                    <a href="{{ route('manager.complaints.show', $complaint->id) }}" class="text-[#111418] dark:text-white text-base font-bold leading-tight mb-1 hover:underline">
                        {{ $complaint->flat->flat_number ?? '-' }} - {{ $complaint->title }}
                    </a>
                    @php
                        $words = str_word_count(strip_tags($complaint->description), 1);
                        $descShort = implode(' ', array_slice($words, 0, 11));
                        $descLong = implode(' ', $words);
                        $isLong = count($words) > 11;
                    @endphp
                        <div class="mt-1">
                            <span class="text-[#617589] dark:text-gray-400 text-sm font-normal">
                                @if($isLong)
                                    <span>{{ $descShort }}...</span>
                                    <a href="{{ route('manager.complaints.show', $complaint->id) }}" class="text-primary font-semibold ml-2 hover:underline">View More</a>
                                @else
                                    <span>{{ $descShort }}</span>
                                @endif
                            </span>
                        </div>
                </div>
                @if($complaint->image)
                    <div class="shrink-0 w-20 h-20 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                        <img src="{{ asset('storage/' . $complaint->image) }}" alt="Complaint Image" class="object-cover object-center w-full h-full" />
                    </div>
                @endif
            </div>
            <div class="flex items-center justify-between pt-3 border-t border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <div class="h-6 w-6 rounded-full bg-gray-200 dark:bg-gray-600 overflow-hidden flex items-center justify-center">
                        <span class="text-xs font-bold text-[#111418] dark:text-white">{{ $complaint->resident->name[0] ?? '?' }}</span>
                    </div>
                    <span class="text-xs font-medium text-[#617589] dark:text-gray-400">{{ $complaint->resident->name ?? '-' }}</span>
                </div>
                @if($complaint->status !== 'Resolved')
                    <form method="POST" action="{{ route('manager.complaints.update-status', $complaint->id) }}" class="flex items-center gap-2">
                        @csrf
                        <div class="relative flex items-center">
                            <select name="status" class="appearance-none rounded-md h-10 pl-4 pr-10 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-sm font-semibold text-[#111418] dark:text-white focus:ring-2 focus:ring-primary focus:border-primary transition-all shadow-sm min-w-[120px]" onchange="this.form.submit()">
                                @if($complaint->status == 'Open')
                                    <option value="In Progress">In Progress</option>
                                    <option value="Resolved">Resolved</option>
                                @elseif($complaint->status == 'In Progress')
                                    <option value="Resolved">Resolved</option>
                                @endif
                            </select>
                            <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 material-symbols-outlined text-base">expand_more</span>
                        </div>
                    </form>
                @else
                    <span class="inline-flex items-center rounded-md bg-gray-200 dark:bg-gray-700 px-3 py-1 text-xs font-medium text-gray-500 dark:text-gray-400">Resolved</span>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-500">
            <span class="material-symbols-outlined text-4xl mb-2">inbox</span>
            <p>No complaints to display</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
