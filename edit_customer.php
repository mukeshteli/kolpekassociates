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

// Fetch customer details
$sql = "SELECT * FROM contacts WHERE id = $id AND staff_id = " . $_SESSION['user_id'];
$result = $conn->query($sql);
if (!$result || $result->num_rows == 0) {
    echo "Customer not found or not assigned to you.";
    exit;
}
$row = $result->fetch_assoc();

// Handle update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = $conn->real_escape_string($_POST['fname']);
    $lname = $conn->real_escape_string($_POST['lname']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $requirement = $conn->real_escape_string($_POST['requirement']);
    $profession = $conn->real_escape_string($_POST['profession']);
    $address = $conn->real_escape_string($_POST['address']);
    $message = $conn->real_escape_string($_POST['message']);

    $update_sql = "UPDATE contacts SET fname='$fname', lname='$lname', phone='$phone', email='$email', requirement='$requirement', profession='$profession', address='$address', message='$message' WHERE id=$id AND staff_id=" . $_SESSION['user_id'];
    if ($conn->query($update_sql) === TRUE) {
        // Optionally notify admin here (e.g., insert into notifications table)
        header('Location: staff.php?msg=updated');
        exit;
    } else {
        echo "<p style='color:red;'>Error updating customer: {$conn->error}</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Customer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Customer</h1>
    <form method="POST">
        <label>First Name: <input type="text" name="fname" value="<?php echo htmlspecialchars($row['fname']); ?>" required></label><br>
        <label>Last Name: <input type="text" name="lname" value="<?php echo htmlspecialchars($row['lname']); ?>" required></label><br>
        <label>Phone: <input type="text" name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>" required></label><br>
        <label>Email: <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required></label><br>
        <label>Requirement: <input type="text" name="requirement" value="<?php echo htmlspecialchars($row['requirement']); ?>" required></label><br>
        <label>Profession: <input type="text" name="profession" value="<?php echo htmlspecialchars($row['profession']); ?>"></label><br>
        <label>Address: <input type="text" name="address" value="<?php echo htmlspecialchars($row['address']); ?>"></label><br>
        <label>Message: <textarea name="message"><?php echo htmlspecialchars($row['message']); ?></textarea></label><br>
        <button type="submit">Update</button>
        <a href="staff.php">Cancel</a>
    </form>
</body>
</html>
