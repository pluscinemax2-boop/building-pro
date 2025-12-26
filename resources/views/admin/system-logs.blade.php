@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
        @php
            $appVersion = env('APP_VERSION', '2.4.1');
            $build = env('APP_BUILD', '890');
            $server = env('APP_SERVER', 'us-east-1');
        @endphp
    <div class="flex items-center justify-between mb-4">
        <a href="{{ route('admin.system.maintenance') }}" class="inline-flex items-center gap-2 px-3 py-2 bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-white rounded-lg shadow hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors ml-2">
            <span class="material-symbols-outlined" style="font-size:18px;">arrow_back</span>
            <span>Back</span>
        </a>
        <h2 class="text-xl font-bold text-center flex-1">System Logs</h2>
        <form method="POST" action="{{ route('admin.system.maintenance.clear-logs') }}">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 px-3 py-2 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 transition-colors mr-2">
                <span class="material-symbols-outlined" style="font-size:18px;">delete</span>
                <span>Clear Logs</span>
            </button>
        </form>
        
    </div>
    <div class="bg-slate-100 dark:bg-slate-800 p-4 rounded-lg overflow-auto" style="max-height: 600px;">
        <pre class="text-xs text-slate-800 dark:text-slate-200">{{ $logs }}</pre>
        <div class="mt-4 flex flex-col items-center justify-center gap-1">
            <p class="text-slate-400 dark:text-slate-600 text-xs font-medium">App Version {{ $appVersion }}</p>
            <p class="text-slate-400 dark:text-slate-600 text-[10px] font-normal font-mono">Build {{ $build }} • Server: {{ $server }}</p>
        </div>
    </div>
</div>
@endsection