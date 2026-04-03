<?php

namespace App\Http\Controllers\Api;

use App\Models\Achievement;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AchievementController extends Controller
{
    /**
     * Get all achievements
     */
    public function index(): JsonResponse
    {
        $achievements = Achievement::with('player')
            ->orderBy('achievement_date', 'desc')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $achievements
        ]);
    }

    /**
     * Get achievements for a specific player
     */
    public function byPlayer($playerId): JsonResponse
    {
        $player = Player::find($playerId);
        
        if (!$player) {
            return response()->json([
                'success' => false,
                'message' => 'Player not found'
            ], 404);
        }

        $achievements = $player->achievements()->orderBy('achievement_date', 'desc')->get();
        return response()->json([
            'success' => true,
            'data' => $achievements
        ]);
    }

    /**
     * Get achievements by level
     */
    public function byLevel($level): JsonResponse
    {
        $achievements = Achievement::where('level', $level)
            ->with('player')
            ->orderBy('achievement_date', 'desc')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $achievements
        ]);
    }

    /**
     * Get achievements by medal type
     */
    public function byMedal($medal): JsonResponse
    {
        $achievements = Achievement::where('medal', $medal)
            ->with('player')
            ->orderBy('achievement_date', 'desc')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $achievements
        ]);
    }

    /**
     * Create a new achievement (Admin only)
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'player_id' => 'required|exists:players,id',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string|max:500',
            'medal' => 'required|in:Gold,Silver,Bronze,Certificate,Participation',
            'level' => 'required|in:Local,Regional,State,National,International',
            'achievement_date' => 'required|date|before_or_equal:today',
            'event_name' => 'required|string|max:200',
            'certificate_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('certificate_image')) {
            $path = $request->file('certificate_image')->store('certificates', 'public');
            $validated['certificate_image'] = $path;
        }

        $achievement = Achievement::create($validated);
        return response()->json([
            'success' => true,
            'message' => 'Achievement created successfully',
            'data' => $achievement
        ], 201);
    }

    /**
     * Update an achievement (Admin only)
     */
    public function update(Request $request, $id): JsonResponse
    {
        $achievement = Achievement::find($id);
        
        if (!$achievement) {
            return response()->json([
                'success' => false,
                'message' => 'Achievement not found'
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'string|max:200',
            'description' => 'nullable|string|max:500',
            'medal' => 'in:Gold,Silver,Bronze,Certificate,Participation',
            'level' => 'in:Local,Regional,State,National,International',
            'achievement_date' => 'date|before_or_equal:today',
            'event_name' => 'string|max:200',
            'certificate_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('certificate_image')) {
            $path = $request->file('certificate_image')->store('certificates', 'public');
            $validated['certificate_image'] = $path;
        }

        $achievement->update($validated);
        return response()->json([
            'success' => true,
            'message' => 'Achievement updated successfully',
            'data' => $achievement
        ]);
    }

    /**
     * Delete an achievement (Admin only)
     */
    public function destroy($id): JsonResponse
    {
        $achievement = Achievement::find($id);
        
        if (!$achievement) {
            return response()->json([
                'success' => false,
                'message' => 'Achievement not found'
            ], 404);
        }

        $achievement->delete();
        return response()->json([
            'success' => true,
            'message' => 'Achievement deleted successfully'
        ]);
    }
}
