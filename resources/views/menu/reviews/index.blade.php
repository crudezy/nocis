@extends('layouts.app')

@section('title', 'Committee Registration Review - NOCIS')
@section('page-title')
    Committee Registration Review
@endsection

@section('content')
<div class="space-y-6">

{{-- Search Bar & Calendar View (di bawah header) --}}
    <div class="flex items-center justify-between mb-6">
        <div class="relative flex items-center border border-gray-300 rounded-lg py-2 px-4 pl-10 bg-white">
            <i class="fas fa-search absolute left-3 text-gray-400"></i>
            <input type="text" placeholder="Search Committee..." class="focus:outline-none w-64 ml-2">
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        {{-- Total Applicants --}}
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-gray-500 text-sm font-semibold mb-2">Total Applicants</h3>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_applicants'] ?? 0 }}</p>
        </div>

        {{-- Pending Review --}}
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-gray-500 text-sm font-semibold mb-2">Pending Review</h3>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['pending_review'] ?? 0 }}</p>
        </div>

        {{-- Approved Members --}}
        <div class="bg-white p-6 rounded-lg shadow-sm flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm font-semibold mb-2">Approved Members</h3>
                <p class="text-3xl font-bold text-gray-800">{{ $stats['approved_members'] ?? 0 }}</p>
            </div>
            <i class="fas fa-check-circle text-blue-500 text-2xl"></i>
        </div>

        {{-- Rejection Members --}}
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-gray-500 text-sm font-semibold mb-2">Rejection Members</h3>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['rejected_members'] ?? 0 }}</p>
        </div>
    </div>

    {{-- Applications Table with Categories --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($applications ?? [] as $application)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center mr-3">
                                    <span class="text-gray-600 font-semibold text-sm">{{ strtoupper(substr($application->user->name, 0, 2)) }}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $application->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $application->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $application->opening->title ?? 'N/A' }}</div>
                            <div class="text-xs text-gray-500">{{ $application->opening->event->title ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                @if($application->opening->jobCategory->name === 'Volunteer') bg-blue-100 text-blue-800
                                @elseif($application->opening->jobCategory->name === 'Organizer') bg-green-100 text-green-800
                                @elseif($application->opening->jobCategory->name === 'Liaison') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $application->opening->jobCategory->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $application->opening->event->title ?? 'N/A' }}</div>
                            <div class="text-xs text-gray-500">{{ $application->opening->event->city->name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                @if($application->status === 'approved') bg-green-100 text-green-800
                                @elseif($application->status === 'rejected') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $application->created_at->format('d M Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $application->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex justify-end space-x-2">
                                <button class="text-blue-600 hover:text-blue-800 text-sm font-medium"
                                        onclick="showApplicationDetail({{ $application->id }})">
                                    <i class="fas fa-eye mr-1"></i> View
                                </button>
                                @if($application->status === 'pending')
                                <button class="text-red-600 hover:text-red-800 text-sm font-medium"
                                        onclick="showStatusUpdateModal({{ $application->id }})">
                                    <i class="fas fa-edit mr-1"></i> Review
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            <div class="py-8">
                                <i class="fas fa-inbox text-3xl mb-2"></i>
                                <p>No applications found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination would go here if needed -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <div class="text-sm text-gray-600">
                Showing {{ count($applications ?? []) }} applications
            </div>
        </div>
    </div>
</div>

<!-- Application Detail Modal -->
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-2xl w-full mx-4 relative max-h-[80vh] overflow-y-auto">
        <button onclick="hideDetailModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
            ×
        </button>

        <h3 class="text-lg font-bold text-gray-900 mb-4">Application Details</h3>

        <div id="applicationDetails" class="space-y-4">
            <!-- Details will be loaded here via JavaScript -->
        </div>

        <div class="flex gap-2 justify-end mt-6">
            <button onclick="hideDetailModal()" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                Close
            </button>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 relative">
        <button onclick="hideStatusModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
            ×
        </button>

        <h3 class="text-lg font-bold text-gray-900 mb-4">Update Application Status</h3>

        <form id="statusForm" onsubmit="event.preventDefault(); updateApplicationStatus();">
            <input type="hidden" id="currentApplicationId">

            <div class="space-y-4 mb-6">
                <div>
                    <label for="statusSelect" class="block text-sm font-medium text-gray-700 mb-1">
                        Status
                    </label>
                    <select id="statusSelect" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

                <div>
                    <label for="reviewNotes" class="block text-sm font-medium text-gray-700 mb-1">
                        Review Notes (optional)
                    </label>
                    <textarea id="reviewNotes" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                              placeholder="Add any review notes..."></textarea>
                </div>
            </div>

            <div class="flex gap-2 justify-end">
                <button type="button" onclick="hideStatusModal()" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                    Update Status
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Store applications data for JavaScript access
    const applications = @json($applications ?? []);

    function showApplicationDetail(applicationId) {
        const app = applications.find(a => a.id === applicationId);
        if (!app) return;

        const details = document.getElementById('applicationDetails');
        details.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h4 class="font-semibold text-gray-800 mb-2">Applicant Information</h4>
                    <div class="space-y-2 text-sm">
                        <div><strong>Name:</strong> ${app.user.name}</div>
                        <div><strong>Email:</strong> ${app.user.email || 'N/A'}</div>
                        <div><strong>Applied On:</strong> ${new Date(app.created_at).toLocaleString()}</div>
                        <div><strong>Status:</strong> <span class="text-${app.status === 'approved' ? 'green' : app.status === 'rejected' ? 'red' : 'yellow'}-600 font-medium">${app.status}</span></div>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-800 mb-2">Position Information</h4>
                    <div class="space-y-2 text-sm">
                        <div><strong>Position:</strong> ${app.opening.title}</div>
                        <div><strong>Category:</strong> ${app.opening.job_category.name}</div>
                        <div><strong>Event:</strong> ${app.opening.event.title}</div>
                        <div><strong>Location:</strong> ${app.opening.event.city.name}</div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <h4 class="font-semibold text-gray-800 mb-2">Motivation</h4>
                <p class="text-gray-700 bg-gray-50 p-3 rounded">${app.motivation}</p>
            </div>

            ${app.experience ? `
            <div class="mt-4">
                <h4 class="font-semibold text-gray-800 mb-2">Experience</h4>
                <p class="text-gray-700 bg-gray-50 p-3 rounded">${app.experience}</p>
            </div>
            ` : ''}

            ${app.review_notes ? `
            <div class="mt-4">
                <h4 class="font-semibold text-gray-800 mb-2">Review Notes</h4>
                <p class="text-gray-700 bg-gray-50 p-3 rounded">${app.review_notes}</p>
            </div>
            ` : ''}
        `;

        document.getElementById('detailModal').classList.remove('hidden');
        document.getElementById('detailModal').classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function hideDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
        document.getElementById('detailModal').classList.remove('flex');
        document.body.style.overflow = '';
    }

    function showStatusUpdateModal(applicationId) {
        document.getElementById('currentApplicationId').value = applicationId;
        document.getElementById('statusModal').classList.remove('hidden');
        document.getElementById('statusModal').classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function hideStatusModal() {
        document.getElementById('statusModal').classList.add('hidden');
        document.getElementById('statusModal').classList.remove('flex');
        document.body.style.overflow = '';
    }

    function updateApplicationStatus() {
        const appId = document.getElementById('currentApplicationId').value;
        const status = document.getElementById('statusSelect').value;
        const notes = document.getElementById('reviewNotes').value;

        fetch("{{ route('admin.reviews.update', ['application' => '__ID__']) }}".replace('__ID__', appId), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: status,
                review_notes: notes
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Application status updated successfully!');
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Failed to update status'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }

    // Close modals on escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideDetailModal();
            hideStatusModal();
        }
    });

    // Close modals on outside click
    document.getElementById('detailModal').addEventListener('click', function(e) {
        if (e.target === this) hideDetailModal();
    });

    document.getElementById('statusModal').addEventListener('click', function(e) {
        if (e.target === this) hideStatusModal();
    });
</script>
@endsection