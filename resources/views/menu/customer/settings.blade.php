@extends('layouts.public')

@section('title', 'Pengaturan - NOCIS')

@section('content')
<!-- Customer Settings -->
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Pengaturan</h1>
        <p class="text-gray-600">Kelola informasi akun dan preferensi Anda.</p>
    </div>
    
    <!-- Settings Content -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <!-- Settings Tabs -->
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button onclick="showSettingsTab('basic')" class="tab-button py-4 px-1 border-b-2 font-medium text-sm active-tab" data-tab="basic">
                    <i class="fas fa-info-circle mr-2"></i>Informasi Dasar
                </button>
                <button onclick="showSettingsTab('personal')" class="tab-button py-4 px-1 border-b-2 font-medium text-sm" data-tab="personal">
                    <i class="fas fa-user mr-2"></i>Data Pribadi
                </button>
                <button onclick="showSettingsTab('preferences')" class="tab-button py-4 px-1 border-b-2 font-medium text-sm" data-tab="preferences">
                    <i class="fas fa-cog mr-2"></i>Preferensi
                </button>
            </nav>
        </div>

        <!-- Settings Tab Content -->
        <div class="p-6">
            <!-- Basic Information Tab -->
            <div id="basic-tab" class="tab-content">
                <!-- Photo Upload Form -->
                <form action="{{ route('customer.settings.photo') }}" method="POST" enctype="multipart/form-data" class="mb-8">
                    @csrf
                    
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Foto Formal</h3>
                    
                    <!-- Current Photo Display -->
                    <div class="flex items-center space-x-6 mb-6">
                        <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center">
                            @if($user->profile && $user->profile->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile->profile_photo) }}" alt="Profile" class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-user text-gray-400 text-3xl"></i>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $user->name ?? $user->username }}</p>
                            <p class="text-xs text-gray-500">Foto saat ini</p>
                        </div>
                    </div>

                    <!-- Photo Upload -->
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-red-400 transition-colors">
                        <div class="mb-4">
                            <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl"></i>
                        </div>
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Unggah foto</h4>
                        <p class="text-xs text-gray-500 mb-4">Unggah foto dalam format JPG/JPEG/PNG (maksimal 2 MB).</p>
                        
                        <input type="file"
                               id="profile_photo"
                               name="profile_photo"
                               accept="image/jpeg,image/jpg,image/png"
                               class="hidden"
                               onchange="previewPhoto(event)">
                        <label for="profile_photo"
                               class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium cursor-pointer transition-colors inline-flex items-center">
                            <i class="fas fa-upload mr-2"></i>
                            Unggah foto
                        </label>
                        
                        <div id="photo-preview" class="mt-3 hidden">
                            <div class="flex items-center justify-center space-x-2">
                                <i class="fas fa-image text-blue-500"></i>
                                <span class="text-sm text-gray-600 font-medium" id="photo-name"></span>
                                <button type="button" onclick="removePhoto()" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Foto
                        </button>
                    </div>
                </form>

                <!-- Summary Form -->
                <form action="{{ route('customer.settings.update') }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan</h3>
                        <div>
                            <label for="summary" class="block text-sm font-medium text-gray-700 mb-2">
                                Ringkasan *
                            </label>
                            <textarea id="summary"
                                      name="summary"
                                      rows="4"
                                      placeholder="Tulis ringkasan singkat tentang diri Anda..."
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">{{ old('summary', $user->profile->summary ?? '') }}</textarea>
                            @error('summary')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Ringkasan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Personal Data Tab -->
            <div id="personal-tab" class="tab-content hidden">
                <form action="{{ route('customer.settings.update') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Email -->
                        <div class="md:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email *
                            </label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $user->email ?? '') }}"
                                   required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all @error('email') border-red-500 @enderror">
                            <p class="text-xs text-gray-500 mt-1">Kamu dapat mengubah alamat email dan password melalui pengaturan akun di dicoding.com.</p>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor telepon *
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm">🇮🇩 +62</span>
                                </div>
                                <input type="tel"
                                       id="phone"
                                       name="phone"
                                       value="{{ old('phone', $user->profile->phone ?? '') }}"
                                       placeholder="85264315875"
                                       class="w-full pl-20 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                            </div>
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- City -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                Kota domisili *
                            </label>
                            <input type="text"
                                   id="address"
                                   name="address"
                                   value="{{ old('address', $user->profile->address ?? '') }}"
                                   placeholder="Kabupaten Bandung"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                            @error('address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div class="md:col-span-2">
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal lahir *
                            </label>
                            <input type="date"
                                   id="date_of_birth"
                                   name="date_of_birth"
                                   value="{{ old('date_of_birth', $user->profile->date_of_birth ? $user->profile->date_of_birth->format('Y-m-d') : '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                            @error('date_of_birth')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8 flex space-x-4">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Preferences Tab -->
            <div id="preferences-tab" class="tab-content hidden">
                <div class="text-center py-12">
                    <i class="fas fa-cog text-gray-400 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Preferensi</h3>
                    <p class="text-gray-500">Pengaturan preferensi akan tersedia soon.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .active-tab {
        border-color: #ef4444;
        color: #ef4444;
    }
    
    .tab-content {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    function showSettingsTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        // Remove active class from all tabs
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('active-tab');
            button.classList.add('text-gray-500', 'border-transparent');
            button.classList.remove('text-red-600', 'border-red-500');
        });
        
        // Show selected tab content
        document.getElementById(tabName + '-tab').classList.remove('hidden');
        
        // Add active class to selected tab
        const activeButton = document.querySelector(`[data-tab="${tabName}"]`);
        activeButton.classList.add('active-tab');
        activeButton.classList.remove('text-gray-500', 'border-transparent');
        activeButton.classList.add('text-red-600', 'border-red-500');
    }
    
    function previewPhoto(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Update preview
                const previewDiv = document.getElementById('photo-preview');
                const nameSpan = document.getElementById('photo-name');
                nameSpan.textContent = file.name;
                previewDiv.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
    
    function removePhoto() {
        document.getElementById('profile_photo').value = '';
        document.getElementById('photo-preview').classList.add('hidden');
    }
    
    // Initialize first tab as active
    document.addEventListener('DOMContentLoaded', function() {
        showSettingsTab('basic');
    });
</script>
@endsection