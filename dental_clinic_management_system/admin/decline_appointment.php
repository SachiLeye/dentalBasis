<?php
include '../config/db_config.php';

// Check if the appointment ID is set
if (isset($_GET['id'])) {
    $appointment_id = (int)$_GET['id']; // Cast to integer for safety

    // Update the appointment status to 'Declined'
    $stmt = $conn->prepare("UPDATE appointments SET status = 'Declined' WHERE appointment_id = :id");
    $stmt->bindParam(':id', $appointment_id);
    
    if ($stmt->execute()) {
        // Optionally, you can add a success message to session or log it
        $_SESSION['message'] = 'Appointment has been declined successfully.';
    } else {
        // Handle the error case, e.g., log the error or show an error message
        $_SESSION['error'] = 'Error declining appointment. Please try again.';
    }
}

// Redirect back to manage appointments
header('Location: manage_appointments.php');
exit();
?>
