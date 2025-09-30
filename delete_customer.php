<?php
session_start();
include 'db_connect.php';

// Only staff can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'staff') {
    header('Location: login.php');
    exit;
}

// Get customer ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Check if customer belongs to staff
$sql = "SELECT * FROM contacts WHERE id = $id AND staff_id = " . $_SESSION['user_id'];
$result = $conn->query($sql);
if (!$result || $result->num_rows == 0) {
    echo "Customer not found or not assigned to you.";
    exit;
}

// Delete customer
$delete_sql = "DELETE FROM contacts WHERE id = $id AND staff_id = " . $_SESSION['user_id'];
if ($conn->query($delete_sql) === TRUE) {
    // Optionally notify admin here (e.g., insert into notifications table)
    header('Location: staff.php?msg=deleted');
    exit;
} else {
    echo "<p style='color:red;'>Error deleting customer: {$conn->error}</p>";
}
?>