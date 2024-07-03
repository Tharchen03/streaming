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
    <?php include 'nav.php'; ?>

    <?php echo $content; ?>

    <?php include 'footer.php'; ?>

    <script src="../assets/js/jquery-3.4.1.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/video.js"></script>
    <script src="https://player.vdocipher.com/v2/api.js"></script>
</body>

</html>