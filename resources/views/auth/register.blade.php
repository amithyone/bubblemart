@extends('layouts.template')

@section('content')

<style>
.auth-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, rgba(16, 16, 19, 0.22) 0%, rgb(0, 0, 0) 100%);
    padding: 20px;
}

.auth-card {
    background: linear-gradient(135deg, rgba(16, 16, 19, 0.22) 0%, rgb(0, 0, 0) 100%) !important;
    border: none !important;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3) !important;
    border-radius: 20px !important;
    overflow: hidden;
    max-width: 450px;
    width: 100%;
}

.auth-card .card-header {
    background: linear-gradient(135deg, rgba(16, 17, 19, 0.44) 0%, rgb(0, 0, 0) 100%) !important;
    border: none !important;
    padding: 2rem 2rem 1rem;
    text-align: center;
}

.auth-card .card-body {
    padding: 2rem;
}

.auth-logo {
    width: 80px;
    height: 80px;
    margin: 0 auto 1rem;
    background: linear-gradient(135deg, #005a66 0%, #004953 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(255, 115, 0, 0.3);
}

.auth-title {
    color: #ffffff !important;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.auth-subtitle {
    color: #b0b0b0 !important;
    font-size: 0.9rem;
}

.form-label {
    color: #ffffff !important;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.form-control {
    background: rgba(255, 255, 255, 0.1) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    color: #ffffff !important;
    border-radius: 10px !important;
    padding: 0.75rem 1rem !important;
    transition: all 0.3s ease;
}

.form-control:focus {
    background: rgba(255, 255, 255, 0.15) !important;
    border-color: #004953 !important;
    box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25) !important;
    color: #ffffff !important;
}

.form-control::placeholder {
    color: rgba(255, 255, 255, 0.6) !important;
}

.btn-auth {
    background: linear-gradient(135deg, #005a66 0%, #004953 100%) !important;
    border: none !important;
    color: #ffffff !important;
    padding: 0.75rem 2rem !important;
    border-radius: 10px !important;
    font-weight: 600 !important;
    transition: all 0.3s ease;
    width: 100%;
}

.btn-auth:hover {
    background: linear-gradient(135deg, #004953 0%, #005a66 100%) !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4) !important;
    color: #ffffff !important;
}

.btn-link {
    color: #004953 !important;
    text-decoration: none !important;
    font-weight: 500 !important;
}

.btn-link:hover {
    color: #005a66 !important;
    text-decoration: underline !important;
}

.form-check-input:checked {
    background-color: #004953 !important;
    border-color: #004953 !important;
}

.form-check-label {
    color: #b0b0b0 !important;
}

.auth-divider {
    text-align: center;
    margin: 1.5rem 0;
    position: relative;
}

.auth-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: rgba(255, 255, 255, 0.2);
}

.auth-divider span {
    background: linear-gradient(135deg, rgba(16, 16, 19, 0.22) 0%, rgb(0, 0, 0) 100%);
    padding: 0 1rem;
    color: #b0b0b0;
    font-size: 0.9rem;
}

.invalid-feedback {
    color: #ff6b6b !important;
    font-size: 0.85rem;
    margin-top: 0.25rem;
}

.form-control.is-invalid {
    border-color: #ff6b6b !important;
}

.form-control.is-invalid:focus {
    box-shadow: 0 0 0 0.2rem rgba(255, 107, 107, 0.25) !important;
}

.terms-check {
    margin: 1.5rem 0;
}

.terms-check .form-check-label {
    font-size: 0.9rem;
    line-height: 1.4;
}

.terms-check .form-check-label a {
    color: #004953 !important;
    text-decoration: none;
}

.terms-check .form-check-label a:hover {
    text-decoration: underline;
}

/* Light theme overrides */
[data-theme="light"] .auth-container {
    background: linear-gradient(135deg, rgba(248, 249, 250, 0.8) 0%, rgba(233, 236, 239, 0.9) 100%) !important;
}

[data-theme="light"] .auth-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .auth-card .card-header {
    background: #ffffff !important;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .auth-title {
    color: #000000 !important;
}

[data-theme="light"] .auth-subtitle {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .form-label {
    color: #000000 !important;
}

[data-theme="light"] .form-control {
    background: rgba(0, 0, 0, 0.05) !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    color: #000000 !important;
}

[data-theme="light"] .form-control:focus {
    background: rgba(0, 0, 0, 0.08) !important;
    border-color: #004953 !important;
    box-shadow: 0 0 0 0.2rem rgba(0, 73, 83, 0.25) !important;
    color: #000000 !important;
}

[data-theme="light"] .form-control::placeholder {
    color: rgba(0, 0, 0, 0.5) !important;
}

[data-theme="light"] .btn-auth {
    background: linear-gradient(135deg, #004953 0%, #005a66 100%) !important;
    color: #ffffff !important;
}

[data-theme="light"] .btn-auth:hover {
    background: linear-gradient(135deg, #005a66 0%, #004953 100%) !important;
    box-shadow: 0 8px 25px rgba(0, 73, 83, 0.4) !important;
    color: #ffffff !important;
}

[data-theme="light"] .btn-link {
    color: #004953 !important;
}

[data-theme="light"] .btn-link:hover {
    color: #005a66 !important;
}

[data-theme="light"] .form-check-label {
    color: rgba(0, 0, 0, 0.7) !important;
}

[data-theme="light"] .auth-divider::before {
    background: rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .auth-divider span {
    background: #ffffff !important;
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .invalid-feedback {
    color: #dc3545 !important;
}

[data-theme="light"] .terms-check .form-check-label a {
    color: #004953 !important;
}

/* CAPTCHA styling */
.captcha-container {
    display: flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    padding: 0.5rem;
}

[data-theme="light"] .captcha-container {
    background: rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(0, 0, 0, 0.1);
}

.captcha-container img {
    border-radius: 5px;
    max-height: 40px;
}

.captcha-container .btn {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #ffffff;
    border-radius: 5px;
    padding: 0.25rem 0.5rem;
    font-size: 0.8rem;
}

[data-theme="light"] .captcha-container .btn {
    background: rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(0, 0, 0, 0.1);
    color: #000000;
}

.captcha-container .btn:hover {
    background: rgba(255, 255, 255, 0.2);
    color: #ffffff;
}

[data-theme="light"] .captcha-container .btn:hover {
    background: rgba(0, 0, 0, 0.1);
    color: #000000;
}
</style>

<script>
function refreshCaptcha() {
    fetch('/captcha/refresh', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        document.querySelector('.captcha-container img').src = data.captcha;
    })
    .catch(error => {
        console.error('Error refreshing CAPTCHA:', error);
    });
}

// Auto-refresh CAPTCHA every 5 minutes
setInterval(refreshCaptcha, 300000);
</script>

<div class="auth-container">
    <div class="auth-card card">
        <div class="card-header">
            <div class="auth-logo">
                <i class="bi bi-gift h2 text-white"></i>
            </div>
                            <h4 class="auth-title">Join Bubblemart</h4>
            <p class="auth-subtitle">Create your account to start gifting</p>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">
                        <i class="bi bi-person me-2"></i>Full Name
                    </label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                           name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                           placeholder="Enter your full name">
                    @error('name')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class="bi bi-envelope me-2"></i>Email Address
                    </label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email') }}" required autocomplete="email"
                           placeholder="Enter your email address">
                    @error('email')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">
                        <i class="bi bi-telephone me-2"></i>Phone Number
                    </label>
                    <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" 
                           name="phone" value="{{ old('phone') }}" required autocomplete="tel"
                           placeholder="Enter your phone number">
                    @error('phone')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock me-2"></i>Password
                    </label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                           name="password" required autocomplete="new-password"
                           placeholder="Create a strong password">
                    @error('password')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password-confirm" class="form-label">
                        <i class="bi bi-shield-lock me-2"></i>Confirm Password
                    </label>
                    <input id="password-confirm" type="password" class="form-control" 
                           name="password_confirmation" required autocomplete="new-password"
                           placeholder="Confirm your password">
                </div>

                <!-- Honeypot field (hidden) -->
                <div style="display: none;">
                    <input type="text" name="website" tabindex="-1" autocomplete="off">
                </div>

                <!-- CAPTCHA -->
                <div class="mb-3">
                    <label class="form-label">
                        <i class="bi bi-shield-check me-2"></i>Security Verification
                    </label>
                    <div class="captcha-container">
                        {!! captcha_img() !!}
                        <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="refreshCaptcha()">
                            <i class="bi bi-arrow-clockwise"></i> Refresh
                        </button>
                    </div>
                    <input id="captcha" type="text" class="form-control mt-2 @error('captcha') is-invalid @enderror" 
                           name="captcha" required placeholder="Enter the code above">
                    @error('captcha')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="terms-check">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">
                            I agree to the <a href="#" target="_blank">Terms of Service</a> and <a href="#" target="_blank">Privacy Policy</a>
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <button type="submit" class="btn btn-auth">
                        <i class="bi bi-person-plus me-2"></i>Create Account
                    </button>
                </div>

                <div class="auth-divider">
                    <span>Already have an account?</span>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="btn-link">
                        <i class="bi bi-arrow-left me-1"></i>Sign in to your account
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
