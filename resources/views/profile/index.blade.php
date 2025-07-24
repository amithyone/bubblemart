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

/* Modal background fixes */
#addAddressModal .modal-content,
#deleteAddressModal .modal-content {
    background: #101013 !important;
    border: 1px solid rgba(255,255,255,0.1) !important;
}

[data-theme="light"] #addAddressModal .modal-content,
[data-theme="light"] #deleteAddressModal .modal-content {
    background: #ffffff !important;
    border: 1px solid rgba(0,0,0,0.1) !important;
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

                <!-- Address Management -->
                <div class="card adminuiux-card form-card mb-4">
                    <div class="content">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="font-600 mb-0">My Addresses</h5>
                                <small class="text-secondary">{{ $user->addresses->count() }}/5 addresses used</small>
                            </div>
                            @if($user->addresses->count() < 5)
                                <button type="button" class="btn btn-theme btn-sm" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                    <i class="bi bi-plus-circle me-1"></i>Add New Address
                                </button>
                            @else
                                <button type="button" class="btn btn-secondary btn-sm" disabled>
                                    <i class="bi bi-plus-circle me-1"></i>Address Limit Reached
                                </button>
                            @endif
                        </div>

                        @if($user->addresses->count() > 0)
                            <div class="row">
                                @foreach($user->addresses as $address)
                                    <div class="col-12 col-md-6 col-lg-4 mb-3">
                                        <div class="card address-card h-100" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h6 class="font-600 mb-1">{{ $address->label ?: 'Address' }}</h6>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-link text-secondary p-0" type="button" data-bs-toggle="dropdown">
                                                            <i class="bi bi-three-dots-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#" onclick="editAddress({{ $address->id }})">
                                                                <i class="bi bi-pencil me-2"></i>Edit
                                                            </a></li>
                                                            <li><a class="dropdown-item" href="#" onclick="setDefaultAddress({{ $address->id }})">
                                                                <i class="bi bi-star me-2"></i>Set as Default
                                                            </a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li><a class="dropdown-item text-danger" href="#" onclick="deleteAddress({{ $address->id }})">
                                                                <i class="bi bi-trash me-2"></i>Delete
                                                            </a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                
                                                @if($address->is_default)
                                                    <span class="badge bg-success mb-2">Default Address</span>
                                                @endif
                                                
                                                <p class="mb-1"><strong>{{ $address->name }}</strong></p>
                                                <p class="mb-1 small">{{ $address->phone }}</p>
                                                <p class="mb-1 small">{{ $address->address_line_1 }}</p>
                                                @if($address->address_line_2)
                                                    <p class="mb-1 small">{{ $address->address_line_2 }}</p>
                                                @endif
                                                <p class="mb-0 small">{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</p>
                                                <p class="mb-0 small text-secondary">{{ $address->country_display_name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-geo-alt text-secondary" style="font-size: 3rem;"></i>
                                <p class="text-secondary mt-2">No addresses saved yet</p>
                                <button type="button" class="btn btn-theme btn-sm" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                    <i class="bi bi-plus-circle me-1"></i>Add Your First Address
                                </button>
                            </div>
                        @endif
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

<!-- Add/Edit Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background: #101013; border: 1px solid rgba(255,255,255,0.1);">
            <div class="modal-header border-0">
                <h5 class="modal-title text-white" id="addAddressModalLabel">Add New Address</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addressForm" action="{{ route('profile.addresses.store') }}" method="POST">
                @csrf
                <input type="hidden" id="address_id" name="address_id">
                <!-- Method override field for editing -->
                <input type="hidden" id="method_override" name="_method" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="label" class="form-label text-white">Address Label (Optional)</label>
                            <input type="text" class="form-control" id="label" name="label" placeholder="e.g., Home, Office, Vacation Home">
                        </div>
                        
                        <div class="col-12 col-md-6 mb-3">
                            <label for="name" class="form-label text-white">Full Name *</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        
                        <div class="col-12 col-md-6 mb-3">
                            <label for="phone" class="form-label text-white">Phone Number *</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label for="address_line_1" class="form-label text-white">Address Line 1 *</label>
                            <input type="text" class="form-control" id="address_line_1" name="address_line_1" required>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label for="address_line_2" class="form-label text-white">Address Line 2 (Optional)</label>
                            <input type="text" class="form-control" id="address_line_2" name="address_line_2" placeholder="Apartment, suite, unit, etc.">
                        </div>
                        
                        <div class="col-12 col-md-6 mb-3">
                            <label for="city" class="form-label text-white">City *</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                        
                        <div class="col-12 col-md-6 mb-3">
                            <label for="state" class="form-label text-white">State/Province *</label>
                            <input type="text" class="form-control" id="state" name="state" required>
                        </div>
                        
                        <div class="col-12 col-md-6 mb-3">
                            <label for="postal_code" class="form-label text-white">Postal Code *</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" required>
                        </div>
                        
                        <div class="col-12 col-md-6 mb-3">
                            <label for="country" class="form-label text-white">Country *</label>
                            <select class="form-control" id="country" name="country" required>
                                <option value="">Select Country</option>
                                @foreach(\App\Models\Setting::getAllCountries() as $code => $name)
                                    <option value="{{ $code }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_default" name="is_default" value="1">
                                <label class="form-check-label text-white" for="is_default">
                                    Set as default address
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-theme">Save Address</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hidden form for editing addresses -->
<form id="editAddressForm" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
    <input type="hidden" id="edit_address_id" name="address_id">
    <input type="hidden" id="edit_label" name="label">
    <input type="hidden" id="edit_name" name="name">
    <input type="hidden" id="edit_phone" name="phone">
    <input type="hidden" id="edit_address_line_1" name="address_line_1">
    <input type="hidden" id="edit_address_line_2" name="address_line_2">
    <input type="hidden" id="edit_city" name="city">
    <input type="hidden" id="edit_state" name="state">
    <input type="hidden" id="edit_postal_code" name="postal_code">
    <input type="hidden" id="edit_country" name="country">
    <input type="hidden" id="edit_is_default" name="is_default">
</form>

<!-- Delete Address Confirmation Modal -->
<div class="modal fade" id="deleteAddressModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background: #101013; border: 1px solid rgba(255,255,255,0.1);">
            <div class="modal-header border-0">
                <h5 class="modal-title text-white">Delete Address</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-white">Are you sure you want to delete this address? This action cannot be undone.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteAddressForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Address</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Address management functions
function editAddress(addressId) {
    console.log('Editing address:', addressId);
    // Fetch address data and populate modal
    fetch(`/profile/addresses/${addressId}/edit`)
        .then(response => response.json())
        .then(data => {
            console.log('Address data:', data);
            document.getElementById('address_id').value = data.id;
            document.getElementById('label').value = data.label || '';
            document.getElementById('name').value = data.name;
            document.getElementById('phone').value = data.phone;
            document.getElementById('address_line_1').value = data.address_line_1;
            document.getElementById('address_line_2').value = data.address_line_2 || '';
            document.getElementById('city').value = data.city;
            document.getElementById('state').value = data.state;
            document.getElementById('postal_code').value = data.postal_code;
            document.getElementById('country').value = data.country;
            document.getElementById('is_default').checked = data.is_default;
            
            // Update modal title and form for editing
            document.getElementById('addAddressModalLabel').textContent = 'Edit Address';
            const form = document.getElementById('addressForm');
            form.action = `/profile/addresses/${addressId}`;
            form.method = 'POST'; // Keep as POST but add method override
            
            // Set method override for PATCH
            document.getElementById('method_override').value = 'PATCH';
            console.log('Form action:', form.action);
            console.log('Method override:', document.getElementById('method_override').value);
            
            // Also try setting the method field directly
            const methodField = form.querySelector('input[name="_method"]');
            if (methodField) {
                methodField.value = 'PATCH';
            }
            
            const modal = new bootstrap.Modal(document.getElementById('addAddressModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading address data');
        });
}

// Handle form submission for editing
document.getElementById('addressForm').addEventListener('submit', function(e) {
    const addressId = document.getElementById('address_id').value;
    const methodOverride = document.getElementById('method_override').value;
    
    // If editing (has address_id and method override), use AJAX
    if (addressId && methodOverride) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const url = this.action;
        
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(formData)
        })
        .then(response => {
            if (response.redirected) {
                window.location.href = response.url;
            } else {
                return response.text();
            }
        })
        .then(data => {
            if (data) {
                // Reload page to show updated data
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating address');
        });
    }
    // If adding new address, let form submit normally
});

function setDefaultAddress(addressId) {
    if (confirm('Set this address as your default address?')) {
        fetch(`/profile/addresses/${addressId}/default`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error setting default address');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error setting default address');
        });
    }
}

function deleteAddress(addressId) {
    document.getElementById('deleteAddressForm').action = `/profile/addresses/${addressId}`;
    const modal = new bootstrap.Modal(document.getElementById('deleteAddressModal'));
    modal.show();
}

// Reset modal when closed
document.getElementById('addAddressModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('addressForm').reset();
    document.getElementById('address_id').value = '';
    document.getElementById('addAddressModalLabel').textContent = 'Add New Address';
    
    // Reset form for adding new address
    const form = document.getElementById('addressForm');
    form.action = '{{ route("profile.addresses.store") }}';
    form.method = 'POST';
    
    // Clear method override
    document.getElementById('method_override').value = '';
    console.log('Form reset - action:', form.action, 'method override:', document.getElementById('method_override').value);
});

// Light theme styling for modals
if (document.documentElement.getAttribute('data-theme') === 'light') {
    const modals = document.querySelectorAll('.modal-content');
    modals.forEach(modal => {
        modal.style.background = '#ffffff';
        modal.style.border = '1px solid rgba(0, 0, 0, 0.1)';
    });
    
    const modalTitles = document.querySelectorAll('.modal-title');
    modalTitles.forEach(title => {
        title.style.color = '#000000';
    });
    
    const modalTexts = document.querySelectorAll('.modal-body p');
    modalTexts.forEach(text => {
        text.style.color = '#000000';
    });
}
</script>

@endsection 