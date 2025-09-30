<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $conn->query("DELETE FROM users WHERE id=$id AND role='staff'");
}
header('Location: admin.php');
exit;
