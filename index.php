<?php
ob_start();
?>

<main>
    <div class="content">
        <h1>Your gateway to Watching movies</h1>
        <h2>Choose Your Payment Method</h2>
        <a href=""></a>
        <div class="store-buttons">
            <button class="store-btn">
                <img src="assets/img/icons/applestore.png" alt="App Store" /> Intl Payment
            </button>
            <button class="store-btn" href="video.php">
                <img src="assets/img/icons/playstore.png" alt="Play Store" /> RMA Payment
            </button>
        </div>
    </div>
</main>

<?php
$content = ob_get_clean();

include 'layout/main.php';
?>
<?php include 'route.php'; ?>