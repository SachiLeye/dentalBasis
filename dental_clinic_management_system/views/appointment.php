<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'includes/header.php';
include '../config/db_config.php';

// Fetch available services for the dropdown
try {
    $serviceStmt = $conn->prepare("SELECT * FROM services");
    $serviceStmt->execute();
    $services = $serviceStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching services: " . htmlspecialchars($e->getMessage());
    exit();
}

// Get booked dates with the number of appointments
$bookedDates = [];
try {
    $dateStmt = $conn->prepare("SELECT DATE(appointment_date) as date, COUNT(*) as count FROM appointments GROUP BY DATE(appointment_date)");
    $dateStmt->execute();
    $dates = $dateStmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($dates as $date) {
        if ($date['count'] >= 3) {
            $bookedDates[] = $date['date'];
        }
    }
} catch (PDOException $e) {
    echo "Error fetching appointment dates: " . htmlspecialchars($e->getMessage());
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user input
    $firstName = htmlspecialchars(trim($_POST['first_name']));
    $lastName = htmlspecialchars(trim($_POST['last_name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $appointmentDate = htmlspecialchars(trim($_POST['appointment_date']));
    $serviceId = intval($_POST['service_id']);

    // Validate time selection
    $appointmentTime = date('H:i', strtotime($appointmentDate));
    $dayOfWeek = date('w', strtotime($appointmentDate));

    if ($dayOfWeek == 0) {
        $errorMessage = "Appointments cannot be booked on Sundays. Please select another day.";
    } elseif (
        ($appointmentTime >= '08:00' && $appointmentTime <= '11:00') ||
        ($appointmentTime >= '13:00' && $appointmentTime <= '17:00')
    ) {
        // Check if the selected date already has three appointments
        try {
            $checkStmt = $conn->prepare("SELECT COUNT(*) as count FROM appointments WHERE DATE(appointment_date) = DATE(?)");
            $checkStmt->execute([$appointmentDate]);
            $appointmentCount = $checkStmt->fetch(PDO::FETCH_ASSOC)['count'];

            if ($appointmentCount >= 3) {
                $errorMessage = "This date is fully booked. Please choose another date.";
            } else {
                // Proceed with the booking
                $stmt = $conn->prepare("INSERT INTO patients (first_name, last_name, email, phone) VALUES (?, ?, ?, ?)");
                $stmt->execute([$firstName, $lastName, $email, $phone]);

                $patientId = $conn->lastInsertId();

                // Insert appointment with the selected service
                $stmt = $conn->prepare("INSERT INTO appointments (patient_id, appointment_date, service_id) VALUES (?, ?, ?)");
                $stmt->execute([$patientId, $appointmentDate, $serviceId]);

                $successMessage = "Appointment successfully booked!";
            }
        } catch (PDOException $e) {
            $errorMessage = "Error booking appointment: " . htmlspecialchars($e->getMessage());
        }
    } else {
        $errorMessage = "Please select a time between 8 AM - 11 AM or 1 PM - 5 PM.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book an Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Book an Appointment</h2>
        
        <?php if (isset($errorMessage)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p><?php echo $errorMessage; ?></p>
            </div>
        <?php endif; ?>

        <?php if (isset($successMessage)): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p><?php echo $successMessage; ?></p>
            </div>
        <?php endif; ?>

        <form method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="first_name">
                    First Name
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="first_name" name="first_name" type="text" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="last_name">
                    Last Name
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="last_name" name="last_name" type="text" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" type="email" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">
                    Phone
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="phone" name="phone" type="tel" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="appointment_date">
                    Appointment Date
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="appointment_date" name="appointment_date" type="text" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="service_id">
                    Select Service
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="service_id" name="service_id" required>
                    <option value="" disabled selected>Select a service</option>
                    <?php foreach ($services as $service) : ?>
                        <option value="<?= htmlspecialchars($service['service_id']); ?>"><?= htmlspecialchars($service['service_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Book Appointment
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const bookedDates = <?= json_encode($bookedDates); ?>;
            const appointmentDateInput = document.getElementById('appointment_date');
            
            flatpickr(appointmentDateInput, {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                minDate: "today",
                maxDate: new Date().fp_incr(30), // Allow booking up to 30 days in advance
                disable: [
                    function(date) {
                        // Disable Sundays
                        return date.getDay() === 0;
                    },
                    ...bookedDates
                ],
                locale: {
                    firstDayOfWeek: 1 // Start week on Monday
                },
                time_24hr: true,
                minTime: "08:00",
                maxTime: "17:00",
                onChange: function(selectedDates, dateStr, instance) {
                    const selectedTime = selectedDates[0].getHours();
                    if ((selectedTime >= 8 && selectedTime < 11) || (selectedTime >= 13 && selectedTime < 17)) {
                        // Time is within allowed range
                        return;
                    } else {
                        alert('Please select a time between 8 AM - 11 AM or 1 PM - 5 PM.');
                        instance.clear();
                    }
                }
            });
        });
    </script>
</body>
</html>

<?php include 'includes/footer.php'; ?>