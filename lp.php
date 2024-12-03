<?php 
session_start();
include 'db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['ua_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

// Fetch the logged-in user's details
$user_id = $_SESSION['ua_id'];
$sql_user = "SELECT username FROM users_account WHERE ua_id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();
$username = $user['username'] ?? 'Guest'; // Default to "Guest" if no username is found

// Fetch categories from the database
$sql_categories = "SELECT * FROM category";
$stmt_categories = $conn->prepare($sql_categories);
$stmt_categories->execute();
$categories_result = $stmt_categories->get_result();

// Handle category filter
$category_filter = isset($_GET['category']) ? $_GET['category'] : null;
$items_result = null;
if ($category_filter) {
    // Fetch items for the selected category
    $sql_items = "SELECT i.item_id, i.item_name, i.item_price, c.category_name 
                  FROM items i 
                  JOIN category c ON i.category_id = c.category_id 
                  WHERE c.category_name = ?";
    $stmt_items = $conn->prepare($sql_items);
    $stmt_items->bind_param("s", $category_filter);
    $stmt_items->execute();
    $items_result = $stmt_items->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopease - Landing Page</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #fbcfe8, #ff80ab); /* Baby pink gradient background */
            color: #333;
            display: flex;
        }
        .sidebar {
            width: 20%;
            background-color: #d5006d; /* Dark pink sidebar */
            color: white;
            height: 100vh; /* Sidebar stretches the entire height of the screen */
            padding: 30px 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow-y: auto; /* Allows scrolling if content overflows */
        }
        .sidebar h3 {
            margin-top: 0;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }
        .sidebar p {
            font-size: 16px;
            margin: 10px 0;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.2);
            padding: 10px 20px;
            margin: 5px 0;
            border-radius: 5px;
            text-align: center;
            width: 100%;
            font-size: 16px;
        }
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.4);
        }
        .main-content {
            width: 80%;
            padding: 20px 40px;
            overflow-y: auto;
        }
        .main-content h1 {
            color: #333;
            font-size: 32px;
            margin-bottom: 20px;
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
        }
        .categories {
            margin-top: 20px;
            width: 100%;
            text-align: center;
        }
        .categories a {
            display: block;
            color: white;
            background-color: #c51162; /* Lighter dark pink for category links */
            padding: 10px 20px;
            margin: 5px 0;
            border-radius: 5px;
            text-decoration: none;
        }
        .categories a:hover {
            background-color: #a1004d; /* Darker pink for hover effect */
        }
        .items-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .item {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.2s;
        }
        .item:hover {
            transform: translateY(-5px);
        }
        .item h4 {
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
        }
        .item p {
            margin: 5px 0;
            font-size: 16px;
            color: #555;
        }
        .item button {
            padding: 10px 20px;
            background-color: #d5006d; /* Dark pink button */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }
        .item button:hover {
            background-color: #a1004d; /* Darker pink for hover effect */
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Shopease</h3>
        <p>Welcome, <?php echo htmlspecialchars($username); ?></p>
        <a href="profile.php">View Profile</a>
        <a href="lp.php">Home</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Categories</h1>

        <!-- Categories List -->
        <div class="categories">
            <?php
            // Display categories fetched from the database
            while ($category = $categories_result->fetch_assoc()) {
                echo '<a href="landingpage.php?category=' . urlencode($category['category_name']) . '">' . htmlspecialchars($category['category_name']) . '</a>';
            }
            ?>
        </div>

        <!-- Items List -->
        <?php if ($category_filter): ?>
            <h2>Items in "<?php echo htmlspecialchars($category_filter); ?>"</h2>
            <div class="items-list">
                <?php
                // Display items if any exist for the selected category
                if ($items_result && $items_result->num_rows > 0):
                    while ($row = $items_result->fetch_assoc()):
                ?>
                        <div class="item">
                            <h4><?php echo htmlspecialchars($row['item_name']); ?></h4>
                            <p>Price: ₱<?php echo number_format($row['item_price'], 2); ?></p>
                            <button>Add to Cart</button>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No items found in this category.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>