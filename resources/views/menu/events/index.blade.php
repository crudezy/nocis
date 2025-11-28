@extends('layouts.app') {{-- Memperluas master layout --}}

@section('title', 'Events & Competitions - KOI')
@section('page-title')
    Events & Competitions <span class="bg-red-500 text-white text-sm px-2 py-1 rounded-full ml-2">Admin</span>
@endsection

@section('content')
<div class="space-y-6">
    
    {{-- Search Bar --}}
    <div class="flex items-center justify-between">
        <div class="relative flex items-center border border-gray-300 rounded-lg py-2 px-4 pl-10 bg-white">
            <i class="fas fa-search absolute left-3 text-gray-400"></i>
            <input type="text" placeholder="Search events..." class="focus:outline-none w-64 ml-2" disabled>
        </div>
        <a href="{{ route('events.create') }}"
           class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold flex items-center">
            <i class="fas fa-plus mr-2"></i> Create Event
        </a>
    </div>

    {{-- Event stats --}}
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <p class="text-xs uppercase tracking-wide text-gray-500">Total Events</p>
            <p class="text-3xl font-semibold text-gray-800 mt-2">{{ $stats['total_events'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <p class="text-xs uppercase tracking-wide text-gray-500">Active Events</p>
            <p class="text-3xl font-semibold text-gray-800 mt-2">{{ $stats['active_events'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <p class="text-xs uppercase tracking-wide text-gray-500">Upcoming</p>
            <p class="text-3xl font-semibold text-gray-800 mt-2">{{ $stats['upcoming_events'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <p class="text-xs uppercase tracking-wide text-gray-500">Planning</p>
            <p class="text-3xl font-semibold text-gray-800 mt-2">{{ $stats['planning_events'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <p class="text-xs uppercase tracking-wide text-gray-500">Volunteer Openings</p>
            <p class="text-3xl font-semibold text-gray-800 mt-2">{{ $stats['volunteer_openings'] }}</p>
        </div>
    </div>

    {{-- Main Content Area --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Event List --}}
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow space-y-6">
            @php
                $statusColors = [
                    'active' => 'bg-green-500 text-white',
                    'upcoming' => 'bg-blue-500 text-white',
                    'planning' => 'bg-yellow-500 text-white',
                    'draft' => 'bg-gray-400 text-white',
                ];

                $priorityColors = [
                    'high' => 'bg-red-500 text-white',
                    'medium' => 'bg-yellow-500 text-white',
                    'low' => 'bg-gray-400 text-white',
                ];
            @endphp
            @forelse ($events as $event)
                <div class="{{ !$loop->last ? 'border-b border-gray-200 pb-6' : '' }}">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-3 mb-3">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-1">{{ $event->title }}</h4>
                            <p class="text-gray-600 text-sm">{{ $event->venue ?? 'Venue TBA' }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-xs px-2 py-1 rounded {{ $statusColors[$event->status] ?? 'bg-gray-300 text-gray-700' }}">
                                {{ ucfirst($event->status) }}
                            </span>
                            <span class="text-xs px-2 py-1 rounded {{ $priorityColors[$event->priority] ?? 'bg-gray-300 text-gray-700' }}">
                                {{ ucfirst($event->priority) }}
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-4 text-gray-600 text-sm mb-4">
                        <span class="flex items-center">
                            <i class="fas fa-clock mr-2 text-gray-400"></i>
                            {{ optional($event->start_at)->translatedFormat('d M Y') }} &ndash;
                            {{ optional($event->end_at)->translatedFormat('d M Y') ?? 'TBD' }}
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                            {{ $event->city ?? 'Lokasi belum ditentukan' }}
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-users mr-2 text-gray-400"></i>
                            Capacity: {{ number_format($event->capacity) }}
                        </span>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm text-gray-500 mb-2">Sports:</p>
                        <div class="flex flex-wrap gap-2">
                            @forelse ($event->sports as $sport)
                                <span class="bg-gray-100 text-gray-700 text-xs px-3 py-1 rounded-full">{{ $sport->name }}</span>
                            @empty
                                <span class="text-xs text-gray-500">Belum ada cabang olahraga.</span>
                            @endforelse
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm text-gray-600 mb-4">
                        <div>
                            <p class="text-xs uppercase text-gray-400">Volunteer Roles</p>
                            <p class="font-semibold">{{ $event->volunteer_openings_count }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-gray-400">Slots Total</p>
                            <p class="font-semibold">{{ $event->slots_total_sum ?? 0 }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-gray-400">Applications</p>
                            <p class="font-semibold">{{ $event->applications_count }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-gray-400">Contact PIC</p>
                            <p class="font-semibold">
                                {{ data_get($event->contact_info, 'pic', 'TBD') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('events.edit', $event) }}"
                           class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('events.destroy', $event) }}"
                              onsubmit="return confirm('Delete this event? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-12">
                    <i class="fas fa-calendar-times text-4xl mb-3"></i>
                    <p>Belum ada event terdaftar. Mulai dengan membuat event baru.</p>
                </div>
            @endforelse
        </div>

        {{-- Right Sidebar --}}
        <div class="lg:col-span-1 space-y-6">

            {{-- Event Calendar --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Event Calendar</h3>
                <div class="calendar-widget">
                    <div class="flex justify-between items-center mb-4">
                        <span class="font-semibold text-lg text-gray-800">{{ $calendarMonth }}</span>
                        <span class="text-sm text-gray-400">Auto-generated</span>
                    </div>
                    <div class="grid grid-cols-7 gap-1 text-xs text-gray-600 mb-2 text-center">
                        <div class="py-1">Su</div>
                        <div class="py-1">Mo</div>
                        <div class="py-1">Tu</div>
                        <div class="py-1">We</div>
                        <div class="py-1">Th</div>
                        <div class="py-1">Fr</div>
                        <div class="py-1">Sa</div>
                    </div>
                    @php $today = now()->day; @endphp
                    <div class="grid grid-cols-7 gap-1 text-sm text-center">
                        @foreach ($calendarDays as $day)
                            <div class="py-2 rounded-full {{ $day === $today ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-gray-100 cursor-pointer' }}">
                                {{ $day }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Quick Stats --}}
            <div class="bg-white p-6 rounded-lg shadow space-y-4">
                <h3 class="text-xl font-bold text-gray-800">Quick Stats</h3>
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Total Applications</span>
                    <span class="font-semibold text-gray-900">{{ $stats['total_applications'] }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Events w/ Volunteers</span>
                    <span class="font-semibold text-gray-900">
                        {{ $events->where('volunteer_openings_count', '>', 0)->count() }}
                    </span>
                </div>
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Avg Slots per Event</span>
                    <span class="font-semibold text-gray-900">
                        {{ $events->count() ? number_format(($events->sum('slots_total_sum') ?? 0) / $events->count(), 1) : 0 }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
