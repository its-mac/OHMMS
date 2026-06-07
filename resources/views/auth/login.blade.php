@extends('layouts.auth', ['title' => 'Login'])

@section('content')
    <div class="auth-main">
        <div class="auth-wrapper v4">
            <div class="auth-form">
                <div class="card my-2">
                    <div class="row g-0">
                        <div class="bg-brand-color-1 col-md-4 col-lg-6 d-none d-md-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/images/authentication/lock.png') }}" alt="lock" class="img-fluid">
                        </div>

                        <div class="col-md-8 col-lg-6">
                            <div class="card-body">
                                <div class="text-center">
                                    <a href="{{ route('login') }}">
                                        <img src="{{ asset('assets/images/logo-dark.svg') }}" alt="logo">
                                    </a>
                                </div>

                                <h4 class="text-center f-w-500 mt-4 mb-3">
                                    Online Hostel &amp; Mess Management
                                </h4>

                                <p class="text-center text-muted mb-4">
                                    Login with your email and password.
                                </p>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        {{ $errors->first() }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <input type="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               name="email"
                                               value="{{ old('email') }}"
                                               placeholder="Email address"
                                               required
                                               autofocus>
                                    </div>

                                    <div class="mb-3">
                                        <input type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               name="password"
                                               placeholder="Password"
                                               required>
                                    </div>

                                    <div class="d-flex mt-1 justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input input-primary"
                                                   type="checkbox"
                                                   id="remember"
                                                   name="remember">

                                            <label class="form-check-label text-muted" for="remember">
                                                Remember me
                                            </label>
                                        </div>

                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="text-secondary f-w-400">
                                                Forgot password?
                                            </a>
                                        @endif
                                    </div>

                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-primary shadow px-sm-4">
                                            Login
                                        </button>
                                    </div>
                                </form>

                                <p class="text-center text-muted mt-4 mb-0">
                                    Admin and Manager accounts will use biometric verification later.
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </div>
@endsection
