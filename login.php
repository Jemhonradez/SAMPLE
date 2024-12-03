<?php
session_start();
require_once 'db_connect.php';

$login_message = " ";

// Check if the user is already logged in
if (isset($_SESSION['ua_id'])) {
    header('Location: lp.php'); // If logged in, redirect to shop_now
    exit();
}

// Handle login logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username']; // Added username
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if fields are not empty
    if (empty($username) || empty($email) || empty($password)) {
        $login_message = "Please fill in all fields!";
    } else {
        // Check if the credentials are valid
        $sql = "SELECT * FROM users_account WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verify password
            if (password_verify($password, $user['password'])) {
                $_SESSION['ua_id'] = $user['ua_id']; // Set session variable
                header('Location: lp.php'); // Redirect to shop_now
                exit();
            } else {
                $login_message = "Invalid login credentials!";
            }
        } else {
            $login_message = "No account found with that email!";
        }
    }   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register</title>
    <style>
        /* CSS remains unchanged */
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

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            background-color: #f9f9f9;
        }

        button {
            background-color: #ff4d88;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 14px;
            cursor: pointer;
            width: 100%;
            margin-bottom: 10px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #e63971;
        }

        .separator {
            margin: 20px 0;
            text-align: center;
            position: relative;
        }

        .separator::before,
        .separator::after {
            content: '';
            height: 1px;
            width: 45%;
            background: #ddd;
            position: absolute;
            top: 50%;
        }

        .separator::before {
            left: 0;
        }

        .separator::after {
            right: 0;
        }

        .separator span {
            background: #fff;
            padding: 0 10px;
            font-size: 12px;
            color: #aaa;
        }

        .register-link {
            display: block;
            margin-top: 15px;
            font-size: 14px;
            color: #ff4d88;
            text-decoration: none;
        }

        .register-link:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #d9534f;
            font-size: 14px;
        }

        /* Add a soft gradient background */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom right, #ffccd5, #ffe6f2);
            z-index: -1;
        }

        /* Add some small touches */
        input:focus {
            border-color: #ff4d88;
            outline: none;
        }

        button:focus {
            outline: none;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form method="POST" action="">
            <label for="login-username">Username</label>
            <input type="text" id="login-username" name="username" required> <!-- Username field -->
            <label for="login-email">Email</label>
            <input type="email" id="login-email" name="email" required>
            <label for="login-password">Password</label>
            <input type="password" id="login-password" name="password" required>
            <button type="submit" name="login">Login</button>
        </form>

        <?php if ($login_message) { ?>
            <div class="error-message"><?php echo $login_message; ?></div>
        <?php } ?>

        <div class="separator"><span>OR</span></div>

        <a href="register.php" class="register-link">Don't have an account? Register here</a>
    </div>
</body>
</html>