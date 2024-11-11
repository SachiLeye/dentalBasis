<?php
// Database configuration
$host = 'localhost';
$db   = 'dental_clinic';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Create a connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE verified = 0");
    
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Token is valid, update the user's verified status
        $updateStmt = $conn->prepare("UPDATE users SET verified = 1");
       
        $updateStmt->execute();

        // Redirect to login page after verification
        header("Location: login.php");
        exit;
    } else {
        echo "Invalid or expired token.";
    }

    // Close statements
    $stmt->close();
    $updateStmt->close();
}

// Close the connection
$conn->close();
?>
