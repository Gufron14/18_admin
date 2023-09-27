<!DOCTYPE html>
<html lang="en">

<head>

    @include('dashboard.layouts.head')

</head>

<body>
    <div id="page-top">
        <div id="wrapper">
            @include('dashboard.layouts.sidebar')
            <div id="content-wrapper" class="d-flex flex-column">
                @include('dashboard.layouts.top-bar')

                <div id="content">
                    @yield('content')
                </div>

                @include('dashboard.layouts.footer')
                @include('dashboard.layouts.scroll-to-top')
                @include('dashboard.layouts.logout-modal')

            </div>
        </div>
    </div>
    @include('dashboard.layouts.script')

</body>

@include('sweetalert::alert')

</html>
