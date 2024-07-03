<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Page</title>
</head>
<body>
    <h1>Welcome to the Test Page</h1>
    <?php
    session_start(); // Resume session
    if (isset($_SESSION['submitted']) && $_SESSION['submitted'] === true) {
        // Display content for users who have submitted the form
        echo "<p>You have access because you have successfully submitted the form.</p>";
        
        
    } else {
        // Display content for users who haven't submitted the form or have already accessed once
        echo "<p>Access denied. You need to submit the form first.</p>";
        echo '<p><a href="index.html">Go back to submit the form</a></p>';
    }
    ?>
</body>
</html>
