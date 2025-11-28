@extends('layouts.app')

@section('title', 'Volunteer Job Openings - NOCIS')
@section('page-title')
    Volunteers <span class="bg-red-500 text-white text-sm px-2 py-1 rounded-full ml-2">Admin</span>
@endsection

@section('content')
<div class="space-y-6">
    
    {{-- Search Bar & Create Job Opening --}}
    <div class="flex items-center justify-between">
        <div class="relative flex items-center border border-gray-300 rounded-lg py-2 px-4 pl-10 bg-white">
            <i class="fas fa-search absolute left-3 text-gray-400"></i>
            <input type="text" placeholder="Search job openings..." class="focus:outline-none w-64 ml-2" disabled>
        </div>
        <button id="create-job-btn" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> Create Job Opening
        </button>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-gray-500 text-sm font-semibold mb-2">Total Job Openings</h3>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_openings'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-gray-500 text-sm font-semibold mb-2">Active Openings</h3>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['active_openings'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-gray-500 text-sm font-semibold mb-2">Total Applications</h3>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_applications'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-gray-500 text-sm font-semibold mb-2">Positions Filled</h3>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['positions_filled'] }}</p>
        </div>
    </div>

    {{-- Job Openings List --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @php
            $statusMap = [
                'open' => ['label' => 'Active', 'class' => 'bg-green-500 text-white'],
                'planned' => ['label' => 'Planned', 'class' => 'bg-blue-500 text-white'],
                'draft' => ['label' => 'Draft', 'class' => 'bg-gray-500 text-white'],
                'closed' => ['label' => 'Closed', 'class' => 'bg-gray-700 text-white'],
            ];
        @endphp
        @forelse ($openings as $opening)
            <div class="bg-white rounded-lg shadow-sm p-6 flex flex-col space-y-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-1">{{ $opening->title }}</h4>
                        <p class="text-gray-600 text-sm">{{ $opening->event->title ?? 'Event TBA' }}</p>
                        <p class="text-gray-500 text-xs mt-1">{{ $opening->jobCategory->name ?? 'Kategori tidak ada' }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-xs px-2 py-1 rounded {{ $statusMap[$opening->status]['class'] ?? 'bg-gray-300 text-gray-700' }}">
                            {{ $statusMap[$opening->status]['label'] ?? ucfirst($opening->status) }}
                        </span>
                        <span class="text-xs px-2 py-1 rounded bg-gray-100 text-gray-700">
                            Slots: {{ $opening->slots_filled }}/{{ $opening->slots_total }}
                        </span>
                    </div>
                </div>

                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex items-center">
                        <i class="fas fa-calendar mr-2 text-gray-400"></i>
                        <span>
                            Shift: {{ optional($opening->shift_start)->translatedFormat('d M Y') ?? 'TBD' }} -
                            {{ optional($opening->shift_end)->translatedFormat('d M Y') ?? 'TBD' }}
                        </span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                        <span>{{ $opening->event->venue ?? 'Lokasi menyusul' }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-users mr-2 text-gray-400"></i>
                        <span>{{ $opening->slots_total }} positions available | {{ $opening->applications_count }} applications</span>
                    </div>
                </div>

                <div>
                    <h5 class="text-sm font-semibold text-gray-700 mb-2">Requirements:</h5>
                    <ul class="text-sm text-gray-600 space-y-1">
                        @forelse ((array) $opening->requirements as $requirement)
                            <li>- {{ $requirement }}</li>
                        @empty
                            <li>- Belum ada requirement spesifik.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="flex space-x-2 pt-2">
                    <button class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded text-sm">View Applications</button>
                    <button class="flex-1 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm">Edit</button>
                </div>
            </div>
        @empty
            <div class="col-span-2 text-center text-gray-500 py-12">
                <i class="fas fa-hands-helping text-4xl mb-3"></i>
                <p>Belum ada lowongan relawan. Buat lowongan pertama Anda.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- Create Job Opening Modal --}}
<div id="create-job-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-800">Create New Job Opening</h3>
                    <button id="close-modal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form class="space-y-6">
                    {{-- Event Selection --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Select Event</label>
                        <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <option value="">Choose an event...</option>
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}">{{ $event->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    {{-- Position Type --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Position Type</label>
                        <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <option value="">Select position...</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    {{-- Job Title --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Job Title</label>
                        <input type="text" placeholder="e.g., Volunteer Organizer - Asian Games 2024" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>
                    
                    {{-- Number of Positions --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Positions Available</label>
                            <input type="number" min="1" placeholder="5" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Priority Level</label>
                            <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                                <option value="medium">Medium Priority</option>
                                <option value="high">High Priority</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                    </div>
                    
                    {{-- Deadline --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Application Deadline</label>
                        <input type="date" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>
                    
                    {{-- Location --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Location</label>
                        <input type="text" placeholder="e.g., Jakarta Sports Complex" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>
                    
                    {{-- Requirements --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Requirements</label>
                        <textarea rows="4" placeholder="Enter job requirements (one per line)..." class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500"></textarea>
                    </div>
                    
                    {{-- Job Description --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Job Description</label>
                        <textarea rows="3" placeholder="Brief description of the role and responsibilities..." class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500"></textarea>
                    </div>
                    
                    {{-- Action Buttons --}}
                    <div class="flex space-x-3 pt-4">
                        <button type="button" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Save as Draft</button>
                        <button type="submit" class="flex-1 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">Publish Job Opening</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const createJobBtn = document.getElementById('create-job-btn');
    const modal = document.getElementById('create-job-modal');
    const closeModal = document.getElementById('close-modal');
    
    createJobBtn.addEventListener('click', function() {
        modal.classList.remove('hidden');
    });
    
    closeModal.addEventListener('click', function() {
        modal.classList.add('hidden');
    });
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });
});
</script>
@endsection
