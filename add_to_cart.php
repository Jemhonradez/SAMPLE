<?php
session_start(); // Start the session
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['item_id'];
    $quantity;

    // Fetch product details
    $sql = "SELECT * FROM items WHERE item_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        // Check if product is available
        if ($product['item_stock'] >= $quantity) {
            $item = [
                'id' => $product['item_id'],
                'name' => $product['item_name'],
                'price' => $product['item_price'],
                'stock' => $product ['item_stock'],
                'quantity' => $quantity,
            ];

            // Add item to cart in session
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            $_SESSION['cart'][] = $item;

            // Update product stock in the database
            $new_stock = $product['item_stock'] - $quantity;
            $update_sql = "UPDATE products SET item_stock = ? WHERE item_id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ii", $new_stock, $product_id);
            $update_stmt->execute();

            echo "Added to cart: " . $product['item_name'] . " (Quantity: $quantity).<br>";
        } else {
            echo "Insufficient stock for " . $product['item_id'] . ".<br>";
        }
    } else {
        echo "Product not found.<br>";
    }
}
echo '<a href="lp.php">Back to Products</a>';
?>
