@extends('dashboard.layouts.main')
@section('title', 'Review')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        {{-- <h1 class="h3 mb-2 text-gray-800">Partner List</h1> --}}

        <!-- DataTales Example -->
        <div class="card border-0 shadow mb-4">
            <div class="card-header">
                <p class="mb-0">Review List</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" cellspacing="0">
                        @php
                            use Faker\Factory as Faker;
                            use Carbon\Carbon;
                            
                            $faker = Faker::create('id_ID');
                            $reviews = [];
                            for ($i = 1; $i <= 100; $i++) {
                                $rating = random_int(1, 5);
                                $desc = $faker->text;
                                $partner_id = random_int(1, 5);
                                $customer_id = random_int(1, 5);
                            
                                $reviews[] = [
                                    'rating' => $rating,
                                    'desc' => $desc,
                                    'partner_id' => $partner_id,
                                    'customer_id' => $customer_id,
                                ];
                            }
                        @endphp
                        <thead>
                            <tr>
                                {{-- <th width="20px">No</th> --}}
                                <th width="14%">Rating</th>
                                <th>Desc</th>
                                <th>Partner Id</th>
                                <th>Customer Id</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $review)
                                <tr>
                                    <td>
                                        @php
                                            for ($i = 0; $i < $review['rating']; $i++) {
                                                echo '<i class="text-warning fa-solid fa-star"></i>';
                                            }
                                            echo ' (' . $review['rating'] . ')';
                                        @endphp
                                    </td>
                                    <td>{{ $review['desc'] }}</td>
                                    <td>{{ $review['partner_id'] }}</td>
                                    <td>{{ $review['customer_id'] }}</td>
                                    <td class="text-center">
                                        <div class="btn btn-sm btn-danger btn-icon shadow-sm">Delete</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
