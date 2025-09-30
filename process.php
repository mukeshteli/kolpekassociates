<?php
// Database connection details
$servername = "localhost";
$username = "root";   // default for WAMP
$password = "";       // default for WAMP
$dbname = "mywebsite_db";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) !== TRUE) {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// Create contacts table with staff_id if not exists
$table_sql = "CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(100) NOT NULL,
    lname VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100),
    requirement VARCHAR(255),
    profession VARCHAR(100),
    address VARCHAR(255),
    message TEXT,
    staff_id INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($table_sql) !== TRUE) {
    die("Error creating table: " . $conn->error);
}

// Get form data safely
$fname = isset($_POST['fname']) ? $conn->real_escape_string($_POST['fname']) : '';
$lname = isset($_POST['lname']) ? $conn->real_escape_string($_POST['lname']) : '';
$phone = isset($_POST['phone']) ? $conn->real_escape_string($_POST['phone']) : '';
$email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
$requirement = isset($_POST['requirement']) ? $conn->real_escape_string($_POST['requirement']) : '';
$profession = isset($_POST['profession']) ? $conn->real_escape_string($_POST['profession']) : '';
$address = isset($_POST['address']) ? $conn->real_escape_string($_POST['address']) : '';
$message = isset($_POST['message']) ? $conn->real_escape_string($_POST['message']) : '';

// Temporary assignment (later: dynamic from login session)
$staff_id = 2; 

// Insert data into table
$insert_sql = "INSERT INTO contacts (fname, lname, phone, email, requirement, profession, address, message, staff_id)
               VALUES ('$fname', '$lname', '$phone', '$email', '$requirement', '$profession', '$address', '$message', '$staff_id')";

if ($conn->query($insert_sql) === TRUE) {
    // Send notification email
    $to = 'telimukesh2005@gmail.com';
    $subject = 'New Form Submission - Kolpek Associates';
    $body = "A new user has submitted the form:\n\n"
        . "First Name: $fname\n"
        . "Last Name: $lname\n"
        . "Phone: $phone\n"
        . "Email: $email\n"
        . "Requirement: $requirement\n"
        . "Profession: $profession\n"
        . "Address: $address\n"
        . "Message: $message\n";
    $headers = 'From: noreply@kolpekassociates.com';
    mail($to, $subject, $body, $headers);
    echo "Thank you! Your information has been saved successfully.";
} else {
    echo "Error: " . $insert_sql . "<br>" . $conn->error;
}

$conn->close();
?>
