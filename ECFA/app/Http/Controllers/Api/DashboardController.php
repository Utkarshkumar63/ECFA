<?php

namespace App\Http\Controllers\Api;

use App\Models\Player;
use App\Models\Event;
use App\Models\Achievement;
use App\Models\Registration;
use App\Models\News;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics (Admin only)
     */
    public function stats(): JsonResponse
    {
        $stats = [
            'total_players' => Player::count(),
            'active_players' => Player::where('is_active', true)->count(),
            'total_events' => Event::count(),
            'upcoming_events' => Event::upcoming()->count(),
            'completed_events' => Event::completed()->count(),
            'total_achievements' => Achievement::count(),
            'pending_registrations' => Registration::where('status', 'Pending')->count(),
            'approved_registrations' => Registration::where('status', 'Approved')->count(),
            'total_news' => News::count(),
            'published_news' => News::where('is_published', true)->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Get pending approvals (Admin only)
     */
    public function pendingApprovals(): JsonResponse
    {
        $pending = [
            'registrations' => Registration::where('status', 'Pending')
                ->with('event')
                ->orderBy('created_at', 'asc')
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $pending
        ]);
    }

    /**
     * Get recent activities (Admin only)
     */
    public function recentActivities(): JsonResponse
    {
        $activities = [
            'recent_registrations' => Registration::orderBy('created_at', 'desc')
                ->take(5)
                ->get(),
            'recent_events' => Event::orderBy('created_at', 'desc')
                ->take(5)
                ->get(),
            'recent_news' => News::orderBy('created_at', 'desc')
                ->take(5)
                ->get(),
            'recent_achievements' => Achievement::orderBy('created_at', 'desc')
                ->take(5)
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $activities
        ]);
    }
}
