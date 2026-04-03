<?php

namespace App\Http\Controllers\Api;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NewsController extends Controller
{
    /**
     * Get all published news
     */
    public function index(): JsonResponse
    {
        $news = News::published()
            ->orderBy('published_date', 'desc')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $news
        ]);
    }

    /**
     * Get news by type
     */
    public function byType($type): JsonResponse
    {
        $news = News::where('type', $type)
            ->published()
            ->orderBy('published_date', 'desc')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $news
        ]);
    }

    /**
     * Get a single news article
     */
    public function show($id): JsonResponse
    {
        $news = News::find($id);
        
        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'News not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $news
        ]);
    }

    /**
     * Create a new news article (Admin only)
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'content' => 'required|string|min:10',
            'excerpt' => 'nullable|string|max:300',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'type' => 'required|in:News,Announcement,Selection,Update',
            'published_date' => 'required|date|before_or_equal:today',
            'is_published' => 'boolean',
        ]);

        $validated['created_by'] = auth()->id() ?? 1;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news', 'public');
            $validated['image'] = $path;
        }

        $news = News::create($validated);
        return response()->json([
            'success' => true,
            'message' => 'News created successfully',
            'data' => $news
        ], 201);
    }

    /**
     * Update a news article (Admin only)
     */
    public function update(Request $request, $id): JsonResponse
    {
        $news = News::find($id);
        
        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'News not found'
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'string|max:200',
            'content' => 'string|min:10',
            'excerpt' => 'nullable|string|max:300',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'type' => 'in:News,Announcement,Selection,Update',
            'published_date' => 'date|before_or_equal:today',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news', 'public');
            $validated['image'] = $path;
        }

        $news->update($validated);
        return response()->json([
            'success' => true,
            'message' => 'News updated successfully',
            'data' => $news
        ]);
    }

    /**
     * Delete a news article (Admin only)
     */
    public function destroy($id): JsonResponse
    {
        $news = News::find($id);
        
        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'News not found'
            ], 404);
        }

        $news->delete();
        return response()->json([
            'success' => true,
            'message' => 'News deleted successfully'
        ]);
    }
}
