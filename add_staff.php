<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}
if (isset($_POST['username'], $_POST['password'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = md5($_POST['password']);
    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'staff')";
    $conn->query($sql);
}
header('Location: admin.php');
exit;
