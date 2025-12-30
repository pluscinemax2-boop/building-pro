@extends('building-admin.layout')

@section('content')
<div class="relative flex h-full min-h-screen w-full flex-col bg-background-light dark:bg-background-dark pb-24">
    <!-- Header -->
    <header class="sticky top-0 z-30 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-5 py-4 flex items-center justify-between">
        <a href="{{ route('building-admin.admin-profile') }}" class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">
            <span class="material-symbols-outlined text-2xl">arrow_back</span>
        </a>
        <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white flex-1 ml-4">Edit Profile</h1>
    </header>

    <div class="max-w-md mx-auto w-full px-5 py-6 flex-1">
        <!-- Form -->
        <form method="POST" action="{{ route('building-admin.admin-profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Avatar Section -->
            <div>
                <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-3">Profile Picture</label>
                <div class="flex flex-col items-center gap-4">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 overflow-hidden flex items-center justify-center border-4 border-white dark:border-slate-700 shadow-lg">
                        @if($admin->avatar)
                            <img src="{{ $admin->avatar }}" alt="{{ $admin->name }}" class="w-full h-full object-cover" id="avatarPreview" />
                        @else
                            <span class="material-symbols-outlined text-white text-5xl">account_circle</span>
                        @endif
                    </div>
                    <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*" onchange="previewAvatar(this)" />
                    <button type="button" onclick="document.getElementById('avatar').click()" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors text-sm font-semibold">
                        <span class="material-symbols-outlined inline mr-1 text-[18px]">camera_alt</span>
                        Change Photo
                    </button>
                </div>
            </div>

            <!-- Name Field -->
            <div>
                <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Full Name</label>
                <input type="text" name="name" value="{{ $admin->name }}" required class="w-full px-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-surface-dark text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary" />
                @error('name')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Field -->
            <div>
                <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Email Address</label>
                <input type="email" name="email" value="{{ $admin->email }}" required class="w-full px-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-surface-dark text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary" />
                @error('email')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone Field -->
            <div>
                <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Phone Number</label>
                <input type="tel" name="phone" value="{{ $admin->phone ?? '' }}" class="w-full px-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-surface-dark text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="+1 (555) 000-0000" />
                @error('phone')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Button Group -->
            <div class="flex gap-3 pt-6">
                <a href="{{ route('building-admin.admin-profile') }}" class="flex-1 px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-700 font-semibold transition-colors text-center">
                    Cancel
                </a>
                <button type="submit" class="flex-1 px-4 py-3 rounded-lg bg-primary text-white hover:bg-blue-600 font-semibold transition-colors">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            let preview = document.getElementById('avatarPreview');
            if (preview) {
                preview.src = e.target.result;
            } else {
                const container = document.querySelector('.w-24.h-24');
                const img = document.createElement('img');
                img.id = 'avatarPreview';
                img.src = e.target.result;
                img.className = 'w-full h-full object-cover';
                container.innerHTML = '';
                container.appendChild(img);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
