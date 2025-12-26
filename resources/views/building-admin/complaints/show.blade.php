@extends('building-admin.layout')

@section('content')
<div class="max-w-xl mx-auto bg-white dark:bg-background-dark shadow-xl rounded-xl p-6 mt-8">
    <div class="flex items-center gap-2 mb-4">
        <a href="{{ route('building-admin.complaints.index') }}" class="text-text-primary dark:text-white flex size-10 shrink-0 items-center justify-center rounded-full hover:bg-neutral-100 dark:hover:bg-gray-800 transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h2 class="text-xl font-bold text-text-primary dark:text-white">Complaint Details</h2>
    </div>
    <div class="mb-4">
        <div class="flex items-center gap-2 mb-2">
        @if($complaint->image)
                <div class="mb-4" style="display: flex; justify-content: center; width: 100%;">
                    <img src="{{ asset('storage/' . $complaint->image) }}" alt="Complaint Image" class="rounded-xl border border-gray-200 dark:border-gray-700 object-cover" style="width: 360px; height: 180px; display: block; margin: 0 auto;" />
                </div>
        @endif
        </div>
        <div class="flex items-center gap-2 mb-2">
        <span class="text-base font-bold text-text-primary dark:text-white block mb-2">{{ $complaint->flat->flat_number ?? '-' }} - {{ $complaint->title }}</span>
            @if($complaint->priority)
                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ml-2
                    @if($complaint->priority === 'High') bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400 ring-red-600/10
                    @elseif($complaint->priority === 'Medium') bg-yellow-50 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 ring-yellow-600/20
                    @else bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400 ring-green-600/20 @endif
                    ring-1 ring-inset">
                    {{ $complaint->priority }} Priority
                </span>
            @endif
            <span class="text-xs text-text-secondary dark:text-gray-400">• {{ $complaint->created_at->diffForHumans() }}</span>
        </div>
        <div class="mb-2">
            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ml-0
                @if($complaint->status === 'Open') bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400 ring-red-600/10
                @elseif($complaint->status === 'In Progress') bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 ring-blue-700/10
                @elseif($complaint->status === 'Resolved') bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400 ring-green-600/20
                @else bg-yellow-50 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 ring-yellow-600/20 @endif
                ring-1 ring-inset">
                {{ $complaint->status }}
            </span>
        </div>
        <div class="text-sm text-text-secondary dark:text-gray-400 mb-4">
            <span class="font-semibold">Flat:</span> {{ $complaint->flat->flat_number ?? '-' }}<br>
            <span class="font-semibold">Resident:</span> {{ $complaint->resident->name ?? '-' }}<br>
            <span class="font-semibold">Created:</span> {{ $complaint->created_at->format('d M Y, h:i A') }}
        </div>
        <div class="mb-4">
            <h3 class="font-semibold text-text-primary dark:text-white mb-1">Description</h3>
            <div class="text-text-secondary dark:text-gray-300 text-base whitespace-pre-line">{!! nl2br(e($complaint->description)) !!}</div>
        </div>
        <div class="flex items-center gap-2 mt-4">
            <div class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-600 overflow-hidden flex items-center justify-center">
                <span class="text-sm font-bold text-text-primary dark:text-white">{{ $complaint->resident->name[0] ?? '?' }}</span>
            </div>
            <span class="text-sm font-medium text-text-secondary dark:text-gray-400">{{ $complaint->resident->name ?? '-' }}</span>
        </div>
    </div>
</div>
@endsection
