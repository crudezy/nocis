<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\WorkerOpening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $customerId = session('customer_id');
        
        // Get customer's applications
        $applications = Application::with(['workerOpening.event', 'workerOpening.jobCategory'])
            ->where('user_id', $customerId)
            ->latest()
            ->take(5)
            ->get();

        // Get recommended jobs (open jobs that customer hasn't applied to)
        $recommendedJobs = WorkerOpening::with(['event.city', 'jobCategory'])
            ->where('status', 'open')
            ->whereDoesntHave('applications', function($query) use ($customerId) {
                $query->where('user_id', $customerId);
            })
            ->take(6)
            ->get();

        // Get statistics
        $totalApplications = Application::where('user_id', $customerId)->count();
        $pendingApplications = Application::where('user_id', $customerId)->where('status', 'pending')->count();
        $approvedApplications = Application::where('user_id', $customerId)->where('status', 'approved')->count();
        $rejectedApplications = Application::where('user_id', $customerId)->where('status', 'rejected')->count();

        return view('menu.customer.dashboard', compact(
            'applications', 
            'recommendedJobs', 
            'totalApplications',
            'pendingApplications', 
            'approvedApplications', 
            'rejectedApplications'
        ));
    }

    public function profile()
    {
        $customerId = session('customer_id');
        $user = \App\Models\User::with('profile')->find($customerId);

        return view('menu.customer.profile', compact('user'));
    }

    public function settings()
    {
        $customerId = session('customer_id');
        $user = \App\Models\User::with('profile')->find($customerId);

        return view('menu.customer.settings', compact('user'));
    }

    public function updateSettings(Request $request)
    {
        $customerId = session('customer_id');
        $user = \App\Models\User::find($customerId);
        
        // Validate email separately since it's always required
        $request->validate([
            'email' => 'required|email|unique:users,email,'.$customerId,
        ]);

        // Update user email
        $user->update([
            'email' => $request->email
        ]);

        // Get or create user profile
        $userProfile = $user->profile()->first();
        if (!$userProfile) {
            $userProfile = new \App\Models\UserProfile();
            $userProfile->user_id = $customerId;
        }

        // Handle different types of updates based on request data
        $profileData = [];

        // Handle summary update (from basic info tab)
        if ($request->has('summary')) {
            $request->validate([
                'summary' => 'nullable|string|max:2000',
            ]);
            $profileData['summary'] = $request->summary;
        }

        // Handle personal data updates (from personal data tab)
        if ($request->has('phone') || $request->has('date_of_birth') || $request->has('address')) {
            $request->validate([
                'phone' => 'nullable|string|max:20',
                'date_of_birth' => 'nullable|date',
                'address' => 'nullable|string|max:500',
            ]);

            if ($request->filled('phone')) $profileData['phone'] = $request->phone;
            if ($request->filled('date_of_birth')) $profileData['date_of_birth'] = $request->date_of_birth;
            if ($request->filled('address')) $profileData['address'] = $request->address;
        }

        // Save profile data if any exists
        if (!empty($profileData)) {
            $userProfile->fill($profileData);
            $userProfile->save();
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui!');
    }

    public function updateProfilePhoto(Request $request)
    {
        $customerId = session('customer_id');
        $user = \App\Models\User::find($customerId);
        
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,jpg,png|max:2048', // 2MB max
        ]);

        // Get or create user profile
        $userProfile = $user->profile()->first();
        if (!$userProfile) {
            $userProfile = new \App\Models\UserProfile();
            $userProfile->user_id = $customerId;
        }

        // Remove old photo if exists
        if ($userProfile->profile_photo && \Storage::exists($userProfile->profile_photo)) {
            \Storage::delete($userProfile->profile_photo);
        }

        // Store new photo
        $photoPath = $request->file('profile_photo')->store('profile_photos', 'public');
        
        $userProfile->profile_photo = $photoPath;
        $userProfile->save();

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    public function removeProfilePhoto()
    {
        $customerId = session('customer_id');
        $user = \App\Models\User::find($customerId);
        
        $userProfile = $user->profile()->first();
        if ($userProfile && $userProfile->profile_photo && \Storage::exists($userProfile->profile_photo)) {
            \Storage::delete($userProfile->profile_photo);
        }
        
        if ($userProfile) {
            $userProfile->profile_photo = null;
            $userProfile->save();
        }

        return redirect()->back()->with('success', 'Foto profil berhasil dihapus!');
    }

    public function updateProfile(Request $request)
    {
        $customerId = session('customer_id');
        
        // Determine which fields to validate based on the request
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$customerId,
            'username' => 'required|string|max:255|unique:users,username,'.$customerId,
        ];

        // Add conditional validation rules for additional fields
        if ($request->has('phone')) {
            $rules['phone'] = 'nullable|string|max:20';
        }
        
        if ($request->has('date_of_birth')) {
            $rules['date_of_birth'] = 'nullable|date';
        }
        
        if ($request->has('address')) {
            $rules['address'] = 'nullable|string|max:500';
        }
        
        // Social media fields
        $socialFields = ['linkedin', 'instagram', 'twitter', 'github', 'website'];
        foreach ($socialFields as $field) {
            if ($request->has($field)) {
                $rules[$field] = 'nullable|url';
            }
        }

        $validated = $request->validate($rules);

        $user = \App\Models\User::find($customerId);
        
        // Handle CV file upload
        if ($request->hasFile('cv_file')) {
            $request->validate([
                'cv_file' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB max
            ]);
            
            // Remove old CV if exists
            if ($user->cv_file && \Storage::exists($user->cv_file)) {
                \Storage::delete($user->cv_file);
            }
            
            // Store new CV
            $cvPath = $request->file('cv_file')->store('cv_files', 'private');
            $validated['cv_file'] = $cvPath;
            $validated['cv_updated_at'] = now();
        }

        $user->update($validated);

        // Update session data
        session([
            'customer_username' => $user->username,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function updateSocialMedia(Request $request)
    {
        $customerId = session('customer_id');
        $user = \App\Models\User::find($customerId);

        // Debug: Log all request data
        \Log::info('Social media request data:', [
            'all_data' => $request->all(),
            'platform' => $request->input('platform'),
            'social_link' => $request->input('social_link'),
            'user_id' => $customerId
        ]);

        // Validate the request
        $request->validate([
            'platform' => 'required|in:linkedin,instagram,twitter,github,website',
            'social_link' => 'required|string|max:255',
        ]);

        try {
            // Get the platform and social link from request
            $platform = $request->input('platform');
            $socialLink = $request->input('social_link');

            \Log::info('Processing social media update:', [
                'platform' => $platform,
                'social_link' => $socialLink,
                'user_id' => $customerId
            ]);

            // Get or create user profile
            $userProfile = $user->profile()->first();
            if (!$userProfile) {
                $userProfile = new \App\Models\UserProfile();
                $userProfile->user_id = $customerId;
                $userProfile->save();
                \Log::info('Created new user profile', ['profile_id' => $userProfile->id]);
            }

            // Update the specific social media field
            $userProfile->{$platform} = $socialLink;
            $userProfile->save();

            \Log::info('Social media update successful:', [
                'platform' => $platform,
                'social_link' => $socialLink,
                'profile_id' => $userProfile->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Akun sosial media berhasil ditambahkan!'
            ]);

        } catch (\Exception $e) {
            \Log::error('Social media update error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui akun sosial media: ' . $e->getMessage()
            ], 500);
        }
    }

    public function removeCV()
    {
        $customerId = session('customer_id');
        $user = \App\Models\User::find($customerId);
        
        if ($user->cv_file && \Storage::exists($user->cv_file)) {
            \Storage::delete($user->cv_file);
        }
        
        $user->update([
            'cv_file' => null,
            'cv_updated_at' => null
        ]);

        return redirect()->back()->with('success', 'CV removed successfully!');
    }

    public function applications()
    {
        $customerId = session('customer_id');
        
        $applications = Application::with(['workerOpening.event', 'workerOpening.jobCategory'])
            ->where('user_id', $customerId)
            ->latest()
            ->paginate(10);
return view('menu.customer.applications', compact('applications'));
}

public function saveJob(Request $request, WorkerOpening $job)
{
$customerId = session('customer_id');

// Check if already saved
$alreadySaved = \DB::table('saved_jobs')
    ->where('user_id', $customerId)
    ->where('worker_opening_id', $job->id)
    ->exists();

if ($alreadySaved) {
    return response()->json(['success' => false, 'message' => 'Job is already saved']);
}

// Save the job
\DB::table('saved_jobs')->insert([
    'user_id' => $customerId,
    'worker_opening_id' => $job->id,
    'created_at' => now(),
    'updated_at' => now()
]);

return response()->json(['success' => true, 'message' => 'Job saved successfully']);
}

public function unsaveJob(Request $request, WorkerOpening $job)
{
$customerId = session('customer_id');

\DB::table('saved_jobs')
    ->where('user_id', $customerId)
    ->where('worker_opening_id', $job->id)
    ->delete();

return response()->json(['success' => true, 'message' => 'Job removed from saved jobs']);
}

public function savedJobs()
{
$customerId = session('customer_id');

$savedJobs = WorkerOpening::with(['event.city', 'jobCategory'])
    ->whereHas('savedByUsers', function($query) use ($customerId) {
        $query->where('user_id', $customerId);
    })
    ->orderBy('created_at', 'desc')
    ->paginate(10);

return view('menu.customer.saved-jobs', compact('savedJobs'));
}
}
