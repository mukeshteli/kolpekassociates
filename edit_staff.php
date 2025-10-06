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

<style>
body { font-family: Arial, sans-serif; background: #fff8f0; margin: 0; padding: 0; }
.edit-staff-container {
    max-width: 370px;
    margin: 60px auto 0 auto;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 4px 32px rgba(255,152,0,0.13);
    padding: 2.5rem 2.2rem 2rem 2.2rem;
    text-align: center;
    border: 2px solid #ff9800;
}
.edit-staff-container h2 {
    color: darkred;
    margin-bottom: 1.5rem;
}
.edit-staff-form {
    display: flex;
    flex-direction: column;
    gap: 1.2rem;
}
.edit-staff-form label {
    font-weight: bold;
    color: #333;
    margin-bottom: 0.2rem;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}
.edit-staff-form input[type="text"],
.edit-staff-form input[type="password"] {
    width: 100%;
    padding: 0.7rem 0.9rem;
    border: 1.5px solid #ff9800;
    border-radius: 6px;
    font-size: 1rem;
    background: #f9f9f9;
    transition: border 0.2s;
}
.edit-staff-form input[type="text"]:focus,
.edit-staff-form input[type="password"]:focus {
    border: 1.5px solid darkred;
    outline: none;
}
.edit-staff-form .form-buttons {
    display: flex;
    justify-content: center;
    gap: 1.2rem;
}
.edit-staff-form button[type="submit"] {
    background: orange;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 0.7rem 2.2rem;
    font-size: 1.1rem;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(255,152,0,0.10);
    transition: background 0.2s;
}
.edit-staff-form button[type="submit"]:hover {
    background: darkred;
}
.edit-staff-form a {
    background: #e53935;
    color: #fff;
    border-radius: 6px;
    padding: 0.7rem 2.2rem;
    font-size: 1.1rem;
    font-weight: bold;
    text-decoration: none;
    box-shadow: 0 2px 8px rgba(255,152,0,0.10);
    transition: background 0.2s;
    display: inline-block;
}
.edit-staff-form a:hover {
    background: darkred;
}
@media (max-width: 600px) {
    .edit-staff-container {
        max-width: 100vw;
        padding: 0.7rem 0.2rem 0.7rem 0.2rem;
        border-radius: 8px;
        box-shadow: none;
    }
    .edit-staff-form button[type="submit"], .edit-staff-form a {
        padding: 0.5rem 1.2rem;
        font-size: 1rem;
    }
}
</style>
<div class="edit-staff-container">
    <h2>Edit Staff</h2>
    <form method="post" class="edit-staff-form">
        <label>Username:
            <input type="text" name="username" value="<?php echo htmlspecialchars($staff['username']); ?>" required>
        </label>
        <label>New Password:
            <input type="password" name="password">
        </label>
        <div class="form-buttons">
            <button type="submit">Update</button>
            <a href="admin.php">Cancel</a>
        </div>
    </form>
</div>
</body></html>
