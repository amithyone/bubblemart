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
    max-width: 400px;
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

.text-content {
    color: #ffffff !important;
    text-align: center;
    line-height: 1.6;
    margin-bottom: 1.5rem;
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
</style>

<div class="auth-container">
    <div class="auth-card card">
        <div class="card-header">
            <div class="auth-logo">
                <i class="bi bi-shield-check h2 text-white"></i>
            </div>
            <h4 class="auth-title">Confirm Password</h4>
            <p class="auth-subtitle">Please confirm your password</p>
        </div>

        <div class="card-body">
            <div class="text-content">
                {{ __('Please confirm your password before continuing.') }}
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock me-2"></i>Password
                    </label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                           name="password" required autocomplete="current-password"
                           placeholder="Enter your password">
                    @error('password')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <button type="submit" class="btn btn-auth">
                        <i class="bi bi-check-circle me-2"></i>Confirm Password
                    </button>
                </div>

                @if (Route::has('password.request'))
                    <div class="auth-divider">
                        <span>Forgot your password?</span>
                    </div>

                    <div class="text-center">
                        <a class="btn-link" href="{{ route('password.request') }}">
                            <i class="bi bi-question-circle me-1"></i>Reset Password
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

@endsection
