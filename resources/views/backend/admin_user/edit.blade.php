@extends('backend.layouts.app')
@section('title', 'Admin User Mangement')
@section('admin-user-active', 'active')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Admin</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="card px-3">
        <div class="card-body">
            <form action="{{ route('admin.admin-user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name" class="form-larbel">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}"
                        placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="email" class="form-larbel">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                        placeholder="Email">
                    @error('email')
                        {{ $message }}
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone" class="form-larbel">Phone</label>
                    <input type="phone" class="form-control" id="phone" name="phone" value="{{ $user->phone }}"
                        placeholder="Phone">
                </div>
                <div class="form-group">
                    <label for="password" class="form-larbel">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-secondary back_btn">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\UpdateAdminUser') !!}
@endsection
