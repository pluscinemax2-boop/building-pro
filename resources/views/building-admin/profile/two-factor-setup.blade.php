@extends('building-admin.layout')

@section('content')
<div class="relative flex h-full min-h-screen w-full flex-col bg-background-light dark:bg-background-dark pb-24">
    <!-- Header -->
    <header class="sticky top-0 z-30 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-5 py-4 flex items-center justify-between">
        <a href="{{ route('building-admin.admin-profile') }}" class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">
            <span class="material-symbols-outlined text-2xl">arrow_back</span>
        </a>
        <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white flex-1 ml-4">Two-Factor Authentication</h1>
    </header>

    <div class="max-w-2xl mx-auto w-full px-5 py-6 flex-1">
        <!-- Info Box -->
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-100 dark:border-blue-800 mb-6">
            <div class="flex gap-3">
                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 flex-shrink-0">info</span>
                <p class="text-sm text-blue-900 dark:text-blue-100">Two-Factor Authentication adds an extra layer of security to your account. You'll need to enter a code from your authenticator app in addition to your password when logging in.</p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <!-- Step 1: Install App -->
            <div class="bg-white dark:bg-surface-dark rounded-2xl p-5 shadow-sm border border-slate-100 dark:border-slate-700">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-primary text-white text-sm font-bold">1</span>
                    Install Authenticator App
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">Download one of these apps on your phone:</p>
                <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
                    <li class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">done</span>
                        Google Authenticator
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">done</span>
                        Microsoft Authenticator
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">done</span>
                        Authy
                    </li>
                </ul>
            </div>

            <!-- Step 2: Scan QR Code -->
            <div class="bg-white dark:bg-surface-dark rounded-2xl p-5 shadow-sm border border-slate-100 dark:border-slate-700">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-primary text-white text-sm font-bold">2</span>
                    Scan QR Code
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">Open your authenticator app and scan this QR code:</p>
                <div class="bg-white p-4 rounded-lg flex justify-center">
                    <img src="{{ $qrCodeUrl }}" alt="2FA QR Code" class="w-48 h-48">
                </div>
            </div>

            <!-- Step 3: Manual Entry -->
            <div class="bg-white dark:bg-surface-dark rounded-2xl p-5 shadow-sm border border-slate-100 dark:border-slate-700 md:col-span-2">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">lock_open</span>
                    Can't Scan? Enter Manually
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">Enter this key in your authenticator app if you can't scan the QR code:</p>
                <div class="bg-slate-100 dark:bg-slate-900 p-4 rounded-lg flex items-center justify-between">
                    <code class="text-sm font-mono text-slate-900 dark:text-white break-all">{{ $secret }}</code>
                    <button type="button" onclick="copyToClipboard('{{ $secret }}')" class="ml-2 p-2 hover:bg-slate-200 dark:hover:bg-slate-800 rounded transition-colors">
                        <span class="material-symbols-outlined text-sm">content_copy</span>
                    </button>
                </div>
            </div>

            <!-- Step 4: Verify Code -->
            <div class="bg-white dark:bg-surface-dark rounded-2xl p-5 shadow-sm border border-slate-100 dark:border-slate-700 md:col-span-2">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-primary text-white text-sm font-bold">3</span>
                    Verify Authentication Code
                </h3>
                <form method="POST" action="{{ route('building-admin.admin-profile.two-factor-verify') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Enter the 6-digit code from your authenticator app:</label>
                        <input type="text" name="code" inputmode="numeric" maxlength="6" placeholder="000000" class="w-full px-4 py-3 text-center text-2xl tracking-widest rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-surface-dark text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" required />
                        @error('code')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="w-full px-4 py-3 rounded-lg bg-primary text-white hover:bg-blue-600 font-semibold transition-colors">
                        Verify & Enable 2FA
                    </button>
                </form>
            </div>

            <!-- Backup Codes -->
            <div class="bg-amber-50 dark:bg-amber-900/20 rounded-2xl p-5 shadow-sm border border-amber-100 dark:border-amber-800 md:col-span-2">
                <h3 class="text-lg font-bold text-amber-900 dark:text-amber-100 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined">backup</span>
                    Save Your Backup Codes
                </h3>
                <p class="text-sm text-amber-900 dark:text-amber-100 mb-4">Save these codes in a safe place. Use them to regain access if you lose your authenticator device:</p>
                <div class="bg-white dark:bg-surface-dark p-4 rounded-lg grid grid-cols-2 gap-3 mb-4">
                    @foreach($backupCodes as $code)
                        <div class="font-mono text-sm text-slate-900 dark:text-white">{{ $code }}</div>
                    @endforeach
                </div>
                <button type="button" onclick="downloadBackupCodes()" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-sm font-semibold transition-colors">
                    <span class="material-symbols-outlined inline text-[18px] mr-1">download</span>
                    Download Codes
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Copied to clipboard!');
    });
}

function downloadBackupCodes() {
    const codes = @json($backupCodes);
    const content = `Building Manager Pro - 2FA Backup Codes\n\nDate: ${new Date().toLocaleDateString()}\n\n${codes.join('\n')}\n\nIMPORTANT: Keep these codes safe and secure.`;
    
    const element = document.createElement('a');
    element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(content));
    element.setAttribute('download', `backup-codes-${Date.now()}.txt`);
    element.style.display = 'none';
    document.body.appendChild(element);
    element.click();
    document.body.removeChild(element);
}

// Auto-focus on code input
document.addEventListener('DOMContentLoaded', function() {
    const codeInput = document.querySelector('input[name="code"]');
    if (codeInput) {
        codeInput.focus();
    }
});
</script>
@endsection
