<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopEase Landing Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            overflow-x: hidden;
        }

        /* Full-page image container */
        .landing-container {
            position: relative;
            width: 100%;
            height: 100vh;
            background-image: url('backgroundfinal.jpg'); /* Replace with your image */
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Overlay to darken the image */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6); /* Semi-transparent overlay */
            z-index: 1;
        }

        /* Content wrapper */
        .content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: #fff;
        }

        .content h1 {
            font-size: 3em;
            margin: 0 0 10px;
        }

        .content p {
            font-size: 1.2em;
            margin: 0 0 20px;
        }

        /* Button container */
        .button-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        /* Button styling */
        .btn {
            background: #ff758c;
            color: #fff;
            text-decoration: none;
            padding: 12px 25px;
            font-size: 1.1em;
            font-weight: bold;
            border-radius: 50px;
            transition: background-color 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: #ff4c6a;
        }

        /* Footer */
        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: center;
            padding: 10px;
            background: #333;
            color: #fff;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="landing-container">
        <div class="overlay"></div>
        <div class="content">
            <h1>Welcome to ShopEase</h1>
            <p>Your Style, Your Way - Limited Time Offers Await You!</p>
            <div class="button-container">
                <a href="menu.php" class="btn">Menu</a>
                <a href="login.php" class="btn">Log In</a>
                <a href="login.php" class="btn">Shop Now</a>
            </div>
        </div>
    </div>
    <footer>
        &copy; 2024 ShopEase. All rights reserved.
    </footer>
</body>
</html>
