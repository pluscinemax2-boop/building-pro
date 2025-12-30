@extends('building-admin.layout')

@section('content')
<div class="relative flex h-full min-h-screen w-full flex-col bg-background-light dark:bg-background-dark pb-24">
    <!-- Header -->
    <header class="sticky top-0 z-30 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-5 py-4 flex items-center justify-between">
        <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">{{ $admin->name }}'s Profile</h1>
        <a href="{{ route('building-admin.admin-profile.edit') }}" class="flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-full hover:bg-blue-600 active:scale-95 transition-all shadow-md shadow-primary/20">
            <span class="material-symbols-outlined text-[20px]">edit</span>
            <span class="text-sm font-bold">Edit</span>
        </a>
    </header>

    <div class="max-w-md mx-auto w-full px-5 py-6">
        <!-- Profile Section -->
        <section class="mb-8">
            <div class="flex flex-col items-center gap-4">
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 overflow-hidden flex items-center justify-center border-4 border-white dark:border-slate-700 shadow-lg">
                    @if($admin->avatar)
                        <img src="{{ $admin->avatar }}" alt="{{ $admin->name }}" class="w-full h-full object-cover" />
                    @else
                        <span class="material-symbols-outlined text-white text-5xl">account_circle</span>
                    @endif
                </div>
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $admin->name }}</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">{{ $admin->email }}</p>
                    @if($admin->phone)
                        <p class="text-slate-500 dark:text-slate-400 text-xs mt-1">{{ $admin->phone }}</p>
                    @endif
                </div>
            </div>
        </section>

        <!-- Profile Info Section -->
        <section class="mb-8">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Profile Information</h3>
            <div class="bg-white dark:bg-surface-dark rounded-2xl p-5 shadow-sm border border-slate-100 dark:border-slate-700 space-y-4">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-700">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-slate-500 dark:text-slate-400">person</span>
                        <div>
                            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">Full Name</p>
                            <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $admin->name }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-700">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-slate-500 dark:text-slate-400">email</span>
                        <div>
                            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">Email Address</p>
                            <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $admin->email }}</p>
                        </div>
                    </div>
                </div>
                @if($admin->phone)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-slate-500 dark:text-slate-400">phone</span>
                            <div>
                                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">Phone Number</p>
                                <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $admin->phone }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- Security Section -->
        <section class="mb-8">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Security Settings</h3>
            <div class="space-y-3">
                <!-- Change Password -->
                <a href="{{ route('building-admin.admin-profile.password') }}" class="bg-white dark:bg-surface-dark rounded-2xl p-5 shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-md transition-all flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary">lock</span>
                        <div>
                            <p class="text-sm font-bold text-slate-900 dark:text-white">Change Password</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Update your password</p>
                        </div>
                    </div>
                    <span class="material-symbols-outlined text-slate-400">arrow_forward</span>
                </a>

                <!-- Two-Factor Authentication -->
                <div class="bg-white dark:bg-surface-dark rounded-2xl p-5 shadow-sm border border-slate-100 dark:border-slate-700">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3 flex-1">
                            <span class="material-symbols-outlined text-slate-500 dark:text-slate-400">shield</span>
                            <div>
                                <p class="text-sm font-bold text-slate-900 dark:text-white">Two-Factor Authentication</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Add an extra layer of security</p>
                            </div>
                        </div>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $admin->two_factor_enabled ? 'bg-emerald-100 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400' : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400' }}">
                            {{ $admin->two_factor_enabled ? 'Enabled' : 'Disabled' }}
                        </span>
                    </div>
                    <div class="flex gap-2">
                        @if($admin->two_factor_enabled)
                            <a href="{{ route('building-admin.admin-profile.two-factor-setup') }}" class="flex-1 px-3 py-2 bg-slate-100 dark:bg-slate-700 text-slate-900 dark:text-white hover:bg-slate-200 dark:hover:bg-slate-600 rounded-lg text-sm font-semibold transition-colors text-center">
                                Reconfigure
                            </a>
                            <form method="POST" action="{{ route('building-admin.admin-profile.two-factor-disable') }}" class="flex-1">
                                @csrf
                                <button type="button" onclick="if(confirm('Are you sure? This will make your account less secure.')) showDisable2FAModal()" class="w-full px-3 py-2 bg-red-100 dark:bg-red-900/20 text-red-700 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/30 rounded-lg text-sm font-semibold transition-colors">
                                    Disable
                                </button>
                            </form>
                        @else
                            <a href="{{ route('building-admin.admin-profile.two-factor-setup') }}" class="w-full px-3 py-2 bg-primary text-white hover:bg-blue-600 rounded-lg text-sm font-semibold transition-colors text-center">
                                Enable 2FA
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Account Status Section -->
        <section class="mb-8">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Account Status</h3>
            <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl p-5 border border-emerald-100 dark:border-emerald-800">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400">verified</span>
                    <div>
                        <p class="font-bold text-emerald-900 dark:text-emerald-100">Account Verified</p>
                        <p class="text-xs text-emerald-700 dark:text-emerald-300 mt-1">Your account is active and in good standing</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Bottom Tab Bar -->
    @include('building-admin.partials.bottom-nav', ['active' => 'profile'])
</div>

<!-- Disable 2FA Modal -->
<div id="disable2FAModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-end">
    <div class="w-full bg-white dark:bg-surface-dark rounded-t-2xl p-6 animate-slide-up">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Disable 2FA?</h3>
        <p class="text-sm text-slate-600 dark:text-slate-400 mb-6">Enter your password to confirm. This will make your account less secure.</p>
        
        <form method="POST" action="{{ route('building-admin.admin-profile.two-factor-disable') }}" class="space-y-4">
            @csrf
            <div>
                <input type="password" name="password" placeholder="Enter your password" class="w-full px-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" required />
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="hide2FAModal()" class="flex-1 px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-700 font-semibold transition-colors">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-4 py-3 rounded-lg bg-red-600 text-white hover:bg-red-700 font-semibold transition-colors">
                    Disable 2FA
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showDisable2FAModal() {
    document.getElementById('disable2FAModal').classList.remove('hidden');
}

function hide2FAModal() {
    document.getElementById('disable2FAModal').classList.add('hidden');
}

// Close modal on outside click
document.getElementById('disable2FAModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});
</script>

@endsection
