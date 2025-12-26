@extends('layouts.app')
@section('content')
<form method="POST" action="{{ route('admin.email.notification.save') }}" class="max-w-lg mx-auto w-full">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @csrf
    <!-- Header -->
    <div class="sticky top-0 z-20 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 transition-colors duration-300">
        <div class="flex items-center justify-between p-4 h-16 max-w-lg mx-auto">
                <div class="flex items-center w-10 h-10 justify-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center justify-center w-10 h-10 text-slate-900 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">
                        <span class="material-symbols-outlined">arrow_back_ios_new</span>
                    </a>
                </div>
                <div class="flex-1 flex items-center justify-center">
                    <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] text-center">Email / Notification Settings</h2>
                </div>
                <div class="w-10 h-10"></div>
        </div>
    </div>
    <!-- Main Content -->
    <main class="flex flex-col p-4 gap-6">
        <!-- Section 1: Service Provider -->
        <section class="flex flex-col gap-2">
            <h3 class="text-[#111418] text-sm font-bold uppercase tracking-wider px-1">Service Provider</h3>
            <div class="bg-white rounded-xl shadow-sm border border-[#dbe0e6] overflow-hidden p-4">
                <div class="flex flex-col gap-4">
                    <label class="flex flex-col w-full">
                        <span class="text-[#111418] text-sm font-medium pb-2">Mail Driver</span>
                        <div class="relative">
                            <select class="w-full appearance-none rounded-lg bg-[#f6f7f8] border border-[#dbe0e6] text-[#111418] h-12 px-4 pr-10 text-base focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all" name="mail_driver">
                                <option value="smtp" {{ old('mail_driver', $emailConfig['mail_driver'] ?? '') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                                <option value="mailgun" {{ old('mail_driver', $emailConfig['mail_driver'] ?? '') == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                                <option value="sendgrid" {{ old('mail_driver', $emailConfig['mail_driver'] ?? '') == 'sendgrid' ? 'selected' : '' }}>SendGrid</option>
                            </select>
                        </div>
                    </label>
                    <div class="flex items-center gap-2 p-3 bg-primary/10 rounded-lg border border-primary/20">
                        <span class="material-symbols-outlined text-primary text-xl">info</span>
                        <p class="text-xs text-[#111418]">Additional SMTP configuration fields will appear below when selected.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Section 2: Sender Details -->
        <section class="flex flex-col gap-2">
            <h3 class="text-[#111418] text-sm font-bold uppercase tracking-wider px-1">Sender Details</h3>
            <div class="bg-white rounded-xl shadow-sm border border-[#dbe0e6] overflow-hidden p-4 flex flex-col gap-5">
                <!-- From Name Input -->
                <label class="flex flex-col w-full group">
                    <span class="text-[#111418] text-sm font-medium pb-2">From Name</span>
                    <div class="relative flex items-center">
                        <span class="absolute left-4 text-[#617589] material-symbols-outlined text-[20px]">badge</span>
                        <input class="w-full rounded-lg bg-[#f6f7f8] border border-[#dbe0e6] text-[#111418] h-12 pl-11 pr-4 text-base placeholder:text-[#617589]/60 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all" placeholder="e.g. Skyline Admin" type="text" name="from_name" value="{{ old('from_name', $emailConfig['from_name'] ?? '') }}" />
                    </div>
                </label>
                <!-- From Email Input -->
                <label class="flex flex-col w-full group">
                    <span class="text-[#111418] text-sm font-medium pb-2">From Email</span>
                    <div class="relative flex items-center">
                        <span class="absolute left-4 text-[#617589] material-symbols-outlined text-[20px]">alternate_email</span>
                        <input class="w-full rounded-lg bg-[#f6f7f8] border border-[#dbe0e6] text-[#111418] h-12 pl-11 pr-4 text-base placeholder:text-[#617589]/60 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all" placeholder="e.g. admin@skyline.com" type="email" name="from_email" value="{{ old('from_email', $emailConfig['from_email'] ?? '') }}" />
                    </div>
                </label>
            </div>
        </section>
        <!-- Section 3: System Behavior -->
        <section class="flex flex-col gap-2 mb-8">
            <h3 class="text-[#111418] text-sm font-bold uppercase tracking-wider px-1">System Behavior</h3>
            <div class="bg-white rounded-xl shadow-sm border border-[#dbe0e6] overflow-hidden divide-y divide-[#dbe0e6]">
                <!-- Queue Emails Toggle -->
                <div class="flex items-center justify-between p-4">
                    <div class="flex flex-col pr-4">
                        <span class="text-[#111418] text-base font-medium">Queue Emails</span>
                        <span class="text-[#617589] text-xs mt-1">Process emails in background jobs for better performance.</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer shrink-0">
                        <input class="sr-only peer" type="checkbox" name="queue_emails" value="1" {{ old('queue_emails', !empty($emailConfig['queue_emails'])) ? 'checked' : '' }} />
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/30 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                    </label>
                </div>
                <!-- Another Setting Example (Encrypted) -->
                <div class="flex items-center justify-between p-4">
                    <div class="flex flex-col pr-4">
                        <span class="text-[#111418] text-base font-medium">Encrypt Connection</span>
                        <span class="text-[#617589] text-xs mt-1">Force TLS encryption for outgoing mail.</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer shrink-0">
                        <input class="sr-only peer" type="checkbox" name="encrypt_connection" value="1" {{ old('encrypt_connection', !empty($emailConfig['encrypt_connection'])) ? 'checked' : '' }} />
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/30 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                    </label>
                </div>
            </div>
        </section>
        <!-- Footer Action -->
        <div class="mt-auto pb-6">
            <button type="submit" class="w-full bg-primary hover:bg-blue-600 text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/30 transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[20px]">save</span>
                Save Configuration
            </button>
        </div>
            <!-- Fixed Footer -->
            <div class="fixed bottom-0 left-0 z-30 w-full border-t border-[#dbe0e6] bg-white px-4 py-4 dark:border-slate-800 dark:bg-[#1E293B]">
                <div class="mx-auto w-full max-w-md">
                    <button type="submit" class="flex h-12 w-full items-center justify-center gap-2 rounded-lg bg-primary px-6 text-base font-semibold text-white shadow-md shadow-blue-500/20 transition-all hover:bg-blue-600 active:scale-[0.98]">
                        <span class="material-symbols-outlined" style="font-size: 20px;">check</span>
                        Save Changes
                    </button>
                </div>
            </div>
    </main>
</form>
