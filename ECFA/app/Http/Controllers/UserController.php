<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use App\Models\Event;
use App\Models\LearnMaterial;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Cloudinary\Cloudinary;


class UserController extends Controller
{
  public function playerDashboard()
{
    $user = Auth::user();

    // Stats Logic
    $totalEvents = Event::count();
    $myAchievements = Achievement::where('user_id', $user->id)->count();

    // Dynamic stats (can be connected to DB later)
    $stats = [
        'rank' => 'Elite Fencer',
        'level' => 12,
        'xp_percent' => 75, // For a progress bar
    ];

    $upcomingEvents = Event::where('event_date', '>=', now())
                            ->orderBy('event_date', 'asc')
                            ->take(3)->get();

    $latestMaterials = LearnMaterial::latest()->take(3)->get();

    return view('player-dashboard', compact('user', 'totalEvents', 'myAchievements', 'stats', 'upcomingEvents', 'latestMaterials'));
}

public function profile() {
    $user = Auth::user();

     $myMessages = Contact::where('email', $user->email)->latest()->get();

    $user->load(['registeredEvents' => function($q) {
        $q->orderBy('event_date', 'desc');
    }]);

     $stats = [
        'rank' => 'Elite Fencer',
        'level' => 12,
        'xp_percent' => 75,
        'points' => 1250,
        'win_rate' => '72%'
    ];

    return view('profile', compact('user', 'stats', 'myMessages'));
}

public function showChangePasswordForm()
{
    return view('change-password');
}

public function updatePassword(Request $request)
{
    // 1. Validation
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed',
    ]);

    // 2. Check if current password matches
    if (!Hash::check($request->current_password, Auth::user()->password)) {
        return back()->withErrors(['current_password' => 'Current password does not match our records.']);
    }

    // 3. Update the password
    $user = Auth::user();
    $user->password = Hash::make($request->new_password);
    $user->save();

    return redirect()->route('player.profile')->with('success', 'Password changed successfully! 🔐');
}

public function viewCertificate($id) {
    $achievement = Achievement::findOrFail($id);
    return view('certificate', compact('achievement'));
}
public function addAchievementForm() {
    // Fetch all approved players to show in the dropdown
    $players = User::where('role', 'player')->where('is_approved', true)->get();
    return view('admin-add-achievement', compact('players'));
}


public function storeAchievement(Request $request) {
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'title' => 'required|string|max:255',
        'event_name' => 'required|string',
        'medal_type' => 'required',
        'level' => 'required',
        'achievement_date' => 'required|date',
        'certificate' => 'required|image|max:5120', // Max 5MB
    ]);

    try {
        $file = $request->file('certificate');
        $config = config('cloudinary.cloud');

        $cloudinary = new \Cloudinary\Cloudinary([
            'cloud' => [
                'cloud_name' => $config['cloud_name'],
                'api_key'    => $config['api_key'],
                'api_secret' => $config['api_secret'],
            ]
        ]);

        // Upload to a specific folder in Cloudinary
        $upload = $cloudinary->uploadApi()->upload($file->getRealPath(), [
            'folder' => 'ecfa_certificates'
        ]);

        // Save to Database
        Achievement::create([
            'user_id' => $request->user_id,
            'title'            => $request->title,
            'event_name' => $request->event_name,
            'medal_type' => $request->medal_type,
            'level'            => $request->level,
            'achievement_date' => $request->achievement_date,
             'image'            => $upload['secure_url'],
            'description'      => $request->description ?? 'Official Achievement Record',
        ]);

        return back()->with('success', 'Certificate uploaded and assigned to player successfully! 🏆');

    } catch (\Exception $e) {
        return back()->with('error', 'Upload failed: ' . $e->getMessage());
    }
}



}
