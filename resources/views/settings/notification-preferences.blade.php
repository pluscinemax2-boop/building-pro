<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">
            Notification Preferences
        </h2>
        <p class="text-gray-600 mt-1">Manage how you receive notifications</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Master Toggle -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">All Notifications</h3>
                        <p class="text-sm text-gray-600 mt-1">Turn off all email notifications at once</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" 
                               id="email_notifications_enabled"
                               class="sr-only peer toggle-master"
                               {{ $preferences->user->email_notifications_enabled ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>

            <!-- Individual Notification Types -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Notification Types</h3>
                </div>

                <div class="divide-y divide-gray-200">
                    <!-- Payment Confirmations -->
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                        <div>
                            <h4 class="font-medium text-gray-900">Payment Confirmations</h4>
                            <p class="text-sm text-gray-600">Receive confirmations for subscription payments</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   class="sr-only peer notification-toggle"
                                   data-type="payment_confirmations"
                                   {{ $preferences->email_payment_confirmations ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <!-- Subscription Updates -->
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                        <div>
                            <h4 class="font-medium text-gray-900">Subscription Updates</h4>
                            <p class="text-sm text-gray-600">Updates about your subscription status and renewals</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   class="sr-only peer notification-toggle"
                                   data-type="subscription_updates"
                                   {{ $preferences->email_subscription_updates ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <!-- Complaint Updates -->
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                        <div>
                            <h4 class="font-medium text-gray-900">Complaint Updates</h4>
                            <p class="text-sm text-gray-600">Status updates on complaints you've filed</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   class="sr-only peer notification-toggle"
                                   data-type="complaint_updates"
                                   {{ $preferences->email_complaint_updates ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <!-- Maintenance Updates -->
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                        <div>
                            <h4 class="font-medium text-gray-900">Maintenance Updates</h4>
                            <p class="text-sm text-gray-600">Updates on maintenance requests and completions</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   class="sr-only peer notification-toggle"
                                   data-type="maintenance_updates"
                                   {{ $preferences->email_maintenance_updates ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <!-- Announcements -->
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                        <div>
                            <h4 class="font-medium text-gray-900">Announcements</h4>
                            <p class="text-sm text-gray-600">Important building announcements and notices</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   class="sr-only peer notification-toggle"
                                   data-type="announcements"
                                   {{ $preferences->email_announcements ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <!-- Emergency Alerts -->
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                        <div>
                            <h4 class="font-medium text-gray-900">Emergency Alerts</h4>
                            <p class="text-sm text-gray-600 font-medium">Critical emergency notifications</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   class="sr-only peer notification-toggle"
                                   data-type="emergency_alerts"
                                   {{ $preferences->email_emergency_alerts ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <!-- Forum Replies -->
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                        <div>
                            <h4 class="font-medium text-gray-900">Forum Replies</h4>
                            <p class="text-sm text-gray-600">Notifications when someone replies to your forum posts</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   class="sr-only peer notification-toggle"
                                   data-type="forum_replies"
                                   {{ $preferences->email_forum_replies ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Digest Options -->
            <div class="bg-white rounded-lg shadow mt-6 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Email Digests</h3>
                    <p class="text-sm text-gray-600 mt-1">Receive a summary of all activity instead of individual emails</p>
                </div>

                <div class="divide-y divide-gray-200">
                    <!-- Weekly Digest -->
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                        <div>
                            <h4 class="font-medium text-gray-900">Weekly Digest</h4>
                            <p class="text-sm text-gray-600">Every Monday morning</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   class="sr-only peer notification-toggle"
                                   data-type="digest_weekly"
                                   {{ $preferences->digest_weekly ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <!-- Monthly Digest -->
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                        <div>
                            <h4 class="font-medium text-gray-900">Monthly Digest</h4>
                            <p class="text-sm text-gray-600">First day of every month</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   class="sr-only peer notification-toggle"
                                   data-type="digest_monthly"
                                   {{ $preferences->digest_monthly ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Help Text -->
            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-800">
                    <strong>Note:</strong> Emergency alerts will always be sent regardless of your notification preferences.
                </p>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Master toggle
        document.getElementById('email_notifications_enabled')?.addEventListener('change', function() {
            const enabled = this.checked;
            // In a real implementation, you would send this to the server
            console.log('Email notifications:', enabled ? 'enabled' : 'disabled');
        });

        // Individual notification toggles
        document.querySelectorAll('.notification-toggle').forEach(toggle => {
            toggle.addEventListener('change', function() {
                const type = this.getAttribute('data-type');
                const enabled = this.checked;
                
                // Send to server via AJAX
                fetch(`/settings/notifications/toggle/${type}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ enabled })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        console.log(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    </script>
    @endpush
</x-app-layout>
