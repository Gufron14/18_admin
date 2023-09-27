@extends('dashboard.layouts.main')
@section('title', 'Customer')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        {{-- <h1 class="h3 mb-2 text-gray-800">user List</h1> --}}

        <!-- DataTales Example -->
        <div class="card border-0 shadow mb-4">
            <div class="card-header">
                <p class="mb-0">Customer List</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Avatar</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Status</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="text-center">
                                        @if ($user['avatar'])
                                            <img src="http://localhost:5000/api/admin/user/avatar/{{ $user['id'] }}"
                                                class="rounded-circle" style="width:60px; height:60px; object-fit: cover;"
                                                alt="Avatar" />
                                        @else
                                            <img src="{{ asset('assets/dashboard/img/dummyavatar.png') }}"
                                                class="rounded-circle" style="width:60px; height:60px; object-fit: cover;"
                                                alt="Avatar" />
                                        @endif
                                    </td>
                                    <td>{{ $user['email'] }}</td>
                                    <td>{{ $user['username'] }}</td>
                                    @if ($user['status'] == 1)
                                        <td>Active</td>
                                    @else
                                        <td>Banned</td>
                                    @endif

                                    @if ($user['partner_id'] == 0)
                                        <td>User</td>
                                    @else
                                        <td>Admin Partner</td>
                                    @endif
                                    {{-- <td>{{ $user['role'] }}</td> --}}
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <div data-toggle="modal" data-target="#modalEdituser"
                                                onclick="customerModalEdit('{{ json_encode($user) }}')"
                                                class="btn btn-sm btn-warning btn-icon shadow-sm">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </div>
                                            <button class="btn btn-sm btn-danger btn-icon shadow-sm"
                                                id="delete-btn-{{ $user['id'] }}"><i
                                                    class="fa-solid fa-trash"></i></button>

                                            <form id="delete-form-{{ $user['id'] }}"
                                                action="{{ url('dashboard/customer') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $user['id'] }}"
                                                    id="inputIdDeletePartner">
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- modal edit --}}
    <div class="modal fade" id="modalEdituser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formEditCustomer" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editUsername">Username</label>
                                    <input id="editUsername" class="form-control @error('username') is-invalid @enderror"
                                        type="text" name="username" placeholder="Username">
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="editEmail">Email</label>
                                    <input id="editEmail" class="form-control @error('email') is-invalid @enderror"
                                        type="email" name="email" placeholder="Email">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editStatus">Status</label>
                                    <select id="editStatus" class="form-control @error('status') is-invalid @enderror"
                                        name="status">
                                        <option value="1">Active</option>
                                        <option value="0">Banned</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="editRole">Role</label>
                                    <input id="role" class="form-control @error('email') is-invalid @enderror" type="number" name="partner_id" placeholder="punya toko?">
                                    {{-- <select id="editRole" class="form-control @error('role') is-invalid @enderror"
                                        name="role">
                                        <option value="1">Partner Admin</option>
                                        <option value="0">User</option>
                                    </select> --}}
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="input-group">
                                <label class="input-group-text" for="avatar">Avatar</label>
                                <input id="editAvatar" type="file"
                                    class="form-control @error('avatar') is-invalid @enderror" id="avatar"
                                    name="avatar">
                                @error('avatar')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm shadow-sm" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">Cancel</span>
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm shadow-sm">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // edit
        function customerModalEdit(userJson) {
            const user = JSON.parse(userJson);
            document.getElementById('editUsername').value = user.username;
            document.getElementById('editEmail').value = user.email;
            document.getElementById('editStatus').value = user.status;
            document.getElementById('editRole').value = user.role;
            document.getElementById('formEditCustomer').action = `customer/${user.id}`;
        }

        // delete
        // delete
        const deleteButtons = document.querySelectorAll('button[id^="delete-btn"]');
        deleteButtons.forEach(button => {
            button.addEventListener('click', e => {
                e.preventDefault();
                console.log("Hello");

                // Extract the ID from the button ID
                const id = button.id.replace('delete-btn-', '');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be delete this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the corresponding delete form
                        const deleteForm = document.getElementById(`delete-form-${id}`);
                        deleteForm.submit();
                    }
                })
            });
        });
    </script>
@endsection
