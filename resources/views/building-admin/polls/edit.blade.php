@extends('building-admin.layout')

@section('content')
<div class="min-h-screen bg-background-light dark:bg-background-dark">
    <!-- Header -->
    <header class="sticky top-0 z-30 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-5 py-4">
        <div class="flex items-center justify-between max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Edit Poll</h1>
            <a href="{{ route('building-admin.polls.index') }}" class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">
                <span class="material-symbols-outlined">close</span>
            </a>
        </div>
    </header>

    <!-- Form -->
    <section class="px-5 py-8 max-w-2xl mx-auto">
        @if($errors->any())
            <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                <p class="text-sm font-semibold text-red-600 dark:text-red-400 mb-2">Please fix the following errors:</p>
                <ul class="text-sm text-red-600 dark:text-red-400 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('building-admin.polls.update', $poll->id) }}" class="bg-white dark:bg-surface-dark rounded-xl shadow-sm border border-slate-100 dark:border-slate-800 p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Question -->
            <div>
                <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Poll Question *</label>
                <input type="text" name="question" value="{{ old('question', $poll->question) }}" placeholder="E.g., What should be the color of the lobby?"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 @error('question') border-red-500 @enderror" required>
                @error('question')
                    <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Description (optional)</label>
                <textarea name="description" rows="3" placeholder="Provide more context or details about this poll..."
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 @error('description') border-red-500 @enderror">{{ old('description', $poll->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Category *</label>
                <select name="category" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary/30 @error('category') border-red-500 @enderror" required>
                    <option value="maintenance" {{ old('category', $poll->category) === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="amenity" {{ old('category', $poll->category) === 'amenity' ? 'selected' : '' }}>Amenity</option>
                    <option value="general" {{ old('category', $poll->category) === 'general' ? 'selected' : '' }}>General</option>
                    <option value="other" {{ old('category', $poll->category) === 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('category')
                    <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Dates -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Start Date *</label>
                    <input type="date" name="start_date" value="{{ old('start_date', \Carbon\Carbon::parse($poll->start_date)->format('Y-m-d')) }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary/30 @error('start_date') border-red-500 @enderror" required>
                    @error('start_date')
                        <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">End Date *</label>
                    <input type="date" name="end_date" value="{{ old('end_date', \Carbon\Carbon::parse($poll->end_date)->format('Y-m-d')) }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary/30 @error('end_date') border-red-500 @enderror" required>
                    @error('end_date')
                        <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Status *</label>
                <select name="status" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary/30 @error('status') border-red-500 @enderror" required>
                    <option value="scheduled" {{ old('status', $poll->status) === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="active" {{ old('status', $poll->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="closed" {{ old('status', $poll->status) === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
                @error('status')
                    <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Options -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-sm font-semibold text-slate-900 dark:text-white">Poll Options * (2-6 options)</label>
                    <button type="button" onclick="addOption()" class="text-xs font-semibold text-primary hover:text-blue-700">
                        + Add Option
                    </button>
                </div>
                <div id="optionsContainer" class="space-y-2">
                    @forelse($poll->options as $option)
                        <div class="flex gap-2">
                            <input type="text" name="options[]" value="{{ old('options.' . $loop->index, $option->option_text) }}" placeholder="Option {{ $loop->iteration }}"
                                class="flex-1 px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30">
                            @if($poll->options->count() > 2)
                                <button type="button" onclick="removeOption(this)" class="px-3 py-2 rounded-lg text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            @endif
                        </div>
                    @empty
                        <div class="flex gap-2">
                            <input type="text" name="options[]" placeholder="Option 1"
                                class="flex-1 px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30">
                        </div>
                        <div class="flex gap-2">
                            <input type="text" name="options[]" placeholder="Option 2"
                                class="flex-1 px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30">
                        </div>
                    @endforelse
                </div>
                @error('options')
                    <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-3 pt-4">
                <a href="{{ route('building-admin.polls.index') }}" class="flex-1 px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-700 font-semibold transition-colors text-center">
                    Cancel
                </a>
                <button type="submit" class="flex-1 px-4 py-2.5 rounded-lg bg-primary text-white hover:bg-blue-600 font-semibold transition-colors">
                    Update Poll
                </button>
            </div>
        </form>
    </section>
</div>

<script>
function addOption() {
    const container = document.getElementById('optionsContainer');
    const optionCount = container.children.length;
    
    if (optionCount >= 6) {
        alert('Maximum 6 options allowed');
        return;
    }

    const div = document.createElement('div');
    div.className = 'flex gap-2';
    div.innerHTML = `
        <input type="text" name="options[]" placeholder="Option ${optionCount + 1}"
            class="flex-1 px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30">
        <button type="button" onclick="removeOption(this)" class="px-3 py-2 rounded-lg text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">
            <span class="material-symbols-outlined">delete</span>
        </button>
    `;
    container.appendChild(div);
}

function removeOption(button) {
    const container = document.getElementById('optionsContainer');
    if (container.children.length > 2) {
        button.parentElement.remove();
    } else {
        alert('Minimum 2 options required');
    }
}
</script>
@endsection
