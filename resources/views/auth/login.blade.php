@extends('frontend.layouts.app_plain')
@section('title', 'Login')
@section('content')
    <div class="container">
        <div class="row justify-content-center align-content-center" style="height: 100vh;">
            <div class="col-md-6 align-content-center">
                <div class="card py-4 shadow-sm">
                    <div class="card-title">
                        <h3 class="text-center">Login</h3>
                        <p class="text-center text-muted">Fill the form to login.</p>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <label for="email" class="form-lable">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror mb-2"
                                placeholder='Enter email' name="email" value="{{ old('email') }}">
                            @error('email')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror

                            <label for="password">Password</label>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid  @enderror mb-2" placeholder="Password"
                                value="{{ old('password') }}">
                            @error('password')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror

                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>

                            <button class="btn btn-theme form-control my-2">Login</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
