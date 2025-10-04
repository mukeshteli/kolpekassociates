<?php
$servername = "sql306.infinityfree.com";   // MySQL Host provided by InfinityFree
$username   = "if0_40067450";              // MySQL User Name
$password   = "ElrqwrpCXXMftR";    // Replace with your actual InfinityFree password
$dbname     = "if0_40067450_kolpek_db";    // MySQL Database Name
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
