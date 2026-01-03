@extends('manager.layout')

@section('title', 'Documents - Manager')

@section('content')
<div class="p-4">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-bold">Documents</h3>
        <button class="bg-primary hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
            <span class="material-symbols-outlined align-middle mr-1">upload</span> Upload
        </button>
    </div>
    
    <div class="grid grid-cols-2 gap-3 mb-4">
        <div class="flex flex-col gap-3 rounded-xl p-4 bg-white dark:bg-gray-800 shadow-[0_2px_8px_rgba(0,0,0,0.04)] dark:shadow-none border border-transparent dark:border-gray-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-900 text-primary p-2">
                    <span class="material-symbols-outlined">folder</span>
                </div>
            </div>
            <div>
                <p class="text-[#111418] dark:text-white text-3xl font-bold leading-tight">{{ $documents->count() > 0 ? $documents->count() : count($documents) }}</p>
                <p class="text-[#617589] dark:text-gray-400 text-sm font-medium mt-1">Total Documents</p>
            </div>
        </div>
        <div class="flex flex-col gap-3 rounded-xl p-4 bg-white dark:bg-gray-800 shadow-[0_2px_8px_rgba(0,0,0,0.04)] dark:shadow-none border border-transparent dark:border-gray-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-center rounded-lg bg-green-50 dark:bg-green-900 text-green-600 dark:text-green-400 p-2">
                    <span class="material-symbols-outlined">download</span>
                </div>
            </div>
            <div>
                <p class="text-[#111418] dark:text-white text-3xl font-bold leading-tight">{{ $documents->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                <p class="text-[#617589] dark:text-gray-400 text-sm font-medium mt-1">This Month</p>
            </div>
        </div>
    </div>

    <div class="flex flex-col gap-3">
        @forelse($documents as $document)
        <div class="flex items-center justify-between gap-4 rounded-xl bg-white dark:bg-gray-800 p-3 shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 size-10">
                    <span class="material-symbols-outlined">description</span>
                </div>
                <div class="flex flex-col justify-center">
                    <p class="text-[#111418] dark:text-white text-sm font-semibold leading-normal line-clamp-1">{{ $document->name ?? $document->title ?? 'Document' }}</p>
                    <p class="text-[#617589] dark:text-gray-400 text-xs font-normal leading-normal">{{ $document->size ?? '1.2 MB' }} • {{ $document->created_at->format('d M Y') ?? '15 Dec 2023' }}</p>
                </div>
            </div>
            <div class="shrink-0 flex items-center gap-2">
                <span class="material-symbols-outlined text-gray-400 text-xl">download</span>
                <span class="material-symbols-outlined text-gray-400 text-xl">more_vert</span>
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-500">
            <span class="material-symbols-outlined text-4xl mb-2">inbox</span>
            <p>No documents available</p>
        </div>
        @endforelse
    </div>
</div>
@endsection