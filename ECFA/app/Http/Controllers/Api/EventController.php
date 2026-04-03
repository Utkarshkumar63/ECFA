<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    /**
     * Get all events
     */
    public function index(): JsonResponse
    {
        $events = Event::orderBy('event_date', 'desc')->get();
        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }

    /**
     * Get upcoming events only
     */
    public function upcoming(): JsonResponse
    {
        $events = Event::upcoming()->get();
        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }

    /**
     * Get past/completed events
     */
    public function past(): JsonResponse
    {
        $events = Event::completed()->get();
        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }

    /**
     * Get a single event with participants
     */
    public function show($id): JsonResponse
    {
        $event = Event::with(['participants', 'galleryItems', 'registrations'])->find($id);
        
        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $event
        ]);
    }

    /**
     * Create a new event (Admin only)
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'required|string|min:10',
            'event_date' => 'required|date|after_or_equal:today',
            'venue' => 'required|string|max:200',
            'venue_address' => 'nullable|string|max:300',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'status' => 'in:Upcoming,Ongoing,Completed,Cancelled',
            'max_participants' => 'nullable|integer|min:1',
            'rules' => 'nullable|string',
            'event_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_registration_open' => 'boolean',
            'registration_end_date' => 'nullable|date|before:event_date',
        ]);

        if ($request->hasFile('event_image')) {
            $path = $request->file('event_image')->store('events', 'public');
            $validated['event_image'] = $path;
        }

        $event = Event::create($validated);
        return response()->json([
            'success' => true,
            'message' => 'Event created successfully',
            'data' => $event
        ], 201);
    }

    /**
     * Update an event (Admin only)
     */
    public function update(Request $request, $id): JsonResponse
    {
        $event = Event::find($id);
        
        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found'
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'string|max:200',
            'description' => 'string|min:10',
            'event_date' => 'date',
            'venue' => 'string|max:200',
            'venue_address' => 'nullable|string|max:300',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'status' => 'in:Upcoming,Ongoing,Completed,Cancelled',
            'max_participants' => 'nullable|integer|min:1',
            'rules' => 'nullable|string',
            'event_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_registration_open' => 'boolean',
            'registration_end_date' => 'nullable|date',
        ]);

        if ($request->hasFile('event_image')) {
            $path = $request->file('event_image')->store('events', 'public');
            $validated['event_image'] = $path;
        }

        $event->update($validated);
        return response()->json([
            'success' => true,
            'message' => 'Event updated successfully',
            'data' => $event
        ]);
    }

    /**
     * Delete an event (Admin only)
     */
    public function destroy($id): JsonResponse
    {
        $event = Event::find($id);
        
        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found'
            ], 404);
        }

        $event->delete();
        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully'
        ]);
    }
}
