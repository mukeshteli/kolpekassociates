<?php
session_start();
include 'db_connect.php';

// Check if logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Fetch all staff
$staff_result = $conn->query("SELECT id, username FROM users WHERE role='staff'");
// Fetch all customers
$result = $conn->query("SELECT * FROM contacts ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Kolpek Associates</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: darkred; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: orange; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .logout { margin-top: 200px; }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>

    <div class="admin-section">
        <h2>All Staff</h2>
        <table>
            <tr><th>ID</th><th>Username</th><th>Actions</th></tr>
            <?php 
            // Re-query staff for management section
            $staff_result2 = $conn->query("SELECT id, username FROM users WHERE role='staff'");
            while ($staff = $staff_result2->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $staff['id']; ?></td>
                    <td><?php echo htmlspecialchars($staff['username']); ?></td>
                    <td>
                        <form action="edit_staff.php" method="get" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $staff['id']; ?>">
                            <button type="submit">Edit</button>
                        </form>
                        <form action="delete_staff.php" method="post" style="display:inline;" onsubmit="return confirm('Delete this staff member?');">
                            <input type="hidden" name="id" value="<?php echo $staff['id']; ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <h3>Add New Staff</h3>
        <form action="add_staff.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Add Staff</button>
        </form>
    </div>
    <div class="admin-section">
        <h2>All Customers</h2>
        <table>
            <tr>
                <th>ID</th><th>Name</th><th>Contact</th><th>Email</th><th>Requirement</th><th>Staff Assigned</th><th>Assign/Change Staff</th>
            </tr>
            <?php 
            // Re-query staff for dropdowns
            $staff_dropdown = $conn->query("SELECT id, username FROM users WHERE role='staff'");
            $result2 = $conn->query("SELECT * FROM contacts ORDER BY id DESC");
            while ($cust = $result2->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $cust['id']; ?></td>
                    <td><?php echo htmlspecialchars($cust['fname'] . ' ' . $cust['lname']); ?></td>
                    <td><?php echo htmlspecialchars($cust['phone']); ?></td>
                    <td><?php echo htmlspecialchars($cust['email']); ?></td>
                    <td><?php echo htmlspecialchars($cust['requirement']); ?></td>
                    <td><?php echo $cust['staff_id'] ? $cust['staff_id'] : "Unassigned"; ?></td>
                    <td>
                        <form action="assign_staff.php" method="post" style="display:inline;">
                            <input type="hidden" name="customer_id" value="<?php echo $cust['id']; ?>">
                            <select name="staff_id" required>
                                <option value="">Select Staff</option>
                                <?php 
                                $staff_dropdown2 = $conn->query("SELECT id, username FROM users WHERE role='staff'");
                                while ($s = $staff_dropdown2->fetch_assoc()) { ?>
                                    <option value="<?php echo $s['id']; ?>" <?php if ($cust['staff_id'] == $s['id']) echo 'selected'; ?>><?php echo htmlspecialchars($s['username']); ?></option>
                                <?php } ?>
                            </select>
                            <button type="submit">Assign</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <div class="logout-btn-box">
        <form action="logout.php" method="post" style="display:flex;justify-content:center;align-items:center;">
            <button type="submit" style="background-color: maroon;color:#fff;border:none;border-radius:12px;margin:45px;padding:12px 24px;font-size:1.2rem;font-weight:bold;box-shadow:0 4px 18px rgba(148, 67, 5, 0.1);letter-spacing:0.5px;outline:none;cursor:pointer;">Logout</button>
        </form>
    </div>
</body>
</html>
