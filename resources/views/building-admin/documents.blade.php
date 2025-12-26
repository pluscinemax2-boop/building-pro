@extends('building-admin.layout')

@section('content')
<div class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white min-h-screen flex flex-col overflow-hidden">
    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col h-full overflow-hidden relative max-w-md mx-auto w-full bg-background-light dark:bg-background-dark shadow-2xl">
        <!-- Header -->
        <header class="bg-background-light dark:bg-background-dark pt-12 pb-2 px-5 sticky top-0 z-20">
            <div class="flex items-center mb-4 relative">
                <a href="{{ route('building-admin.dashboard') }}" class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-background-light dark:hover:bg-slate-800 transition-colors text-slate-600 dark:text-slate-300 absolute left-0">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <h1 class="flex-1 text-2xl font-bold tracking-tight text-slate-900 dark:text-white text-center">Documents</h1>
            </div>
            <!-- Search Bar -->
            <form method="GET" action="" class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <span class="material-symbols-outlined text-[20px]">search</span>
                </span>
                <input name="search" value="{{ request('search') }}" class="w-full py-3 pl-10 pr-4 bg-white dark:bg-slate-800 border-none rounded-xl text-sm font-medium text-slate-900 dark:text-white placeholder-slate-400 shadow-sm focus:ring-2 focus:ring-primary/50 outline-none" placeholder="Search files..." type="text" />
            </form>
        </header>
        <!-- No filter chips needed -->
        <!-- Document List -->
        <main class="flex-1 overflow-y-auto px-5 pt-2 pb-24 space-y-4 no-scrollbar">
            <div class="flex items-center justify-between pt-2">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">All Documents</h3>
            </div>
            @forelse($documents as $doc)
            <div class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-soft border border-slate-100 dark:border-slate-700 flex items-center justify-between gap-4 group active:scale-[0.99] transition-transform duration-200">
                <div class="flex items-start gap-4 flex-1 min-w-0">
                    <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                        <span class="material-symbols-outlined filled">description</span>
                    </div>
                    <div class="flex flex-col min-w-0">
                        <h4 class="text-base font-semibold text-slate-900 dark:text-white truncate">{{ $doc->name }}</h4>
                        <div class="flex flex-wrap items-center gap-x-2 gap-y-1 mt-1 text-xs text-slate-500 dark:text-slate-400">
                            <span class="font-medium text-slate-700 dark:text-slate-300">v{{ $doc->version }}</span>
                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                            <span>{{ $doc->created_at->format('d M Y') }}</span>
                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                            <span>{{ $doc->uploader ? $doc->uploader->name : 'Unknown' }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('building-admin.documents.download', $doc->id) }}" class="w-10 h-10 rounded-full flex items-center justify-center text-primary hover:bg-primary/5 dark:hover:bg-primary/20 transition-colors shrink-0" title="Download">
                        <span class="material-symbols-outlined">download</span>
                    </a>
                    <form method="POST" action="{{ route('building-admin.documents.delete', $doc->id) }}" onsubmit="return confirm('Are you sure you want to delete this document?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-10 h-10 rounded-full flex items-center justify-center text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors shrink-0" title="Delete">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center text-slate-400 py-8">No documents found.</div>
            @endforelse
            <div class="h-16"></div>
        </main>
        <!-- Fixed Footer Upload Button (modern UX) -->
        <form method="POST" action="{{ route('building-admin.documents.upload') }}" enctype="multipart/form-data" id="uploadForm" class="fixed bottom-0 left-0 right-0 z-50 bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 px-5 py-4 flex items-center justify-center max-w-md mx-auto w-full">
            @csrf
            <input type="file" name="file" id="fileInput" class="hidden" onchange="document.getElementById('uploadForm').submit()" required />
            <button type="button" onclick="document.getElementById('fileInput').click()" class="flex items-center gap-2 px-6 py-3 rounded-full bg-primary text-white font-semibold text-base shadow-card hover:bg-primary/90 transition">
                <span class="material-symbols-outlined text-xl">upload</span>
                Upload
            </button>
        </form>
        <!-- Bottom Navigation removed as per requirement -->
    </div>
</div>
@endsection
