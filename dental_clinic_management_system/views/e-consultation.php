<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Consultation - Dental Clinic Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet"> <!-- Custom CSS -->
</head>
<body>

    <div class="container mt-5">
        <h1 class="text-center">E-Consultation</h1>
        <p class="text-center">Please fill in the symptoms you are experiencing.</p>

        <form action="" method="POST">
            <div class="mb-3">
                <label for="symptoms" class="form-label">Select your symptoms (choose 1-3):</label>
                <div>
                    <input type="checkbox" name="symptoms[]" value="toothache"> Toothache <br>
                    <input type="checkbox" name="symptoms[]" value="bleeding_gums"> Bleeding Gums <br>
                    <input type="checkbox" name="symptoms[]" value="bad_breath"> Bad Breath <br>
                    <input type="checkbox" name="symptoms[]" value="sensitive_teeth"> Sensitive Teeth <br>
                    <input type="checkbox" name="symptoms[]" value="swollen_gums"> Swollen Gums <br>
                    <input type="checkbox" name="symptoms[]" value="jaw_pain"> Jaw Pain <br>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">How long have you been experiencing these symptoms?</label>
                <select class="form-select" name="duration" required>
                    <option value="" disabled selected>Select Duration</option>
                    <option value="less_than_a_week">Less than a week</option>
                    <option value="1_week_to_1_month">1 week to 1 month</option>
                    <option value="more_than_1_month">More than 1 month</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Have you visited a dentist for this issue before?</label>
                <select class="form-select" name="previous_visit" required>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <!-- Prescription Modal -->
        <div class="modal fade" id="prescriptionModal" tabindex="-1" aria-labelledby="prescriptionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="prescriptionModalLabel">Prescription</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="prescriptionContent">
                        <!-- Prescription content will be injected here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $symptoms = $_POST['symptoms'] ?? [];
            $duration = $_POST['duration'];
            $previousVisit = $_POST['previous_visit'];

            $needsPhysicalVisit = false;
            $prescription = "";

            // Define treatment suggestions for each symptom
            $treatmentSuggestions = [
                "toothache" => "Over-the-counter pain relievers, saltwater rinse.",
                "bleeding_gums" => "Saltwater rinse, maintain good oral hygiene.",
                "bad_breath" => "Regular brushing, flossing, and mouthwash.",
                "sensitive_teeth" => "Desensitizing toothpaste, avoid acidic foods.",
                "swollen_gums" => "Warm saltwater rinse, over-the-counter pain relief.",
                "jaw_pain" => "Cold compress, pain relievers, jaw exercises.",
            ];

            // Decision-making process
            if (count($symptoms) > 0) {
                if ($duration == "more_than_1_month" || $previousVisit == "no") {
                    $needsPhysicalVisit = true;
                    $prescription = "Please visit us for a thorough examination. Our clinic is located at Gozar Street, Barangay Camilmil, Calapan City Oriental Mindoro, 5200";
                } else {
                    $prescription = "Based on your symptoms, here are suggested treatments: <ul>";
                    foreach ($symptoms as $symptom) {
                        if (array_key_exists($symptom, $treatmentSuggestions)) {
                            $prescription .= "<li>" . htmlspecialchars($treatmentSuggestions[$symptom]) . "</li>";
                        }
                    }
                    $prescription .= "</ul>";
                }

                // Prepare the prescription content for the modal
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var modalContent = document.getElementById('prescriptionContent');
                            modalContent.innerHTML = '" . addslashes($prescription) . "';
                            var modal = new bootstrap.Modal(document.getElementById('prescriptionModal'));
                            modal.show();
                        });
                      </script>";
            }
        }
        ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include 'includes/footer.php'; ?>
