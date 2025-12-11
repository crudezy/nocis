<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\WorkerOpening;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        if (!session('admin_authenticated')) {
            return redirect('/admin/login');
        }

        // Get all applications with user and job opening data
        $applications = Application::with(['user', 'opening.jobCategory', 'opening.event'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate statistics
        $stats = [
            'total_applicants' => $applications->count(),
            'pending_review' => $applications->where('status', 'pending')->count(),
            'approved_members' => $applications->where('status', 'approved')->count(),
            'rejected_members' => $applications->where('status', 'rejected')->count(),
        ];

        return view('menu.reviews.index', [
            'applications' => $applications,
            'stats' => $stats,
        ]);
    }

    public function updateStatus(Request $request, Application $application)
    {
        if (!session('admin_authenticated')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'review_notes' => 'nullable|string|max:1000',
        ]);

        $application->update([
            'status' => $validated['status'],
            'review_notes' => $validated['review_notes'],
            'reviewed_by' => session('admin_id'),
            'reviewed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Application status updated successfully',
            'application' => $application->load('user', 'opening'),
        ]);
    }
}