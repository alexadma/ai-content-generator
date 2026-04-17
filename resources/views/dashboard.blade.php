<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('AI Content Generator') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-lg shadow-lg mb-8 overflow-hidden">
                <div class="p-6 text-white">
                    <h3 class="text-2xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-purple-100">Ready to create amazing content today? You have <span class="font-bold">20</span> free generations remaining this month.</p>
                </div>
            </div>

            <!-- Content Generator Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Generate New Content</h3>
                    
                    <form id="contentForm" class="space-y-6">
                        @csrf
                        <!-- Content Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content Type</label>
                            <select id="contentType" name="content_type" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-purple-500">
                                <option value="email">📧 Email Newsletter</option>
                                <option value="blog">📝 Blog Post</option>
                                <option value="ad">📣 Ad Copy</option>
                                <option value="social">📱 Social Media</option>
                                <option value="product">🛍 Product Description</option>
                                <option value="press">📰 Press Release</option>
                                <option value="landing">🎯 Landing Page</option>
                                <option value="script">🎬 Video Script</option>
                            </select>
                        </div>

                        <!-- Topic -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Topic / Subject</label>
                            <input type="text" id="topic" name="topic" placeholder="e.g., Summer sale announcement, Product launch, Holiday promotion..." 
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-purple-500">
                        </div>

                        <!-- Target Audience -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Target Audience</label>
                            <input type="text" id="audience" name="audience" placeholder="e.g., Young professionals, Small business owners, Gen Z..." 
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-purple-500">
                        </div>

                        <!-- Tone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tone of Voice</label>
                            <select id="tone" name="tone" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-purple-500">
                                <option value="professional">Professional</option>
                                <option value="casual">Casual & Friendly</option>
                                <option value="persuasive">Persuasive</option>
                                <option value="witty">Witty & Humorous</option>
                                <option value="empathetic">Empathetic</option>
                                <option value="formal">Formal</option>
                            </select>
                        </div>

                        <!-- Additional Instructions -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Additional Instructions (Optional)</label>
                            <textarea id="instructions" name="instructions" rows="3" 
                                      placeholder="Add any specific keywords, points to include, or style preferences..." 
                                      class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-purple-500"></textarea>
                        </div>

                        <!-- Generate Button -->
                        <div>
                            <button type="submit" id="generateBtn" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold py-3 px-6 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all duration-200 transform hover:scale-[1.02]">
                                <span id="btnText">✨ Generate Content</span>
                                <span id="btnLoading" class="hidden">⏳ Generating...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Generated Content Display -->
            <div id="generatedContent" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8 hidden">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Generated Content</h3>
                        <div class="flex gap-2">
                            <button id="copyBtn" class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                📋 Copy
                            </button>
                            <button id="downloadBtn" class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                💾 Download
                            </button>
                        </div>
                    </div>
                    <div id="contentOutput" class="prose dark:prose-invert max-w-none bg-gray-50 dark:bg-gray-900 p-6 rounded-lg">
                        <!-- Generated content will appear here -->
                    </div>
                </div>
            </div>

            <!-- Recent Generations History -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Recent Generations</h3>
                    <div id="historyList" class="space-y-3">
                        <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                            No generations yet. Create your first content above! ✨
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Mock AI Generation (Replace with actual API call)
        document.getElementById('contentForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const generateBtn = document.getElementById('generateBtn');
            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');
            const generatedContentDiv = document.getElementById('generatedContent');
            const contentOutput = document.getElementById('contentOutput');
            
            // Show loading state
            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');
            generateBtn.disabled = true;
            
            // Get form data
            const contentType = document.getElementById('contentType').options[document.getElementById('contentType').selectedIndex].text;
            const topic = document.getElementById('topic').value;
            const audience = document.getElementById('audience').value;
            const tone = document.getElementById('tone').options[document.getElementById('tone').selectedIndex].text;
            const instructions = document.getElementById('instructions').value;
            
            // Simulate API call delay
            setTimeout(() => {
                // Mock generated content based on inputs
                const mockContent = generateMockContent(contentType, topic, audience, tone, instructions);
                
                // Display content
                contentOutput.innerHTML = `<div class="whitespace-pre-wrap">${mockContent}</div>`;
                generatedContentDiv.classList.remove('hidden');
                
                // Save to history
                saveToHistory(contentType, topic, mockContent);
                
                // Reset button state
                btnText.classList.remove('hidden');
                btnLoading.classList.add('hidden');
                generateBtn.disabled = false;
                
                // Scroll to content
                generatedContentDiv.scrollIntoView({ behavior: 'smooth' });
            }, 2000);
        });
        
        // Copy to clipboard
        document.getElementById('copyBtn')?.addEventListener('click', function() {
            const content = document.getElementById('contentOutput').innerText;
            navigator.clipboard.writeText(content).then(() => {
                const originalText = this.innerHTML;
                this.innerHTML = '✅ Copied!';
                setTimeout(() => {
                    this.innerHTML = originalText;
                }, 2000);
            });
        });
        
        // Download as .txt
        document.getElementById('downloadBtn')?.addEventListener('click', function() {
            const content = document.getElementById('contentOutput').innerText;
            const blob = new Blob([content], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `generated-content-${Date.now()}.txt`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        });
        
        // Mock content generator
        function generateMockContent(contentType, topic, audience, tone, instructions) {
            const templates = {
                '📧 Email Newsletter': `Subject: ${topic || 'Special Announcement'} 🎉

Dear ${audience || 'Valued Customer'},

We're excited to share some amazing news with you today! ${topic || 'Our latest offering'} is here to transform the way you work.

✨ What's inside:
• Exclusive benefits just for you
• Limited-time offers
• Early access opportunities

${instructions ? `\nAdditional Notes: ${instructions}\n` : ''}

Ready to get started? Click below to learn more!

Best regards,
The Inkraft Team

P.S. Don't miss out on this opportunity!`,

                '📝 Blog Post': `# ${topic || 'How to Master Your Content Strategy'}

## Introduction

In today's digital landscape, creating compelling content is more important than ever. Whether you're a ${audience || 'content creator'} or business owner, mastering the art of ${topic || 'content creation'} can set you apart from the competition.

## Key Takeaways

- Understand your ${audience || 'target audience'} deeply
- Maintain a ${tone || 'professional'} tone throughout
- Deliver value in every piece

${instructions ? `\n> ${instructions}\n` : ''}

## Conclusion

Start implementing these strategies today and watch your engagement soar!

*What's your biggest content challenge? Share in the comments below!*`,

                '📣 Ad Copy': `🎯 **ATTENTION ${audience?.toUpperCase() || 'EVERYONE'}!** 🎯

${topic || 'Discover'} the solution you've been searching for!

✅ Benefits that matter
✅ Results you can see
✅ Satisfaction guaranteed

**${tone || 'Professional'} tone** | Limited time offer

👉 Click here to learn more: [LINK]

${instructions || 'Don\'t wait - this opportunity won\'t last!'}`,

                '📱 Social Media': `${topic || 'Big news'}! 🚀

${audience || 'Everyone'} needs to hear about this. We're taking things to the next level with our ${tone || 'amazing'} new approach.

👇 Drop a 🔥 if you're excited!

${instructions ? `\n${instructions}\n` : ''}

#ContentCreation #AI #Innovation`,

                '🛍 Product Description': `# Introducing ${topic || 'Our Amazing Product'}

## What Makes It Special?

Designed specifically for ${audience || 'modern consumers'}, our product delivers exceptional results with a ${tone || 'professional'} approach.

### Key Features:
- Premium quality materials
- User-friendly design
- Lifetime durability

${instructions ? `\n✨ ${instructions}\n` : ''}

### Why Choose Us?

Join thousands of satisfied customers who've made the switch. Order today and experience the difference!

*Satisfaction guaranteed or your money back*`,

                '📰 Press Release': `**FOR IMMEDIATE RELEASE**

## ${topic || 'Inkraft Announces Revolutionary New Feature'}

**CITY, State** — ${new Date().toLocaleDateString()} — Inkraft, the leading AI content generation platform, today announced ${topic || 'an exciting new development'} that will transform how ${audience || 'businesses'} create content.

"This is a game-changer," said [Spokesperson Name], [Title]. "${instructions || 'Our commitment to innovation continues to drive exceptional results for our users.'}"

### About Inkraft
Inkraft is revolutionizing content creation with cutting-edge AI technology.

### Media Contact
[Name]
[Email]
[Phone]

###`,

                '🎯 Landing Page': `# ${topic || 'Transform Your Results Today'}

## Join ${audience || 'thousands of successful users'} who've already made the switch

### Why Choose Us?
✓ ${tone || 'Professional'} quality guaranteed
✓ Results-driven approach
✓ Risk-free trial

${instructions ? `💡 ${instructions}\n\n` : ''}

### Limited Time Offer
Get started now with special pricing!

[CTA BUTTON: Get Started Now →]`,

                '🎬 Video Script': `[SCENE START]

**TITLE:** ${topic || 'The Future of Content Creation'}

**TONE:** ${tone || 'Professional'}

**TARGET AUDIENCE:** ${audience || 'Content creators'}

**VISUAL:** Opening shot of [describe scene]

**VOICEOVER:** 
"${instructions || 'Welcome to the future of content creation...'}"

**VISUAL:** Cut to [next scene]

**VOICEOVER:**
"With Inkraft, you can generate professional content in seconds."

**VISUAL:** Final shot with logo

**VOICEOVER:**
"Start your free trial today at inkraft.com"

[SCENE END]`
            };
            
            let content = templates[contentType] || templates['📧 Email Newsletter'];
            
            // Replace placeholders with actual values
            content = content.replace(/\${topic}/g, topic || 'our latest offering');
            content = content.replace(/\${audience}/g, audience || 'our valued customers');
            content = content.replace(/\${tone}/g, tone || 'professional');
            
            return content;
        }
        
        // Save to history (localStorage for demo)
        function saveToHistory(contentType, topic, content) {
            let history = JSON.parse(localStorage.getItem('contentHistory') || '[]');
            history.unshift({
                id: Date.now(),
                contentType: contentType,
                topic: topic,
                content: content.substring(0, 100) + '...',
                date: new Date().toISOString()
            });
            // Keep only last 10 items
            history = history.slice(0, 10);
            localStorage.setItem('contentHistory', JSON.stringify(history));
            displayHistory();
        }
        
        // Display history
        function displayHistory() {
            const historyList = document.getElementById('historyList');
            const history = JSON.parse(localStorage.getItem('contentHistory') || '[]');
            
            if (history.length === 0) {
                historyList.innerHTML = '<div class="text-center text-gray-500 dark:text-gray-400 py-8">No generations yet. Create your first content above! ✨</div>';
                return;
            }
            
            historyList.innerHTML = history.map(item => `
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <span class="font-semibold text-gray-900 dark:text-gray-100">${item.contentType}</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">${item.topic || 'Untitled'}</span>
                        </div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">${new Date(item.date).toLocaleDateString()}</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">${item.content}</p>
                </div>
            `).join('');
        }
        
        // Load history on page load
        displayHistory();
    </script>
    @endpush
</x-app-layout>