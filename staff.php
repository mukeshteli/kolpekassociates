<?php
session_start();
include 'db_connect.php';

// Check if logged in as staff
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'staff') {
    header("Location: login.php");
    exit;
}

$staff_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Fetch only customer submissions assigned to this staff
$sql = "SELECT * FROM contacts WHERE staff_id = '$staff_id' ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Staff Dashboard - Kolpek Associates</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: darkred; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: orange; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .logout { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Staff Dashboard</h1>
    <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>

    <h2>Your Assigned Customers</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Requirement</th>
            <th>Profession</th>
            <th>Address</th>
            <th>Message</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['fname'] . " " . $row['lname']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['requirement']; ?></td>
                <td><?php echo $row['profession']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['message']; ?></td>
                <td>
                    <form action="edit_customer.php" method="get" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="action-btn edit-btn">Edit</button>
                    </form>
                    <form action="delete_customer.php" method="get" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="action-btn delete-btn">Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    <!-- No summary row needed -->
    </table>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
