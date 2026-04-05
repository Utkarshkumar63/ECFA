<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use App\Models\Player;
use App\Models\Registration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    /**
     * Get all registrations (Admin only)
     */
    public function index(): JsonResponse
    {
        $registrations = Registration::with('event')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $registrations
        ]);
    }

    /**
     * Get pending registrations (Admin only)
     */
    public function pending(): JsonResponse
    {
        $registrations = Registration::where('status', 'Pending')
            ->with('event')
            ->orderBy('created_at', 'asc')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $registrations
        ]);
    }

    /**
     * Get registrations for a specific event
     */
    public function byEvent($eventId): JsonResponse
    {
        $event = Event::find($eventId);
        
        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found'
            ], 404);
        }

        $registrations = $event->registrations()->get();
        return response()->json([
            'success' => true,
            'data' => $registrations
        ]);
    }

    /**
     * Submit a new registration (Public)
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:100',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:Male,Female,Other',
            'email' => 'required|email',
            'phone' => 'required|digits:10',
            'address' => 'required|string|min:5',
            'category' => 'required|in:U-8,U-10,U-12,U-14,U-16,U-18,Senior',
            'event_type' => 'required|in:Épée,Foil,Sabre',
            'event_id' => 'required|exists:events,id',
        ]);

        // Check if event exists and registration is open
        $event = Event::find($validated['event_id']);
        if (!$event->is_registration_open) {
            return response()->json([
                'success' => false,
                'message' => 'Registration is closed for this event'
            ], 400);
        }

        // Check if registration deadline has passed
        if ($event->registration_end_date && now()->isAfter($event->registration_end_date)) {
            return response()->json([
                'success' => false,
                'message' => 'Registration deadline has passed'
            ], 400);
        }

        // Check if participant already registered for this event
        $existing = Registration::where('email', $validated['email'])
            ->where('event_id', $validated['event_id'])
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'You are already registered for this event'
            ], 400);
        }

        $registration = Registration::create($validated);
        return response()->json([
            'success' => true,
            'message' => 'Registration submitted successfully. Awaiting admin approval.',
            'data' => $registration
        ], 201);
    }

    /**
     * Get a single registration
     */
    public function show($id): JsonResponse
    {
        $registration = Registration::find($id);
        
        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'Registration not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $registration
        ]);
    }

    /**
     * Approve a registration (Admin only)
     */
    public function approve(Request $request, $id): JsonResponse
    {
        $request->validate([
            'player_password' => 'nullable|string|min:6|max:100',
        ]);

        $registration = Registration::find($id);

        if (! $registration) {
            return response()->json([
                'success' => false,
                'message' => 'Registration not found',
            ], 404);
        }

        if ($registration->status !== 'Pending') {
            return response()->json([
                'success' => false,
                'message' => 'Registration is already processed',
            ], 400);
        }

        $plainPassword = $request->input('player_password', 'ecfaPlayer1');

        Player::updateOrCreate(
            ['email' => $registration->email],
            [
                'name' => $registration->name,
                'date_of_birth' => $registration->date_of_birth,
                'gender' => $registration->gender,
                'phone' => $registration->phone,
                'password' => Hash::make($plainPassword),
                'address' => $registration->address,
                'category' => $registration->category,
                'event_type' => $registration->event_type,
                'bio' => '',
                'is_active' => true,
            ]
        );

        $registration->update([
            'status' => 'Approved',
            'approved_at' => now(),
            'approved_by' => auth()->id() ?? 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registration approved. Player can log in with this email and the password you set (default: ecfaPlayer1 if omitted).',
            'data' => $registration->fresh(),
            'player_login_hint' => 'Share password securely with the player.',
        ]);
    }

    /**
     * Reject a registration (Admin only)
     */
    public function reject(Request $request, $id): JsonResponse
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $registration = Registration::find($id);
        
        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'Registration not found'
            ], 404);
        }

        if ($registration->status !== 'Pending') {
            return response()->json([
                'success' => false,
                'message' => 'Registration is already processed'
            ], 400);
        }

        $registration->update([
            'status' => 'Rejected',
            'rejection_reason' => $request->rejection_reason,
            'approved_by' => auth()->id() ?? 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registration rejected',
            'data' => $registration
        ]);
    }

    /**
     * Delete a registration (Admin only)
     */
    public function destroy($id): JsonResponse
    {
        $registration = Registration::find($id);
        
        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'Registration not found'
            ], 404);
        }

        $registration->delete();
        return response()->json([
            'success' => true,
            'message' => 'Registration deleted successfully'
        ]);
    }
}
