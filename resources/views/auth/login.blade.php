@extends('layouts.app')

@section('content')
<style>
    body {
        background: #f8f9fa;
    }

    .login-box {
        max-width: 400px;
        margin: 80px auto;
        padding: 30px 40px;
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .login-box h2 {
        margin-bottom: 25px;
        font-weight: 600;
        text-align: center;
        color: #333;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #0d6efd;
    }

    .btn-primary {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
    }

    .form-text {
        font-size: 0.9rem;
    }

    .forgot-link {
        text-align: right;
    }

    .logo {
        display: block;
        margin: 0 auto 20px auto;
        width: 60px;
    }
</style>

<div class="container">
    <div class="login-box">

        <h2>Log In</h2>

        {{-- Flash message sukses --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                       {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>

            @if (Route::has('password.request'))
                <div class="forgot-link mt-3">
                    <a href="{{ route('password.request') }}">Lupa Password?</a>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
