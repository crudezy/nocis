@extends('layouts.public')

@section('title', 'My Applications - NOCIS')

@section('content')
<!-- Customer Applications -->
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">My Applications</h1>
        <p class="text-gray-600">Track the status of your job applications.</p>
    </div>

    <!-- Dashboard Navigation -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
        <div class="p-6">
            <nav class="flex space-x-8">
                <a href="{{ route('customer.dashboard') }}" class="text-gray-500 hover:text-gray-700 px-1 pb-2 font-medium transition-colors">
                    Dashboard
                </a>
                <a href="{{ route('customer.applications') }}" class="border-b-2 border-red-500 text-red-600 px-1 pb-2 font-medium">
                    My Applications
                </a>
                <a href="{{ route('customer.saved-jobs') }}" class="text-gray-500 hover:text-gray-700 px-1 pb-2 font-medium transition-colors">
                    Saved Jobs
                </a>
            </nav>
        </div>
    </div>

    <!-- Applications List -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Application History</h3>
                <div class="text-sm text-gray-600">
                    Total: {{ $applications->total() }} applications
                </div>
            </div>
        </div>

        <div class="p-6">
            @forelse($applications as $application)
            <div class="border border-gray-200 rounded-lg p-6 mb-4 last:mb-0">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">{{ $application->workerOpening->title }}</h4>
                                <p class="text-gray-600 mt-1">{{ $application->workerOpening->event->title }}</p>
                                <p class="text-sm text-gray-500 mt-2">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    {{ $application->workerOpening->event->venue }}, {{ $application->workerOpening->event->city->name }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    <i class="fas fa-calendar mr-1"></i>
                                    Applied on {{ $application->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                            
                            <!-- Status Badge -->
                            <div class="ml-4">
                                @if($application->status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>
                                        Pending Review
                                    </span>
                                @elseif($application->status === 'approved')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Approved
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Not Selected
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Application Details -->
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h5 class="text-sm font-medium text-gray-700 mb-2">Your Motivation</h5>
                                <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded">{{ $application->motivation }}</p>
                            </div>
                            @if($application->experience)
                            <div>
                                <h5 class="text-sm font-medium text-gray-700 mb-2">Relevant Experience</h5>
                                <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded">{{ $application->experience }}</p>
                            </div>
                            @endif
                        </div>

                        <!-- Job Details -->
                        <div class="mt-4 p-4 bg-gray-50 rounded">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">Category:</span>
                                    <p class="font-medium">{{ $application->workerOpening->jobCategory->name }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Slots:</span>
                                    <p class="font-medium">{{ $application->workerOpening->slots_filled }}/{{ $application->workerOpening->slots_total }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Deadline:</span>
                                    <p class="font-medium">{{ $application->workerOpening->application_deadline->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Event Dates:</span>
                                    <p class="font-medium">{{ $application->workerOpening->event->start_at->format('d M') }} - {{ $application->workerOpening->event->end_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-4 flex space-x-3">
                            <a href="{{ route('jobs.show', $application->workerOpening) }}" 
                               class="text-red-600 hover:text-red-700 font-medium text-sm">
                                <i class="fas fa-eye mr-1"></i>
                                View Job Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <i class="fas fa-file-alt text-gray-400 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No applications yet</h3>
                <p class="text-gray-500 mb-6">Start exploring job opportunities and apply to positions that interest you.</p>
                <a href="{{ route('jobs.index') }}" 
                   class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium inline-flex items-center transition-colors">
                    <i class="fas fa-search mr-2"></i>
                    Browse Job Opportunities
                </a>
            </div>
            @endforelse

            <!-- Pagination -->
            @if($applications->hasPages())
            <div class="mt-8">
                {{ $applications->links('pagination::tailwind') }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection