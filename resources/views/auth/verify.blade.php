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

.text-content {
    color: #ffffff !important;
    text-align: center;
    line-height: 1.6;
}

.btn-link {
    color: #004953 !important;
    text-decoration: none !important;
    font-weight: 500 !important;
    background: none !important;
    border: none !important;
    padding: 0 !important;
    margin: 0 !important;
}

.btn-link:hover {
    color: #005a66 !important;
    text-decoration: underline !important;
}

.alert-success {
    background: rgba(76, 175, 80, 0.1) !important;
    border: 1px solid rgba(76, 175, 80, 0.3) !important;
    color: #4caf50 !important;
    border-radius: 10px !important;
    padding: 1rem !important;
    margin-bottom: 1.5rem !important;
}
</style>

<div class="auth-container">
    <div class="auth-card card">
        <div class="card-header">
            <div class="auth-logo">
                <i class="bi bi-envelope-check h2 text-white"></i>
            </div>
            <h4 class="auth-title">Verify Your Email</h4>
            <p class="auth-subtitle">Please check your email for verification link</p>
        </div>

        <div class="card-body">
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            <div class="text-content mb-4">
                {{ __('Before proceeding, please check your email for a verification link.') }}
            </div>

            <div class="text-content">
                {{ __('If you did not receive the email') }},
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn-link">{{ __('click here to request another') }}</button>.
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
