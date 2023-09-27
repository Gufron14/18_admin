@extends('dashboard.layouts.main')
@section('title', 'Customer')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        {{-- <h1 class="h3 mb-2 text-gray-800">user List</h1> --}}

        <!-- DataTales Example -->
        <div class="card border-0 shadow mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between py-auto">
                    <p class="my-auto">Package List</p>
                    <div class="btn btn-primary btn-sm px-4 border-0 shadow-sm" data-toggle="modal"
                        data-target="#modalCreatepackage">Add</div>

                    <div class="modal fade" id="modalCreatepackage" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content border-0">
                                <div class="modal-header text-center">
                                    <h4 class="modal-title w-100 font-weight-bold">New Package</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ url('dashboard/package') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input class="form-control mb-3 @error('package_name') is-invalid @enderror"
                                                type="text" name="package_name" placeholder="package Name" required>
                                            @error('package_name')
                                                <div class="form-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control mb-3 @error('count_month') is-invalid @enderror"
                                                type="number" name="count_month" placeholder="count month" required>
                                            @error('count_month')
                                                <div class="form-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control mb-3 @error('price') is-invalid @enderror"
                                                type="price" name="price" placeholder="price" required>
                                            @error('price')
                                                <div class="form-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm shadow-sm"
                                            data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">Cancel</span>
                                        </button>
                                        <button type="submit" class="btn btn-primary btn-sm shadow-sm">Create</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" cellspacing="0">
                        <thead>
                            <tr>
                                <th>package Name</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $package)
                                <tr>
                                    <td>{{ $package['package_name'] }}</td>
                                    <td>{{ $package['count_month'] }}</td>
                                    <td>{{ $package['price'] }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <div data-toggle="modal" data-target="#modalEditpackage"
                                                onclick="packageModalEdit('{{ json_encode($package) }}')"
                                                class="btn btn-sm btn-warning btn-icon shadow-sm">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </div>
                                            <button class="btn btn-sm btn-danger btn-icon shadow-sm"
                                                id="delete-btn-{{ $package['id'] }}"><i
                                                    class="fa-solid fa-trash"></i></button>

                                            <form id="delete-form-{{ $package['id'] }}"
                                                action="{{ url('dashboard/package') }}" method="POST"
                                                style="display: none;">
                                                @method('DELETE')
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $package['id'] }}"
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
    <div class="modal fade" id="modalEditpackage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Edit package</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formEditpackage">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <label for="editpackageName">Package Name</label>
                                <input id="editpackageName"
                                    class="form-control @error('package_name') is-invalid @enderror" type="text"
                                    name="package_name" placeholder="package Name">
                                @error('package_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <label for="editCMName">Count Month</label>
                                <input id="editCMName"
                                    class="form-control @error('count_month') is-invalid @enderror" type="text"
                                    name="count_month" placeholder="Count Month">
                                @error('count_month')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <label for="editPriceName">Price</label>
                                <input id="editPriceName"
                                    class="form-control @error('price') is-invalid @enderror" type="text"
                                    name="price" placeholder="price">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
        function packageModalEdit(packageJson) {
            const package = JSON.parse(packageJson);
            document.getElementById('editpackageName').value = package.package_name;
            document.getElementById('editCMName').value = package.count_month;
            document.getElementById('editPriceName').value = package.price;
            document.getElementById('formEditpackage').action = `package/${package.id}`;
        }

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
