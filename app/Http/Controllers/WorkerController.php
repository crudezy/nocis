<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Event;
use App\Models\JobCategory;
use App\Models\WorkerOpening;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public function index(Request $request)
    {
        if (!session('admin_authenticated')) {
            return redirect('/admin/login');
        }

        $statusFilter = $request->input('status', 'active');

        // Get ALL openings for statistics calculation (not filtered)
        $allOpenings = WorkerOpening::with(['event', 'jobCategory'])
            ->withCount('applications')
            ->get();

        // Calculate statistics from ALL openings (consistent across all views)
        $stats = [
            'total_openings' => $allOpenings->count(),
            'active_openings' => $allOpenings->where('status', 'open')->count(),
            'closed_openings' => $allOpenings->where('status', 'closed')->count(),
            'total_applications' => Application::count(),
            'positions_filled' => $allOpenings->sum('slots_filled'),
        ];

        // Apply status filtering for the display list
        $query = WorkerOpening::with(['event', 'jobCategory'])
            ->withCount('applications');

        if ($statusFilter === 'active') {
            $query->where('status', 'open');
        } elseif ($statusFilter === 'closed') {
            $query->where('status', 'closed');
        }
        // 'all' shows everything, no additional filtering needed

        $openings = $query->orderByDesc('status')
            ->orderBy('application_deadline')
            ->get();

        $categories = JobCategory::orderBy('name')->get();
        $events = Event::orderBy('start_at')->get(['id', 'title', 'venue']);

        return view('menu.workers.index', [
            'openings' => $openings,
            'stats' => $stats,
            'categories' => $categories,
            'events' => $events,
            'statusFilter' => $statusFilter,
        ]);
    }

    public function create()
    {
        if (!session('admin_authenticated')) {
            return redirect('/admin/login');
        }

        $categories = JobCategory::orderBy('name')->get();
        // Only show events that are not closed for new worker openings
        $events = Event::whereIn('status', ['planning', 'upcoming', 'active'])
                      ->orderBy('start_at')
                      ->get(['id', 'title', 'venue']);
        $opening = new WorkerOpening(['status' => 'planned', 'slots_filled' => 0]);

        return view('menu.workers.create', [
            'opening' => $opening,
            'categories' => $categories,
            'events' => $events,
        ]);
    }

    public function store(Request $request)
    {
        if (!session('admin_authenticated')) {
            return redirect('/admin/login');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'job_category_id' => 'required|exists:job_categories,id',
            'event_id' => 'required|exists:events,id',
            'description' => 'nullable|string',
            'application_deadline' => 'required|date',
            'slots_total' => 'required|integer|min:1',
            'slots_filled' => 'nullable|integer|min:0',
            'status' => 'required|in:planned,open,closed',
            'requirements_text' => 'nullable|string',
            'benefits' => 'nullable|string',
        ]);

        $requirements = [];
        if (!empty($validated['requirements_text'])) {
            $requirements = array_filter(array_map('trim', explode("\n", $validated['requirements_text'])));
        }

        $opening = WorkerOpening::create([
            'title' => $validated['title'],
            'job_category_id' => $validated['job_category_id'],
            'event_id' => $validated['event_id'],
            'description' => $validated['description'],
            'application_deadline' => $validated['application_deadline'],
            'slots_total' => $validated['slots_total'],
            'slots_filled' => $validated['slots_filled'] ?? 0,
            'status' => $validated['status'],
            'requirements' => $requirements,
            'benefits' => $validated['benefits'],
        ]);

        return redirect()->route('admin.workers.index', ['flash' => 'created', 'name' => $opening->title]);
    }

    public function edit(WorkerOpening $worker)
    {
        if (!session('admin_authenticated')) {
            return redirect('/admin/login');
        }

        $categories = JobCategory::orderBy('name')->get();
        // For editing, show all events (including closed) in case user needs to see current assignment
        $events = Event::orderBy('start_at')->get(['id', 'title', 'venue', 'status']);

        return view('menu.workers.edit', [
            'opening' => $worker,
            'categories' => $categories,
            'events' => $events,
        ]);
    }

    public function update(Request $request, WorkerOpening $worker)
    {
        if (!session('admin_authenticated')) {
            return redirect('/admin/login');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'job_category_id' => 'required|exists:job_categories,id',
            'event_id' => 'required|exists:events,id',
            'description' => 'nullable|string',
            'application_deadline' => 'required|date',
            'slots_total' => 'required|integer|min:1',
            'slots_filled' => 'nullable|integer|min:0',
            'status' => 'required|in:planned,open,closed',
            'requirements_text' => 'nullable|string',
            'benefits' => 'nullable|string',
        ]);

        $requirements = [];
        if (!empty($validated['requirements_text'])) {
            $requirements = array_filter(array_map('trim', explode("\n", $validated['requirements_text'])));
        }

        $worker->update([
            'title' => $validated['title'],
            'job_category_id' => $validated['job_category_id'],
            'event_id' => $validated['event_id'],
            'description' => $validated['description'],
            'application_deadline' => $validated['application_deadline'],
            'slots_total' => $validated['slots_total'],
            'slots_filled' => $validated['slots_filled'] ?? 0,
            'status' => $validated['status'],
            'requirements' => $requirements,
            'benefits' => $validated['benefits'],
        ]);

        return redirect()->route('admin.workers.index', ['flash' => 'updated', 'name' => $worker->title]);
    }
}