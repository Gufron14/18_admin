@extends('dashboard.layouts.main')
@section('title', 'Partner')
@section('content')
    <div class="container px-3">
        <!-- Search -->
        <div class="input-group mb-4 d-flex justify-content-end">
            <div class="form-outline">
                <input type="search" id="searchInput" class="form-control" placeholder="Search" />
            </div>
            <button type="button" class="btn btn-primary">
                <i class="fas fa-search"></i>
            </button>
        </div>

        <div class="px-3 d-flex gap-3 justify-content-center flex-wrap" id="partnerCards">
            @foreach ($partners as $partner)
                <div class="card border-0 shadow-sm rounded col-xl-2 text-center p-3">
                    <div class="text-center my-2">
                        <img src="http://localhost:5000/api/admin/partner/avatar/{{ $partner['id'] }}?token={{session('token')}}"
                            class="rounded-circle" style="width:60px; height:60px; object-fit: cover;" alt="Avatar" />
                    </div>
                    <p class="my-1">
                        @if(is_null($partner['request_status']))
                        <div class="dropdown">
                                <a type="button" class="badge px-2 py-1 text-white bg-primary" id="partner-{{ $partner['id'] }}-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">New Partner</a>
                                <div class="dropdown-menu" aria-labelledby="partner-{{ $partner['id'] }}-dropdown">
                                    <a href="{{ url('dashboard/partner/' . $partner['id'] . '/confirmation/1') }}"onclick="confirmPartner1(event)" class="dropdown-item">Accepted</a>
                                    <a href="{{ url('dashboard/partner/' . $partner['id'] . '/confirmation/0') }}"onclick="confirmPartner0(event)" class="dropdown-item">Rejected</a>
                                </div>
                            </div>
                        @else
                            @if($partner['request_status'] == 1)
                                <a href="{{ url('dashboard/partner/' . $partner['id'] . '/confirmation/0') }}"onclick="confirmPartner0(event)" class="badge px-2 py-1 text-white bg-success">Accepted</a>
                            @else
                                <a href="{{ url('dashboard/partner/' . $partner['id'] . '/confirmation/1') }}"onclick="confirmPartner1(event)" class="badge px-2 py-1 text-white bg-danger">Rejected</a>
                            @endif
                        @endif
                    </p>
                    <p class="mb-2 partner_name" style="height: 50px;">{{ $partner['partner_name'] }}</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href=" {{ url('dashboard/partner/' . $partner['id']) }} "
                            class="btn btn-sm btn-primary btn-icon shadow-sm"><i class="fa-solid fa-circle-info"></i></a>


                        <a href="#" class="btn btn-sm btn-warning btn-icon shadow-sm" data-toggle="modal"
                            data-target="#modalEditPartner" onclick="partnerModalEdit('{{ json_encode($partner) }}')">
                            <i class="fa-solid fa-pen-to-square"></i></a>

                        <button class="btn btn-sm btn-danger btn-icon shadow-sm" id="delete-btn-{{ $partner['id'] }}"><i
                                class="fa-solid fa-trash"></i></button>

                        <form id="delete-form-{{ $partner['id'] }}" action="{{ url('dashboard/partner') }}" method="POST"
                            style="display: none;">
                            @csrf
                            <input type="hidden" name="id" value="{{ $partner['id'] }}" id="inputIdDeletePartner">
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{-- modal edit --}}
    <div class="modal fade" id="modalEditPartner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Edit Partner</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formEditPartner" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editPartnerName">Partner Name</label>
                                    <input id="editPartnerName"
                                        class="form-control @error('partner_name') is-invalid @enderror" type="text"
                                        name="partner_name" placeholder="Partner Name">
                                    @error('partner_name')
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
                                <div class="form-group">
                                    <label for="editCoordinate">Location</label>
                                    <input id="editCoordinate"
                                        class="form-control @error('coordinate') is-invalid @enderror" type="text"
                                        name="coordinate" placeholder="Coordinate">
                                    @error('coordinate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="editPhoneNumber">Phone Number</label>
                                    <input id="editPhoneNumber"
                                        class="form-control @error('phone_number') is-invalid @enderror" type="text"
                                        name="phone_number" placeholder="Phone Number">
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
                                        name="count_order" placeholder="Count Order">
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
                                        <option value="1">Active</option>
                                        <option value="0">Not Active</option>
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
                                        <option value="1">Open</option>
                                        <option value="0">Closed</option>
                                    </select>
                                    @error('operational_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="editAddress">Address</label>
                                    <input id="editAddress" class="form-control @error('address') is-invalid @enderror"
                                        type="text" name="address" placeholder="Address">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editDescription">Description</label>
                            <textarea id="editDescription" class="form-control @error('description') is-invalid @enderror" name="description"
                                placeholder="Description"></textarea>
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
        // search
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('keyup', function() {
            const searchValue = searchInput.value.toLowerCase();
            const cards = document.querySelectorAll('.card');

            cards.forEach(function(card) {
                const partner_name = card.querySelector('.partner_name').textContent.toLowerCase();

                // Show or hide the card based on the search value
                if (partner_name.includes(searchValue)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

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

        //request_partner

        function request_partner(event){
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you accept this request?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, confirm it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = event.target.href;
                }
            })
        }
        // confirm & unconfirm partner
        function confirmPartner1(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be confirm this partner!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, confirm it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = event.target.href;
                }
            })
        }

        function confirmPartner0(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be unconfirm this partner!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, unconfirm it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = event.target.href;
                }
            })
        }

        // edit
        function partnerModalEdit(partnerJson) {
            const partner = JSON.parse(partnerJson);

            // now you can access properties of the partner object like this:

            // console.log(partner.id);
            document.getElementById('editPartnerName').value = partner.partner_name;
            document.getElementById('editEmail').value = partner.partner_name;
            document.getElementById('editCoordinate').value = partner.link_google_map;
            document.getElementById('editAddress').value = partner.address;
            document.getElementById('editDescription').value = partner.description;
            document.getElementById('editCountOrder').value = partner.count_order;
            document.getElementById('editAccountStatus').value = partner.account_status;
            document.getElementById('editPhoneNumber').value = partner.phone_number;
            document.getElementById('editOperationalStatus').value = partner.operational_status;
            document.getElementById('formEditPartner').action = `partner/${partner.id}`;
        }
    </script>
@endsection
