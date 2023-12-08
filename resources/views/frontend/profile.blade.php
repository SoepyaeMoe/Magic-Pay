@extends('frontend.layouts.app')
@section('title', 'Profile')
@section('profile_active', 'active')
@section('content')
    <div class="account mt-3">
        <div class="profile_img mb-3">
            <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=random" alt="">
        </div>
        <div class="card mb-3 shadow-sm">
            <div class="card-body pe-0">
                <div class="d-flex justify-content-between">
                    <span>Name</span>
                    <span class="me-3">{{ $user->name }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>Email</span>
                    <span class="me-3">{{ $user->email }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>Phone</span>
                    <span class="me-3">{{ $user->phone }}</span>
                </div>
            </div>
        </div>
        <div class="card mb-3 shadow-sm">
            <div class="card-body pe-0">
                <a href="{{ route('update-password') }}" class="d-flex justify-content-between">
                    <span>Update Password</span>
                    <span class="me-3"><i class='bx bxs-right-arrow-alt'></i></span>
                </a>
                <hr>
                <a href="#" class="d-flex justify-content-between logout">
                    <span>Logout</span>
                    <span class="me-3"><i class="bx bxs-right-arrow-alt"></i></span>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $(".logout").click(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Do you want to logout?",
                    showCancelButton: true,
                    confirmButtonText: "Comfirm",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('logout') }}",
                            method: "POST",
                            success: function() {
                                location.replace('/login');
                            }
                        })
                    } else if (result.isDenied) {
                        Swal.fire("Changes are not saved", "", "info");
                    }
                });
            });
        })
    </script>
@endsection
