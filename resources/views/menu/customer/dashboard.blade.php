@extends('layouts.public')

@section('title', 'Dashboard - NOCIS')

@section('content')
<!-- Customer Dashboard -->
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard</h1>
        <p class="text-gray-600">Welcome back, {{ session('customer_username') }}! Here's your job application overview.</p>
    </div>

    <!-- Dashboard Navigation -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
        <div class="p-6">
            <nav class="flex space-x-8">
                <a href="{{ route('customer.dashboard') }}" class="border-b-2 border-red-500 text-red-600 px-1 pb-2 font-medium">
                    Dashboard
                </a>
                <a href="{{ route('customer.applications') }}" class="text-gray-500 hover:text-gray-700 px-1 pb-2 font-medium transition-colors">
                    My Applications
                </a>
                <a href="{{ route('customer.saved-jobs') }}" class="text-gray-500 hover:text-gray-700 px-1 pb-2 font-medium transition-colors">
                    Saved Jobs
                </a>
            </nav>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Applications -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Applications</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalApplications }}</p>
                </div>
            </div>
        </div>

        <!-- Pending Applications -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingApplications }}</p>
                </div>
            </div>
        </div>

        <!-- Approved Applications -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Approved</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $approvedApplications }}</p>
                </div>
            </div>
        </div>

        <!-- Rejected Applications -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 rounded-lg">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Rejected</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $rejectedApplications }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Applications -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Applications</h3>
                    <a href="{{ route('customer.applications') }}" class="text-red-600 hover:text-red-700 font-medium text-sm">
                        View All
                    </a>
                </div>
            </div>
            <div class="p-6">
                @forelse($applications as $application)
                <div class="mb-4 last:mb-0">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900">{{ $application->workerOpening->title }}</h4>
                            <p class="text-sm text-gray-600">{{ $application->workerOpening->event->title }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $application->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="ml-4">
                            @if($application->status === 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            @elseif($application->status === 'approved')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Approved
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Rejected
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <i class="fas fa-file-alt text-gray-400 text-3xl mb-4"></i>
                    <p class="text-gray-500">No applications yet</p>
                    <a href="{{ route('jobs.index') }}" class="text-red-600 hover:text-red-700 font-medium mt-2 inline-block">
                        Browse Job Opportunities
                    </a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Recommended Jobs -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Recommended Jobs</h3>
                    <a href="{{ route('jobs.index') }}" class="text-red-600 hover:text-red-700 font-medium text-sm">
                        View All
                    </a>
                </div>
            </div>
            <div class="p-6">
                @forelse($recommendedJobs as $job)
                <div class="mb-4 last:mb-0">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900">{{ $job->title }}</h4>
                            <p class="text-sm text-gray-600">{{ $job->event->title }}</p>
                            <p class="text-sm text-gray-500">{{ $job->event->city->name }}, Indonesia</p>
                            <p class="text-xs text-gray-500 mt-1">Deadline: {{ $job->application_deadline->format('d M Y') }}</p>
                        </div>
                        <div class="ml-4">
                            <a href="{{ route('jobs.show', $job) }}" class="text-red-600 hover:text-red-700 font-medium text-sm">
                                View
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <i class="fas fa-briefcase text-gray-400 text-3xl mb-4"></i>
                    <p class="text-gray-500">No recommendations available</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection