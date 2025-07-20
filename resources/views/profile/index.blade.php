@extends('layouts.template')

@section('content')
<style>
.adminuiux-card { border: none !important; box-shadow: 0 4px 15px rgba(0,0,0,0.3) !important; transition: all 0.3s ease; }
.adminuiux-card:hover { box-shadow: 0 8px 25px rgba(0,0,0,0.4) !important; transform: translateY(-2px); }
.card { border: none !important; }
.profile-card, .form-card, .summary-card { border: none !important; box-shadow: 0 4px 15px rgba(0,0,0,0.3) !important; transition: all 0.3s ease; overflow: hidden; background: linear-gradient(135deg,rgba(16,16,19,0.22) 0%,rgb(0,0,0) 100%) !important; }
.profile-card:hover, .form-card:hover, .summary-card:hover { box-shadow: 0 8px 25px rgba(0,0,0,0.4) !important; transform: translateY(-2px); }
.header-card { background: linear-gradient(135deg,rgba(16,17,19,0.44) 0%,rgb(0,0,0) 100%) !important; }
.info-card { background: linear-gradient(135deg,rgba(16,16,19,0.22) 0%,rgb(0,0,0) 100%) !important; }

/* Custom button styling to match card gradients */
.btn-gradient {
    background: linear-gradient(135deg,rgba(16,16,19,0.22) 0%,rgb(0,0,0) 100%) !important;
    border: none !important;
    color: #ffffff !important;
    transition: all 0.3s ease;
}

.btn-gradient:hover {
    background: linear-gradient(135deg,rgba(16,17,19,0.44) 0%,rgb(0,0,0) 100%) !important;
    color: #ffffff !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.3) !important;
}

.btn-gradient-danger {
    background: linear-gradient(135deg,rgba(220,53,69,0.8) 0%,rgba(220,53,69,0.6) 100%) !important;
    border: none !important;
    color: #ffffff !important;
    transition: all 0.3s ease;
}

.btn-gradient-danger:hover {
    background: linear-gradient(135deg,rgba(220,53,69,1) 0%,rgba(220,53,69,0.8) 100%) !important;
    color: #ffffff !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(220,53,69,0.3) !important;
}

/* Avatar styling */
.avatar-upload {
    position: relative;
    display: inline-block;
    cursor: pointer;
}

.avatar-upload input[type="file"] {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
    z-index: 10;
}

.avatar-preview {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    cursor: pointer;
}

.avatar-upload:hover .avatar-preview {
    border-color: #036674;
    transform: scale(1.05);
}

.avatar-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.avatar-upload:hover .avatar-overlay {
    opacity: 1;
}

/* Loading state for avatar upload */
.avatar-upload.loading .avatar-preview {
    opacity: 0.7;
}

.avatar-upload.loading .avatar-overlay {
    opacity: 1;
    background: rgba(0, 0, 0, 0.7);
}

.avatar-upload.loading .avatar-overlay i {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Mobile padding */
@media (max-width: 768px) {
    .container { padding: 0 15px; }
}

/* Light theme styling */
[data-theme="light"] .profile-card,
[data-theme="light"] .form-card,
[data-theme="light"] .summary-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .profile-card:hover,
[data-theme="light"] .form-card:hover,
[data-theme="light"] .summary-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
}

[data-theme="light"] .header-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .info-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

/* Light theme text colors */
[data-theme="light"] .text-white {
    color: #000000 !important;
}

[data-theme="light"] .text-secondary {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .form-label {
    color: #000000 !important;
}

[data-theme="light"] .form-label.text-white {
    color: #000000 !important;
}

[data-theme="light"] .form-control {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    color: #000000 !important;
}

[data-theme="light"] .form-control:focus {
    border-color: #036674 !important;
    box-shadow: 0 0 0 0.2rem rgba(3, 102, 116, 0.25) !important;
}

[data-theme="light"] .form-text {
    color: rgba(0, 0, 0, 0.6) !important;
}

/* Light theme button styling */
[data-theme="light"] .btn-gradient {
    background: #036674 !important;
    color: #ffffff !important;
    border: 1px solid #036674 !important;
}

[data-theme="light"] .btn-gradient:hover {
    background: #025a66 !important;
    color: #ffffff !important;
    border-color: #025a66 !important;
    box-shadow: 0 4px 15px rgba(3, 102, 116, 0.3) !important;
}

[data-theme="light"] .btn-gradient-danger {
    background: #dc3545 !important;
    color: #ffffff !important;
    border: 1px solid #dc3545 !important;
}

[data-theme="light"] .btn-gradient-danger:hover {
    background: #c82333 !important;
    color: #ffffff !important;
    border-color: #c82333 !important;
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3) !important;
}

/* Light theme button overrides for profile page */
[data-theme="light"] .btn-theme {
    background-color: #036674 !important;
    border-color: #036674 !important;
    color: #ffffff !important;
}

[data-theme="light"] .btn-theme:hover {
    background-color: #025a66 !important;
    border-color: #025a66 !important;
    color: #ffffff !important;
}

/* Light theme avatar styling */
[data-theme="light"] .avatar-preview {
    border: 3px solid rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .avatar-upload:hover .avatar-preview {
    border-color: #036674 !important;
}

[data-theme="light"] .avatar-overlay {
    background: rgba(0, 0, 0, 0.3) !important;
}

/* Light theme headings */
[data-theme="light"] h4,
[data-theme="light"] h5,
[data-theme="light"] .font-600,
[data-theme="light"] .font-700 {
    color: #000000 !important;
}

/* Light theme alert styling */
[data-theme="light"] .alert-success {
    background: #d4edda !important;
    border-color: #c3e6cb !important;
    color: #155724 !important;
}

[data-theme="light"] .alert-danger {
    background: #f8d7da !important;
    border-color: #f5c6cb !important;
    color: #721c24 !important;
}

/* Enhanced card padding */
.profile-card {
    padding: 2rem !important;
}

.form-card {
    padding: 2rem !important;
}

.summary-card {
    padding: 2rem !important;
}

/* Mobile responsive padding */
@media (max-width: 768px) {
    .profile-card {
        padding: 1.5rem !important;
    }
    
    .form-card {
        padding: 1.5rem !important;
    }
    
    .summary-card {
        padding: 1.5rem !important;
    }
}

@media (max-width: 576px) {
    .profile-card {
        padding: 1rem !important;
    }
    
    .form-card {
        padding: 1rem !important;
    }
    
    .summary-card {
        padding: 1rem !important;
    }
}
</style>
<div class="row">
    <div class="col-12">
        <div class="card adminuiux-card profile-card p-3 p-md-4">
            <div class="content">
                <div class="d-flex align-items-center mb-4">
                    <div class="me-3">
                        <div class="avatar-upload">
                            <input type="file" id="avatar_upload" name="avatar" accept="image/*" form="profile-form">
                            <img src="{{ \App\Helpers\StorageHelper::getAvatarUrl($user) }}" 
                                 alt="Profile" class="avatar-preview" onerror="this.src='{{ asset('template-assets/img/avatars/1.jpg') }}'">
                            <div class="avatar-overlay">
                                <i class="bi bi-camera text-white h4"></i>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-700 mb-1 text-white">{{ $user->name }}</h4>
                        <p class="text-secondary mb-0">{{ $user->email }}</p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Profile Information -->
                <div class="card adminuiux-card form-card mb-4">
                    <div class="content">
                        <h5 class="font-600 mb-3">Profile Information</h5>
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profile-form">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="name" class="form-label text-white">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                                    @error('name')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6 mb-3">
                                    <label for="email" class="form-label text-white">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                                    @error('email')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6 mb-3">
                                    <label for="phone" class="form-label text-white">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="{{ $user->phone ?? '' }}">
                                    @error('phone')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6 mb-3">
                                    <label for="avatar_upload" class="form-label text-white">Profile Photo</label>
                                    <div class="form-text text-secondary">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Click on your profile picture above to upload a new photo (JPG, PNG, GIF up to 2MB)
                                    </div>
                                    @error('avatar')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-theme">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="card adminuiux-card form-card mb-4">
                    <div class="content">
                        <h5 class="font-600 mb-3">Change Password</h5>
                        <form action="{{ route('profile.password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                                @error('current_password')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                @error('password')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>

                            <button type="submit" class="btn btn-theme">Change Password</button>
                        </form>
                    </div>
                </div>

                <!-- Account Actions -->
                <div class="card adminuiux-card summary-card">
                    <div class="content">
                        <h5 class="font-600 mb-3">Account Actions</h5>
                        <div class="d-grid gap-2">
                            <a href="{{ route('wallet.index') }}" class="btn btn-gradient">
                                <i class="bi bi-wallet me-2"></i>Manage Wallet
                            </a>
                            <a href="{{ route('orders.index') }}" class="btn btn-gradient">
                                <i class="bi bi-bag me-2"></i>View Orders
                            </a>
                            <a href="{{ route('logout') }}" class="btn btn-gradient-danger"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle avatar preview
    const avatarInput = document.getElementById('avatar_upload');
    const avatarPreview = document.querySelector('.avatar-preview');
    const avatarUpload = document.querySelector('.avatar-upload');
    
    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file size (2MB limit)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    avatarInput.value = '';
                    return;
                }
                
                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPG, PNG, GIF)');
                    avatarInput.value = '';
                    return;
                }
                
                // Show loading state
                if (avatarUpload) {
                    avatarUpload.classList.add('loading');
                    const overlay = avatarUpload.querySelector('.avatar-overlay i');
                    if (overlay) {
                        overlay.className = 'bi bi-arrow-clockwise text-white h4';
                    }
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarPreview.src = e.target.result;
                    
                    // Remove loading state after a short delay
                    setTimeout(() => {
                        if (avatarUpload) {
                            avatarUpload.classList.remove('loading');
                            const overlay = avatarUpload.querySelector('.avatar-overlay i');
                            if (overlay) {
                                overlay.className = 'bi bi-camera text-white h4';
                            }
                        }
                    }, 1000);
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Add click handler to avatar preview to trigger file input
    if (avatarPreview) {
        avatarPreview.addEventListener('click', function() {
            avatarInput.click();
        });
    }
    
    // Add click handler to avatar upload container
    if (avatarUpload) {
        avatarUpload.addEventListener('click', function(e) {
            // Don't trigger if clicking on the input itself
            if (e.target !== avatarInput) {
                avatarInput.click();
            }
        });
    }
});
</script>

@endsection 