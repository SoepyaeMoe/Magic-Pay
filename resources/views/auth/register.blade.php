@extends('frontend.layouts.app_plain')
@section('title', 'Register')
@section('content')
    <div class="container">
        <div class="row justify-content-center align-content-center" style="height: 100vh;">
            <div class="col-md-6 align-content-center">
                <div class="card py-4 shadow-sm">
                    <div class="card-title">
                        <h3 class="text-center">Register</h3>
                        <p class="text-center text-muted">Fill the form to register.</p>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <label for="name" class="form-lable">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror mb-2"
                                placeholder='Enter name' name="name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror

                            <label for="email" class="form-lable">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror mb-2"
                                placeholder='Enter email' name="email" value="{{ old('email') }}">
                            @error('email')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror

                            <label for="phone" class="form-lable">Phone</label>
                            <input type="number" class="form-control @error('phone') is-invalid @enderror mb-2"
                                placeholder='Enter phone' name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror

                            <label for="password" class="form-lable">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror mb-2"
                                placeholder='Enter password' name="password" value="{{ old('password') }}">
                            @error('password')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror

                            <label for="password_confirmation">Password Confirmation</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid  @enderror mb-2"
                                placeholder="Password Confirmation" value="">
                            @error('password_confirmation')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror

                            <button class="btn btn-theme form-control my-2">Login</button>
                            <a href="{{ route('login') }}" class="theme-link">Do you have account?</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
