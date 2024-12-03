<?php
session_start();
require_once 'db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['ua_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

$ua_id = $_SESSION['ua_id']; // Get the logged-in user's ID

// Fetch the user's profile information
$sql = "SELECT username, email FROM users_account WHERE ua_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ua_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc(); // Fetch user data
} else {
    echo "Error: User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffe6f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 30px 50px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h1 {
            color: #ff4d88;
            margin-bottom: 20px;
            font-size: 28px;
        }

        p {
            font-size: 16px;
            color: #666;
            margin-bottom: 10px;
        }

        .logout {
            background-color: #ff4d88;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 14px;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .logout:hover {
            background-color: #e63971;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Profile</h1>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>

        <form action="logout.php" method="POST">
            <button class="logout" type="submit">Logout</button>
        </form>
    </div>
</body>
</html>