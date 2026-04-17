<?php

namespace App\Http\Controllers;

use App\Models\Generation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ContentController extends Controller
{
    // ── Dashboard ────────────────────────────────────────────────────────────
    public function dashboard()
    {
        $recentGenerations = Generation::where('user_id', Auth::id())
            ->latest()
            ->take(20)
            ->get();

        return view('dashboard', compact('recentGenerations'));
    }

    // ── Generate content (POST) ───────────────────────────────────────────────
    public function generate(Request $request)
    {
        $request->validate([
            'content_type' => 'required|string|max:100',
            'topic'        => 'nullable|string|max:500',
            'keywords'     => 'nullable|string|max:300',
            'audience'     => 'nullable|string|max:200',
            'tone'         => 'nullable|string|max:50',
            'instructions' => 'nullable|string|max:1000',
        ]);

        $prompt = $this->buildPrompt($request);

        try {
            $content = $this->callGemini($prompt);
        } catch (\Exception $e) {
            Log::error('Gemini error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'AI service error: ' . $e->getMessage(),
            ], 500);
        }

        // Save to DB
        $generation = Generation::create([
            'user_id'      => Auth::id(),
            'content_type' => $request->content_type,
            'topic'        => $request->topic,
            'keywords'     => $request->keywords,
            'audience'     => $request->audience,
            'tone'         => $request->tone ?? 'Professional',
            'instructions' => $request->instructions,
            'content'      => $content,
            'word_count'   => str_word_count($content),
        ]);

        return response()->json([
            'success'      => true,
            'content'      => $content,
            'content_type' => $generation->content_type,
            'word_count'   => $generation->word_count,
            'id'           => $generation->id,
        ]);
    }

    // ── History page ─────────────────────────────────────────────────────────
    public function history()
    {
        $generations = Generation::where('user_id', Auth::id())
            ->latest()
            ->paginate(20);

        return view('content.history', compact('generations'));
    }

    // ── Load single generation (sidebar click) ────────────────────────────────
    public function show($id)
    {
        $gen = Generation::where('user_id', Auth::id())
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'content' => $gen->content,
            'meta' => [
                'content_type' => $gen->content_type,
                'topic'        => $gen->topic,
                'word_count'   => $gen->word_count,
                'created_at'   => $gen->created_at->format('d M Y, H:i'),
            ],
        ]);
    }

    // ── Delete single generation ──────────────────────────────────────────────
    public function destroy($id)
    {
        $gen = Generation::where('user_id', Auth::id())
            ->findOrFail($id);

        $gen->delete();

        return response()->json(['success' => true]);
    }

    // ── Delete ALL history for current user ───────────────────────────────────
    public function destroyAll()
    {
        Generation::where('user_id', Auth::id())->delete();

        return response()->json(['success' => true]);
    }

    // ── Private helpers ───────────────────────────────────────────────────────
    private function buildPrompt(Request $request): string
    {
        $type         = $request->content_type;
        $topic        = $request->topic        ? "Topic: {$request->topic}" : '';
        $keywords     = $request->keywords     ? "Keywords to include: {$request->keywords}" : '';
        $audience     = $request->audience     ? "Target audience: {$request->audience}" : '';
        $tone         = $request->tone         ? "Tone of voice: {$request->tone}" : 'Tone: Professional';
        $instructions = $request->instructions ? "Additional instructions: {$request->instructions}" : '';

        $parts = array_filter([$topic, $keywords, $audience, $tone, $instructions]);

        return "You are an expert copywriter. Write a {$type} with the following details:\n\n"
            . implode("\n", $parts)
            . "\n\nWrite only the content itself, no meta-commentary or explanations.";
    }

    private function callGemini(string $prompt): string
    {
        $apiKey = config('services.gemini.key');

        if (empty($apiKey)) {
            throw new \RuntimeException('Gemini API key not configured.');
        }

        $response = Http::timeout(30)->post(
            "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}",
            [
                'contents' => [
                    ['parts' => [['text' => $prompt]]]
                ],
                'generationConfig' => [
                    'temperature'     => 0.8,
                    'maxOutputTokens' => 1024,
                ],
            ]
        );

        if (!$response->successful()) {
            throw new \RuntimeException('Gemini API returned: ' . $response->status());
        }

        $data = $response->json();

        return $data['candidates'][0]['content']['parts'][0]['text']
            ?? throw new \RuntimeException('Unexpected Gemini response structure.');
    }
}