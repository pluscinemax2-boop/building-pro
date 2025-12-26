@extends('layouts.app')
@section('content')
@php
    $docMeta = [
        'terms' => [
            'icon' => 'gavel',
            'title' => 'Terms & Conditions',
        ],
        'privacy' => [
            'icon' => 'shield',
            'title' => 'Privacy Policy',
        ],
        'refund' => [
            'icon' => 'currency_exchange',
            'title' => 'Refund Policy',
        ],
    ];
@endphp
<div class="relative flex h-full min-h-screen w-full flex-col overflow-x-hidden max-w-md mx-auto bg-background-light dark:bg-background-dark shadow-xl">
    <!-- Top App Bar -->
    <div class="sticky top-0 z-10 flex items-center bg-white dark:bg-surface-dark p-4 pb-2 justify-between shadow-sm border-b border-border-light dark:border-border-dark">
        <a href="{{ route('dashboard') }}" class="text-text-main dark:text-white flex size-12 shrink-0 items-center cursor-pointer hover:opacity-70 transition-opacity">
            <span class="material-symbols-outlined text-2xl">arrow_back</span>
        </a>
        <h2 class="text-text-main dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center">Legal & Policy</h2>
        <div class="flex w-12 items-center justify-end">
            <button class="text-primary hover:text-primary-dark font-bold text-base leading-normal tracking-[0.015em] shrink-0 transition-colors">Save</button>
        </div>
    </div>
    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto pb-24">
        <!-- Section 1: Public Documents -->
        <div class="mb-2">
            <h3 class="text-text-main dark:text-white text-sm font-bold uppercase tracking-wider px-4 pb-3 pt-2 opacity-80">Public Legal Documents</h3>
            <div class="flex flex-col gap-3 px-4">
                @foreach(['terms','privacy','refund'] as $type)
                @php
                    $policy = $policies[$type] ?? null;
                    $icon = $docMeta[$type]['icon'];
                    $title = $docMeta[$type]['title'];
                    $status = $policy && $policy->status === 'active' ? 'Active' : 'Draft';
                    $status_color = $policy && $policy->status === 'active'
                        ? 'bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400 ring-green-600/20'
                        : 'bg-gray-50 dark:bg-white/5 text-gray-600 dark:text-gray-400 ring-gray-500/10';
                    $updated = $policy ? $policy->updated_at->format('d M Y') : 'Never published';
                    $action = $policy && $policy->status === 'active' ? 'Edit' : 'Setup';
                    $action_color = $policy && $policy->status === 'active'
                        ? 'bg-background-light dark:bg-white/10 text-text-main dark:text-white hover:bg-gray-200 dark:hover:bg-white/20'
                        : 'bg-primary/10 text-primary hover:bg-primary/20';
                @endphp
                <div class="flex flex-col bg-white dark:bg-surface-dark rounded-xl shadow-sm border border-border-light dark:border-border-dark overflow-hidden">
                    <form method="POST" action="{{ route('admin.legal.policy.save') }}" class="flex items-center gap-4 px-4 py-4 justify-between">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">
                        <input type="hidden" name="title" value="{{ $title }}">
                        <div class="flex items-center gap-4 overflow-hidden">
                            <div class="text-primary flex items-center justify-center rounded-lg bg-blue-50 dark:bg-primary/20 shrink-0 size-12">
                                <span class="material-symbols-outlined">{{ $icon }}</span>
                            </div>
                            <div class="flex flex-col justify-center overflow-hidden">
                                <p class="text-text-main dark:text-white text-base font-semibold leading-normal truncate">{{ $title }}</p>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium ring-1 ring-inset {{ $status_color }}">{{ $status }}</span>
                                    <span class="text-text-secondary dark:text-gray-400 text-xs truncate">Updated {{ $updated }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="shrink-0 flex gap-2">
                            <button type="button" class="flex items-center justify-center rounded-lg h-9 px-4 {{ $action_color }} text-sm font-medium transition-colors" onclick="showDocModal('{{ $type }}')">
                                {{ $action }}
                            </button>
                            <textarea name="content" class="hidden" id="doc-content-{{ $type }}">{{ $policy ? $policy->content : '' }}</textarea>
                        </div>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
        <div class="h-6"></div>
        <!-- Section 2: Internal Compliance -->
        <div class="mb-4">
            <h3 class="text-text-main dark:text-white text-sm font-bold uppercase tracking-wider px-4 pb-3 pt-2 opacity-80">Internal Compliance</h3>
            <div class="flex flex-col gap-3 px-4">
                <!-- GDPR Toggle (Styled Switch) -->
                <div class="flex items-center gap-4 bg-white dark:bg-surface-dark px-4 py-4 rounded-xl shadow-sm border border-border-light dark:border-border-dark justify-between">
                    <div class="flex items-center gap-4">
                        <div class="text-text-main dark:text-white flex items-center justify-center rounded-lg bg-background-light dark:bg-white/5 shrink-0 size-12">
                            <span class="material-symbols-outlined">verified_user</span>
                        </div>
                        <div class="flex flex-col justify-center">
                            <p class="text-text-main dark:text-white text-base font-medium leading-normal">GDPR Compliance Mode</p>
                            <p class="text-text-secondary dark:text-gray-400 text-sm font-normal leading-normal">Enforce strict data retention</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('admin.legal.policy.save-compliance') }}">
                        @csrf
                        <label class="relative inline-flex items-center cursor-pointer select-none">
                            <input type="checkbox" name="gdpr_enabled" class="sr-only peer" {{ $compliance && $compliance->gdpr_enabled ? 'checked' : '' }} onchange="this.form.submit()">
                            <div class="w-10 h-6 bg-gray-300 dark:bg-gray-600 rounded-full peer-checked:bg-primary transition-colors duration-200"></div>
                            <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-sm transition-transform duration-200 peer-checked:translate-x-4"></div>
                        </label>
                    </form>
                </div>
                <!-- Compliance Notes -->
                <div class="bg-white dark:bg-surface-dark rounded-xl shadow-sm border border-border-light dark:border-border-dark p-4">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="material-symbols-outlined text-primary">edit_note</span>
                        <h4 class="text-text-main dark:text-white text-base font-semibold">Compliance Notes</h4>
                    </div>
                    <textarea class="w-full min-h-[120px] rounded-lg border border-gray-200 dark:border-gray-700 bg-background-light dark:bg-background-dark p-3 text-sm text-text-main dark:text-white placeholder-gray-400 focus:border-primary focus:ring-1 focus:ring-primary outline-none resize-none" placeholder="Add internal notes regarding regulatory audits, policy changes, or legal advice references here..." readonly>{{ $compliance ? $compliance->notes : '' }}</textarea>
                    <form method="POST" action="{{ route('admin.legal.policy.save-compliance') }}" class="flex justify-between items-center mt-2 gap-2">
                        @csrf
                        <p class="text-xs text-text-secondary dark:text-gray-500">Only visible to Super Admins</p>
                        <textarea name="notes" class="hidden">{{ $compliance ? $compliance->notes : '' }}</textarea>
                        <button type="submit" class="text-primary text-xs font-semibold hover:underline">Save Notes</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="h-6"></div>
    </div>
    <!-- Sticky Footer -->
    <div class="absolute bottom-0 w-full bg-white dark:bg-surface-dark border-t border-border-light dark:border-border-dark p-4 backdrop-blur-md bg-opacity-90 dark:bg-opacity-90 z-20">
        <div class="flex flex-col gap-3">
            <button class="flex w-full cursor-pointer items-center justify-center rounded-xl h-12 bg-primary hover:bg-primary-dark text-white text-base font-bold leading-normal transition-transform active:scale-[0.98]">
                <a href="{{ route('admin.legal.policy.preview') }}" class="w-full h-full flex items-center justify-center">Preview Portal</a>
            </button>
        </div>
    </div>
</div>
<script>
function showDocModal(type) {
    let content = document.getElementById('doc-content-' + type).value;
    let newContent = prompt('Edit ' + type.charAt(0).toUpperCase() + type.slice(1) + ':', content);
    if (newContent !== null) {
        document.getElementById('doc-content-' + type).value = newContent;
        document.getElementById('doc-content-' + type).form.submit();
    }
}
</script>
@endsection
