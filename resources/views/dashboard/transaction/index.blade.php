@extends('dashboard.layouts.main')
@section('title', 'Transaction')
@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card border-0 shadow mb-4">
            <div class="card-header">
                <p class="mb-0">Transaction List</p>
                {{-- <div class="d-flex justify-content-between py-auto">
                    <p class="my-auto">Transaction List</p>
                    <div class="btn btn-primary btn-sm px-4 border-0 shadow-sm" data-toggle="modal"
                        data-target="#modalCreateTransaction">Add</div>
                </div> --}}

                {{-- modal create --}}
                {{-- <div class="modal fade" id="modalCreateTransaction" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content border-0">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">New Transaction</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input class="form-control mb-3 @error('quantity') is-invalid @enderror"
                                            type="number" name="quantity" placeholder="Quantity">
                                        @error('quantity')
                                            <div class="form-text">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control mb-3 @error('sub_price') is-invalid @enderror"
                                            type="number" name="sub_price" placeholder="Sub Price">
                                        @error('sub_price')
                                            <div class="form-text">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control mb-3 @error('price') is-invalid @enderror" type="number"
                                            name="price" placeholder="Price" disabled>
                                        @error('price')
                                            <div class="form-text">{{ $message }}</div>
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
                </div> --}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" cellspacing="0">
                        <thead>
                            <tr>
                                {{-- <th style="width: 20%">ID</th> --}}
                                <th style="width: 18%">Created</th>
                                <th>Package</th>
                                <th>Price</th>
                                <th>Payment Proof</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    {{-- <td>{{ $transaction['id'] }}</td> --}}
                                    <td>{{ $transaction['date_time'] }}</td>
                                    <td>{{ $transaction['package_name'] }}</td>
                                    <td>@toRP($transaction['price'])</td>
                                    <td class="text-center">
                                        @if (is_null($transaction['payment_proof']))
                                            Not uploaded yet
                                        @else
                                            <button class="btn-sm btn-primary shadow-sm border-0" onclick="showPaymentProofImage('{{ json_encode($transaction['id']) }}')">
                                                <i class="fa-solid fa-image"></i> See Image
                                            </button>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (is_null($transaction['status']))
                                            <div class="dropdown">
                                                <button
                                                    href="{{ url('dashboard/transaction/' . $transaction['id'] . '/confirmation/1') }}"
                                                    class="btn-sm btn-warning shadow-sm border-0 text-white" type="button"
                                                    id="transaction-{{ $transaction['id'] }}-dropdown"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    style="width: 100%; height: 20%">Unconfirmed <i
                                                        class="fa-solid fa-caret-down"></i></button>
                                                <div class="dropdown-menu"
                                                    aria-labelledby="transaction-{{ $transaction['id'] }}-dropdown">
                                                    <a href="{{ url('dashboard/transaction/' . $transaction['id'] . '/confirmation/1') }}"
                                                        onclick="confirmtransaction1(event)"
                                                        class="dropdown-item">Accepted</a>
                                                    <a href="{{ url('dashboard/transaction/' . $transaction['id'] . '/confirmation/0') }}"
                                                        onclick="confirmtransaction0(event)"
                                                        class="dropdown-item">Rejected</a>
                                                </div>
                                            </div>
                                        @elseif ($transaction['status'] == 1)
                                            <button class="btn-sm btn-success shadow-sm border-0 "
                                                style="width: 100%; height: 20%"><a
                                                    href="{{ url('dashboard/transaction/' . $transaction['id'] . '/confirmation/0') }}"
                                                    onclick="confirmtransaction0(event)"
                                                    class="text-decoration-none text-white">Accepted
                                                    <i class="fa-solid fa-check"></i></a></button>
                                        @elseif ($transaction['status'] == 0)
                                            <button class="btn-sm btn-danger shadow-sm border-0 "
                                                style="width: 100%; height: 20%">
                                                <a href="{{ url('dashboard/transaction/' . $transaction['id'] . '/confirmation/1') }}"
                                                    onclick="confirmtransaction1(event)"
                                                    class="text-white text-decoration-none">Rejected
                                                    <i class="fa-solid fa-xmark"></i></a></button>
                                        @endif

                                    </td>
                                    {{-- <td class="text-center">
                                        <div class="btn btn-sm btn-primary btn-icon shadow-sm"><i
                                                class="fa-solid fa-download"></i></div>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showPaymentProofImage(idjsn) {
            const id = JSON.parse(idjsn)
            Swal.fire({
                title: '',
                text: '',
                imageUrl: "http://localhost:5000/api/admin/payment_proof/"+id,
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'Payment Proof',
            })
        }

        function confirmtransaction1(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be accept this transaction!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, accept it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = event.target.href;
                }
            })
        }

        function confirmtransaction0(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be reject this transaction!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reject it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = event.target.href;
                }
            })
        }
    </script>
@endsection
