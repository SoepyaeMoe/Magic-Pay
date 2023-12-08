@extends('backend.layouts.app')
@section('title', 'User Mangement')
@section('user-active', 'active')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create User</h1>
                </div>
            </div>
        </div>
    </div>
    @error('fail')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @enderror
    <div class="card px-3">
        <div class="card-body">
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-larbel">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                        placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="email" class="form-larbel">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                        placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="phone" class="form-larbel">Phone</label>
                    <input type="phone" class="form-control" id="phone" name="phone" value="{{ old('phone') }}"
                        placeholder="Phone">
                </div>
                <div class="form-group">
                    <label for="password" class="form-larbel">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-secondary back_btn">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\StoreUser') !!}
@endsection
