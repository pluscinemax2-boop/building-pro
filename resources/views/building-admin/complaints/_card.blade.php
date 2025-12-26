<div class="flex flex-col gap-4 mb-3 rounded-2xl bg-white dark:bg-gray-800 p-4 border border-neutral-200 dark:border-gray-700 shadow-sm">
    <div class="flex items-start gap-3">
        <div class="flex-1">
            <div class="flex items-center gap-2 mb-1">
                @if($complaint->priority === 'High')
                    <span class="inline-flex items-center rounded-md bg-red-50 dark:bg-red-900/30 px-2 py-1 text-xs font-medium text-red-700 dark:text-red-400 ring-1 ring-inset ring-red-600/10">High Priority</span>
                @elseif($complaint->priority === 'Medium')
                    <span class="inline-flex items-center rounded-md bg-yellow-50 dark:bg-yellow-900/30 px-2 py-1 text-xs font-medium text-yellow-800 dark:text-yellow-400 ring-1 ring-inset ring-yellow-600/20">Medium Priority</span>
                @else
                    <span class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-900/30 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20">Low Priority</span>
                @endif
                @if($complaint->status === 'Open')
                    <span class="inline-flex items-center rounded-md bg-red-50 dark:bg-red-900/30 px-2 py-1 text-xs font-medium text-red-700 dark:text-red-400 ring-1 ring-inset ring-red-600/10 ml-2">Open</span>
                @elseif($complaint->status === 'In Progress')
                    <span class="inline-flex items-center rounded-md bg-blue-50 dark:bg-blue-900/30 px-2 py-1 text-xs font-medium text-blue-700 dark:text-blue-400 ring-1 ring-inset ring-blue-700/10 ml-2">In Progress</span>
                @elseif($complaint->status === 'Resolved')
                    <span class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-900/30 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20 ml-2">Resolved</span>
                @else
                    <span class="inline-flex items-center rounded-md bg-yellow-50 dark:bg-yellow-900/30 px-2 py-1 text-xs font-medium text-yellow-800 dark:text-yellow-400 ring-1 ring-inset ring-yellow-600/20 ml-2">{{ $complaint->status }}</span>
                @endif
                <span class="text-xs text-text-secondary dark:text-gray-400">• {{ $complaint->created_at->diffForHumans() }}</span>
            </div>
            <a href="{{ route('building-admin.complaints.show', $complaint->id) }}" class="text-text-primary dark:text-white text-base font-bold leading-tight mb-1 hover:underline">
                {{ $complaint->flat->flat_number ?? '-' }} - {{ $complaint->title }}
            </a>
            @php
                $words = str_word_count(strip_tags($complaint->description), 1);
                $descShort = implode(' ', array_slice($words, 0, 11));
                $descLong = implode(' ', $words);
                $isLong = count($words) > 11;
            @endphp
                <div class="mt-1">
                    <span class="text-text-secondary dark:text-gray-400 text-sm font-normal">
                        @if($isLong)
                            <span>{{ $descShort }}...</span>
                            <a href="{{ route('building-admin.complaints.show', $complaint->id) }}" class="text-primary font-semibold ml-2 hover:underline">View More</a>
                        @else
                            <span>{{ $descShort }}</span>
                        @endif
                    </span>
                </div>
        </div>
        @if($complaint->image)
            <div class="shrink-0 w-20 h-20 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                <img src="{{ asset('storage/' . $complaint->image) }}" alt="Complaint Image" class="object-cover object-center w-full h-full" />
            </div>
        @endif
    </div>
    <div class="flex items-center justify-between pt-3 border-t border-neutral-100 dark:border-gray-700">
        <div class="flex items-center gap-2">
            <div class="h-6 w-6 rounded-full bg-gray-200 dark:bg-gray-600 overflow-hidden flex items-center justify-center">
                <span class="text-xs font-bold text-text-primary dark:text-white">{{ $complaint->resident->name[0] ?? '?' }}</span>
            </div>
            <span class="text-xs font-medium text-text-secondary dark:text-gray-400">{{ $complaint->resident->name ?? '-' }}</span>
        </div>
        @if($complaint->status !== 'Resolved')
            <form method="POST" action="{{ route('building-admin.complaints.update-status', $complaint->id) }}" class="flex items-center gap-2">
                @csrf
                <div class="relative flex items-center">
                    <select name="status" class="appearance-none rounded-md h-10 pl-4 pr-10 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-sm font-semibold text-text-primary dark:text-white focus:ring-2 focus:ring-primary focus:border-primary transition-all shadow-sm min-w-[120px]">
                        @if($complaint->status == 'Open')
                            <option value="In Progress">In Progress</option>
                            <option value="Resolved">Resolved</option>
                        @elseif($complaint->status == 'In Progress')
                            <option value="Resolved">Resolved</option>
                        @endif
                    </select>
                    <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 material-symbols-outlined text-base">expand_more</span>
                </div>
                <button type="submit" class="flex items-center justify-center rounded-md h-10 px-5 bg-primary text-white text-sm font-semibold hover:bg-blue-600 transition-colors shadow-sm">Update</button>
            </form>
        @else
            <span class="inline-flex items-center rounded-md bg-gray-200 dark:bg-gray-700 px-3 py-1 text-xs font-medium text-gray-500 dark:text-gray-400">Resolved</span>
        @endif
    </div>
</div>
