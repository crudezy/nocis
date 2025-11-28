<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Event;
use App\Models\JobCategory;
use App\Models\VolunteerOpening;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    public function index()
    {
        if (!session('authenticated')) {
            return redirect('/login');
        }

        $openings = VolunteerOpening::with(['event', 'jobCategory'])
            ->withCount('applications')
            ->orderByDesc('status')
            ->orderBy('shift_start')
            ->get();

        $stats = [
            'total_openings' => $openings->count(),
            'active_openings' => $openings->where('status', 'open')->count(),
            'total_applications' => Application::count(),
            'positions_filled' => $openings->sum('slots_filled'),
        ];

        $categories = JobCategory::orderBy('name')->get();
        $events = Event::orderBy('start_at')->get(['id', 'title', 'venue']);

        return view('menu.volunteers.index', [
            'openings' => $openings,
            'stats' => $stats,
            'categories' => $categories,
            'events' => $events,
        ]);
    }
}
