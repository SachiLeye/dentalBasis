<?php
include '../config/db_config.php';

// Check if the appointment ID is set
if (isset($_GET['id'])) {
    // Get the appointment ID and ensure it's an integer
    $appointment_id = (int)$_GET['id'];

    // Prepare the SQL statement to update the appointment status
    $stmt = $conn->prepare("UPDATE appointments SET status = 'Approved' WHERE appointment_id = :id");
    $stmt->bindParam(':id', $appointment_id, PDO::PARAM_INT);

    // Execute the statement and check for errors
    if ($stmt->execute()) {
        // Optional: You can set a success message in the session
         $_SESSION['message'] = 'Appointment accepted successfully.';
    } else {
        // Optional: Handle execution errors
         $_SESSION['error'] = 'Failed to accept the appointment.';
    }
}

// Redirect back to manage appointments
header('Location: manage_appointments.php');
exit();
?>
