<?php
// Database connection
include 'db_connect.php';

// Start session (if needed)
session_start();

// Example ua_id (Replace with actual login or account logic)
$ua_id = $_SESSION['ua_id'] ?? 1; // Default to ua_id 1 for testing

// Get item ID and quantity from POST request
$item_id = $_POST['item_id'];
$quantity = $_POST['quantity'];

// Check if the item exists in the cart for this ua_id
$sql = "SELECT * FROM cart WHERE ua_id = ? AND item_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $ua_id, $item_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update quantity if item already exists in the cart
    $sql = "UPDATE cart SET quantity = quantity + ? WHERE ua_id = ? AND item_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $quantity, $ua_id, $item_id);
    $stmt->execute();
} else {
    // Insert new item into the cart
    $sql = "INSERT INTO cart (ua_id, item_id, quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $ua_id, $item_id, $quantity);
    $stmt->execute();
}

$stmt->close();
$conn->close();

// Redirect to itemshowing.php after adding to cart
header("Location: itemshowing.php");
exit();
?>