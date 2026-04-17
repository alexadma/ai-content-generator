<?php

namespace App\Http\Controllers;

use App\Models\ContentGeneration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ContentGenerationController extends Controller
{
    // ──────────────────────────────────────────────────────────────
    // Dashboard (Generator Page)
    // ──────────────────────────────────────────────────────────────

    public function index()
    {
        $recentGenerations = ContentGeneration::where('user_id', Auth::id())
            ->latest()
            ->take(20)
            ->get();

        return view('dashboard', compact('recentGenerations'));
    }

    // ──────────────────────────────────────────────────────────────
    // Generate Content
    // ──────────────────────────────────────────────────────────────

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
        } catch (\Throwable $e) {
            Log::error('Gemini API Error', ['message' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
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
            'success'      => true,
            'content'      => $generatedContent,
            'content_type' => $generation->content_type,
            'word_count'   => $wordCount,
            'id'           => $generation->id,
            'created_at'   => $generation->created_at->format('d M Y, H:i'),
        ]);
    }

    // ──────────────────────────────────────────────────────────────
    // History Page (paginated)
    // ──────────────────────────────────────────────────────────────

    public function history()
    {
        $generations = ContentGeneration::where('user_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('content.history', compact('generations'));
    }

    // ──────────────────────────────────────────────────────────────
    // Show Single Generation (JSON — used by sidebar & preview)
    // ──────────────────────────────────────────────────────────────

    public function show(ContentGeneration $generation)
    {
        // Ensure the authenticated user owns this record
        abort_if($generation->user_id !== Auth::id(), 403);

        return response()->json([
            'success' => true,
            'content' => $generation->generated_content,
            'meta'    => [
                'content_type' => $generation->content_type,
                'topic'        => $generation->topic,
                'tone'         => $generation->tone,
                'audience'     => $generation->audience,
                'word_count'   => $generation->word_count,
                'created_at'   => $generation->created_at->format('d M Y, H:i'),
            ],
        ]);
    }

    // ──────────────────────────────────────────────────────────────
    // Destroy Single Generation
    // ──────────────────────────────────────────────────────────────

    public function destroy(ContentGeneration $generation)
    {
        abort_if($generation->user_id !== Auth::id(), 403);

        $generation->delete();

        return response()->json(['success' => true]);
    }

    // ──────────────────────────────────────────────────────────────
    // Destroy ALL Generations for the Authenticated User
    // ──────────────────────────────────────────────────────────────

    public function destroyAll()
    {
        ContentGeneration::where('user_id', Auth::id())->delete();

        return response()->json(['success' => true]);
    }

    // ══════════════════════════════════════════════════════════════
    // PRIVATE HELPERS
    // ══════════════════════════════════════════════════════════════

    private function buildPrompt(array $data): string
    {
        return <<<PROMPT
You are an expert marketing copywriter. Generate a high-quality {$data['content_type']} based on:

Topic: {$data['topic']}
Audience: {$data['audience']}
Tone: {$data['tone']}
Keywords: {$data['keywords']}
Instructions: {$data['instructions']}

Rules:
- No placeholder
- No explanation
- Direct output only
PROMPT;
    }

    private function callGeminiApi(string $prompt): string
    {
        $apiKey = config('services.gemini.api_key');

        if (empty($apiKey)) {
            throw new \RuntimeException('Gemini API key not set.');
        }

        $models = [
            'gemini-2.5-flash',
            'gemini-2.0-flash',
        ];

        foreach ($models as $model) {
            $url = "https://generativelanguage.googleapis.com/v1/models/{$model}:generateContent?key={$apiKey}";

            for ($attempt = 0; $attempt < 3; $attempt++) {
                try {
                    $response = Http::timeout(60)->post($url, [
                        'contents' => [
                            [
                                'parts' => [
                                    ['text' => $prompt],
                                ],
                            ],
                        ],
                    ]);

                    $data = $response->json();

                    Log::info("Gemini RAW response [{$model}]:", $data);

                    if ($response->failed()) {
                        $errorMessage = $data['error']['message'] ?? 'Unknown error';
                        Log::warning("HTTP ERROR {$model}: " . $errorMessage);

                        if (str_contains(strtolower($errorMessage), 'rate') ||
                            str_contains(strtolower($errorMessage), 'demand')) {
                            sleep(pow(2, $attempt));
                            continue;
                        }

                        throw new \RuntimeException($errorMessage);
                    }

                    if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                        Log::warning("INVALID STRUCTURE {$model}", $data);
                        sleep(pow(2, $attempt));
                        continue;
                    }

                    $content = $data['candidates'][0]['content']['parts'][0]['text'];

                    if (!empty($content)) {
                        return trim($content);
                    }

                    Log::warning("EMPTY CONTENT {$model}");

                } catch (\Exception $e) {
                    Log::warning("EXCEPTION {$model}: " . $e->getMessage());
                }

                sleep(pow(2, $attempt));
            }
        }

        throw new \RuntimeException('All Gemini models failed. Please try again later.');
    }
}