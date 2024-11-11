<?php
session_start();
require_once '../config/db_config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../views/login.php');
    exit();
}

$appointment_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($appointment_id === 0) {
    header('Location: appointments.php');
    exit();
}

// Fetch the current appointment details
$sql = "SELECT a.appointment_id, p.first_name, p.last_name, p.phone, p.email, a.appointment_date, s.service_name, a.status, a.service_id
        FROM appointments a
        JOIN patients p ON a.patient_id = p.patient_id
        JOIN services s ON a.service_id = s.service_id
        WHERE a.appointment_id = :appointment_id";
$query = $conn->prepare($sql);
$query->execute([':appointment_id' => $appointment_id]);
$appointment = $query->fetch(PDO::FETCH_ASSOC);

if (!$appointment) {
    header('Location: appointments.php');
    exit();
}

// Fetch available services
$services_query = $conn->query("SELECT service_id, service_name FROM services");
$services = $services_query->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission for updating the appointment
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $appointment_date = trim($_POST['appointment_date']);
    $service_id = (int)$_POST['service_id'];

    // Update the appointment in the database
    $update_sql = "UPDATE appointments a
                   JOIN patients p ON a.patient_id = p.patient_id
                   SET p.first_name = :first_name, p.last_name = :last_name, p.phone = :phone, p.email = :email,
                       a.appointment_date = :appointment_date, a.service_id = :service_id
                   WHERE a.appointment_id = :appointment_id";
    $update_query = $conn->prepare($update_sql);
    $update_query->execute([
        ':first_name' => $first_name,
        ':last_name' => $last_name,
        ':phone' => $phone,
        ':email' => $email,
        ':appointment_date' => $appointment_date,
        ':service_id' => $service_id,
        ':appointment_id' => $appointment_id
    ]);

    header('Location: manage_appointments.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Appointment - Dental Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include '../admin/includes/header.php'; ?>

    <div class="container mt-5">
        <h3>Edit Appointment</h3>
        <form method="POST">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($appointment['first_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($appointment['last_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Contact Number</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($appointment['phone']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($appointment['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="appointment_date" class="form-label">Appointment Date</label>
                <input type="datetime-local" class="form-control" id="appointment_date" name="appointment_date" value="<?php echo date('Y-m-d\TH:i', strtotime($appointment['appointment_date'])); ?>" required>
            </div>
            <div class="mb-3">
                <label for="service_id" class="form-label">Service</label>
                <select class="form-control" id="service_id" name="service_id" required>
                    <?php foreach ($services as $service): ?>
                        <option value="<?php echo $service['service_id']; ?>" <?php echo $service['service_id'] == $appointment['service_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($service['service_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="appointments.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
