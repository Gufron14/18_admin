@extends('dashboard.layouts.main')
@section('title', 'Partner')
@section('content')
    <div class="container">
        <div class="card border-0 shadow-sm mb-3">
            <div class="row">
                <div class="col-4 d-flex align-items-center justify-content-center">
                    <img src="http://localhost:5000/api/admin/partner/avatar/{{ $partner['id'] }}?token={{session('token')}}" alt="image-partner"
                        style="width:300px; height:300px; object-fit: cover;" class="rounded">
                </div>

                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-0">{{ $partner['partner_name'] }}</h5>
                        <div class="my-2">
                            <p class="btn btn-sm btn-primary rounded text-white border-0 my-1"><i class="fa-solid fa-envelope"></i>{{ $partner['email'] }}</p>
                            <a href="{{$partner['link_google_map']}}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-primary rounded text-white border-0 my-1"><i class="fa-solid fa-location-dot"></i>Lihat lokasi</a>
                            <br>
                            @foreach (['fa-house', 'fa-screwdriver-wrench'] as $icon)
                                <p class="btn btn-sm btn-primary rounded text-white border-0 my-1"><i
                                        class="fa-solid {{ $icon }}"></i>
                                    @switch($icon)
                                        @case('fa-house')
                                            {{ $partner['address'] }}
                                        @break

                                        @case('fa-screwdriver-wrench')
                                            {{ $partner['count_order'] }}
                                        @break
                                    @endswitch
                                </p>
                            @endforeach
                        </div>

                        <a href="https://wa.me/{{ $partner['phone_number'] }}"class="btn btn-sm btn-primary rounded text-white border-0 mb-1"><i class="fa-solid fa-phone"></i>
                            {{ $partner['phone_number'] }}
                        </a>

                        <p>{{ $partner['description'] }}</p>
                        <hr>
                        <p class="card-text"><small class="text-muted">Shop Created By by
                                <b>{{ $partner['user']['username'] }}</b></small></p>
                        <div class="d-flex justify-content-start gap-3 my-3">
                            <a href="" class="btn btn-sm btn-warning btn-icon shadow-sm px-3" data-toggle="modal"
                                data-target="#modalEditPartnerDetail"><i class="fa-solid fa-pen-to-square"></i>
                                Edit</a>

                            <button class="btn btn-sm btn-danger btn-icon shadow-sm"
                                id="delete-btn-{{ $partner['id'] }}"><i class="fa-solid fa-trash"></i> Delete</button>

                            <form id="delete-form-{{ $partner['id'] }}" action="{{ url('dashboard/partner') }}"
                                method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="id" value="{{ $partner['id'] }}"
                                    id="inputIdDeletePartner">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-grid">
            <a href="{{ url('dashboard/partner') }}"
                class="btn border-0 shadow-sm text-decoration-none btn-primary text-center">Back</a>
        </div>
    </div>
    <div class="modal fade" id="modalEditPartnerDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Edit Partner</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('dashboard/partner/' . $partner['id']) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editPartnerName">Partner Name</label>
                                    <input id="editPartnerName"
                                        class="form-control @error('partner_name') is-invalid @enderror" type="text"
                                        name="partner_name" placeholder="Partner Name"
                                        value="{{ $partner['partner_name'] }}">
                                    @error('partner_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="editEmail">Email</label>
                                    <input id="editEmail" class="form-control @error('email') is-invalid @enderror"
                                        type="email" name="email" placeholder="Email" value="{{ $partner['email'] }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="editCoordinate">Link Google Map</label>
                                    <input id="editCoordinate"
                                        class="form-control @error('coordinate') is-invalid @enderror" type="text"
                                        name="coordinate" placeholder="Coordinate" value="{{ $partner['link_google_map'] }}">
                                    @error('coordinate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="editPhoneNumber">Phone Number</label>
                                    <input id="editPhoneNumber"
                                        class="form-control @error('phone_number') is-invalid @enderror" type="text"
                                        name="phone_number" placeholder="Phone Number"
                                        value="{{ $partner['phone_number'] }}">
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editCountOrder">Count Order</label>
                                    <input id="editCountOrder"
                                        class="form-control @error('count_order') is-invalid @enderror" type="number"
                                        name="count_order" placeholder="Count Order"
                                        value="{{ $partner['count_order'] }}">
                                    @error('count_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="editAccountStatus">Account Status</label>
                                    <select id="editAccountStatus"
                                        class="form-control @error('account_status') is-invalid @enderror"
                                        name="account_status">
                                        <option value="" disabled selected>Account Status</option>
                                        <option value="1" {{ $partner['account_status'] == 1 ? 'selected' : '' }}>
                                            Confirmed</option>
                                        <option value="0" {{ $partner['account_status'] == 0 ? 'selected' : '' }}>
                                            Unconfirmed</option>
                                    </select>
                                    @error('account_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="editOperationalStatus">Operational Status</label>
                                    <select id="editOperationalStatus"
                                        class="form-control @error('operational_status') is-invalid @enderror"
                                        name="operational_status">
                                        <option value="" disabled selected>Operational Status</option>
                                        <option value="1"
                                            {{ $partner['operational_status'] == 1 ? 'selected' : '' }}>Open</option>
                                        <option value="0"
                                            {{ $partner['operational_status'] == 0 ? 'selected' : '' }}>Closed</option>
                                    </select>
                                    @error('operational_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="editAddress">Address</label>
                                    <input id="editAddress" class="form-control @error('address') is-invalid @enderror"
                                        type="text" name="address" placeholder="Address"
                                        value="{{ $partner['address'] }}">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editDescription">Description</label>
                            <textarea id="editDescription" class="form-control @error('description') is-invalid @enderror" name="description"
                                placeholder="Description">{{ $partner['description'] }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="input-group">
                            <label class="input-group-text" for="avatar">Avatar</label>
                            <input id="editAvatar" type="file"
                                class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar">
                            @error('avatar')
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
<style>
    #content>div>div>div>div.col-md-8>div>p {
        margin: 0;
    }

    .custom-img {}
</style>
