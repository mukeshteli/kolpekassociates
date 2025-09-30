<?php
session_start();
include "db_connect.php"; // <-- common DB file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $conn->real_escape_string($_POST['username']);
  $password = md5($_POST['password']); // hashing

  $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['user_id'] = $row['id'];

        if ($row['role'] == 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: staff.php");
        }
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login - Kolpek Associates</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="contact-container">
    <h1>Login</h1>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" action="">
      <div class="form-group">
        <label>Username:</label>
        <input type="text" name="username" required>
      </div>
      <div class="form-group">
        <label>Password:</label>
        <input type="password" name="password" required>
      </div>
      <div class="form-buttons">
        <button type="submit">Login</button>
      </div>
    </form>
    <div class="logout-link-box">
      <a href="logout.php" class="logout-link">Logout</a>
    </div>
  </div>
</body>
</html>
