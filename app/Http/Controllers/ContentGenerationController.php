<?php

namespace App\Http\Controllers;

use App\Models\ContentGeneration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ContentGenerationController extends Controller
{
    /**
     * Show dashboard / generator form.
     */
    public function index()
    {
        $recentGenerations = ContentGeneration::where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('recentGenerations'));
    }

    /**
     * Generate content using Gemini API and save to DB.
     */
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'content_type'  => 'required|string|max:100',
            'topic'         => 'nullable|string|max:500',
            'keywords'      => 'nullable|string|max:500',
            'audience'      => 'nullable|string|max:255',
            'tone'          => 'required|string|max:100',
            'instructions'  => 'nullable|string|max:1000',
        ]);

        $prompt = $this->buildPrompt($validated);

        try {
            $generatedContent = $this->callGeminiApi($prompt);
        } catch (\Exception $e) {
            Log::error('Gemini API Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'AI generation failed: ' . $e->getMessage(),
            ], 422);
        }

        $wordCount = str_word_count(strip_tags($generatedContent));

        $generation = ContentGeneration::create([
            'user_id'           => Auth::id(),
            'content_type'      => $validated['content_type'],
            'topic'             => $validated['topic'] ?? null,
            'keywords'          => $validated['keywords'] ?? null,
            'audience'          => $validated['audience'] ?? null,
            'tone'              => $validated['tone'],
            'instructions'      => $validated['instructions'] ?? null,
            'generated_content' => $generatedContent,
            'word_count'        => $wordCount,
        ]);

        return response()->json([
            'success'    => true,
            'content'    => $generatedContent,
            'word_count' => $wordCount,
            'id'         => $generation->id,
            'created_at' => $generation->created_at->format('d M Y, H:i'),
        ]);
    }

    /**
     * History page with search and pagination.
     */
    public function history(Request $request)
    {
        $query = ContentGeneration::where('user_id', Auth::id())->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('topic', 'like', "%{$search}%")
                  ->orWhere('content_type', 'like', "%{$search}%")
                  ->orWhere('keywords', 'like', "%{$search}%")
                  ->orWhere('generated_content', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('content_type', $request->type);
        }

        $generations = $query->paginate(10)->withQueryString();

        return view('history', compact('generations'));
    }

    /**
     * Show a single generation.
     */
    public function show(ContentGeneration $generation)
    {
        $this->authorizeGeneration($generation);

        return response()->json([
            'success' => true,
            'content' => $generation->generated_content,
            'meta'    => [
                'content_type' => $generation->content_type,
                'topic'        => $generation->topic,
                'tone'         => $generation->tone,
                'word_count'   => $generation->word_count,
                'created_at'   => $generation->created_at->format('d M Y, H:i'),
            ],
        ]);
    }

    /**
     * Delete a generation.
     */
    public function destroy(ContentGeneration $generation)
    {
        $this->authorizeGeneration($generation);
        $generation->delete();

        return response()->json(['success' => true, 'message' => 'Generation deleted.']);
    }

    // ─── Private helpers ──────────────────────────────────────────────────────

    private function authorizeGeneration(ContentGeneration $generation): void
    {
        if ($generation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }

    private function buildPrompt(array $data): string
    {
        $contentType  = $data['content_type'];
        $topic        = $data['topic'] ?? 'General topic';
        $keywords     = $data['keywords'] ?? '';
        $audience     = $data['audience'] ?? 'General audience';
        $tone         = $data['tone'];
        $instructions = $data['instructions'] ?? '';

        $keywordsLine = $keywords
            ? "Keywords to include: {$keywords}."
            : '';

        $instructionsLine = $instructions
            ? "Additional instructions: {$instructions}."
            : '';

        return <<<PROMPT
You are an expert marketing copywriter. Generate a high-quality {$contentType} based on the following details:

Topic/Subject: {$topic}
Target Audience: {$audience}
Tone of Voice: {$tone}
{$keywordsLine}
{$instructionsLine}

Requirements:
- Write the full content ready to use (no placeholders like [INSERT HERE])
- Match the tone strictly: {$tone}
- Format appropriately for the content type (e.g. use subject line for email, headline for blog post, hashtags for social media)
- Be specific, engaging, and professional
- Do NOT include meta commentary, just output the content itself

Generate the {$contentType} now:
PROMPT;
    }

    private function callGeminiApi(string $prompt): string
    {
        $apiKey = config('services.gemini.api_key');
        $model  = config('services.gemini.model', 'gemini-1.5-flash');

        if (empty($apiKey)) {
            throw new \RuntimeException('Gemini API key is not configured.');
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        $response = Http::timeout(60)->post($url, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                    ],
                ],
            ],
            'generationConfig' => [
                'temperature'     => 0.8,
                'topK'            => 40,
                'topP'            => 0.95,
                'maxOutputTokens' => 2048,
            ],
        ]);

        if ($response->failed()) {
            $error = $response->json('error.message') ?? $response->body();
            throw new \RuntimeException("Gemini API returned error: {$error}");
        }

        $content = $response->json('candidates.0.content.parts.0.text');

        if (empty($content)) {
            throw new \RuntimeException('Gemini API returned an empty response.');
        }

        return trim($content);
    }
}