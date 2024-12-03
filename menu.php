<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['ua_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

// Include database connection if needed
require_once 'db_connection.php';

// Retrieve user information if needed
$user_id = $_SESSION['ua_id'];
$stmt = $conn->prepare("SELECT name FROM users_account WHERE ua_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$username = $user['name'] ?? 'User'; // Fallback to 'User' if name is not set
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to ShopEase</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 20px;
        }

        header h1 {
            margin: 0;
        }

        nav {
            margin: 20px 0;
        }

        nav a {
            color: #007bff;
            text-decoration: none;
            margin: 0 15px;
            font-size: 1.2em;
        }

        nav a:hover {
            text-decoration: underline;
        }

        main {
            padding: 20px;
        }

        footer {
            background-color: #333;
            color: white;
            padding: 10px 0;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to ShopEase</h1>
        <p>Hello, <?php echo htmlspecialchars($username); ?>! We're glad you're here.</p>
    </header>
    <nav>
        <a href="shop_now.php">Shop Now</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </nav>
    <main>
        <h2>Explore the Best Deals!</h2>
        <p>Discover exclusive discounts, trending products, and more. Start your shopping journey now.</p>
    </main>
    <footer>
        <p>&copy; 2024 ShopEase. All rights reserved.</p>
    </footer>
</body>
</html>