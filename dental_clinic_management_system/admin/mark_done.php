<?php
session_start();
require_once '../config/db_config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../views/login.php');
    exit();
}

if (isset($_GET['id'])) {
    $appointmentId = $_GET['id'];

    try {
        $stmt = $conn->prepare("UPDATE appointments SET status = 'Done' WHERE appointment_id = ?");
        $stmt->execute([$appointmentId]);

        $_SESSION['message'] = "Appointment marked as Done successfully!";
    } catch (PDOException $e) {
        $_SESSION['message'] = "Error marking appointment as Done: " . $e->getMessage();
    }

    header('Location: manage_appointments.php');
    exit();
}
