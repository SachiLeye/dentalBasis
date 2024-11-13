<?php
// Include the header and database configuration
include 'includes/header.php';
include '../config/db_config.php';

// Fetch all feedbacks from the database
$sql = "SELECT * FROM feedback ORDER BY created_at DESC"; // Assuming you have a created_at column for sorting
$stmt = $conn->prepare($sql);
$stmt->execute();
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Feedbacks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
        }
        .feedback-list {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .feedback-item {
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }
        .feedback-item:last-child {
            border-bottom: none;
        }
        .feedback-header {
            font-weight: bold;
            font-size: 18px;
        }
        .feedback-date {
            font-size: 12px;
            color: #888;
        }
        .feedback-rating {
            font-size: 16px;
            color: #ffd700;
        }
        .feedback-body {
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="feedback-list">
                    <h3 class="text-center mb-4">All Feedbacks</h3>

                    <?php if (count($feedbacks) > 0): ?>
                        <?php foreach ($feedbacks as $feedback): ?>
                            <div class="feedback-item">
                                <div class="feedback-header">
                                    <span><?php echo htmlspecialchars($feedback['name']); ?></span>
                                    <span class="feedback-date"><?php echo date('F j, Y, g:i a', strtotime($feedback['created_at'])); ?></span>
                                </div>
                                <div class="feedback-rating">
                                    <?php 
                                    for ($i = 0; $i < $feedback['rating']; $i++) {
                                        echo '<i class="fas fa-star"></i>';
                                    }
                                    for ($i = $feedback['rating']; $i < 5; $i++) {
                                        echo '<i class="far fa-star"></i>';
                                    }
                                    ?>
                                </div>
                                <div class="feedback-body">
                                    <p><?php echo nl2br(htmlspecialchars($feedback['feedback'])); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-info">No feedbacks found.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
