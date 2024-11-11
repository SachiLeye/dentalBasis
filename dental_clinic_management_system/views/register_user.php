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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Basic validation
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "All fields are required.";
        exit;
    }

    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit;
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Generate verification token
    $verification_token = bin2hex(random_bytes(16)); // Generate a random token

    // Set expiration time for the token
    $expiration_time = date("Y-m-d H:i:s", strtotime('+1 hour')); // Set expiry to 1 hour from now

    // Prepare SQL statement to insert data
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, token_expiration) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $expiration_time);

    // Execute the statement
    if ($stmt->execute()) {
        // Send verification email
        $to = $email;
        $subject = "Email Verification";
        
        // Adjust the verification link for local development
        $verificationLink = "http://localhost/dental_clinic_management_system/views/verify_email.php?token=" . $verification_token;
        $message = "Click the link below to verify your email:\n" . $verificationLink;
        $headers = "From: sachilette@gmail.com\r\n" .
                   "Reply-To: sachilette@gmail.com\r\n" .
                   "X-Mailer: PHP/" . phpversion();

        if (mail($to, $subject, $message, $headers)) {
            echo "Registration successful. A verification email has been sent to your email address. Please check your inbox.";
        } else {
            echo "Registration successful, but failed to send verification email.";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
