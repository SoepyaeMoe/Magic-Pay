@extends('frontend.layouts.app')
@section('title', 'Update Password')
@section('profile_active', 'active')
@section('content')
    <div class="update_password mt-3">
        <div class="card mb-3 shadow-sm">
            <div class="text-center mt-2">
                <img src="{{ asset('img/security.svg') }}" alt="">
            </div>
            <div class="card-body">
                <form action="{{ route('update-password.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="old">Old Password</label>
                        <input type="password" name="old_password" id="old"
                            class="form-control @error('old_password') is-invalid @enderror"
                            value="{{ old('old_password') }}">
                        @error('old_password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="new">New Password</label>
                        <input type="password" name="new_password" id="new"
                            class="form-control @error('new_password') is-invalid @enderror"
                            value="{{ old('new_password') }}">
                        @error('new_password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="conf">Confirm Password</label>
                        <input type="password" name="confirm_password" id="conf"
                            class="form-control @error('confirm_password') is-invalid @enderror">
                        @error('confirm_password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-theme form-control">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script>
            $(document).ready(function() {

            })
        </script>
    @endsection
