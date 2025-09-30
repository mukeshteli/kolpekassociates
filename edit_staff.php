<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = !empty($_POST['password']) ? ", password='" . md5($_POST['password']) . "'" : '';
    $sql = "UPDATE users SET username='$username' $password WHERE id=$id AND role='staff'";
    $conn->query($sql);
    header('Location: admin.php');
    exit;
}
$staff = $conn->query("SELECT * FROM users WHERE id=$id AND role='staff'")->fetch_assoc();
?>
<!DOCTYPE html>
<html><head><title>Edit Staff</title></head><body>
<h2>Edit Staff</h2>
<form method="post">
    <label>Username: <input type="text" name="username" value="<?php echo htmlspecialchars($staff['username']); ?>" required></label><br>
    <label>New Password: <input type="password" name="password"></label><br>
    <button type="submit">Update</button>
    <a href="admin.php">Cancel</a>
</form>
</body></html>
