<nav class="fixed bottom-0 left-0 right-0 z-50 bg-white dark:bg-[#111418] shadow-lg border-t border-gray-200 dark:border-gray-700 flex justify-between items-center px-2 py-1 h-16">
    <!-- Home -->
    <a href="{{ route('building-admin.dashboard') }}" class="flex flex-col items-center justify-center flex-1 {{ $active == 'dashboard' ? 'text-primary' : 'text-gray-500 dark:text-gray-300' }}">
        <span class="material-symbols-outlined text-2xl">home</span>
        <span class="text-xs">Home</span>
    </a>
    <!-- Complaints -->
    <a href="{{ route('building-admin.complaints.index') }}" class="flex flex-col items-center justify-center flex-1 {{ $active == 'complaints' ? 'text-primary' : 'text-gray-500 dark:text-gray-300' }}">
        <span class="material-symbols-outlined text-2xl">report</span>
        <span class="text-xs">Complaints</span>
    </a>
    <!-- Add / Action (Center Button) -->
    @if ($active == 'dashboard')
    <div class="relative flex-1 flex items-center justify-center">
        <button id="actionSheetBtn" class="bg-primary text-white rounded-full shadow-lg w-12 h-12 flex items-center justify-center absolute -top-6 left-1/2 transform -translate-x-1/2 z-10">
            <span class="material-symbols-outlined text-2xl">add</span>
        </button>
        <!-- Action Sheet (hidden by default, show on click) -->
        <div id="actionSheet" class="hidden absolute bottom-16 left-1/2 transform -translate-x-1/2 bg-white dark:bg-[#1a2632] rounded-xl shadow-lg p-4 w-56">
            <button class="w-full flex items-center gap-2 py-2 text-primary hover:bg-gray-100 rounded" onclick="location.href='{{ route('building-admin.residents.create') }}'">
                <span class="material-symbols-outlined">person_add</span> Add Resident
            </button>
            <button class="w-full flex items-center gap-2 py-2 text-primary hover:bg-gray-100 rounded" onclick="location.href='{{ route('building-admin.expenses.create') }}'">
                <span class="material-symbols-outlined">receipt_long</span> Add Expense
            </button>
            <button class="w-full flex items-center gap-2 py-2 text-primary hover:bg-gray-100 rounded" onclick="location.href='{{ route('building-admin.emergency.create') }}'">
                <span class="material-symbols-outlined">emergency</span> Send Emergency Alert
            </button>
            <input type="file" name="file" id="fileInput" class="hidden" onchange="document.getElementById('uploadForm').submit()" required />
            <button type="button" onclick="document.getElementById('fileInput').click()" class="w-full flex items-center gap-2 py-2 text-primary hover:bg-gray-100 rounded">
                <span class="material-symbols-outlined text-xl">upload</span>
                Upload
            </button>
        </div>
    </div>
    @endif
    <!-- Expenses -->
    <a href="{{ route('building-admin.expenses.index') }}" class="flex flex-col items-center justify-center flex-1 {{ $active == 'expenses' ? 'text-primary' : 'text-gray-500 dark:text-gray-300' }}">
        <span class="material-symbols-outlined text-2xl">payments</span>
        <span class="text-xs">Expenses</span>
    </a>
    <!-- More -->
    <div class="relative flex-1 flex items-center justify-center">
        <button id="moreMenuBtn" class="flex flex-col items-center justify-center w-full {{ $active == 'more' ? 'text-primary' : 'text-gray-500 dark:text-gray-300' }}">
            <span class="material-symbols-outlined text-2xl">menu</span>
            <span class="text-xs">More</span>
        </button>
        <!-- More Menu (hidden by default, show on click) -->
        <div id="moreMenu" class="hidden absolute bottom-16 right-0 bg-white dark:bg-[#1a2632] rounded-xl shadow-lg p-4 w-56">
            <a href="{{ route('building-admin.emergency') }}" class="flex flex-col items-center justify-center flex-1 {{ $active == 'emergency' ? 'text-primary' : 'text-gray-500 dark:text-gray-300' }}">
                <span class="material-symbols-outlined text-2xl">campaign</span>
                <span class="text-xs">Alerts</span>
            <a href="{{ route('building-admin.subscription') }}" class="flex flex-col items-center justify-center flex-1 {{ $active == 'subscription' ? 'text-primary' : 'text-gray-500 dark:text-gray-300' }}">
                <span class="material-symbols-outlined text-2xl">credit_card</span>
                <span class="text-xs">Subscription</span>
            </a>
            <a href="{{ route('building-admin.flat-management.index') }}" class="flex flex-col items-center justify-center flex-1 {{ $active == 'flat-management' ? 'text-primary' : 'text-gray-500 dark:text-gray-300' }}">
                <span class="material-symbols-outlined text-2xl">home_work</span>
                <span class="text-xs">Flats</span>
            </a>
            <a href="{{ route('building-admin.resident-management.index') }}" class="flex flex-col items-center justify-center flex-1 {{ $active == 'resident-management' ? 'text-primary' : 'text-gray-500 dark:text-gray-300' }}">
                <span class="material-symbols-outlined text-2xl">groups</span>
                <span class="text-xs">Residents</span>
            </a>
            <a href="{{ route('building-admin.resident-management.index') }}" class="flex flex-col items-center justify-center flex-1 {{ $active == 'resident-management' ? 'text-primary' : 'text-gray-500 dark:text-gray-300' }}">
                <span class="material-symbols-outlined text-2xl">groups</span>
                <span class="text-xs">Residents</span>
            </a>
            <a href="{{ route('building-admin.documents.index') }}" class="flex flex-col items-center justify-center flex-1 {{ $active == 'documents' ? 'text-primary' : 'text-gray-500 dark:text-gray-300' }}">
                <span class="material-symbols-outlined text-2xl">folder_open</span>
                <span class="text-xs">Documents</span>
            </a>
            <a href="{{ route('building-admin.reports') }}" class="flex flex-col items-center justify-center flex-1 {{ $active == 'reports' ? 'text-primary' : 'text-gray-500 dark:text-gray-300' }}">
                <span class="material-symbols-outlined text-2xl">bar_chart</span>
                <span class="text-xs">Reports</span>
            </a>
            <a href="{{ route('building-admin.notices.index') }}" class="flex flex-col items-center justify-center flex-1 {{ $active == 'notices' ? 'text-primary' : 'text-gray-500 dark:text-gray-300' }}">
                <span class="material-symbols-outlined text-2xl">how_to_vote</span>
                <span class="text-xs">Polls</span>
            </a>
            <a href="{{ route('building-admin.admin-profile') }}" class="flex flex-col items-center justify-center flex-1 {{ $active == 'admin-profile' ? 'text-primary' : 'text-gray-500 dark:text-gray-300' }}">
                <span class="material-symbols-outlined text-2xl">person</span>
                <span class="text-xs">Profile</span>
            </a>
            <a href="{{ route('building-admin.support') }}" class="flex flex-col items-center justify-center flex-1 {{ $active == 'support' ? 'text-primary' : 'text-gray-500 dark:text-gray-300' }}">
                <span class="material-symbols-outlined text-2xl">support_agent</span>
                <span class="text-xs">Support</span>
            </a>
            <a href="{{ route('building-admin.logout') }}" class="flex flex-col items-center justify-center flex-1 {{ $active == 'logout' ? 'text-primary' : 'text-gray-500 dark:text-gray-300' }}">
                <span class="material-symbols-outlined text-2xl">logout</span>
                <span class="text-xs">Logout</span>
            </a>
        </div>
    </div>
</nav>
<script>
// Action Sheet toggle
const actionBtn = document.getElementById('actionSheetBtn');
const actionSheet = document.getElementById('actionSheet');
actionBtn && actionBtn.addEventListener('click', () => {
    actionSheet.classList.toggle('hidden');
});
// More Menu toggle
const moreBtn = document.getElementById('moreMenuBtn');
const moreMenu = document.getElementById('moreMenu');
moreBtn && moreBtn.addEventListener('click', () => {
    moreMenu.classList.toggle('hidden');
});
// Hide menus on outside click
window.addEventListener('click', function(e) {
    if (!actionBtn.contains(e.target) && !actionSheet.contains(e.target)) {
        actionSheet.classList.add('hidden');
    }
    if (!moreBtn.contains(e.target) && !moreMenu.contains(e.target)) {
        moreMenu.classList.add('hidden');
    }
});
</script>