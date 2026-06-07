@extends('layouts.auth', ['title' => 'Register'])

@section('content')
<div class="auth-main">
    <div class="auth-wrapper v4">
        <div class="auth-form">
            <div class="card my-2">
                <div class="row g-0">

                    <div class="bg-brand-color-1 col-md-4 col-lg-6 d-none d-md-flex align-items-center justify-content-center">
                        <img src="{{ asset('assets/images/authentication/lock.png') }}"
                             alt="register"
                             class="img-fluid">
                    </div>

                    <div class="col-md-8 col-lg-6">
                        <div class="card-body">

                            <div class="text-center">
                                <a href="{{ route('register') }}">
                                    <img src="{{ asset('assets/images/logo-dark.svg') }}" alt="logo">
                                </a>
                            </div>

                            <h4 class="text-center f-w-500 mt-4 mb-3">
                                Create Account
                            </h4>

                            <p class="text-center text-muted mb-4">
                                Register a new user account.
                            </p>

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="mb-3">
                                    <input type="text"
                                           name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}"
                                           placeholder="Full Name"
                                           required>
                                </div>

                                <div class="mb-3">
                                    <input type="email"
                                           name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}"
                                           placeholder="Email Address"
                                           required>
                                </div>

                                <div class="mb-3">
                                    <input type="password"
                                           name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Password"
                                           required>
                                </div>

                                <div class="mb-3">
                                    <input type="password"
                                           name="password_confirmation"
                                           class="form-control"
                                           placeholder="Confirm Password"
                                           required>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit"
                                            class="btn btn-primary shadow px-sm-4">
                                        Register
                                    </button>
                                </div>

                                <div class="text-center mt-3">
                                    <a href="{{ route('login') }}">
                                        Already registered?
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
