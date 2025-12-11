@extends('layouts.public')

@section('title', $job->title . ' - NOCIS')

@section('content')
<!-- Professional Job Detail Page -->
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <!-- Header with Back Navigation -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <a href="{{ route('jobs.index') }}" class="text-red-600 hover:text-red-700 font-medium transition-colors">
                ← Back to Job Listings
            </a>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Job Header -->
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900 mb-3">{{ $job->title }}</h1>

                        <!-- Company/Event Info -->
                        <div class="mb-4">
                            <h3 class="font-semibold text-gray-800">{{ $job->event->title }}</h3>
                            <p class="text-sm text-gray-500">
                                {{ $job->event->city->name }}, Indonesia
                            </p>
                        </div>

                        <!-- Status and Deadline -->
                        <div class="flex flex-wrap items-center gap-4 text-sm mb-4">
                            <span class="inline-flex items-center gap-1 bg-green-100 text-green-800 px-2 py-1 rounded font-medium">
                                {{ ucfirst($job->status) }}
                            </span>
                            <span class="text-gray-600">
                                Applications close {{ $job->application_deadline->format('d M Y, H:i') }}
                            </span>
                        </div>
                    </div>

                    <!-- Job Overview Section -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3">Job Overview</h3>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <span class="text-gray-600"><strong>Category:</strong> {{ $job->jobCategory->name }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600"><strong>Event:</strong> {{ $job->event->title }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600"><strong>Location:</strong> {{ $job->event->venue }}, {{ $job->event->city->name }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600"><strong>Event Dates:</strong> {{ $job->event->start_at->format('d M Y') }} - {{ $job->event->end_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Job Description -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3">Job Description</h3>
                        <div class="text-gray-700 prose max-w-none">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                    </div>

                    <!-- Requirements Section -->
                    @if(!empty($job->requirements))
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3">Requirements</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-700">
                            @foreach($job->requirements as $requirement)
                            <li>{{ $requirement }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Benefits Section -->
                    @if(!empty($job->benefits))
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3">Benefits</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-700">
                            @foreach(explode("\n", $job->benefits) as $benefit)
                                @if(trim($benefit))
                                <li>{{ trim($benefit) }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-gray-50 rounded-lg p-4 sticky top-8">
                        <h3 class="font-semibold text-gray-900 mb-3">Job Summary</h3>

                        <div class="space-y-3 mb-4">
                            <div>
                                <span class="text-sm text-gray-500 block">Status</span>
                                <span class="font-medium">{{ ucfirst($job->status) }}</span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 block">Slots Available</span>
                                <span class="font-medium text-green-600">{{ $job->slots_total - $job->slots_filled }} of {{ $job->slots_total }}</span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 block">Application Deadline</span>
                                <span class="font-medium">
                                    {{ $job->application_deadline->format('d M Y, H:i') }}
                                </span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 block">Created</span>
                                <span class="font-medium">
                                    {{ $job->created_at->format('d M Y, H:i') }}
                                </span>
                            </div>
                        </div>

                        <!-- Apply Button Section -->
                        <div class="pt-3 border-t border-gray-200">
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
                                <!-- Already Applied Button -->
                                <button disabled
                                        class="w-full bg-gray-300 text-gray-600 py-2 px-4 rounded-lg font-medium transition-colors mb-2 cursor-not-allowed">
                                    Already Applied
                                </button>
                                @else
                                <!-- Apply Button for Authenticated Users -->
                                <button id="applyButton"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg font-medium transition-colors mb-2"
                                        onclick="showApplyModal()">
                                    Apply for this Job
                                </button>
                                @endif

                                <!-- Save Button -->
                                <button class="w-full bg-white hover:bg-gray-50 text-gray-800 py-2 px-4 rounded-lg font-medium transition-colors border border-gray-200"
                                        onclick="saveJob({{ $job->id }})">
                                    Save this Job
                                </button>
                            @else
                                <!-- Login Prompt for Guests -->
                                <a href="{{ route('login') }}"
                                   class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded-lg font-medium transition-colors text-center mb-2">
                                    Login to Apply
                                </a>

                                <button class="w-full bg-white hover:bg-gray-50 text-gray-800 py-2 px-4 rounded-lg font-medium transition-colors border border-gray-200"
                                        onclick="saveJob({{ $job->id }})">
                                    Save this Job
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Apply Modal -->
<div id="applyModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 relative">
        <button onclick="hideApplyModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
            ×
        </button>

        <h3 class="text-lg font-bold text-gray-900 mb-3">Apply for {{ $job->title }}</h3>

        <p class="text-gray-600 mb-4">
            Please provide some information about your application.
        </p>

        <!-- Application Form -->
        <form id="applicationForm" onsubmit="event.preventDefault(); submitApplication();">
            <div class="space-y-4 mb-6">
                <!-- Motivation Field -->
                <div>
                    <label for="motivation" class="block text-sm font-medium text-gray-700 mb-1">
                        Why are you interested in this position?
                    </label>
                    <textarea id="motivation" name="motivation" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                              placeholder="Briefly explain your motivation..."></textarea>
                </div>

                <!-- Experience Field -->
                <div>
                    <label for="experience" class="block text-sm font-medium text-gray-700 mb-1">
                        Relevant Experience (optional)
                    </label>
                    <textarea id="experience" name="experience" rows="2"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                              placeholder="Describe your relevant experience..."></textarea>
                </div>
            </div>

            <div class="flex gap-2 justify-end">
                <button type="button" onclick="hideApplyModal()" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                    Submit Application
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Clean Styles -->
<style>
    /* Smooth animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .job-detail {
        animation: fadeIn 0.3s ease-out forwards;
    }

    /* Modal animation */
    #applyModal {
        transition: opacity 0.3s ease;
    }

    #applyModal > div {
        transform: translateY(20px);
        transition: transform 0.3s ease;
    }

    #applyModal:not(.hidden) > div {
        transform: translateY(0);
    }

    /* Responsive adjustments */
    @media (max-width: 1024px) {
        .lg\:grid-cols-3 {
            grid-template-columns: 1fr;
        }

        .lg\:col-span-2,
        .lg\:col-span-1 {
            grid-column: span 1;
        }
    }
</style>

<!-- Clean JavaScript -->
<script>
    function showApplyModal() {
        document.getElementById('applyModal').classList.remove('hidden');
        document.getElementById('applyModal').classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function hideApplyModal() {
        document.getElementById('applyModal').classList.add('hidden');
        document.getElementById('applyModal').classList.remove('flex');
        document.body.style.overflow = '';
    }

    function submitApplication() {
        const applyButton = document.getElementById('applyButton');
        applyButton.disabled = true;
        applyButton.textContent = 'Processing...';

        // Get form data
        const motivation = document.getElementById('motivation')?.value || 'Interested in this opportunity';
        const experience = document.getElementById('experience')?.value || '';

        // Submit via AJAX
        fetch("{{ route('jobs.apply', $job) }}", {
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
                // Update button to show "Already Applied"
                applyButton.textContent = 'Already Applied';
                applyButton.classList.remove('bg-red-600', 'hover:bg-red-700');
                applyButton.classList.add('bg-gray-300', 'cursor-not-allowed');
                applyButton.disabled = true;
            } else {
                alert('Error: ' + (data.message || 'Failed to submit application'));
                applyButton.disabled = false;
                applyButton.textContent = 'Apply for this Job';
            }
            hideApplyModal();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
            applyButton.disabled = false;
            applyButton.textContent = 'Apply for this Job';
            hideApplyModal();
        });
    }

    // Close modal on escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideApplyModal();
        }
    });

    // Close modal on outside click
    document.getElementById('applyModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideApplyModal();
        }
    });

    // Save job functionality
    function saveJob(jobId) {
        fetch('/jobs/' + jobId + '/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Job saved successfully!');
            } else {
                alert(data.message || 'Failed to save job');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }
</script>
@endsection