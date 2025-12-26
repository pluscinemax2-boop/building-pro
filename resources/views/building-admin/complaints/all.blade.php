@extends('building-admin.layout')

@section('content')
<div class="max-w-2xl mx-auto bg-white dark:bg-background-dark shadow-xl rounded-xl p-6 mt-8">
    <div class="flex items-center gap-2 mb-4">
        <a href="{{ route('building-admin.complaints.index') }}" class="text-text-primary dark:text-white flex size-10 shrink-0 items-center justify-center rounded-full hover:bg-neutral-100 dark:hover:bg-gray-800 transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h2 class="text-xl font-bold text-text-primary dark:text-white">All Complaints</h2>
    </div>
    <form method="GET" action="" class="mb-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search complaints..." class="form-input w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary bg-neutral-100 dark:bg-gray-800 text-text-primary dark:text-white" />
    </form>
    <div class="space-y-4">
        @forelse($complaints as $complaint)
            @include('building-admin.complaints._card', ['complaint' => $complaint])
        @empty
            <div class="text-slate-400 text-sm">No complaints found.</div>
        @endforelse
    </div>
    <div class="mt-6">
        {{ $complaints->links() }}
    </div>
</div>
@endsection
