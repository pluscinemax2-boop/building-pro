@extends('manager.layout')

@section('title', 'Complaint Details - Manager')

@section('content')
<div class="p-4">
    <div class="flex items-center justify-between mb-4">
        <a href="{{ route('manager.complaints.index') }}" class="flex items-center justify-center size-10 rounded-full bg-gray-100 dark:bg-gray-800 text-[#111418] dark:text-white">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h1 class="text-xl font-bold text-[#111418] dark:text-white">Complaint Details</h1>
        <div class="w-10"></div> <!-- Spacer for alignment -->
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4">
        <div class="flex items-center gap-2 mb-2">
        @if($complaint->image)
                <div class="mb-4" style="display: flex; justify-content: center; width: 100%;">
                    <img src="{{ asset('storage/' . $complaint->image) }}" alt="Complaint Image" class="rounded-xl border border-gray-200 dark:border-gray-700 object-cover" style="width: 100%; height: auto; max-height: 200px;" />
                </div>
        @endif
        </div>
        <div class="flex items-center gap-2 mb-2">
            <span class="text-base font-bold text-[#111418] dark:text-white block mb-2">{{ $complaint->flat->flat_number ?? '-' }} - {{ $complaint->title }}</span>
            @if($complaint->priority)
                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ml-2
                    @if($complaint->priority === 'High') bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400 ring-red-600/10
                    @elseif($complaint->priority === 'Medium') bg-yellow-50 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 ring-yellow-600/20
                    @else bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400 ring-green-600/20 @endif
                    ring-1 ring-inset">
                    {{ $complaint->priority }} Priority
                </span>
            @endif
            <span class="text-xs text-[#617589] dark:text-gray-400">• {{ $complaint->created_at->diffForHumans() }}</span>
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
        <div class="text-sm text-[#617589] dark:text-gray-400 mb-4">
            <span class="font-semibold">Flat:</span> {{ $complaint->flat->flat_number ?? '-' }}<br>
            <span class="font-semibold">Resident:</span> {{ $complaint->resident->name ?? '-' }}<br>
            <span class="font-semibold">Created:</span> {{ $complaint->created_at->format('d M Y, h:i A') }}
        </div>
        <div class="mb-4">
            <h3 class="font-semibold text-[#111418] dark:text-white mb-1">Description</h3>
            <div class="text-[#617589] dark:text-gray-300 text-base whitespace-pre-line">{!! nl2br(e($complaint->description)) !!}</div>
        </div>
        <div class="flex items-center gap-2 mt-4">
            <div class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-600 overflow-hidden flex items-center justify-center">
                <span class="text-sm font-bold text-[#111418] dark:text-white">{{ $complaint->resident->name[0] ?? '?' }}</span>
            </div>
            <span class="text-sm font-medium text-[#617589] dark:text-gray-400">{{ $complaint->resident->name ?? '-' }}</span>
        </div>
    </div>
    
    <!-- Status Update Form -->
    <div class="mt-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4">
        <h3 class="font-semibold text-[#111418] dark:text-white mb-2">Update Status</h3>
        <form method="POST" action="{{ route('manager.complaints.update-status', $complaint->id) }}">
            @csrf
            <div class="flex items-center gap-2">
                <select name="status" class="flex-1 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-[#111418] dark:text-white p-2">
                    @if($complaint->status == 'Open')
                        <option value="In Progress" {{ $complaint->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Resolved" {{ $complaint->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                    @elseif($complaint->status == 'In Progress')
                        <option value="Resolved" {{ $complaint->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                    @endif
                </select>
                <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-white font-semibold">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection