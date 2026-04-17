<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Generation History
            </h2>
            <a href="{{ route('dashboard') }}"
                class="text-sm text-purple-600 dark:text-purple-400 hover:underline font-medium">
                ← Back to Generator
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Search & Filter -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl mb-6 p-6">
                <form method="GET" action="{{ route('content.history') }}" class="flex flex-col sm:flex-row gap-3">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by topic, type, or keyword..."
                        class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-purple-500 text-sm">

                    <select name="type"
                        class="w-full sm:w-48 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-purple-500 text-sm">
                        <option value="">All Types</option>
                        @foreach (['Email Newsletter', 'Blog Post', 'Ad Copy', 'Social Media Post', 'Product Description', 'Press Release', 'Landing Page Copy', 'Video Script'] as $type)
                            <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>
                                {{ $type }}</option>
                        @endforeach
                    </select>

                    <button type="submit"
                        class="px-5 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm font-medium">
                        🔍 Search
                    </button>

                    @if (request()->hasAny(['search', 'type']))
                        <a href="{{ route('content.history') }}"
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition text-sm font-medium text-center">
                            Clear
                        </a>
                    @endif
                </form>
            </div>

            <!-- Results Count -->
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                {{ $generations->total() }} {{ Str::plural('generation', $generations->total()) }} found
                @if (request('search'))
                    for "<strong>{{ request('search') }}</strong>"
                @endif
            </p>

            <!-- History List -->
            @if ($generations->count() > 0)
                <div class="space-y-4">
                    @foreach ($generations as $gen)
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl p-5 hover:shadow-md transition"
                            id="history-{{ $gen->id }}">
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2 mb-2">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                                            {{ $gen->content_type }}
                                        </span>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                            {{ $gen->tone }}
                                        </span>
                                        <span class="text-xs text-gray-400">{{ $gen->word_count }} words</span>
                                    </div>

                                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-1">
                                        {{ $gen->topic ?: 'Untitled' }}
                                    </h4>

                                    @if ($gen->keywords)
                                        <p class="text-xs text-gray-400 mb-1">
                                            🔑 {{ $gen->keywords }}
                                        </p>
                                    @endif

                                    <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2">
                                        {{ $gen->excerpt }}
                                    </p>
                                </div>

                                <div class="flex flex-col sm:items-end gap-2 shrink-0">
                                    <span
                                        class="text-xs text-gray-400">{{ $gen->created_at->format('d M Y, H:i') }}</span>
                                    <div class="flex gap-2">
                                        <button onclick="openModal({{ $gen->id }})"
                                            class="px-3 py-1.5 text-xs bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-800 transition font-medium">
                                            👁 View
                                        </button>
                                        <button onclick="copyGen({{ $gen->id }}, this)"
                                            class="px-3 py-1.5 text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition font-medium">
                                            📋 Copy
                                        </button>
                                        <button onclick="deleteGen({{ $gen->id }})"
                                            class="px-3 py-1.5 text-xs bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-200 dark:hover:bg-red-900 transition font-medium">
                                            🗑 Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $generations->links() }}
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl p-16 text-center">
                    <p class="text-5xl mb-4">📭</p>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">No results found</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">
                        @if (request()->hasAny(['search', 'type']))
                            Try a different search term or filter.
                        @else
                            You haven't generated any content yet.
                        @endif
                    </p>
                    <a href="{{ route('dashboard') }}"
                        class="inline-block px-5 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm font-medium">
                        ✨ Create Your First Content
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- View Modal -->
    <div id="viewModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-3xl max-h-[90vh] flex flex-col">
            <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-700">
                <div>
                    <h3 id="modalTitle" class="font-semibold text-gray-900 dark:text-gray-100 text-lg">Content</h3>
                    <p id="modalMeta" class="text-xs text-gray-400 mt-0.5"></p>
                </div>
                <div class="flex items-center gap-2">
                    <button id="modalCopyBtn"
                        class="px-3 py-1.5 text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 transition font-medium">
                        📋 Copy
                    </button>
                    <button id="modalDownloadBtn"
                        class="px-3 py-1.5 text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 transition font-medium">
                        💾 Download
                    </button>
                    <button onclick="closeModal()"
                        class="ml-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-2xl leading-none">&times;</button>
                </div>
            </div>
            <div class="overflow-y-auto p-5 flex-1">
                <pre id="modalContent" class="whitespace-pre-wrap text-sm text-gray-800 dark:text-gray-200 leading-relaxed font-sans"></pre>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const historyBaseUrl = "{{ url('/history') }}";
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // ── Open modal with content ───────────────────────────────────────────
            async function openModal(id) {
                try {
                    const res = await fetch(`${historyBaseUrl}/${id}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });
                    const data = await res.json();
                    if (!data.success) throw new Error();

                    const m = data.meta;
                    document.getElementById('modalTitle').textContent = `${m.content_type}: ${m.topic || 'Untitled'}`;
                    document.getElementById('modalMeta').textContent =
                    `${m.tone} • ${m.word_count} words • ${m.created_at}`;
                    document.getElementById('modalContent').textContent = data.content;

                    document.getElementById('modalCopyBtn').onclick = () => {
                        navigator.clipboard.writeText(data.content).then(() => {
                            const btn = document.getElementById('modalCopyBtn');
                            const orig = btn.innerHTML;
                            btn.innerHTML = '✅ Copied!';
                            setTimeout(() => btn.innerHTML = orig, 2000);
                        });
                    };

                    document.getElementById('modalDownloadBtn').onclick = () => {
                        const blob = new Blob([data.content], {
                            type: 'text/plain'
                        });
                        const url = URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = `content-${id}.txt`;
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        URL.revokeObjectURL(url);
                    };

                    const modal = document.getElementById('viewModal');
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                } catch {
                    alert('Could not load content.');
                }
            }

            function closeModal() {
                const modal = document.getElementById('viewModal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            // Close on backdrop click
            document.getElementById('viewModal').addEventListener('click', function(e) {
                if (e.target === this) closeModal();
            });

            // ── Copy inline ───────────────────────────────────────────────────────
            async function copyGen(id, btn) {
                try {
                    const res = await fetch(`${historyBaseUrl}/${id}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });
                    const data = await res.json();
                    if (!data.success) throw new Error();
                    await navigator.clipboard.writeText(data.content);
                    const orig = btn.innerHTML;
                    btn.innerHTML = '✅ Copied!';
                    setTimeout(() => btn.innerHTML = orig, 2000);
                } catch {
                    alert('Could not copy content.');
                }
            }

            // ── Delete ────────────────────────────────────────────────────────────
            async function deleteGen(id) {
                if (!confirm('Delete this generation permanently?')) return;

                try {
                    const res = await fetch(`${historyBaseUrl}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    });
                    const data = await res.json();
                    if (data.success) {
                        document.getElementById(`history-${id}`)?.remove();
                        // If no items left, reload to show empty state
                        if (!document.querySelector('[id^="history-"]')) location.reload();
                    }
                } catch {
                    alert('Could not delete.');
                }
            }
        </script>
    @endpush
</x-app-layout>
