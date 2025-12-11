<?php

namespace App\Http\Controllers;

use App\Models\WorkerOpening;
use App\Models\City;
use App\Models\JobCategory;
use App\Models\Application;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of public job openings
     */
    public function index(Request $request)
    {
        $query = WorkerOpening::with(['event.city', 'jobCategory'])
            ->where('status', 'open')
            ->where('application_deadline', '>', now())
            ->orderBy('application_deadline');

        // Apply filters
        $this->applyFilters($query, $request);

        $jobs = $query->paginate(10);

        $filterData = $this->getFilterData();

        return view('jobs.index', array_merge(compact('jobs'), $filterData));
    }

    /**
     * Apply filters to the job query
     */
    protected function applyFilters($query, $request)
    {
        // Handle cities filter (checkbox array)
        if ($request->filled('cities')) {
            $query->whereHas('event.city', function($q) use ($request) {
                $q->whereIn('name', $request->cities);
            });
        }

        // Handle categories filter (checkbox array)
        if ($request->filled('categories')) {
            $query->whereIn('job_category_id', $request->categories);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }
    }

    /**
     * Get filter data for the view
     */
    protected function getFilterData()
    {
        return [
            'cities' => City::active()->orderBy('name')->get(),
            'categories' => JobCategory::where('is_active', true)->orderBy('name')->get(),
            'searchTerm' => request('search'),
            'selectedCity' => request('city'),
            'selectedCategory' => request('category'),
        ];
    }

    /**
     * Display the specified job opening
     */
    public function show(WorkerOpening $job)
    {
        if ($job->status !== 'open') {
            abort(404, 'Job is not currently accepting applications');
        }

        // Decode requirements JSON field to array for the view
        if (is_string($job->requirements)) {
            $job->requirements = json_decode($job->requirements, true) ?: [];
        }

        return view('jobs.show', compact('job'));
    }

    /**
     * Handle job application submission
     */
    public function apply(Request $request, WorkerOpening $job)
    {
        // Check if customer is authenticated using our custom session
        if (!session('customer_authenticated')) {
            // Store intended URL so user gets redirected back after login
            session(['intended_url' => $request->fullUrl()]);
            return redirect()->route('login')->with('error', 'Please login to apply for jobs');
        }

        // Validate the request
        $validated = $request->validate([
            'motivation' => 'required|string|max:1000',
            'experience' => 'nullable|string|max:1000',
        ]);

        $customerId = session('customer_id');

        // Check if user has already applied for this job
        $existingApplication = Application::where('worker_opening_id', $job->id)
            ->where('user_id', $customerId)
            ->first();

        if ($existingApplication) {
            return redirect()->back()->with('error', 'You have already applied for this position');
        }

        // Create the application
        $application = Application::create([
            'worker_opening_id' => $job->id,
            'user_id' => $customerId,
            'motivation' => $validated['motivation'],
            'experience' => $validated['experience'],
            'status' => 'pending',
        ]);

        // Update job slots if needed
        if ($job->slots_filled < $job->slots_total) {
            $job->increment('slots_filled');
        }

        return redirect()->back()->with('success', 'Your application has been submitted successfully!');
    }
}