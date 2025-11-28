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
            <p class="text-3xl font-bold text-gray-800">1,247</p>
        </div>
        
        {{-- Pending Review --}}
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-gray-500 text-sm font-semibold mb-2">Pending Review</h3>
            <p class="text-3xl font-bold text-gray-800">892</p>
        </div>

        {{-- Approved Members --}}
        <div class="bg-white p-6 rounded-lg shadow-sm flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm font-semibold mb-2">Approved Members</h3>
                <p class="text-3xl font-bold text-gray-800">34</p>
            </div>
            <i class="fas fa-check-circle text-blue-500 text-2xl"></i>
        </div>

        {{-- Rejection Members --}}
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-gray-500 text-sm font-semibold mb-2">Rejection Members</h3>
            <p class="text-3xl font-bold text-gray-800">3</p>
        </div>
    </div>

    {{-- Committee Applications Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        {{-- Applicant 1: Greysia Polli --}}
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center mb-4">
                <img src="https://via.placeholder.com/50" alt="Greysia Polli" class="w-12 h-12 rounded-full mr-3">
                <div>
                    <h4 class="font-semibold text-gray-800">Greysia Polli</h4>
                    <p class="text-sm text-gray-500">Badminton</p>
                </div>
            </div>
            
            <div class="mb-4">
                <span class="bg-red-500 text-white text-xs px-3 py-1 rounded-full font-semibold">Volunteer Organizer</span>
            </div>
            
            <div class="mb-4">
                <div class="flex items-center text-sm text-gray-600 mb-2">
                    <i class="fas fa-trophy text-yellow-500 mr-2"></i>
                    <span>Achievements : 15</span>
                </div>
                <p class="text-xs text-gray-500">Relevant Experience : 12 Event</p>
            </div>
            
            <div class="mb-4">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm text-gray-600">Skill Match</span>
                    <span class="text-sm font-semibold text-gray-800">97%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-red-500 h-2 rounded-full" style="width: 97%"></div>
                </div>
            </div>
            
            <div class="mb-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Health</span>
                    <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded">High</span>
                </div>
            </div>
            
            <div class="flex space-x-2">
                <button class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded text-sm">View Profil</button>
                <button class="flex-1 bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-sm">Approve</button>
            </div>
        </div>

        {{-- Applicant 2: Anthony G --}}
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center mr-3">
                    <span class="text-gray-600 font-semibold">AG</span>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Anthony G</h4>
                    <p class="text-sm text-gray-500">Badminton</p>
                </div>
            </div>
            
            <div class="mb-4">
                <span class="bg-red-500 text-white text-xs px-3 py-1 rounded-full font-semibold">Pending</span>
            </div>
            
            <div class="mb-4">
                <div class="flex items-center text-sm text-gray-600 mb-2">
                    <i class="fas fa-user-tie text-blue-500 mr-2"></i>
                    <span>Volunteer Organizer</span>
                </div>
                <p class="text-xs text-gray-500">Bandung</p>
                <p class="text-xs text-gray-500">World Championship</p>
            </div>
            
            <div class="mb-4">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm text-gray-600">Skill Match</span>
                    <span class="text-sm font-semibold text-gray-800">88%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-red-500 h-2 rounded-full" style="width: 88%"></div>
                </div>
            </div>
            
            <div class="mb-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Health</span>
                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">Good</span>
                </div>
            </div>
            
            <div class="flex space-x-2">
                <button class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded text-sm">View Profil</button>
                <button class="flex-1 bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-sm">Manage</button>
            </div>
        </div>

        {{-- Applicant 3: Budi Santoso --}}
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-full bg-orange-300 flex items-center justify-center mr-3">
                    <span class="text-white font-semibold">BS</span>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Budi Santoso</h4>
                    <p class="text-sm text-gray-500">Badminton</p>
                </div>
            </div>
            
            <div class="mb-4">
                <span class="bg-red-500 text-white text-xs px-3 py-1 rounded-full font-semibold">Pending</span>
            </div>
            
            <div class="mb-4">
                <div class="flex items-center text-sm text-gray-600 mb-2">
                    <i class="fas fa-handshake text-green-500 mr-2"></i>
                    <span>Liaison Officer</span>
                </div>
                <p class="text-xs text-gray-500">Bandung</p>
                <p class="text-xs text-gray-500">World Championship</p>
            </div>
            
            <div class="mb-4">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm text-gray-600">Skill Match</span>
                    <span class="text-sm font-semibold text-gray-800">87%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-red-500 h-2 rounded-full" style="width: 87%"></div>
                </div>
            </div>
            
            <div class="mb-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Health</span>
                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">Good</span>
                </div>
            </div>
            
            <div class="flex space-x-2">
                <button class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded text-sm">View Profil</button>
                <button class="flex-1 bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-sm">Manage</button>
            </div>
        </div>

        {{-- Applicant 4: Eyi Sawan --}}
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-full bg-red-300 flex items-center justify-center mr-3">
                    <span class="text-white font-semibold">ES</span>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Eyi Sawan</h4>
                    <p class="text-sm text-gray-500">Badminton</p>
                </div>
            </div>
            
            <div class="mb-4">
                <span class="bg-red-500 text-white text-xs px-3 py-1 rounded-full font-semibold">Pending</span>
            </div>
            
            <div class="mb-4">
                <div class="flex items-center text-sm text-gray-600 mb-2">
                    <i class="fas fa-handshake text-yellow-500 mr-2"></i>
                    <span>Liaison Officer</span>
                </div>
                <p class="text-xs text-gray-500">Jakarta</p>
                <p class="text-xs text-gray-500">Olympic Preparation</p>
            </div>
            
            <div class="mb-4">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm text-gray-600">Skill Match</span>
                    <span class="text-sm font-semibold text-gray-800">85%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-red-500 h-2 rounded-full" style="width: 85%"></div>
                </div>
            </div>
            
            <div class="mb-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Health</span>
                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">Good</span>
                </div>
            </div>
            
            <div class="flex space-x-2">
                <button class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded text-sm">View Profil</button>
                <button class="flex-1 bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-sm">Manage</button>
            </div>
        </div>

    </div>
</div>
@endsection