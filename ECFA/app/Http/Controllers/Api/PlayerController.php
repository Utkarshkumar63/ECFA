<?php

namespace App\Http\Controllers\Api;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PlayerController extends Controller
{
    /**
     * Get all active players
     */
    public function index(): JsonResponse
    {
        $players = Player::where('is_active', true)->get();
        return response()->json([
            'success' => true,
            'data' => $players
        ]);
    }

    /**
     * Get a single player with achievements and events
     */
    public function show($id): JsonResponse
    {
        $player = Player::with('achievements', 'events')->find($id);
        
        if (!$player) {
            return response()->json([
                'success' => false,
                'message' => 'Player not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $player
        ]);
    }

    /**
     * Create a new player (Admin only)
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:100',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:Male,Female,Other',
            'email' => 'required|email|unique:players',
            'phone' => 'required|digits:10',
            'address' => 'required|string|min:5',
            'category' => 'required|in:U-8,U-10,U-12,U-14,U-16,U-18,Senior',
            'event_type' => 'nullable|in:Épée,Foil,Sabre',
            'bio' => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'emergency_contact' => 'nullable|string|max:100',
            'emergency_phone' => 'nullable|digits:10',
        ]);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('players', 'public');
            $validated['profile_image'] = $path;
        }

        $player = Player::create($validated);
        return response()->json([
            'success' => true,
            'message' => 'Player created successfully',
            'data' => $player
        ], 201);
    }

    /**
     * Update a player (Admin only)
     */
    public function update(Request $request, $id): JsonResponse
    {
        $player = Player::find($id);
        
        if (!$player) {
            return response()->json([
                'success' => false,
                'message' => 'Player not found'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'string|min:3|max:100',
            'date_of_birth' => 'date|before:today',
            'gender' => 'in:Male,Female,Other',
            'email' => 'email|unique:players,email,' . $id,
            'phone' => 'digits:10',
            'address' => 'string|min:5',
            'category' => 'in:U-8,U-10,U-12,U-14,U-16,U-18,Senior',
            'event_type' => 'nullable|in:Épée,Foil,Sabre',
            'bio' => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'emergency_contact' => 'nullable|string|max:100',
            'emergency_phone' => 'nullable|digits:10',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('players', 'public');
            $validated['profile_image'] = $path;
        }

        $player->update($validated);
        return response()->json([
            'success' => true,
            'message' => 'Player updated successfully',
            'data' => $player
        ]);
    }

    /**
     * Delete a player (Admin only)
     */
    public function destroy($id): JsonResponse
    {
        $player = Player::find($id);
        
        if (!$player) {
            return response()->json([
                'success' => false,
                'message' => 'Player not found'
            ], 404);
        }

        $player->delete();
        return response()->json([
            'success' => true,
            'message' => 'Player deleted successfully'
        ]);
    }

    /**
     * Get players by category
     */
    public function byCategory($category): JsonResponse
    {
        $players = Player::where('category', $category)
            ->where('is_active', true)
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $players
        ]);
    }

    /**
     * Get players by event type
     */
    public function byEventType($eventType): JsonResponse
    {
        $players = Player::where('event_type', $eventType)
            ->where('is_active', true)
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $players
        ]);
    }
}
