<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('AI Content Generator') }}
            </h2>
            <a href="{{ route('content.history') }}" 
               class="text-sm text-purple-600 dark:text-purple-400 hover:underline font-medium">
                View All History →
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl shadow-lg mb-8 overflow-hidden">
                <div class="p-6 text-white">
                    <h3 class="text-2xl font-bold mb-1">Welcome back, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-purple-100 text-sm">Powered by Google Gemini AI — generate professional content in seconds.</p>
                </div>
            </div>

            <!-- Content Generator Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">✨ Generate New Content</h3>

                    <!-- Error Alert -->
                    <div id="errorAlert" class="hidden mb-4 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 rounded-lg">
                        <div class="flex items-start gap-3">
                            <span class="text-red-500 text-xl">⚠️</span>
                            <div>
                                <p class="font-semibold text-red-800 dark:text-red-300 text-sm">Generation Failed</p>
                                <p id="errorMessage" class="text-red-600 dark:text-red-400 text-sm mt-1"></p>
                            </div>
                        </div>
                    </div>

                    <form id="contentForm" class="space-y-5">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Content Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content Type</label>
                                <select id="contentType" name="content_type"
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-purple-500">
                                    <option value="Email Newsletter">📧 Email Newsletter</option>
                                    <option value="Blog Post">📝 Blog Post</option>
                                    <option value="Ad Copy">📣 Ad Copy</option>
                                    <option value="Social Media Post">📱 Social Media Post</option>
                                    <option value="Product Description">🛍 Product Description</option>
                                    <option value="Press Release">📰 Press Release</option>
                                    <option value="Landing Page Copy">🎯 Landing Page Copy</option>
                                    <option value="Video Script">🎬 Video Script</option>
                                </select>
                            </div>

                            <!-- Tone -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tone of Voice</label>
                                <select id="tone" name="tone"
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-purple-500">
                                    <option value="Professional">Professional</option>
                                    <option value="Casual & Friendly">Casual & Friendly</option>
                                    <option value="Persuasive">Persuasive</option>
                                    <option value="Witty & Humorous">Witty & Humorous</option>
                                    <option value="Empathetic">Empathetic</option>
                                    <option value="Formal">Formal</option>
                                </select>
                            </div>
                        </div>

                        <!-- Topic -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Topic / Subject <span class="text-red-400">*</span></label>
                            <input type="text" id="topic" name="topic"
                                   placeholder="e.g., Summer sale announcement, Product launch, Holiday promotion..."
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-purple-500">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Keywords -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Keywords</label>
                                <input type="text" id="keywords" name="keywords"
                                       placeholder="e.g., diskon, gratis ongkir, limited offer"
                                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-purple-500">
                            </div>

                            <!-- Target Audience -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Target Audience</label>
                                <input type="text" id="audience" name="audience"
                                       placeholder="e.g., Young professionals, Small business owners..."
                                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-purple-500">
                            </div>
                        </div>

                        <!-- Additional Instructions -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Additional Instructions <span class="text-gray-400 font-normal">(Optional)</span></label>
                            <textarea id="instructions" name="instructions" rows="3"
                                      placeholder="Add any specific requirements, style preferences, or extra context..."
                                      class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-purple-500"></textarea>
                        </div>

                        <!-- Generate Button -->
                        <button type="submit" id="generateBtn"
                                class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold py-3 px-6 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all duration-200 transform hover:scale-[1.01] disabled:opacity-60 disabled:cursor-not-allowed disabled:transform-none">
                            <span id="btnText">✨ Generate Content</span>
                            <span id="btnLoading" class="hidden">
                                <svg class="inline-block animate-spin -mt-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                Generating with Gemini AI...
                            </span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Generated Content Output -->
            <div id="generatedContent" class="hidden bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Generated Content</h3>
                            <p id="wordCountBadge" class="text-xs text-gray-500 dark:text-gray-400 mt-1"></p>
                        </div>
                        <div class="flex gap-2">
                            <button id="copyBtn"
                                    class="px-3 py-1.5 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition font-medium">
                                📋 Copy
                            </button>
                            <button id="downloadBtn"
                                    class="px-3 py-1.5 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition font-medium">
                                💾 Download .txt
                            </button>
                        </div>
                    </div>
                    <div id="contentOutput"
                         class="whitespace-pre-wrap prose dark:prose-invert max-w-none bg-gray-50 dark:bg-gray-900 p-6 rounded-lg text-sm text-gray-800 dark:text-gray-200 leading-relaxed border border-gray-200 dark:border-gray-700">
                    </div>
                </div>
            </div>

            <!-- Recent Generations History -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Recent Generations</h3>
                        @if($recentGenerations->count() > 0)
                            <a href="{{ route('content.history') }}" class="text-sm text-purple-600 dark:text-purple-400 hover:underline">View all →</a>
                        @endif
                    </div>

                    <div id="historyList" class="space-y-3">
                        @forelse($recentGenerations as $gen)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition" id="history-{{ $gen->id }}">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                                                {{ $gen->content_type }}
                                            </span>
                                            <span class="text-xs text-gray-400">{{ $gen->word_count }} words</span>
                                        </div>
                                        <p class="font-medium text-gray-900 dark:text-gray-100 text-sm truncate">{{ $gen->topic ?? 'Untitled' }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ $gen->excerpt }}</p>
                                    </div>
                                    <div class="flex items-center gap-2 ml-4 shrink-0">
                                        <span class="text-xs text-gray-400">{{ $gen->created_at->diffForHumans() }}</span>
                                        <button onclick="viewGeneration({{ $gen->id }})"
                                                class="text-xs text-blue-600 dark:text-blue-400 hover:underline">View</button>
                                        <button onclick="deleteGeneration({{ $gen->id }})"
                                                class="text-xs text-red-500 hover:underline">Delete</button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-500 dark:text-gray-400 py-10">
                                <p class="text-3xl mb-3">✨</p>
                                <p>No generations yet. Create your first content above!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        const generateRoute  = "{{ route('content.generate') }}";
        const historyBaseUrl = "{{ url('/history') }}";
        const csrfToken      = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // ── Form Submit → Gemini API ──────────────────────────────────────────
        document.getElementById('contentForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const btn        = document.getElementById('generateBtn');
            const btnText    = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');
            const errorAlert = document.getElementById('errorAlert');
            const errorMsg   = document.getElementById('errorMessage');

            // Reset error
            errorAlert.classList.add('hidden');
            errorMsg.textContent = '';

            // Loading state
            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');
            btn.disabled = true;

            const formData = new FormData(this);

            try {
                const response = await fetch(generateRoute, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(data.message || 'An unexpected error occurred.');
                }

                // Show output
                document.getElementById('contentOutput').textContent = data.content;
                document.getElementById('wordCountBadge').textContent = `${data.word_count} words • saved to history`;
                document.getElementById('generatedContent').classList.remove('hidden');
                document.getElementById('generatedContent').scrollIntoView({ behavior: 'smooth' });

                // Refresh page to update recent history (soft approach)
                setTimeout(() => location.reload(), 100);

            } catch (err) {
                errorMsg.textContent = err.message;
                errorAlert.classList.remove('hidden');
                errorAlert.scrollIntoView({ behavior: 'smooth' });
            } finally {
                btnText.classList.remove('hidden');
                btnLoading.classList.add('hidden');
                btn.disabled = false;
            }
        });

        // ── Copy to clipboard ─────────────────────────────────────────────────
        document.getElementById('copyBtn').addEventListener('click', function () {
            const content = document.getElementById('contentOutput').textContent;
            navigator.clipboard.writeText(content).then(() => {
                const orig = this.innerHTML;
                this.innerHTML = '✅ Copied!';
                setTimeout(() => this.innerHTML = orig, 2000);
            });
        });

        // ── Download as .txt ──────────────────────────────────────────────────
        document.getElementById('downloadBtn').addEventListener('click', function () {
            const content = document.getElementById('contentOutput').textContent;
            const blob    = new Blob([content], { type: 'text/plain' });
            const url     = URL.createObjectURL(blob);
            const a       = document.createElement('a');
            a.href        = url;
            a.download    = `content-${Date.now()}.txt`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        });

        // ── View a past generation ────────────────────────────────────────────
        async function viewGeneration(id) {
            try {
                const res  = await fetch(`${historyBaseUrl}/${id}`, {
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
                });
                const data = await res.json();
                if (!data.success) throw new Error('Not found');

                document.getElementById('contentOutput').textContent = data.content;
                const m = data.meta;
                document.getElementById('wordCountBadge').textContent =
                    `${m.content_type} • ${m.word_count} words • ${m.created_at}`;
                document.getElementById('generatedContent').classList.remove('hidden');
                document.getElementById('generatedContent').scrollIntoView({ behavior: 'smooth' });
            } catch (e) {
                alert('Could not load content.');
            }
        }

        // ── Delete a generation ───────────────────────────────────────────────
        async function deleteGeneration(id) {
            if (!confirm('Delete this generation? This cannot be undone.')) return;

            try {
                const res = await fetch(`${historyBaseUrl}/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                });
                const data = await res.json();
                if (data.success) {
                    const el = document.getElementById(`history-${id}`);
                    el?.remove();
                }
            } catch (e) {
                alert('Could not delete.');
            }
        }
    </script>
    @endpush
</x-app-layout>