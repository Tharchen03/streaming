<!-- layout.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Streaming</title>
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <link rel="stylesheet" href="../assets/css/icomoon.css">
    <link rel="stylesheet" href="../assets/css/video.css" />
    <link rel="stylesheet" href="../assets/css/responsive.css" />
    @livewireStyles
</head>

<body>
    @include('layout.nav')
    @yield('content')

    @include('layout.footer')

    <script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/video.js') }}"></script>
    <script src="{{ asset('assets/js/otp.js') }}"></script>
    <script src="https://player.vdocipher.com/v2/api.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @livewireScripts
    @stack('scripts')

</body>

</html>
