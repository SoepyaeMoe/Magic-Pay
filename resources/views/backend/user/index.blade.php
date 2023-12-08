@extends('backend.layouts.app')
@section('title', 'User Management')
@section('user-active', 'active')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Admin List<span class="badge bg-primary">{{ count($users) }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <a href="{{ route('admin.user.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle me-2"></i>Create
                User</a>
        </div>
    </div>
    {{-- @include('backend.flash') --}}
    <div class="card">
        <div class="card-body" style="overflow-x: auto;">
            <table class="table table-striped table-hover table-bordered" id="user_list" style="width: 100%;">
                <thead class="bg-light">
                    <tr>
                        <th style="min-width: 100px;">Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>IP</th>
                        <th>User Agent</th>
                        <th>Login at</th>
                        <th>Created at</th>
                        <th style="min-width: 100px;">Updated at</th>
                        <th style="min-width: 100px;">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let table = new DataTable('#user_list', {
            ajax: 'datatable/ssd',
            processing: true,
            serverSide: true,
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'ip',
                    name: 'ip',
                    sortable: false,
                    searchable: false
                },
                {
                    data: 'user_agent',
                    name: 'user_agent',
                    sortable: false,
                },
                {
                    data: 'login_at',
                    name: 'login_at',
                    searchable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    sortable: false
                },
                {
                    data: 'updated_at',
                    name: 'updated_at',
                },
                {
                    data: 'action',
                    name: 'action',
                    sortable: false,
                    seachable: false
                }
            ],
            order: [
                [7, 'desc']
            ]
        });

        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger mr-2"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You want to delete it.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).data('id');
                    $.ajax({
                        url: 'delete/' + id,
                        type: 'DELETE',
                        success: function() {
                            table.ajax.reload();
                            swalWithBootstrapButtons.fire({
                                title: "Deleted!",
                                text: "Deleted Success",
                                icon: "success"
                            });
                        }
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled",
                        text: "Delete Cancelled",
                        icon: "error"
                    });
                }
            });
        })
    </script>
@endsection
