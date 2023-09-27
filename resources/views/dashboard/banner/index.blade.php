@extends('dashboard.layouts.main')
@section('title', 'Banner')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        {{-- <h1 class="h3 mb-2 text-gray-800">Partner List</h1> --}}

        <!-- DataTales Example -->
        <div class="card border-0 shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between py-auto">
                    <p class="my-auto">Banner List</p>
                    <div class="btn btn-primary btn-sm px-4 border-0 shadow-sm" data-toggle="modal"
                        data-target="#modalCreateBanner">Add</div>
                </div>

                {{-- modal create --}}
                <div class="modal fade" id="modalCreateBanner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content border-0">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">New Banner</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ url('dashboard/banner/create') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="input-group">
                                        <label class="input-group-text" for="img_path">Banner</label>
                                        <input type="file" class="form-control @error('img_path') is-invalid @enderror"
                                            id="img_path" name="img_path">
                                        @error('img_path')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm shadow-sm" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">Cancel</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-sm shadow-sm">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 70%">Banner Image</th>
                                <th>Created By Admin</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banners as $banner)
                                <tr>
                                    <td class="text-center"><img src="http://localhost:5000/api/admin/banner/{{$banner['id']}}?token={{session('token')}}"style="width: 60%"
                                            alt="Banner-Image" /></td>
                                    <td>{{ $banner['admin']['username'] }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <div data-toggle="modal" data-target="#modalEditBanner"
                                                onclick="bannerModalEdit('{{ json_encode($banner) }}')"
                                                class="btn btn-sm btn-warning btn-icon shadow-sm">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </div>
                                            <button class="btn btn-sm btn-danger btn-icon shadow-sm"
                                                id="delete-btn-{{ $banner['id'] }}"><i
                                                    class="fa-solid fa-trash"></i></button>

                                            <form id="delete-form-{{ $banner['id'] }}"
                                                action="{{ url('dashboard/banner') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $banner['id'] }}"
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
    <div class="modal fade" id="modalEditBanner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Edit Banner</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formEditBanner" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="input-group">
                            <label class="input-group-text" for="img_path">Banner</label>
                            <input type="file" class="form-control @error('img_path') is-invalid @enderror"
                                id="img_path" name="img_path">
                            @error('img_path')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
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
        function bannerModalEdit(bannerJson) {
            const banner = JSON.parse(bannerJson);
            document.getElementById('formEditBanner').action = `banner/${banner.id}`;
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
