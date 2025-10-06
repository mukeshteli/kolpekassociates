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
    echo '<!DOCTYPE html><html><head><title>Staff Deleted</title><style>body{font-family:Arial,sans-serif;background:#fff8f0;margin:0;padding:0;} .delete-msg{max-width:370px;margin:60px auto 0 auto;background:#fff;border-radius:14px;box-shadow:0 4px 32px rgba(255,152,0,0.13);padding:2.5rem 2.2rem 2rem 2.2rem;text-align:center;border:2px solid #ff9800;} .delete-msg h2{color:darkred;margin-bottom:1.5rem;} .delete-msg a{background:#e53935;color:#fff;border-radius:6px;padding:0.7rem 2.2rem;font-size:1.1rem;font-weight:bold;text-decoration:none;box-shadow:0 2px 8px rgba(255,152,0,0.10);transition:background 0.2s;display:inline-block;} .delete-msg a:hover{background:darkred;}@media(max-width:600px){.delete-msg{max-width:100vw;padding:0.7rem 0.2rem 0.7rem 0.2rem;border-radius:8px;box-shadow:none;}.delete-msg a{padding:0.5rem 1.2rem;font-size:1rem;}}</style></head><body><div class="delete-msg"><h2>Staff Deleted</h2><p>The staff member has been deleted successfully.</p><a href="admin.php">Back to Admin Dashboard</a></div></body></html>';
    exit;
}
header('Location: admin.php');
exit;
