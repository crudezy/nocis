@extends('layouts.public')

@section('title', 'Job Opportunities - NOCIS')

@section('content')
<!-- Modern Job Opportunities Page -->
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Job Opportunities</h1>
                    <p class="text-gray-600 mt-1">Find your next adventure in sports event management</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-sm text-gray-500">
                        <span class="font-semibold text-gray-900">{{ $jobs->total() }}</span> opportunities available
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col">
            <!-- Main Content -->
            <div class="w-full">
                <!-- Job Listings -->
                <div class="space-y-6">
                    @forelse($jobs as $job)
                    <!-- Job Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 group">
                        <div class="p-6">
                            <!-- Job Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-4 flex-1">                                    
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-red-600 transition-colors mb-1">
                                            <a href="{{ route('jobs.show', $job) }}" class="hover:underline">
                                                {{ Str::limit($job->title, 60) }}
                                            </a>
                                        </h3>
                                        <div class="flex items-center gap-4 text-sm text-gray-600">
                                            <div class="flex items-center gap-1">
                                                <i class="fas fa-building text-gray-400"></i>
                                                <span class="font-medium">{{ $job->event->title ?? 'Event' }}</span>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <i class="fas fa-map-marker-alt text-red-500"></i>
                                                <span>{{ $job->event->city->name ?? 'Location' }}, Indonesia</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Badge -->
                                <div class="flex flex-col items-end gap-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                                        Open
                                    </span>
                                    @if($job->application_deadline->diffInDays(now()) <= 7)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            <i class="fas fa-clock mr-1"></i>
                                            Urgent
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Job Meta Info -->
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <div class="text-xs text-gray-500 mb-1">Category</div>
                                    <div class="font-semibold text-gray-900">{{ $job->jobCategory->name ?? 'General' }}</div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <div class="text-xs text-gray-500 mb-1">Deadline</div>
                                    <div class="font-semibold text-gray-900">{{ $job->application_deadline->format('d M') }}</div>
                                    <div class="text-xs text-gray-500">{{ $job->application_deadline->format('H:i') }}</div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <div class="text-xs text-gray-500 mb-1">Slots Available</div>
                                    <div class="font-semibold text-gray-900">{{ $job->slots_total - $job->slots_filled }}</div>
                                    <div class="text-xs text-gray-500">of {{ $job->slots_total }}</div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <div class="text-xs text-gray-500 mb-1">Event Date</div>
                                    <div class="font-semibold text-gray-900">{{ $job->event->start_at->format('d M') }}</div>
                                    <div class="text-xs text-gray-500">{{ $job->event->start_at->format('Y') }}</div>
                                </div>
                            </div>


                            <!-- Action Buttons -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <button class="text-gray-400 hover:text-red-600 transition-colors p-2 rounded-lg hover:bg-red-50" 
                                            onclick="toggleBookmark({{ $job->id }})">
                                        <i class="fas fa-bookmark text-lg" id="bookmark-{{ $job->id }}"></i>
                                    </button>
                                    <span class="text-sm text-gray-500">Save job</span>
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('jobs.show', $job) }}" 
                                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-all text-sm">
                                        View Details
                                    </a>
                                    @php
                                        $isCustomerAuthenticated = session('customer_authenticated');
                                        $customerId = session('customer_id');
                                        $hasApplied = false;
                                        
                                        if ($isCustomerAuthenticated && $customerId) {
                                            $hasApplied = \App\Models\Application::where('worker_opening_id', $job->id)
                                                ->where('user_id', $customerId)
                                                ->exists();
                                        }
                                    @endphp

                                    @if($isCustomerAuthenticated)
                                        @if($hasApplied)
                                            <button disabled class="bg-gray-300 text-gray-600 px-6 py-2 rounded-lg font-medium cursor-not-allowed">
                                                Applied
                                            </button>
                                        @else
                                            <button onclick="quickApply({{ $job->id }})" 
                                                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium transition-all shadow-lg hover:shadow-xl">
                                                Apply Now
                                            </button>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" 
                                           class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium transition-all shadow-lg hover:shadow-xl">
                                            Login to Apply
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <!-- Empty State -->
                    <div class="bg-white rounded-xl shadow-sm p-12 text-center border-2 border-dashed border-gray-200">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-search text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">No job opportunities found</h3>
                        <p class="text-gray-500 mb-6">Check back later for new openings</p>
                        <a href="{{ route('jobs.index') }}" 
                           class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium transition-all">
                            <i class="fas fa-refresh"></i>
                            Refresh
                        </a>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($jobs->hasPages())
                <div class="mt-8 bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="text-sm text-gray-600">
                            Showing <strong>{{ $jobs->firstItem() }}-{{ $jobs->lastItem() }}</strong> of <strong>{{ $jobs->total() }}</strong> opportunities
                        </div>
                        <div class="flex items-center gap-1">
                            {{ $jobs->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Apply Modal -->
<div id="quickApplyModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4 relative shadow-2xl">
        <button onclick="hideQuickApplyModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fas fa-times text-xl"></i>
        </button>

        <h3 class="text-xl font-bold text-gray-900 mb-4">Quick Application</h3>
        <p class="text-gray-600 mb-6">Submit your application for this position.</p>

        <form id="quickApplyForm" onsubmit="event.preventDefault(); submitQuickApplication();">
            <div class="space-y-4 mb-6">
                <div>
                    <label for="quickMotivation" class="block text-sm font-medium text-gray-700 mb-2">
                        Why are you interested? *
                    </label>
                    <textarea id="quickMotivation" name="motivation" rows="3" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                              placeholder="Briefly explain your interest..."></textarea>
                </div>

                <div>
                    <label for="quickExperience" class="block text-sm font-medium text-gray-700 mb-2">
                        Relevant Experience
                    </label>
                    <textarea id="quickExperience" name="experience" rows="2"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                              placeholder="Optional: Describe your experience..."></textarea>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="hideQuickApplyModal()" 
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded-lg font-medium transition-colors">
                    Cancel
                </button>
                <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg font-medium transition-colors">
                    Submit Application
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentJobId = null;

    function quickApply(jobId) {
        currentJobId = jobId;
        document.getElementById('quickApplyModal').classList.remove('hidden');
        document.getElementById('quickApplyModal').classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function hideQuickApplyModal() {
        document.getElementById('quickApplyModal').classList.add('hidden');
        document.getElementById('quickApplyModal').classList.remove('flex');
        document.body.style.overflow = '';
        currentJobId = null;
    }

    function submitQuickApplication() {
        if (!currentJobId) return;

        const motivation = document.getElementById('quickMotivation').value;
        const experience = document.getElementById('quickExperience').value;

        const submitButton = document.querySelector('#quickApplyForm button[type="submit"]');
        submitButton.disabled = true;
        submitButton.textContent = 'Submitting...';

        fetch(`/jobs/${currentJobId}/apply`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                motivation: motivation,
                experience: experience
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Application submitted successfully!');
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Failed to submit application'));
                submitButton.disabled = false;
                submitButton.textContent = 'Submit Application';
            }
            hideQuickApplyModal();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
            submitButton.disabled = false;
            submitButton.textContent = 'Submit Application';
            hideQuickApplyModal();
        });
    }

    function toggleBookmark(jobId) {
        const bookmarkIcon = document.getElementById(`bookmark-${jobId}`);
        if (bookmarkIcon.classList.contains('fas')) {
            bookmarkIcon.classList.remove('fas');
            bookmarkIcon.classList.add('far');
            // Here you would typically save to backend
        } else {
            bookmarkIcon.classList.remove('far');
            bookmarkIcon.classList.add('fas');
            // Here you would typically save to backend
        }
    }

    // Close modal on escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideQuickApplyModal();
        }
    });

    // Close modal on outside click
    document.getElementById('quickApplyModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideQuickApplyModal();
        }
    });
</script>
@endsection