<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Consultation - Dental Clinic Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@tailwindcss/forms@0.3.4/dist/forms.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center text-blue-600 mb-2">E-Consultation</h1>
        <p class="text-center text-gray-600 mb-8">Please fill in the symptoms you are experiencing.</p>

        <form action="" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="symptoms">
                    Select your symptoms (choose 1-3):
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <?php
                    $symptoms = [
                        "toothache" => "Toothache",
                        "bleeding_gums" => "Bleeding Gums",
                        "bad_breath" => "Bad Breath",
                        "sensitive_teeth" => "Sensitive Teeth",
                        "swollen_gums" => "Swollen Gums",
                        "jaw_pain" => "Jaw Pain"
                    ];
                    foreach ($symptoms as $value => $label) {
                        echo '<div class="flex items-center">';
                        echo '<input class="form-checkbox h-5 w-5 text-blue-600" type="checkbox" name="symptoms[]" value="' . $value . '" id="' . $value . '">';
                        echo '<label class="ml-2 text-gray-700" for="' . $value . '">' . $label . '</label>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="duration">
                    How long have you been experiencing these symptoms?
                </label>
                <select class="form-select w-full" name="duration" required>
                    <option value="" disabled selected>Select Duration</option>
                    <option value="less_than_a_week">Less than a week</option>
                    <option value="1_week_to_1_month">1 week to 1 month</option>
                    <option value="more_than_1_month">More than 1 month</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="previous_visit">
                    Have you visited a dentist for this issue before?
                </label>
                <select class="form-select w-full" name="previous_visit" required>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Submit
                </button>
            </div>
        </form>

        <!-- Prescription Modal -->
        <div id="prescriptionModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Prescription
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500" id="prescriptionContent"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal()">
                            Close
                        </button>
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
                    $prescription = "Based on your symptoms, here are suggested treatments: <ul class='list-disc pl-5 mt-2'>";
                    foreach ($symptoms as $symptom) {
                        if (array_key_exists($symptom, $treatmentSuggestions)) {
                            $prescription .= "<li class='mb-1'>" . htmlspecialchars($treatmentSuggestions[$symptom]) . "</li>";
                        }
                    }
                    $prescription .= "</ul>";
                }

                // Prepare the prescription content for the modal
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var modalContent = document.getElementById('prescriptionContent');
                            modalContent.innerHTML = '" . addslashes($prescription) . "';
                            openModal();
                        });
                      </script>";
            }
        }
        ?>
    </div>

    <script>
        function openModal() {
            document.getElementById('prescriptionModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('prescriptionModal').classList.add('hidden');
        }
    </script>
</body>
</html>
<?php include 'includes/footer.php'; ?>