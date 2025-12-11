@extends('layouts.public')

@section('title', 'Profile Saya - NOCIS')

@section('content')
<!-- Customer Profile -->
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Profile Saya</h1>
        <p class="text-gray-600">Kelola informasi profil Anda.</p>
    </div>

    <!-- Dashboard Navigation -->
    

    <!-- Profile Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Profile Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-start space-x-6">
                    <!-- Profile Photo -->
                    <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-200 flex-shrink-0">
                        @if($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-red-500 flex items-center justify-center text-white font-bold text-2xl">
                                {{ strtoupper(substr($user->name ?? $user->username ?? 'U', 0, 2)) }}
                            </div>
                        @endif
                    </div>
                    
                    <!-- Profile Info -->
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $user->name ?? $user->username }}</h2>
                        
                        <!-- Summary Section -->
                        @if($user->profile && $user->profile->summary)
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Ringkasan</h3>
                                <p class="text-gray-700 leading-relaxed">
                                    {{ $user->profile->summary }}
                                </p>
                                <button onclick="toggleSummary()" id="summary-toggle" class="text-red-600 hover:text-red-700 font-medium text-sm mt-2">
                                    Lihat lebih banyak
                                </button>
                            </div>
                        @else
                            <div class="mb-4">
                                <p class="text-gray-500 italic">Belum ada ringkasan. <a href="{{ route('customer.settings') }}" class="text-red-600 hover:text-red-700">Tambahkan ringkasan</a></p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Personal Info</h3>
                    <a href="{{ route('customer.settings') }}" class="text-red-600 hover:text-red-700 text-sm font-medium">
                        Edit
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-envelope text-gray-400 w-5"></i>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-medium text-gray-900">{{ $user->email }}</p>
                        </div>
                    </div>
                    
                    @if($user->profile && $user->profile->phone)
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-phone text-gray-400 w-5"></i>
                            <div>
                                <p class="text-sm text-gray-500">Nomor telepon</p>
                                <p class="font-medium text-gray-900">🇮🇩 +62{{ $user->profile->phone }}</p>
                            </div>
                        </div>
                    @endif
                    
                    @if($user->profile && $user->profile->address)
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-map-marker-alt text-gray-400 w-5"></i>
                            <div>
                                <p class="text-sm text-gray-500">Domisili</p>
                                <p class="font-medium text-gray-900">{{ $user->profile->address }}</p>
                            </div>
                        </div>
                    @endif
                    
                    @if($user->profile && $user->profile->date_of_birth)
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-calendar text-gray-400 w-5"></i>
                            <div>
                                <p class="text-sm text-gray-500">Tanggal lahir</p>
                                <p class="font-medium text-gray-900">{{ $user->profile->date_of_birth->format('d F Y') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Social Media Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Sosial Media</h3>
                    <button onclick="openSocialMediaModal()" class="text-red-600 hover:text-red-700 text-sm font-medium">
                        Tambah Akun
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($user->profile && $user->profile->linkedin)
                        <div class="flex items-center space-x-3">
                            <i class="fab fa-linkedin text-blue-600 w-5"></i>
                            <span class="text-blue-600 font-medium">
                                LinkedIn
                            </span>
                        </div>
                    @endif
                    
                    @if($user->profile && $user->profile->instagram)
                        <div class="flex items-center space-x-3">
                            <i class="fab fa-instagram text-pink-600 w-5"></i>
                            <span class="text-pink-600 font-medium">
                                Instagram
                            </span>
                        </div>
                    @endif
                    
                    @if($user->profile && $user->profile->twitter)
                        <div class="flex items-center space-x-3">
                            <i class="fab fa-twitter text-blue-400 w-5"></i>
                            <span class="text-blue-400 font-medium">
                                Twitter
                            </span>
                        </div>
                    @endif
                    
                    @if($user->profile && $user->profile->github)
                        <div class="flex items-center space-x-3">
                            <i class="fab fa-github text-gray-800 w-5"></i>
                            <span class="text-gray-800 font-medium">
                                GitHub
                            </span>
                        </div>
                    @endif
                    
                    @if($user->profile && $user->profile->website)
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-globe text-green-600 w-5"></i>
                            <span class="text-green-600 font-medium">
                                Portfolio Website
                            </span>
                        </div>
                    @endif
                    
                    @if(!$user->profile || (!$user->profile->linkedin && !$user->profile->instagram && !$user->profile->twitter && !$user->profile->github && !$user->profile->website))
                        <div class="col-span-full text-center py-4">
                            <p class="text-gray-500">Belum ada sosial media yang ditambahkan.</p>
                            <button onclick="openSocialMediaModal()" class="text-red-600 hover:text-red-700 font-medium text-sm">
                                Tambahkan sosial media
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- CV/Resume Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">CV/Resume</h3>
                    <a href="{{ route('customer.settings') }}" class="text-red-600 hover:text-red-700 text-sm font-medium">
                        Edit
                    </a>
                </div>
                
                @if($user->profile && $user->profile->cv_file)
                    <div class="flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-file-pdf text-green-600 text-xl"></i>
                            <div>
                                <p class="font-medium text-green-800">CV berhasil diupload</p>
                                <p class="text-sm text-green-600">Terakhir diperbarui: {{ $user->profile->cv_updated_at ? $user->profile->cv_updated_at->format('d M Y H:i') : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ asset('storage/' . $user->profile->cv_file) }}" target="_blank"
                               class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition-colors">
                                <i class="fas fa-eye mr-1"></i>Lihat
                            </a>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-file-upload text-gray-400 text-3xl mb-4"></i>
                        <p class="text-gray-500 mb-4">Belum ada CV yang diupload</p>
                        <a href="{{ route('customer.settings') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            Upload CV
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column - Quick Stats -->
        <div class="space-y-6">
            <!-- Profile Completion -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Kelengkapan Profil</h3>
                
                @php
                    $completionScore = 0;
                    $totalFields = 6;
                    
                    if($user->profile_photo) $completionScore++;
                    if($user->profile && $user->profile->summary) $completionScore++;
                    if($user->profile && $user->profile->phone) $completionScore++;
                    if($user->profile && $user->profile->address) $completionScore++;
                    if($user->profile && $user->profile->date_of_birth) $completionScore++;
                    if($user->profile && $user->profile->cv_file) $completionScore++;
                    
                    $percentage = ($completionScore / $totalFields) * 100;
                @endphp
                
                <div class="mb-4">
                    <div class="flex justify-between text-sm font-medium text-gray-900 mb-1">
                        <span>{{ $completionScore }}/{{ $totalFields }} selesai</span>
                        <span>{{ number_format($percentage, 0) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-red-600 h-2 rounded-full transition-all duration-300" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                
                <div class="space-y-2 text-sm">
                    @if(!$user->profile_photo)
                        <div class="flex items-center text-gray-500">
                            <i class="fas fa-times text-red-500 mr-2"></i>
                            Upload foto profil
                        </div>
                    @else
                        <div class="flex items-center text-green-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Foto profil
                        </div>
                    @endif
                    
                    @if(!$user->profile || !$user->profile->summary)
                        <div class="flex items-center text-gray-500">
                            <i class="fas fa-times text-red-500 mr-2"></i>
                            Tulis ringkasan
                        </div>
                    @else
                        <div class="flex items-center text-green-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Ringkasan
                        </div>
                    @endif
                    
                    @if(!$user->profile || !$user->profile->phone)
                        <div class="flex items-center text-gray-500">
                            <i class="fas fa-times text-red-500 mr-2"></i>
                            Nomor telepon
                        </div>
                    @else
                        <div class="flex items-center text-green-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Nomor telepon
                        </div>
                    @endif
                    
                    @if(!$user->profile || !$user->profile->address)
                        <div class="flex items-center text-gray-500">
                            <i class="fas fa-times text-red-500 mr-2"></i>
                            Alamat domisili
                        </div>
                    @else
                        <div class="flex items-center text-green-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Alamat domisili
                        </div>
                    @endif
                    
                    @if(!$user->profile || !$user->profile->date_of_birth)
                        <div class="flex items-center text-gray-500">
                            <i class="fas fa-times text-red-500 mr-2"></i>
                            Tanggal lahir
                        </div>
                    @else
                        <div class="flex items-center text-green-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Tanggal lahir
                        </div>
                    @endif
                    
                    @if(!$user->profile || !$user->profile->cv_file)
                        <div class="flex items-center text-gray-500">
                            <i class="fas fa-times text-red-500 mr-2"></i>
                            Upload CV
                        </div>
                    @else
                        <div class="flex items-center text-green-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            CV/Resume
                        </div>
                    @endif
                </div>
                
                @if($percentage < 100)
                    <a href="{{ route('customer.settings') }}" class="block w-full text-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors mt-4">
                        Lengkapi Profil
                    </a>
                @endif
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <span class="text-sm text-gray-600">Total Aplikasi</span>
                        </div>
                        <span class="font-semibold text-gray-900">{{ $user->applications()->count() }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <span class="text-sm text-gray-600">Disetujui</span>
                        </div>
                        <span class="font-semibold text-gray-900">{{ $user->applications()->where('status', 'approved')->count() }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            <span class="text-sm text-gray-600">Menunggu</span>
                        </div>
                        <span class="font-semibold text-gray-900">{{ $user->applications()->where('status', 'pending')->count() }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <span class="text-sm text-gray-600">Ditolak</span>
                        </div>
                        <span class="font-semibold text-gray-900">{{ $user->applications()->where('status', 'rejected')->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Social Media Modal -->
<div id="socialMediaModal" class="fixed inset-0 hidden overflow-y-auto h-full w-full z-50 transition-all duration-300" onclick="closeSocialMediaModal(event)" style="background-color: rgba(255, 255, 255, 0.1); backdrop-filter: blur(2px);">
    <div class="relative top-20 mx-auto p-5 w-96 shadow-lg rounded-md bg-white transform scale-95 transition-all duration-300 opacity-0" id="modalContent" onclick="event.stopPropagation()">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Tambah Akun Sosial</h3>
                <button onclick="closeSocialMediaModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="socialMediaForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Platform*</label>
                    <select id="platform" name="platform" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                        <option value="">Pilih platform akun sosial</option>
                        <option value="linkedin">LinkedIn</option>
                        <option value="instagram">Instagram</option>
                        <option value="twitter">Twitter</option>
                        <option value="github">GitHub</option>
                        <option value="website">Portfolio Website</option>
                    </select>
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Sosial Media*</label>
                    <input type="text" id="socialLink" name="socialLink" required
                           placeholder="Masukkan nama username akun sosial"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeSocialMediaModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-md transition-all duration-200 transform hover:scale-105">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md transition-all duration-200 transform hover:scale-105">
                        Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleSummary() {
        const summaryElement = document.querySelector('.text-gray-700.leading-relaxed');
        const toggleButton = document.getElementById('summary-toggle');
        
        if (summaryElement && summaryElement.classList.contains('line-clamp-3')) {
            summaryElement.classList.remove('line-clamp-3');
            toggleButton.textContent = 'Lihat lebih sedikit';
        } else if (summaryElement) {
            summaryElement.classList.add('line-clamp-3');
            toggleButton.textContent = 'Lihat lebih banyak';
        }
    }

    function openSocialMediaModal() {
        const modal = document.getElementById('socialMediaModal');
        const modalContent = document.getElementById('modalContent');
        
        // Remove hidden class and start animations
        modal.classList.remove('hidden');
        modalContent.classList.remove('opacity-0', 'scale-95');
        modalContent.classList.add('opacity-100', 'scale-100');
        
        // Force backdrop to be visible
        modal.style.backgroundColor = 'rgba(255, 255, 255, 0.1)';
        modal.style.backdropFilter = 'blur(8px)';
        
        // Lock body scroll
        document.body.style.overflow = 'hidden';
    }

    function closeSocialMediaModal(event) {
        if (!event || event.target.id === 'socialMediaModal') {
            const modal = document.getElementById('socialMediaModal');
            const modalContent = document.getElementById('modalContent');
            
            // Start closing animations
            modalContent.classList.remove('opacity-100', 'scale-100');
            modalContent.classList.add('opacity-0', 'scale-95');
            
            // Hide backdrop
            modal.style.backgroundColor = 'transparent';
            
            // Hide after animation
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                
                // Reset form
                const form = document.getElementById('socialMediaForm');
                if (form) {
                    form.reset();
                }
            }, 300);
        }
    }

    // Handle form submission
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('socialMediaForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const platform = document.getElementById('platform').value;
                const socialLink = document.getElementById('socialLink').value;
                
                console.log('Form data before submission:', {
                    platform: platform,
                    social_link: socialLink
                });
                
                if (!platform || !socialLink) {
                    alert('Silakan lengkapi semua field yang wajib diisi.');
                    return;
                }
                
                // Show loading state
                const submitButton = form.querySelector('button[type="submit"]');
                const originalText = submitButton.textContent;
                submitButton.textContent = 'Menyimpan...';
                submitButton.disabled = true;
                
                // Prepare data for submission
                const formData = {
                    platform: platform,
                    social_link: socialLink,
                    _token: '{{ csrf_token() }}'
                };
                
                console.log('Sending data:', formData);
                
                // Make AJAX request to save social media
                fetch('{{ route("customer.profile.update-social") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response headers:', response.headers);
                    return response.text().then(text => {
                        console.log('Raw response:', text);
                        try {
                            return JSON.parse(text);
                        } catch (e) {
                            console.error('Failed to parse JSON:', e);
                            throw new Error('Invalid JSON response: ' + text);
                        }
                    });
                })
                .then(data => {
                    console.log('Parsed response data:', data);
                    if (data.success) {
                        closeSocialMediaModal();
                        
                        // Show success message
                        const successDiv = document.createElement('div');
                        successDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg z-50';
                        successDiv.textContent = 'Akun sosial berhasil ditambahkan!';
                        document.body.appendChild(successDiv);
                        
                        // Remove success message after 3 seconds
                        setTimeout(() => {
                            successDiv.remove();
                        }, 3000);
                        
                        // Reload page to show updated social media
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        alert('Terjadi kesalahan: ' + (data.message || 'Gagal menyimpan data'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan data: ' + error.message);
                })
                .finally(() => {
                    // Reset button state
                    submitButton.textContent = originalText;
                    submitButton.disabled = false;
                });
            });
        }
    });
</script>

<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Light backdrop with blur */
    #socialMediaModal {
        background-color: rgba(255, 255, 255, 0.1) !important;
        backdrop-filter: blur(1px) !important;
        -webkit-backdrop-filter: blur(2px) !important;
    }
</style>
@endsection