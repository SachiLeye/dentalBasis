<?php
session_start();
require_once '../config/db_config.php'; // Include the database configuration

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../views/login.php');
    exit();
}

if (isset($_GET['id'])) {
    $appointmentId = $_GET['id'];

    try {
        $stmt = $conn->prepare("UPDATE appointments SET status = 'Follow Up' WHERE appointment_id = ?");
        $stmt->execute([$appointmentId]);

        $_SESSION['message'] = "Appointment marked for Follow Up successfully!";
    } catch (PDOException $e) {
        $_SESSION['message'] = "Error marking appointment as Follow Up: " . $e->getMessage();
    }

    header('Location: manage_appointments.php');
    exit();
}