<?php
// Start the session
session_start();

// Include the database connection file
include 'db_connect.php'; // Change to your connection file if needed

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match!";
    } else {
        // Check if the email already exists
        $sql_check = "SELECT * FROM users_account WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $error_message = "Email is already registered!";
        } else {
            // Insert the new user into the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Securely hash the password
            $sql_insert = "INSERT INTO users_account (username, email, password) VALUES (?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt_insert->execute()) {
                header('Location: login.php'); // Redirect to login page
                exit();
            } else {
                $error_message = "Registration failed! Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px 40px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h1 {
            color: #ff4d88;
            margin-bottom: 20px;
            font-size: 24px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 14px;
            color: #555555;
            margin-bottom: 8px;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            font-size: 14px;
        }

        button {
            background-color: #28a745;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            font-size: 14px;
            cursor: pointer;
            width: 100%;
            margin-bottom: 10px;
        }

        button:hover {
            background-color: #218838;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .login-link {
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <?php if (isset($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            
            <button type="submit">Register</button>
        </form>
        <a href="login.php" class="login-link">Already have an account? Login here</a>
    </div>
</body>
</html>