@extends('dashboard.layouts.main')
@section('title', 'SquareFeed')
@section('content')
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card border-0 shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between py-auto">
                    <p class="my-auto">SquareFeed List</p>
                    <div class="btn btn-primary btn-sm px-4 border-0 shadow-sm" data-toggle="modal"
                        data-target="#modalCreateSquareFeed">Add</div>
                </div>
                <div class="modal fade" id="modalCreateSquareFeed" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content border-0">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">New SquareFeed</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ url('dashboard/squarefeed/create') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="input-group">
                                        <label class="input-group-text" for="img_path">SquareFeed Image</label>
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
                                <th style="width: 70%">SquareFeed Image</th>
                                <th>Created By Admin</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($squarefeeds as $squarefeed)
                                <tr>
                                    <td class="text-center"><img
                                            src="http://localhost:5000/api/admin/sq/{{$squarefeed['id']}}"style="width: 60%"
                                            alt="SquareFeed-Image" /></td>
                                    <td>{{ $squarefeed['admin']['username'] }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <div data-toggle="modal" data-target="#modalEditSquareFeed"
                                                onclick="squareFeedModalEdit('{{ json_encode($squarefeed) }}')"
                                                class="btn btn-sm btn-warning btn-icon shadow-sm">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </div>
                                            <button class="btn btn-sm btn-danger btn-icon shadow-sm"
                                                id="delete-btn-{{ $squarefeed['id'] }}"><i
                                                    class="fa-solid fa-trash"></i></button>

                                            <form id="delete-form-{{ $squarefeed['id'] }}"
                                                action="{{ url('dashboard/squarefeed') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $squarefeed['id'] }}"
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

    <div class="modal fade" id="modalEditSquareFeed" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Edit SquareFeed</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formEditSquareFeed" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="input-group">
                            <label class="input-group-text" for="img_path">SquareFeed</label>
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
        function squareFeedModalEdit(squarefeedJson) {
            const squarefeed = JSON.parse(squarefeedJson);
            document.getElementById('formEditSquareFeed').action = `squarefeed/${squarefeed.id}`;
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
