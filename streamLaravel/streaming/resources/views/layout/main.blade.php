<!-- layout.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Streaming</title>
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="../assets/css/icomoon.css">
    <link rel="stylesheet" href="../assets/css/video.css" />
</head>

<body>
    @include('layout.nav')
    @yield('content')

    @include('layout.footer')


    <script src="../assets/js/jquery-3.4.1.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/video.js"></script>
    <script src="assets/js/otp.js"></script>
    <script src="https://player.vdocipher.com/v2/api.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>
