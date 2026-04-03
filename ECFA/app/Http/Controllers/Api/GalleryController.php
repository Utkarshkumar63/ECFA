<?php

namespace App\Http\Controllers\Api;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GalleryController extends Controller
{
    /**
     * Get all published gallery items
     */
    public function index(): JsonResponse
    {
        $gallery = Gallery::where('is_published', true)
            ->orderBy('display_order')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $gallery
        ]);
    }

    /**
     * Get gallery items by type
     */
    public function byType($type): JsonResponse
    {
        $gallery = Gallery::where('media_type', $type)
            ->where('is_published', true)
            ->orderBy('display_order')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $gallery
        ]);
    }

    /**
     * Get gallery items by event
     */
    public function byEvent($eventId): JsonResponse
    {
        $gallery = Gallery::where('event_id', $eventId)
            ->where('is_published', true)
            ->orderBy('display_order')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $gallery
        ]);
    }

    /**
     * Get a single gallery item
     */
    public function show($id): JsonResponse
    {
        $item = Gallery::find($id);
        
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Gallery item not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $item
        ]);
    }

    /**
     * Create a new gallery item (Admin only)
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string|max:500',
            'media_type' => 'required|in:Image,Video',
            'media_url' => 'required|url',
            'thumbnail_url' => 'nullable|url',
            'event_id' => 'nullable|exists:events,id',
            'caption' => 'nullable|string|max:300',
            'display_order' => 'integer|min:0',
            'is_published' => 'boolean',
        ]);

        $gallery = Gallery::create($validated);
        return response()->json([
            'success' => true,
            'message' => 'Gallery item created successfully',
            'data' => $gallery
        ], 201);
    }

    /**
     * Update a gallery item (Admin only)
     */
    public function update(Request $request, $id): JsonResponse
    {
        $gallery = Gallery::find($id);
        
        if (!$gallery) {
            return response()->json([
                'success' => false,
                'message' => 'Gallery item not found'
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'string|max:200',
            'description' => 'nullable|string|max:500',
            'media_type' => 'in:Image,Video',
            'media_url' => 'url',
            'thumbnail_url' => 'nullable|url',
            'event_id' => 'nullable|exists:events,id',
            'caption' => 'nullable|string|max:300',
            'display_order' => 'integer|min:0',
            'is_published' => 'boolean',
        ]);

        $gallery->update($validated);
        return response()->json([
            'success' => true,
            'message' => 'Gallery item updated successfully',
            'data' => $gallery
        ]);
    }

    /**
     * Delete a gallery item (Admin only)
     */
    public function destroy($id): JsonResponse
    {
        $gallery = Gallery::find($id);
        
        if (!$gallery) {
            return response()->json([
                'success' => false,
                'message' => 'Gallery item not found'
            ], 404);
        }

        $gallery->delete();
        return response()->json([
            'success' => true,
            'message' => 'Gallery item deleted successfully'
        ]);
    }
}
