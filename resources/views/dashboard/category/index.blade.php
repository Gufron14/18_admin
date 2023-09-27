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
                    <p class="my-auto">Category List</p>
                    <div class="btn btn-primary btn-sm px-4 border-0 shadow-sm" data-toggle="modal"
                        data-target="#modalCreateCategory">Add</div>

                    <div class="modal fade" id="modalCreateCategory" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content border-0">
                                <div class="modal-header text-center">
                                    <h4 class="modal-title w-100 font-weight-bold">New Category</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ url('dashboard/category') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input class="form-control mb-3 @error('category_name') is-invalid @enderror"
                                                type="text" name="category_name" placeholder="Category Name">
                                            @error('category_name')
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
                                <th>Category Name</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category['category_name'] }}</td>
                                    <td>{{ $category['admin']['username'] }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <div data-toggle="modal" data-target="#modalEditCategory"
                                                onclick="categoryModalEdit('{{ json_encode($category) }}')"
                                                class="btn btn-sm btn-warning btn-icon shadow-sm">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </div>
                                            <button class="btn btn-sm btn-danger btn-icon shadow-sm"
                                                id="delete-btn-{{ $category['id'] }}"><i
                                                    class="fa-solid fa-trash"></i></button>

                                            <form id="delete-form-{{ $category['id'] }}"
                                                action="{{ url('dashboard/category') }}" method="POST"
                                                style="display: none;">
                                                @method('DELETE')
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $category['id'] }}"
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
    <div class="modal fade" id="modalEditCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Edit Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formEditCategory">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <label for="editCategoryName">Category Name</label>
                                <input id="editCategoryName"
                                    class="form-control @error('category_name') is-invalid @enderror" type="text"
                                    name="category_name" placeholder="Category Name">
                                @error('category_name')
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
        function categoryModalEdit(categoryJson) {
            const category = JSON.parse(categoryJson);
            document.getElementById('editCategoryName').value = category.category_name;
            document.getElementById('formEditCategory').action = `category/${category.id}`;
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
