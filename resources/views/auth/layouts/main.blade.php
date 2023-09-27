<!DOCTYPE html>
<html lang="en">

<head>

    @include('auth.layouts.head')

</head>

<body>

    @yield('content')
    @include('dashboard.layouts.script')
    @include('sweetalert::alert')


</body>


</html>
