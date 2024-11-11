<?php
session_start();
require_once '../config/db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $contact_number = trim($_POST['contact_number']);
    $concern_type = $_POST['concern_type'];
    $concerns = trim($_POST['concerns']);

    if (!empty($full_name) && !empty($email) && !empty($contact_number) && !empty($concerns)) {
        // Prepare SQL query to insert message into the database
        $sql = "INSERT INTO messages (full_name, email, contact_number, concern_type, concerns, created_at) 
                VALUES (:full_name, :email, :contact_number, :concern_type, :concerns, NOW())";
        $stmt = $conn->prepare($sql);

        // Execute the query with parameters
        if ($stmt->execute([':full_name' => $full_name, ':email' => $email, ':contact_number' => $contact_number, ':concern_type' => $concern_type, ':concerns' => $concerns])) {
            $_SESSION['message'] = "Your message has been sent successfully.";
        } else {
            $_SESSION['error'] = "An error occurred. Please try again.";
        }
    } else {
        $_SESSION['error'] = "Please fill in all fields.";
    }

    header('Location: index.php');
    exit();
}
?>
