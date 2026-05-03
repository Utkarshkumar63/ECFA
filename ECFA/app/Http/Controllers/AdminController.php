<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\News;
use App\Models\User;
use App\Models\Achievement;
use App\Models\Certificate;
use App\Models\Event;          // FIX 1: Import Event
use App\Models\LearnMaterial;  // FIX 2: Import LearnMaterial
use Auth;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{

    public function achievements()
    {
        $achievements = Achievement::with('user')->latest()->get();

        return view('achivements', [
            'achievements' => $achievements,
            'goldCount' => $achievements->where('medal_type', 'Gold')->count(),
            'silverCount' => $achievements->where('medal_type', 'Silver')->count(),
            'bronzeCount' => $achievements->where('medal_type', 'Bronze')->count(),
        ]);
    }
    public function adminPlayers(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $query = User::where('role', 'player')->latest();

        if ($status === 'pending') {
            $query->where('is_approved', false);
        } elseif ($status === 'approved') {
            $query->where('is_approved', true);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        $players = $query->paginate(20);
        return view('admin-players', compact('players'));
    }

    public function editPlayer($id)
    {
        $player = User::findOrFail($id);
        return view('admin-edit-player', compact('player'));
    }



    public function updatePlayer(Request $request, $id)
    {
        $player = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required',
            'category' => 'required|in:FOIL,EPEE,SABRE',
            'dob' => 'required|date',
            'gender' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required',
            'age_group' => 'required',
            'experience' => 'required',
            'aadhar_no' => 'required|string|min:12|max:16', // Increased max to allow spaces/dashes
        ]);

        // Force update
        $player->fill($data);
        $player->save();

        // Use absolute redirect to registry
        return redirect('/admin-players')->with('success', 'Athlete details updated successfully! ✨');
    }
    public function storeLearn(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'weapon' => 'required',
            'event_id' => 'nullable|exists:events,id',
            'pdf' => 'nullable|mimes:pdf|max:10000',
            'content' => 'nullable|string'
        ]);

        $fileName = time() . '_' . str_replace(' ', '_', $request->title) . '.pdf';
        $filePath = null;
        $type = 'upload';

        if ($request->hasFile('pdf')) {
            // Case A: File upload ho rahi hai
            $filePath = $request->file('pdf')->storeAs('learn_materials', $fileName, 'public');
            $type = 'upload';
        } elseif ($request->filled('content')) {
            // Case B: Sirf text likha hai (PDF generate hogi)
            $type = 'generated';
            $event = \App\Models\Event::find($request->event_id);
            $data = [
                'title' => $request->title,
                'weapon' => $request->weapon,
                'content' => $request->content,
                'event_name' => $event ? $event->title : 'General Arsenal',
                'date' => date('d M, Y')
            ];
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.training_material', $data);
            $filePath = 'learn_materials/' . $fileName;
            \Illuminate\Support\Facades\Storage::disk('public')->put($filePath, $pdf->output());
        }

        // Database Entry (Yahan content ab NULL nahi jayega)
        \App\Models\LearnMaterial::create([
            'title' => $request->title,
            'weapon' => $request->weapon,
            'event_id' => $request->event_id,
            'file_path' => $filePath,
            'material_type' => $type,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Tactical Intelligence Deployed! 🚀');
    }

    // Click karne par professional view dikhane ke liye
    public function viewMaterial($id)
    {
        $item = \App\Models\LearnMaterial::with('event')->findOrFail($id);

        // Agar text briefing hai toh professional PDF design mein dikhao
        if ($item->material_type == 'generated' || !empty($item->content)) {
            $data = [
                'title' => $item->title,
                'weapon' => $item->weapon,
                'content' => $item->content,
                'event_name' => $item->event ? $item->event->title : 'General Arsenal',
                'date' => $item->created_at->format('d M, Y')
            ];
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.training_material', $data);
            return $pdf->stream();
        }

        // Agar uploaded PDF hai toh file open karo
        return response()->file(storage_path('app/public/' . $item->file_path));
    }

    public function adminAchievements()
    {
        return view('admin-achievements', [
            'achievements' => Achievement::with('user')->latest()->paginate(15),
            'players' => User::where('role', 'player')->where('is_approved', true)->get()
        ]);
    }



 // --- EVENT ATTENDANCE ---
public function showEventAttendance($id) {
    // Get event and only athletes who are 'selected' for this event
    $event = Event::with(['athletes' => function($q) {
        $q->where('event_user.status', 'selected');
    }])->findOrFail($id);

    return view('admin-event-attendance', compact('event'));
}

 public function storeEventAttendance(Request $request, $id)
{
    $event = Event::findOrFail($id);
    $attendanceData = $request->input('attendance', []);
    $reasons = $request->input('reasons', []);

    foreach ($attendanceData as $userId => $status) {
        $event->athletes()->updateExistingPivot($userId, [
            'attendance_status' => $status,
            'absent_reason' => ($status === 'absent') ? ($reasons[$userId] ?? null) : null
        ]);
    }

    return back()->with('success', 'Event attendance report saved! 🏆');
}


    // --- DAILY ATTENDANCE ---
    public function dailyAttendance(Request $request)
    {
        $date = $request->query('date', date('Y-m-d'));

        $players = User::where('role', 'player')
            ->where('is_approved', true)
            ->orderBy('name', 'asc')
            ->get();

        // FIX: Changed 'is_present' to 'status' to match your migration
        $attendance = \App\Models\DailyAttendance::where('attendance_date', $date)
            ->pluck('status', 'user_id')
            ->toArray();

        return view('admin-daily-attendance', compact('players', 'date', 'attendance'));
    }

    public function saveDailyAttendance(Request $request) {
    // 1. Validate the date
    $date = $request->input('attendance_date');
    if (!$date) return back()->with('error', 'Invalid Date');

    // 2. Get the list of IDs that were checked (Present)
    $presentIds = $request->input('present_players', []);

    // 3. Get all approved player IDs to update everyone (even those not checked)
    $allPlayerIds = User::where('role', 'player')->where('is_approved', true)->pluck('id');

    foreach ($allPlayerIds as $id) {
        // If ID is in the checked array, it's 'present', otherwise 'absent'
        $status = in_array($id, $presentIds) ? 'present' : 'absent';

        \App\Models\DailyAttendance::updateOrCreate(
            ['user_id' => $id, 'attendance_date' => $date],
            [
                'status' => $status,
                'marked_by' => auth()->id() // Important: from your migration
            ]
        );
    }

    return back()->with('success', "Register for " . date('d-M', strtotime($date)) . " saved successfully! ✅");
}

    public function storeAchievement(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'medal_type' => 'required|in:Gold,Silver,Bronze',
            'level' => 'required|in:National,State,District',
            'event_name' => 'nullable|string',
            'image' => 'nullable|image|max:5120', // Photo of ceremony/medal
            'description' => 'nullable|string'
        ]);

        // ✅ Cloudinary Image Upload
        if ($request->hasFile('image')) {
            try {
                $config = config('cloudinary.cloud');
                $cloudinary = new Cloudinary([
                    'cloud' => [
                        'cloud_name' => $config['cloud_name'],
                        'api_key' => $config['api_key'],
                        'api_secret' => $config['api_secret'],
                    ]
                ]);
                $upload = $cloudinary->uploadApi()->upload($request->file('image')->getRealPath(), [
                    'folder' => 'ecfa_achievements'
                ]);
                $data['image'] = $upload['secure_url'];
            } catch (\Exception $e) {
                return back()->with('error', 'Cloudinary Error: ' . $e->getMessage());
            }
        }

        Achievement::create($data);
        return back()->with('success', 'Champion record added to the Hall of Fame! 🏆');
    }

    public function deleteAchievement($id)
    {
        Achievement::findOrFail($id)->delete();
        return back()->with('message', 'Achievement record removed.');
    }

    public function generate($event_id, $user_id)
    {
        // Check 1: Kya athlete selected hai? (Taaki bina select kiye cert na bane)
        $event = Event::findOrFail($event_id);
        $athlete = $event->athletes()->where('user_id', $user_id)->first();

        if (!$athlete || $athlete->pivot->status !== 'selected') {
            return back()->with('error', 'Pehle athlete ko select (Approve) karein!');
        }

        // Check 2: Kya certificate pehle se bana hua hai?
        $exists = Certificate::where('event_id', $event_id)
            ->where('user_id', $user_id)
            ->first();

        if ($exists) {
            return back()->with('error', 'Certificate pehle hi generate ho chuka hai!');
        }

        // Check 3: Certificate Generate karein
        $cert_id = 'ECFA-' . date('Y') . '-' . strtoupper(Str::random(8));
        $hash = hash('sha256', $cert_id . $user_id . config('app.key'));

        Certificate::create([
            'cert_id' => $cert_id,
            'user_id' => $user_id,
            'event_id' => $event_id,
            'event_name' => $event->title,
            'verification_hash' => $hash,
            'issue_date' => now(),
        ]);

        return back()->with('success', 'Success! Certificate record created for ' . $athlete->name);
    }

    public function verify(Request $request, $cert_id)
    {
        // 1. Database se certificate nikalein
        $cert = \App\Models\Certificate::with('user')->where('cert_id', $cert_id)->first();

        // 2. Agar certificate nahi mila, toh invalid page dikhao
        if (!$cert) {
            return view('certificates.invalid', ['message' => 'Certificate not found in our records.']);
        }

        // 3. Security Check: Hash match hona chahiye
        // Agar URL mein hash nahi hai ya galat hai, toh error dikhao
        if (!$request->has('hash') || $request->query('hash') !== $cert->verification_hash) {
            return view('certificates.invalid', ['message' => 'Security hash mismatch or link is broken.']);
        }

        // Sab sahi hai toh success page dikhao
        return view('certificates.verify_success', compact('cert'));
    }

    public function view($id)
    {
        $cert = Certificate::with('user')->findOrFail($id);

        if (Auth::id() !== $cert->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('certificates.design', compact('cert'));
    }

    public function publicVerifyForm()
    {
        return view('certificates.public_verify');
    }

    public function publicVerifyCheck(Request $request)
    {
        $request->validate(['cert_id' => 'required|string']);

        $cert = Certificate::with('user')->where('cert_id', $request->cert_id)->first();

        if (!$cert) {
            return back()->with('error', 'No records found for this ID. Please check the number and try again.');
        }

        return view('certificates.public_verify', compact('cert'));
    }


    public function showSmartIssueForm()
    {
        // Sirf approved players ko dikhayenge dropdown mein
        $players = User::where('role', 'player')->where('is_approved', true)->get();

        // Blade file ka name check karein (agar admin folder mein hai toh 'admin.smart-issue')
        return view('admin-smart-issue', compact('players'));
    }

    // 2. Data save karne ke liye (Missing Method)
    public function storeCertificate(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_name' => 'required|string',
            'medal_type' => 'required',
            'location' => 'required',
            'issue_date' => 'required|date',
        ]);

        // Unique ID aur Security Hash generate karein
        $cert_id = 'ECFA-' . date('Y') . '-' . strtoupper(Str::random(8));
        $hash = hash('sha256', $cert_id . $request->user_id . config('app.key'));

        Certificate::create([
            'cert_id' => $cert_id,
            'user_id' => $request->user_id,
            'event_id' => $request->event_id ?? null,
            'event_name' => $request->event_name,
            'medal_type' => $request->medal_type,
            'location' => $request->location,
            'host_org' => $request->host_org ?? 'East Champaran Fencing Association',
            'issue_date' => $request->issue_date,
            'verification_hash' => $hash,
        ]);

        return back()->with('success', "Certificate {$cert_id} Issued Successfully! 🏆");
    }

    public function adminMessages()
    {
        // Database se saare messages uthayenge
        $messages = Contact::latest()->paginate(15);

        // Blade file ka name 'admin-messages' hona chahiye
        return view('admin-messages', compact('messages'));
    }

    public function storeReply(Request $request, $id)
    {
        $request->validate(['reply_message' => 'required']);

        $contact = Contact::findOrFail($id);
        $contact->update([
            'reply_message' => $request->reply_message,
            'replied_at' => now()
        ]);

        return back()->with('success', 'Reply saved successfully! ✉️');
    }

    public function adminNews()
    {
        $news = News::latest()->paginate(10);
        return view('admin-news', compact('news'));
    }

    public function storeNews(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:News,Announcement,Event'
        ]);

        News::create($data);

        return back()->with('success', 'News published to the registry! 🗞️');
    }

    public function deleteNews($id)
    {
        News::findOrFail($id)->delete();
        return back()->with('success', 'News item removed.');
    }


    public function news()
    {
        // Fetch all news ordered by latest
        $news = News::latest()->get();
        return view('news', compact('news'));
    }

    // Edit Page Show karne ke liye
    public function editNews($id)
    {
        $newsItem = News::findOrFail($id);
        // 'admin.' hata diya kyunki file direct views folder mein hai
        return view('edit_news', compact('newsItem'));
    }

    // Update logic
    public function updateNews(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'type' => 'required',
            'description' => 'required',
        ]);

        $item = News::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('admin.news')->with('success', 'Update saved successfully! ✨');
    }

}
