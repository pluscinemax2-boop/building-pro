@extends('building-admin.layout')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-background-light dark:bg-background-dark">
    <div class="max-w-xl w-full bg-white dark:bg-surface-dark rounded-xl shadow-md p-8 border border-border dark:border-gray-800 text-center">
        <span class="material-symbols-outlined text-primary text-5xl mb-4">campaign</span>
        <h1 class="text-2xl font-bold text-text-main dark:text-white mb-2">Notice Board</h1>
        <p class="text-text-sub dark:text-gray-400 mb-6">No notices have been posted yet. Notices and announcements for residents will appear here.</p>
        <a href="#" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-primary text-white font-semibold shadow hover:bg-primary/90 transition-colors opacity-50 cursor-not-allowed" tabindex="-1" aria-disabled="true">
            <span class="material-symbols-outlined text-base">add</span> New Notice
        </a>
    </div>
</div>
@endsection
