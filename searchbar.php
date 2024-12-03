<?php
include 'db_connect.php'; // Connect to the database

// Handle search functionality
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Query to get items matching the search term (with JOIN for category)
$sql = "SELECT i.item_id, i.item_name, i.item_price, c.category_name 
        FROM items i 
        JOIN category c ON i.category_id = c.category_id 
        WHERE i.item_name LIKE ? OR c.category_name LIKE ?";

$stmt = $conn->prepare($sql);
$searchTerm = "%" . $search . "%"; // Add % for partial matching
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Search</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f7f7f7;
        }
        .search-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        #search-bar {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        .results {
            margin-top: 20px;
        }
        .item {
            padding: 10px;
            background: #fff;
            border-bottom: 1px solid #ddd;
        }
        .item:last-child {
            border-bottom: none;
        }
        .item h4 {
            margin: 0 0 5px;
        }
        .item p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="search-container">
        <h1>Search Items</h1>
        <form method="get" action="">
            <input type="text" id="search-bar" name="search" placeholder="Search for items..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>

        <div class="results">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="item">
                        <h4><?php echo htmlspecialchars($row['item_name']); ?></h4>
                        <p>Category: <?php echo htmlspecialchars($row['category_name']); ?></p>
                        <p>Price: ₱<?php echo number_format($row['item_price'], 2); ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No items found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>