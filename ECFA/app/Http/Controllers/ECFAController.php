<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Achievement;
use App\Models\LearnMaterial;
use App\Models\Contact; // Ensure this Model exists
use App\Models\Gallery; // Ensure this Model exists
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\ContactMail; // Ensure this Mailable exists
use Illuminate\Support\Facades\Mail;
use Cloudinary\Cloudinary;
use Barryvdh\DomPDF\Facade\Pdf;
class ECFAController extends Controller
{
    // --- 1. Public Pages ---

    /**
     * Landing Page - Shows stats and latest updates
     */
   public function index() {
    return view('index', [
        'playerCount' => '500 +',
        'eventCount' => Event::count(),
        'medalCount' => Achievement::count(), // Using achievements as medals
        'rankStatus' => 'Top 5 In Bihar', // Static or dynamic ranking
        'events' => Event::where('event_date', '>=', now())->latest()->take(3)->get(),
    ]);
}

    /**
     * News Page
     */
    public function news() {
        $news = []; // Fetch from News model later
        return view('news', compact('news'));
    }

    /**
     * Public Events List - Fetches all tournaments from DB
     */
    public function events() {
        $upcoming = Event::latest()->get();
        return view('events', compact('upcoming'));
    }

    /**
     * Public Gallery Page - Fetches images stored via Cloudinary from DB
     */
   public function gallery()
{
    $galleryItems = Gallery::latest()->paginate(20);
    return view('gallery', compact('galleryItems'));
}

    public function adminGallery() {
        $galleryItems = Gallery::latest()->paginate(20);
        return view('admin-gallery', compact('galleryItems'));
    }
    /**
     * Player Registration
     */
 public function register(Request $request) {
    if ($request->isMethod('post')) {

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'category' => 'required',
            'password' => 'required|min:6',
            'dob' => 'required|date',
            'gender' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required',
            'ageGroup' => 'required',
            'experience' => 'required',
            'aadhar_no' => 'required|string|min:12|max:12',

            'aadhar_photo' => 'required|image|max:5120',
            'dob_photo' => 'required|image|max:5120',
            'passport_no' => 'nullable|string',
            'passport_photo' => 'nullable|image|max:5120',
        ]);

        try {
            $config = config('cloudinary.cloud');

            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => $config['cloud_name'],
                    'api_key'    => $config['api_key'],
                    'api_secret' => $config['api_secret'],
                ]
            ]);

            // ✅ Upload Aadhar
            $aadharUpload = $cloudinary->uploadApi()->upload(
                $request->file('aadhar_photo')->getRealPath(),
                ['folder' => 'ecfa_docs']
            );
            $aadharPhotoUrl = $aadharUpload['secure_url'];

            // ✅ Upload DOB
            $dobUpload = $cloudinary->uploadApi()->upload(
                $request->file('dob_photo')->getRealPath(),
                ['folder' => 'ecfa_docs']
            );
            $dobPhotoUrl = $dobUpload['secure_url'];

            // ✅ Optional Passport
            $passportPhotoUrl = null;
            if ($request->hasFile('passport_photo')) {
                $passportUpload = $cloudinary->uploadApi()->upload(
                    $request->file('passport_photo')->getRealPath(),
                    ['folder' => 'ecfa_docs']
                );
                $passportPhotoUrl = $passportUpload['secure_url'];
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Upload Error: ' . $e->getMessage());
        }

        // ✅ Save User
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'category' => $data['category'],
            'password' => Hash::make($data['password']),
            'dob' => $data['dob'],
            'gender' => $data['gender'],
            'address' => $data['address'],
            'city' => $data['city'],
            'state' => $data['state'],
            'pincode' => $data['pincode'],
            'age_group' => $data['ageGroup'],
            'experience' => $data['experience'],
            'events' => $request->events ?? [], // ✅ safe
            'role' => 'player',
            'is_approved' => false,

            'aadhar_no' => $data['aadhar_no'],
            'aadhar_photo' => $aadharPhotoUrl,
            'dob_photo' => $dobPhotoUrl,
            'passport_no' => $data['passport_no'] ?? null,
            'passport_photo' => $passportPhotoUrl,
        ]);

        return back()->with('success', 'Registration submitted successfully! Please wait for Admin approval.');
    }

    return view('registration');
}

public function adminEvents() {
    $events = Event::withCount('athletes')->latest()->paginate(20);

    return view('admin-events', compact('events'));
}



// 1. Approve/Select player for the event
public function approveEventParticipant($eventId, $userId)
{
    $event = Event::findOrFail($eventId);
    // Update the 'status' column in the pivot table
    $event->athletes()->updateExistingPivot($userId, ['status' => 'selected']);

    return back()->with('success', 'Athlete selected for the event successfully! ✅');
}

// 2. Reject/Remove player from the event
public function rejectEventParticipant($eventId, $userId)
{
    $event = Event::findOrFail($eventId);
    // This removes the link between this player and this event
    $event->athletes()->detach($userId);

    return back()->with('message', 'Athlete removed from the event registry. ❌');
}


    public function contactSubmit(Request $request) {
        $data = $request->validate([
            'name'    => 'required|string',
            'email'   => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        // 1. Save to Backend (contacts table)
        Contact::create($data);

        // 2. Send Professional Email to Admin
        Mail::to('ecfamotihari@gmail.com')->send(new ContactMail($data));

        return back()->with('success', 'Your message has been saved and dispatched successfully!');
    }

     public function joinEvent($id)
{
    // 1. Security: Must be logged in
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Please login to join the tournament.');
    }

    $user = Auth::user();

    // 2. Security: Must be an approved player
    if ($user->role !== 'player' || !$user->is_approved) {
        return back()->with('error', 'Only approved athletes can register for events.');
    }

    // 3. Security: Check if Event exists and is still in the future
    $event = Event::findOrFail($id);
    if (\Carbon\Carbon::parse($event->event_date)->isPast()) {
        return back()->with('error', 'Registration is closed. This event has already passed.');
    }

    // 4. Security: Check for duplicate registration
    if ($user->registeredEvents()->where('event_id', $id)->exists()) {
        return back()->with('error', 'You are already registered for ' . $event->title);
    }

    // 5. Action: Attach user to event
    $user->registeredEvents()->attach($id);

    return back()->with('success', 'Confirmed! You are now registered for ' . $event->title);
}


    public function login(Request $request) {
    if ($request->isMethod('get')) { return view('login'); }

    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'player') {
            if ($user->is_approved) {
                // REDIRECT TO DASHBOARD (Better UX)
                return redirect()->route('player.dashboard');
            } else {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account is pending admin approval.']);
            }
        }
    }
    return back()->withErrors(['email' => 'Invalid credentials.']);
}

     public function storeLearn(Request $request) {
    $request->validate([
        'title' => 'required',
        'weapon' => 'required',
        'pdf' => 'required|mimes:pdf|max:10000',
    ]);

    $path = $request->file('pdf')->store('learn_materials', 'public');

    LearnMaterial::create([
        'title' => $request->title,
        'weapon' => $request->weapon,
        'event_id' => $request->event_id,
        'file_path' => $path,
    ]);

    return back()->with('success', 'Training material deployed successfully!');
}

public function deleteLearn($id) {
    $item = LearnMaterial::findOrFail($id);
    $item->delete();
    return back()->with('success', 'Material archived successfully.');
}




    public function logout() {
        Auth::logout();
        return redirect('/');
    }



    public function showAdminLoginForm() {
    // Check karein ki kya user login hai AUR kya uska role 'admin' hai
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    // Agar login nahi hai, toh login page dikhao
    return view('admin-login');
}
    // --- 2. Admin Dashboard & Management ---

    /**
     * Admin Dashboard Overview
     */
    public function adminDashboard() {
        return view('admin-dashboard', [
            'pendingPlayers' => User::where('is_approved', false)
                                    ->where('role', 'player')
                                    ->latest()
                                    ->get(),
            'totalPlayers'  => User::where('is_approved', true)
                                    ->where('role', 'player')
                                    ->count(),
            'totalEvents'   => Event::count(),
            'totalNews'     => 0,
            'totalAchievements' => Achievement::count(),
            'messages' => Contact::latest()->get(), // Displaying backend messages
        ]);
    }

    /**
     * Admin Learning Management
     */
    public function adminLearn() {
        return view('admin-learn', [
            'events' => Event::latest()->get(),
            'materials' => LearnMaterial::with('event')->latest()->get(),
            'gallery' => Gallery::latest()->get() // Added for admin to see gallery list
        ]);
    }



public function storeEvent(Request $request)
{
    $request->validate([
        'title'       => 'required',
        'description' => 'required',
        'event_date'  => 'required',
        'location'    => 'required',
        'image'       => 'required|image|max:5120',
     ]);

    try {
        if (!$request->hasFile('image')) {
            return back()->with('error', 'Image not found!');
        }

        $file = $request->file('image');

        // ✅ GET CONFIG FROM ENV
        $config = config('cloudinary.cloud');

        if (!$config || !$config['cloud_name']) {
            return back()->with('error', 'Cloudinary config missing!');
        }

        // ✅ CREATE CLOUDINARY INSTANCE (NO cloud_url)
        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => $config['cloud_name'],
                'api_key'    => $config['api_key'],
                'api_secret' => $config['api_secret'],
            ]
        ]);

        // ✅ UPLOAD IMAGE
        $upload = $cloudinary->uploadApi()->upload($file->getRealPath());

        if (!$upload || !isset($upload['secure_url'])) {
            return back()->with('error', 'Upload failed!');
        }

        $imageUrl = $upload['secure_url'];

        // ✅ SAVE TO DB
        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'location' => $request->location,
            'image' => $imageUrl,
             'status' => 'upcoming',
        ]);

        return back()->with('success', 'Event Created Successfully 🚀');

    } catch (\Exception $e) {
        return back()->with('error', 'Cloudinary Error: ' . $e->getMessage());
    }
}

public function changeStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:upcoming,completed,cancelled'
    ]);

    $event = Event::findOrFail($id);
    $event->status = $request->status;
    $event->save();

    return back()->with('success', 'Event status updated successfully 🔄');
}

public function editEvent($id)
{
    $event = Event::findOrFail($id);
    return view('admin-edit-event', compact('event'));
}

public function updateEvent(Request $request, $id)
{
    $request->validate([
        'title' => 'required',
        'description' => 'required',
        'event_date' => 'required',
        'location' => 'required',
        'status' => 'required|in:upcoming,completed,cancelled'
    ]);

    $event = Event::findOrFail($id);

    $event->update([
        'title' => $request->title,
        'description' => $request->description,
        'event_date' => $request->event_date,
        'location' => $request->location,
        'status' => $request->status
    ]);

    return redirect()->route('admin.events')->with('success', 'Event updated successfully ✏️');
}

    /**
     * Store New Gallery Image with Cloudinary
     */
    public function storeGallery(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
    ]);

    if ($request->hasFile('image')) {
        try {
            $file = $request->file('image');

            // ✅ GET CONFIG
            $config = config('cloudinary.cloud');

            // ✅ CREATE INSTANCE
            $cloudinary = new \Cloudinary\Cloudinary([
                'cloud' => [
                    'cloud_name' => $config['cloud_name'],
                    'api_key'    => $config['api_key'],
                    'api_secret' => $config['api_secret'],
                ]
            ]);

            // ✅ UPLOAD (CORRECT METHOD)
            $upload = $cloudinary->uploadApi()->upload(
                $file->getRealPath(),
                ['folder' => 'ecfa_gallery']
            );

            $uploadedFileUrl = $upload['secure_url'];

            // ✅ SAVE DB
            Gallery::create([
                'title' => $request->title,
                'url'   => $uploadedFileUrl,
                'category' => $request->category,
                'description' => $request->description ?? ''
            ]);

            return back()->with('success', 'Media uploaded successfully 🚀');

        } catch (\Exception $e) {
            return back()->with('error', 'Upload Error: ' . $e->getMessage());
        }
    }

    return back()->with('error', 'File not found!');
}

    /**
     * Delete an Event
     */
    public function deleteEvent($id) {
        $event = Event::findOrFail($id);
        $event->delete();
        return back()->with('message', 'Event deleted successfully.');
    }

    /**
     * Delete a Gallery Image
     */
    public function deleteGallery($id) {
        $item = Gallery::findOrFail($id);
        $item->delete();
        return back()->with('message', 'Gallery item removed.');
    }

    /**
     * Approve a pending player
     */
    public function approvePlayer($id) {
        $user = User::findOrFail($id);
        $user->update(['is_approved' => true]);

        return back()->with('success', "Player {$user->name} approved successfully!");
    }

    /**
     * Delete/Reject a player
     */
    public function deletePlayer($id) {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('message', 'Player record removed.');
    }



public function playerDashboard() {
    $user = Auth::user();

    // Simulated data (Replace with real logic/columns later)
    $stats = [
        'rank' => 'Prodigy',
        'level' => 12,
        'points' => 1250,
        'next_level' => 1500,
        'training_hours' => 48,
        'win_rate' => '72%'
    ];

    $upcomingEvents = Event::where('event_date', '>=', now())->orderBy('event_date', 'asc')->take(3)->get();
    $latestMaterials = LearnMaterial::latest()->take(2)->get();

    return view('player-dashboard', compact('user', 'upcomingEvents', 'latestMaterials', 'stats'));
}

 public function viewEventParticipants(Request $request, $id)
{
    $status = $request->query('status'); // Get status from URL (?status=selected)

    $event = Event::with(['athletes' => function($query) use ($status) {
        if ($status === 'selected') {
            $query->where('event_user.status', 'selected');
        } elseif ($status === 'waiting') {
            $query->where('event_user.status', '!=', 'selected')->orWhereNull('event_user.status');
        }
    }])->findOrFail($id);

    return view('admin-event-participants', compact('event', 'status'));
}


public function downloadParticipantsPDF(Request $request, $id)
{
    $status = $request->query('status');

    $event = Event::with(['athletes' => function($query) use ($status) {
        if ($status === 'selected') {
            $query->where('event_user.status', 'selected');
        } elseif ($status === 'waiting') {
            $query->where('event_user.status', '!=', 'selected')->orWhereNull('event_user.status');
        }
    }])->findOrFail($id);

    $data = [
        'event' => $event,
        'status' => $status,
        'date' => date('d-m-Y'),
    ];

    // Use the Pdf facade we imported at the top
    $pdf = Pdf::loadView('pdf.participants', $data);

    return $pdf->download('Participants-'.($status ?? 'All').'-'.str_replace(' ', '-', $event->title).'.pdf');
}


    public function playerLearn() {
        // Dropdown filter ke liye saare events bhejna zaroori hai
        $events = Event::all();

        // Materials ke saath uska event name (relationship) load karein
        $materials = LearnMaterial::with('event')->latest()->get();

        // Aapki file ka naam 'learn.blade.php' hai isliye 'learn' likha hai
        return view('learn', compact('events', 'materials'));
    }

    public function adminPlayers(Request $request) {
    $status = $request->query('status');

    $query = User::where('role', 'player')->latest();

    if ($status === 'pending') {
        $query->where('is_approved', false);
    } elseif ($status === 'approved') {
        $query->where('is_approved', true);
    }

    $players = $query->paginate(20);

    return view('admin-players', compact('players'));
}


}
