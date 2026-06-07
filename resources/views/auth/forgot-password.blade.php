@extends('layouts.auth', ['title' => 'Forgot Password'])

@section('content')
<div class="auth-main">
    <div class="auth-wrapper v4">
        <div class="auth-form">
            <div class="card my-2">
                <div class="row g-0">

                    <div class="bg-brand-color-1 col-md-4 col-lg-6 d-none d-md-flex align-items-center justify-content-center">
                        <img src="{{ asset('assets/images/authentication/lock.png') }}"
                             alt="forgot password"
                             class="img-fluid">
                    </div>

                    <div class="col-md-8 col-lg-6">
                        <div class="card-body">

                            <div class="text-center">
                                <a href="{{ route('login') }}">
                                    <img src="{{ asset('assets/images/logo-dark.svg') }}" alt="logo">
                                </a>
                            </div>

                            <h4 class="text-center f-w-500 mt-4 mb-3">
                                Forgot Password?
                            </h4>

                            <p class="text-center text-muted mb-4">
                                Enter your email address and we will send you a password reset link.
                            </p>

                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="mb-3">
                                    <input type="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           class="form-control @error('email') is-invalid @enderror"
                                           placeholder="Email address"
                                           required
                                           autofocus>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary shadow px-sm-4">
                                        Email Reset Link
                                    </button>
                                </div>

                                <div class="text-center mt-3">
                                    <a href="{{ route('login') }}" class="text-secondary f-w-400">
                                        Back to login
                                    </a>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
