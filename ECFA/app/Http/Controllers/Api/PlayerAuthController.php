<?php

namespace App\Http\Controllers\Api;

use App\Models\Player;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PlayerAuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $player = Player::where('email', $validated['email'])->first();

        if (! $player || empty($player->password) || ! Hash::check($validated['password'], $player->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password',
            ], 401);
        }

        if (! $player->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Your account is inactive. Contact ECFA.',
            ], 403);
        }

        $token = $player->createToken('player')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token' => $token,
            'player' => $player->makeHidden(['password', 'remember_token']),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        if ($user instanceof Player) {
            $user->currentAccessToken()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Logged out',
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        $user = $request->user();
        if (! $user instanceof Player) {
            return response()->json([
                'success' => false,
                'message' => 'Not a player session',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $user->makeHidden(['password', 'remember_token']),
        ]);
    }
}
