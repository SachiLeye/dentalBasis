<?php
session_start();
require_once __DIR__ . '/../config/db_config.php';

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user's appointments
$query = "SELECT a.*, s.service_name 
          FROM appointments a 
          LEFT JOIN services s ON a.service_id = s.service_id 
          WHERE a.patient_id = ? 
          ORDER BY a.appointment_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$appointments = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment History - Dental Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .appointment-card {
            transition: transform 0.2s;
        }
        .appointment-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Dental Clinic</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="appointment_history.php">Appointment History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h1 class="text-center mb-4">Your Appointment History</h1>
        
        <?php if (empty($appointments)): ?>
            <div class="alert alert-info" role="alert">
                You don't have any appointments yet.
            </div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach ($appointments as $appointment): ?>
                    <div class="col">
                        <div class="card h-100 appointment-card <?= $appointment['status'] === 'cancelled' ? 'border-danger' : 'border-success' ?>">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?= htmlspecialchars($appointment['service_name']) ?>
                                    <?php if ($appointment['status'] === 'cancelled'): ?>
                                        <span class="badge bg-danger float-end">Cancelled</span>
                                    <?php else: ?>
                                        <span class="badge bg-success float-end">Active</span>
                                    <?php endif; ?>
                                </h5>
                                <p class="card-text">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    <?= date('F j, Y', strtotime($appointment['appointment_date'])) ?>
                                </p>
                                <p class="card-text">
                                    <i class="fas fa-clock me-2"></i>
                                    <?= date('g:i A', strtotime($appointment['appointment_date'])) ?>
                                </p>
                                <?php if (!empty($appointment['notes'])): ?>
                                    <p class="card-text">
                                        <i class="fas fa-sticky-note me-2"></i>
                                        <?= htmlspecialchars($appointment['notes']) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <div class="card-footer bg-transparent">
                                <?php if ($appointment['status'] !== 'cancelled' && strtotime($appointment['appointment_date']) > time()): ?>
                                    <button class="btn btn-sm btn-outline-danger" onclick="cancelAppointment(<?= $appointment['appointment_id'] ?>)">
                                        Cancel Appointment
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function cancelAppointment(appointmentId) {
            if (confirm('Are you sure you want to cancel this appointment?')) {
                // Send AJAX request to cancel the appointment
                fetch('cancel_appointment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'appointment_id=' + appointmentId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Appointment cancelled successfully');
                        location.reload();
                    } else {
                        alert('Failed to cancel appointment');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while cancelling the appointment');
                });
            }
        }
    </script>
</body>
</html>