<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}
if (isset($_POST['customer_id'], $_POST['staff_id'])) {
    $customer_id = intval($_POST['customer_id']);
    $staff_id = intval($_POST['staff_id']);
    $sql = "UPDATE contacts SET staff_id=$staff_id WHERE id=$customer_id";
    $conn->query($sql);
}
header('Location: admin.php');
exit;
