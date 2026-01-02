@extends('building-admin.layout')

@section('content')
<div class="bg-background-light dark:bg-background-dark font-display text-[#111418] dark:text-white pb-24 min-h-screen">
    <!-- Header -->
    <div class="sticky top-0 z-20 bg-white dark:bg-[#111418] border-b border-[#dbe0e6] dark:border-gray-800 shadow-sm">
        <div class="flex items-center justify-between p-4 pb-2">
            <a href="{{ route('building-admin.dashboard') }}" class="text-[#111418] dark:text-white flex size-12 shrink-0 items-center cursor-pointer">
                <span class="material-symbols-outlined text-2xl">arrow_back</span>
            </a>
            <div class="flex-1 text-center">
                <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">Support</h2>
            </div>
            <div class="flex w-12 items-center justify-end">
                <!-- Empty div for alignment -->
            </div>
        </div>
    </div>

    <!-- Support Content -->
    <div class="p-4">
        <div class="flex flex-col items-stretch justify-start rounded-xl shadow-sm bg-white dark:bg-[#1a2632] overflow-hidden border border-[#dbe0e6] dark:border-gray-700">
            <div class="w-full h-32 bg-center bg-no-repeat bg-cover relative" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuD_-oNXsdEHxhNF8E7sC-60A-edXrXmgv2yG4SAwZwr9FsdNszm1kPXGwvXos0AACdsDgpDTpqDpxWcJDg1ozEQqpHzxbK1TuiNfs9As01vuIW6-9j5352Uy8urGAAbnjZk0pC4QpOX_lkRveGqFNNOLEG_t_Mxt9X2kt1upCaw1fplcs5FkdRZFPpZJxD1Oq0w5p4LfTGvq21nkyTWgzYPBgmXY81OQYX5je1aoagvuzziMYcruLrlYEIg2YY_liDUU8Uie9PuBV2z");'>
                <div class="absolute inset-0 bg-primary/40 mix-blend-multiply"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="bg-white/20 backdrop-blur-sm p-3 rounded-full border border-white/30">
                        <span class="material-symbols-outlined text-white text-3xl">support_agent</span>
                    </div>
                </div>
            </div>
            <div class="flex w-full flex-col items-stretch justify-center gap-3 p-4">
                <div class="flex flex-col gap-1">
                    <p class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">Need Help?</p>
                    <p class="text-[#617589] dark:text-gray-400 text-sm font-normal leading-normal">Get in touch with our support team for assistance with your building management system.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Support Options -->
    <div class="p-4">
        <h3 class="text-[#111418] dark:text-white text-base font-bold mb-3">Contact Support</h3>
        <div class="space-y-3">
            <!-- Email Support -->
            <div class="flex items-center justify-between p-4 bg-white dark:bg-[#1a2632] rounded-xl border border-[#dbe0e6] dark:border-gray-700 shadow-sm">
                <div class="flex items-center">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-50 text-primary dark:bg-blue-900/30 dark:text-blue-400">
                        <span class="material-symbols-outlined text-[20px]">mail</span>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-bold text-[#111418] dark:text-white">Email Support</p>
                        <p class="text-xs text-[#617589] dark:text-gray-400">Send us an email</p>
                    </div>
                </div>
                <a href="mailto:support@buildingmanager.com" class="text-primary">
                    <span class="material-symbols-outlined">chevron_right</span>
                </a>
            </div>

            <!-- Phone Support -->
            <div class="flex items-center justify-between p-4 bg-white dark:bg-[#1a2632] rounded-xl border border-[#dbe0e6] dark:border-gray-700 shadow-sm">
                <div class="flex items-center">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-50 text-green-600 dark:bg-green-900/30 dark:text-green-400">
                        <span class="material-symbols-outlined text-[20px]">phone</span>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-bold text-[#111418] dark:text-white">Phone Support</p>
                        <p class="text-xs text-[#617589] dark:text-gray-400">Call our support line</p>
                    </div>
                </div>
                <a href="tel:+1234567890" class="text-primary">
                    <span class="material-symbols-outlined">chevron_right</span>
                </a>
            </div>

            <!-- FAQ Section -->
            <div class="p-4 bg-white dark:bg-[#1a2632] rounded-xl border border-[#dbe0e6] dark:border-gray-700 shadow-sm">
                <div class="flex items-center mb-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                        <span class="material-symbols-outlined text-[20px]">quiz</span>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-bold text-[#111418] dark:text-white">Frequently Asked Questions</p>
                        <p class="text-xs text-[#617589] dark:text-gray-400">Common questions & answers</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="border border-[#dbe0e6] dark:border-gray-700 rounded-lg overflow-hidden">
                        <button class="faq-toggle w-full flex justify-between items-center p-3 bg-gray-50 dark:bg-[#1a2632] hover:bg-gray-100 dark:hover:bg-[#223240] transition-colors">
                            <span class="font-medium text-[#111418] dark:text-white">How do I add new residents to my building?</span>
                            <span class="faq-icon material-symbols-outlined text-[#617589] dark:text-gray-400">expand_more</span>
                        </button>
                        <div class="faq-content hidden p-3 border-t border-[#dbe0e6] dark:border-gray-700">
                            <p class="text-sm text-[#617589] dark:text-gray-400">Go to Residents section and click on Add Resident. Fill in the required details and save.</p>
                        </div>
                    </div>
                    <div class="border border-[#dbe0e6] dark:border-gray-700 rounded-lg overflow-hidden">
                        <button class="faq-toggle w-full flex justify-between items-center p-3 bg-gray-50 dark:bg-[#1a2632] hover:bg-gray-100 dark:hover:bg-[#223240] transition-colors">
                            <span class="font-medium text-[#111418] dark:text-white">How can I generate financial reports?</span>
                            <span class="faq-icon material-symbols-outlined text-[#617589] dark:text-gray-400">expand_more</span>
                        </button>
                        <div class="faq-content hidden p-3 border-t border-[#dbe0e6] dark:border-gray-700">
                            <p class="text-sm text-[#617589] dark:text-gray-400">Navigate to Reports section and select the desired report type. You can filter by date range and export as PDF.</p>
                        </div>
                    </div>
                    <div class="border border-[#dbe0e6] dark:border-gray-700 rounded-lg overflow-hidden">
                        <button class="faq-toggle w-full flex justify-between items-center p-3 bg-gray-50 dark:bg-[#1a2632] hover:bg-gray-100 dark:hover:bg-[#223240] transition-colors">
                            <span class="font-medium text-[#111418] dark:text-white">Can I send emergency alerts to all residents?</span>
                            <span class="faq-icon material-symbols-outlined text-[#617589] dark:text-gray-400">expand_more</span>
                        </button>
                        <div class="faq-content hidden p-3 border-t border-[#dbe0e6] dark:border-gray-700">
                            <p class="text-sm text-[#617589] dark:text-gray-400">Yes, go to Emergency Alerts section and click on Compose New Alert. Select priority and send to all residents.</p>
                        </div>
                    </div>
                    <div class="border border-[#dbe0e6] dark:border-gray-700 rounded-lg overflow-hidden">
                        <button class="faq-toggle w-full flex justify-between items-center p-3 bg-gray-50 dark:bg-[#1a2632] hover:bg-gray-100 dark:hover:bg-[#223240] transition-colors">
                            <span class="font-medium text-[#111418] dark:text-white">How do I manage subscription plans?</span>
                            <span class="faq-icon material-symbols-outlined text-[#617589] dark:text-gray-400">expand_more</span>
                        </button>
                        <div class="faq-content hidden p-3 border-t border-[#dbe0e6] dark:border-gray-700">
                            <p class="text-sm text-[#617589] dark:text-gray-400">Access the Subscription section to view current plan, upgrade options, and payment history.</p>
                        </div>
                    </div>
                    <div class="border border-[#dbe0e6] dark:border-gray-700 rounded-lg overflow-hidden">
                        <button class="faq-toggle w-full flex justify-between items-center p-3 bg-gray-50 dark:bg-[#1a2632] hover:bg-gray-100 dark:hover:bg-[#223240] transition-colors">
                            <span class="font-medium text-[#111418] dark:text-white">What should I do if I forget my password?</span>
                            <span class="faq-icon material-symbols-outlined text-[#617589] dark:text-gray-400">expand_more</span>
                        </button>
                        <div class="faq-content hidden p-3 border-t border-[#dbe0e6] dark:border-gray-700">
                            <p class="text-sm text-[#617589] dark:text-gray-400">Use the 'Forgot Password' link on login screen to reset your password via email verification.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Live Chat Button (Floating) -->
            <div class="fixed bottom-24 right-4 z-50">
                <button id="chatToggle" class="w-14 h-14 bg-primary text-white rounded-full shadow-lg flex items-center justify-center hover:bg-blue-600 transition-colors">
                    <span class="material-symbols-outlined">chat</span>
                </button>
            </div>
            
            <!-- Floating Chat Window -->
            <div id="chatWindow" class="hidden fixed bottom-20 right-4 z-50 w-80 bg-white dark:bg-[#1a2632] rounded-xl border border-[#dbe0e6] dark:border-gray-700 shadow-xl">
                <div class="border-b border-[#dbe0e6] dark:border-gray-700 p-3 bg-gray-50 dark:bg-[#223240] rounded-t-xl flex justify-between items-center">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div>
                        <span class="text-sm font-medium text-[#111418] dark:text-white">Live Support</span>
                    </div>
                    <button id="closeChat" class="text-[#617589] hover:text-[#111418] dark:text-gray-400 dark:hover:text-white">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                
                <div class="p-3">
                    <!-- Chat Messages -->
                    <div id="chatMessages" class="h-64 overflow-y-auto space-y-3">
                        <div class="flex justify-start">
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3 max-w-xs">
                                <p class="text-sm text-[#111418] dark:text-white">Hello! How can I help you today?</p>
                                <p class="text-xs text-[#617589] dark:text-gray-400 mt-1">10:00 AM</p>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <div class="bg-primary text-white rounded-lg p-3 max-w-xs">
                                <p class="text-sm">I need help with adding new residents to my building.</p>
                                <p class="text-xs text-blue-100 mt-1">10:01 AM</p>
                            </div>
                        </div>
                        
                        <div class="flex justify-start">
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3 max-w-xs">
                                <p class="text-sm text-[#111418] dark:text-white">Sure! You can add new residents by going to the Residents section and clicking 'Add Resident'. Fill in the required details and save.</p>
                                <p class="text-xs text-[#617589] dark:text-gray-400 mt-1">10:02 AM</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Chat Input -->
                    <div class="mt-3 flex">
                        <input type="text" id="messageInput" placeholder="Type your message..." class="flex-1 px-3 py-2 rounded-lg border border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-[#1a2632] text-[#111418] dark:text-white focus:outline-none focus:ring-1 focus:ring-primary">
                        <button id="sendMessage" class="ml-2 px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors">
                            <span class="material-symbols-outlined text-sm">send</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Navigation Bar -->
    @include('building-admin.partials.bottom-nav', ['active' => 'support'])
    
    <!-- FAQ Accordion JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const faqToggles = document.querySelectorAll('.faq-toggle');
            
            faqToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const content = this.nextElementSibling;
                    const icon = this.querySelector('.faq-icon');
                    
                    // Close all other FAQ items
                    faqToggles.forEach(otherToggle => {
                        if (otherToggle !== toggle) {
                            const otherContent = otherToggle.nextElementSibling;
                            const otherIcon = otherToggle.querySelector('.faq-icon');
                            otherContent.classList.add('hidden');
                            otherIcon.textContent = 'expand_more';
                        }
                    });
                    
                    // Toggle current FAQ item
                    content.classList.toggle('hidden');
                    if (content.classList.contains('hidden')) {
                        icon.textContent = 'expand_more';
                    } else {
                        icon.textContent = 'expand_less';
                    }
                });
            });
            
            // Live Chat Toggle Functionality
            const chatToggle = document.getElementById('chatToggle');
            const chatWindow = document.getElementById('chatWindow');
            const closeChat = document.getElementById('closeChat');
            const messageInput = document.getElementById('messageInput');
            const sendMessageBtn = document.getElementById('sendMessage');
            const chatMessages = document.getElementById('chatMessages');
            
            if (chatToggle && chatWindow) {
                chatToggle.addEventListener('click', function() {
                    chatWindow.classList.toggle('hidden');
                });
                
                closeChat.addEventListener('click', function() {
                    chatWindow.classList.add('hidden');
                });
            }
            
            // Function to add a message to the chat
            function addMessage(text, isUser = true) {
                const messageDiv = document.createElement('div');
                messageDiv.className = isUser ? 'flex justify-end' : 'flex justify-start';
                
                const messageContent = document.createElement('div');
                messageContent.className = isUser ? 
                    'bg-primary text-white rounded-lg p-3 max-w-xs' : 
                    'bg-gray-100 dark:bg-gray-700 rounded-lg p-3 max-w-xs';
                
                const messageText = document.createElement('p');
                messageText.className = isUser ? 'text-sm' : 'text-sm text-[#111418] dark:text-white';
                messageText.textContent = text;
                
                const messageTime = document.createElement('p');
                const now = new Date();
                const timeString = now.getHours() + ':' + (now.getMinutes() < 10 ? '0' : '') + now.getMinutes();
                messageTime.className = isUser ? 'text-xs text-blue-100 mt-1' : 'text-xs text-[#617589] dark:text-gray-400 mt-1';
                messageTime.textContent = timeString;
                
                messageContent.appendChild(messageText);
                messageContent.appendChild(messageTime);
                messageDiv.appendChild(messageContent);
                
                chatMessages.appendChild(messageDiv);
                
                // Scroll to bottom
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
            
            // Function to simulate support response
            function simulateSupportResponse(userMessage) {
                // Show typing indicator
                const typingDiv = document.createElement('div');
                typingDiv.className = 'flex justify-start';
                typingDiv.id = 'typing-indicator';
                typingDiv.innerHTML = `
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3 max-w-xs">
                        <p class="text-sm text-[#111418] dark:text-white">Typing...</p>
                    </div>
                `;
                chatMessages.appendChild(typingDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
                
                // Simulate response after delay
                setTimeout(() => {
                    // Remove typing indicator
                    const typingIndicator = document.getElementById('typing-indicator');
                    if (typingIndicator) {
                        typingIndicator.remove();
                    }
                    
                    // Generate response based on user message
                    let response;
                    if (userMessage.toLowerCase().includes('resident') || userMessage.toLowerCase().includes('add')) {
                        response = 'To add a new resident, go to Residents section > Add Resident. Enter the resident details, assign to a flat, and save. The resident will receive login credentials.';
                    } else if (userMessage.toLowerCase().includes('flat') || userMessage.toLowerCase().includes('unit')) {
                        response = 'To manage flats, go to Flats section > Add Flat. Enter flat details like number, type, floor, and assign residents. You can also edit existing flats from the flats list.';
                    } else if (userMessage.toLowerCase().includes('complaint') || userMessage.toLowerCase().includes('issue')) {
                        response = 'To manage complaints, visit the Complaints section. Here you can view all complaints, update their status (Open, In Progress, Resolved), and communicate with residents about the resolution.';
                    } else if (userMessage.toLowerCase().includes('expense') || userMessage.toLowerCase().includes('payment') || userMessage.toLowerCase().includes('finance')) {
                        response = 'For expenses, go to Expenses section > Add Expense. Enter expense details, category, amount, and date. You can also track monthly expenses and generate financial reports.';
                    } else if (userMessage.toLowerCase().includes('alert') || userMessage.toLowerCase().includes('emergency') || userMessage.toLowerCase().includes('broadcast')) {
                        response = 'To send emergency alerts, go to Emergency Alerts section > Compose Alert. Select priority (Low, Medium, High, Critical), enter message, choose status (Draft, Scheduled, Send Now), and send to all residents.';
                    } else if (userMessage.toLowerCase().includes('subscription') || userMessage.toLowerCase().includes('plan') || userMessage.toLowerCase().includes('billing')) {
                        response = 'For subscription management, visit the Subscription section. Here you can view your current plan, upgrade to a higher plan, check expiry date, and manage payment history.';
                    } else if (userMessage.toLowerCase().includes('document') || userMessage.toLowerCase().includes('file')) {
                        response = 'To manage documents, go to Documents section > Upload Document. You can upload PDFs, images, or other files that residents can access. Organize documents by category for easy access.';
                    } else if (userMessage.toLowerCase().includes('notice') || userMessage.toLowerCase().includes('announcement')) {
                        response = 'To create notices, go to Notices section > Create Notice. Enter the notice title and message, select priority, and publish. Residents will receive the notice in their app.';
                    } else if (userMessage.toLowerCase().includes('poll') || userMessage.toLowerCase().includes('vote')) {
                        response = 'To create a poll, visit Polls section > Create Poll. Enter the question, add options, set duration, and publish. Residents can vote and results will be available after the poll ends.';
                    } else if (userMessage.toLowerCase().includes('profile') || userMessage.toLowerCase().includes('update') || userMessage.toLowerCase().includes('setting') || userMessage.toLowerCase().includes('account')) {
                        response = 'To update your profile, go to the More section in the bottom navigation > Profile. Here you can edit personal information, change password, update profile picture, and manage account settings.';
                    } else {
                        response = 'Thank you for your message. Our support team will get back to you shortly. For quick help, you can check our FAQs section or try commands like "how to add residents", "how to manage expenses", or "how to send alerts".';
                    }
                    
                    addMessage(response, false);
                }, 2000); // 2 second delay to simulate typing
            }
            
            // Send message function
            function sendMessage() {
                const message = messageInput.value.trim();
                if (message) {
                    addMessage(message, true);
                    messageInput.value = '';
                    
                    // Simulate support response
                    simulateSupportResponse(message);
                }
            }
            
            // Event listeners for sending messages
            if (sendMessageBtn) {
                sendMessageBtn.addEventListener('click', sendMessage);
            }
            
            if (messageInput) {
                messageInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        sendMessage();
                    }
                });
            }
        });
    </script>
</div>
@endsection