@extends('backend.layouts.app')
@section('title', 'Admin User Mangement')
@section('admin-user-active', 'active')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Admin List<span class="badge bg-primary">{{ count($data) }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <a href="{{ route('admin.admin-user.create') }}" class="btn btn-primary"><i
                    class="fas fa-plus-circle me-2"></i>Create
                Admin</a>
        </div>
    </div>
    {{-- @include('backend.flash') --}}
    <div class="card">
        <div class="card-body" style="overflow-x: auto;">
            <table class="table table-striped table-hover" id="admin_users_table">
                <thead class="bg-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>IP</th>
                        <th>User Agent</th>
                        <th>Created at</th>
                        <th>Updated at</th>
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
        let table = new DataTable('#admin_users_table', {
            ajax: 'admin-user/datatable/ssd',
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
                    searchable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    sortable: false,
                    searchable: false
                }
            ],
            order: [
                [6, 'desc']
            ]
        });

        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success m-2",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You want to delete it",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'admin-user/' + id,
                        type: 'DELETE',
                        success: function() {
                            table.ajax.reload()
                            swalWithBootstrapButtons.fire({
                                title: "Deleted!",
                                text: "An Admin has been deleted.",
                                icon: "success"
                            });
                        }
                    })
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled",
                        text: "",
                        icon: "error"
                    });
                }
            });
        })
    </script>
@endsection
