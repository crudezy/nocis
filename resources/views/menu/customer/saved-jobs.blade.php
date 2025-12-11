@extends('layouts.public')

@section('title', 'Saved Jobs - NOCIS')

@section('content')
<!-- Saved Jobs -->
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Saved Jobs</h1>
        <p class="text-gray-600">Keep track of jobs you're interested in.</p>
    </div>

    <!-- Dashboard Navigation -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
        <div class="p-6">
            <nav class="flex space-x-8">
                <a href="{{ route('customer.dashboard') }}" class="text-gray-500 hover:text-gray-700 px-1 pb-2 font-medium transition-colors">
                    Dashboard
                </a>
                <a href="{{ route('customer.applications') }}" class="text-gray-500 hover:text-gray-700 px-1 pb-2 font-medium transition-colors">
                    My Applications
                </a>
                <a href="{{ route('customer.saved-jobs') }}" class="border-b-2 border-red-500 text-red-600 px-1 pb-2 font-medium">
                    Saved Jobs
                </a>
            </nav>
        </div>
    </div>

    <!-- Saved Jobs List -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Your Saved Jobs</h3>
                <div class="text-sm text-gray-600">
                    Total: {{ $savedJobs->total() }} saved jobs
                </div>
            </div>
        </div>

        <div class="p-6">
            @forelse($savedJobs as $job)
            <div class="border border-gray-200 rounded-lg p-6 mb-4 last:mb-0">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">{{ $job->title }}</h4>
                                <p class="text-gray-600 mt-1">{{ $job->event->title }}</p>
                                <p class="text-sm text-gray-500 mt-2">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    {{ $job->event->venue }}, {{ $job->event->city->name }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    <i class="fas fa-calendar mr-1"></i>
                                    Saved on {{ $job->pivot->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                            
                            <!-- Status Badge -->
                            <div class="ml-4">
                                @if($job->status === 'open' && $job->application_deadline > now())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-circle text-green-500 mr-1"></i>
                                        Applications Open
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Closed
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Job Details -->
                        <div class="mt-4 p-4 bg-gray-50 rounded">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">Category:</span>
                                    <p class="font-medium">{{ $job->jobCategory->name }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Slots:</span>
                                    <p class="font-medium">{{ $job->slots_filled }}/{{ $job->slots_total }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Deadline:</span>
                                    <p class="font-medium">{{ $job->application_deadline->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Event Dates:</span>
                                    <p class="font-medium">{{ $job->event->start_at->format('d M') }} - {{ $job->event->end_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Job Description Preview -->
                        @if($job->description)
                        <div class="mt-4">
                            <h5 class="text-sm font-medium text-gray-700 mb-2">Description</h5>
                            <p class="text-sm text-gray-600">
                                {{ Str::limit($job->description, 200) }}
                                @if(strlen($job->description) > 200)
                                    <span class="text-red-600">...</span>
                                @endif
                            </p>
                        </div>
                        @endif

                        <!-- Actions -->
                        <div class="mt-4 flex space-x-3">
                            <a href="{{ route('jobs.show', $job) }}" 
                               class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium text-sm inline-flex items-center transition-colors">
                                <i class="fas fa-eye mr-2"></i>
                                View Details
                            </a>
                            
                            <!-- Check if already applied -->
                            @php
                                $customerId = session('customer_id');
                                $hasApplied = \App\Models\Application::where('worker_opening_id', $job->id)
                                    ->where('user_id', $customerId)
                                    ->exists();
                            @endphp
                            
                            @if($hasApplied)
                                <button disabled
                                        class="bg-gray-300 text-gray-600 px-4 py-2 rounded-lg font-medium text-sm cursor-not-allowed">
                                    <i class="fas fa-check mr-2"></i>
                                    Already Applied
                                </button>
                            @elseif($job->status === 'open' && $job->application_deadline > now())
                                <button onclick="applyForJob({{ $job->id }})"
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium text-sm inline-flex items-center transition-colors">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    Apply Now
                                </button>
                            @else
                                <button disabled
                                        class="bg-gray-300 text-gray-600 px-4 py-2 rounded-lg font-medium text-sm cursor-not-allowed">
                                    <i class="fas fa-clock mr-2"></i>
                                    Applications Closed
                                </button>
                            @endif
                            
                            <button onclick="removeSavedJob({{ $job->id }})"
                                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium text-sm inline-flex items-center transition-colors">
                                <i class="fas fa-trash mr-2"></i>
                                Remove
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <i class="fas fa-bookmark text-gray-400 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No saved jobs yet</h3>
                <p class="text-gray-500 mb-6">Save jobs you're interested in to view them later and apply when ready.</p>
                <a href="{{ route('jobs.index') }}" 
                   class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium inline-flex items-center transition-colors">
                    <i class="fas fa-search mr-2"></i>
                    Browse Job Opportunities
                </a>
            </div>
            @endforelse

            <!-- Pagination -->
            @if($savedJobs->hasPages())
            <div class="mt-8">
                {{ $savedJobs->links('pagination::tailwind') }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
function removeSavedJob(jobId) {
    if (confirm('Are you sure you want to remove this job from your saved jobs?')) {
        fetch('/dashboard/jobs/' + jobId + '/unsave', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Failed to remove saved job');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }
}

function applyForJob(jobId) {
    // Redirect to job page with apply modal
    window.location.href = '/jobs/' + jobId + '#apply';
}
</script>
@endsection