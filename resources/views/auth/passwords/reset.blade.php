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

[data-theme="light"] .invalid-feedback {
    color: #dc3545 !important;
}
</style>

<div class="auth-container">
    <div class="auth-card card">
        <div class="card-header">
            <div class="auth-logo">
                <i class="bi bi-shield-lock h2 text-white"></i>
            </div>
            <h4 class="auth-title">Reset Password</h4>
            <p class="auth-subtitle">Enter your new password</p>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class="bi bi-envelope me-2"></i>Email Address
                    </label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                           name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
                           placeholder="Enter your email address">
                    @error('email')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock me-2"></i>New Password
                    </label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                           name="password" required autocomplete="new-password"
                           placeholder="Enter your new password">
                    @error('password')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password-confirm" class="form-label">
                        <i class="bi bi-shield-lock me-2"></i>Confirm New Password
                    </label>
                    <input id="password-confirm" type="password" class="form-control" 
                           name="password_confirmation" required autocomplete="new-password"
                           placeholder="Confirm your new password">
                </div>

                <div class="mb-4">
                    <button type="submit" class="btn btn-auth">
                        <i class="bi bi-check-circle me-2"></i>Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
