<?php


// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Not logged in"; // Debug message
    header('Location: /app/index.php'); // Redirect to login page if not logged in
    exit;
}

// Display dashboard content
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome to the Dashboard</h1>
    <p>You are logged in.</p>
</body>
</html>
