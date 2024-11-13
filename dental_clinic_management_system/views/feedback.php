<?php
include 'includes/header.php';
include '../config/db_config.php';

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $name = $_POST['name'];
    $email = $_POST['email'];
    $rating = intval($_POST['rating']);
    $feedback = $_POST['feedback'];

    // Prepare SQL query with placeholders
    $sql = "INSERT INTO feedback (name, email, rating, feedback) VALUES (:name, :email, :rating, :feedback)";
    
    // Prepare statement
    $stmt = $conn->prepare($sql);

    // Bind the parameters to the placeholders in the SQL query
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
    $stmt->bindParam(':feedback', $feedback, PDO::PARAM_STR);

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Redirect to avoid form resubmission
        header("Location: feedback.php?success=1");
        exit();
    } else {
        $message = "Error: " . $stmt->errorInfo()[2];  // Get the error message from PDO
    }
}

// Check if feedback was successfully submitted
if (isset($_GET['success'])) {
    $message = "Thank you for your feedback!";
}

// Pagination setup
$feedbackPerPage = 4;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $feedbackPerPage;

// Fetch the feedback data
$sql = "SELECT * FROM feedback ORDER BY created_at DESC LIMIT :offset, :limit";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':limit', $feedbackPerPage, PDO::PARAM_INT);
$stmt->execute();
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch the total number of feedbacks for pagination
$sqlTotal = "SELECT COUNT(*) FROM feedback";
$totalStmt = $conn->prepare($sqlTotal);
$totalStmt->execute();
$totalFeedbacks = $totalStmt->fetchColumn();
$totalPages = ceil($totalFeedbacks / $feedbackPerPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Clinic Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6f3ff;
        }
        .feedback-form {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #4da6ff;
            border-color: #4da6ff;
        }
        .btn-primary:hover {
            background-color: #1a8cff;
            border-color: #1a8cff;
        }
        .star-rating {
            font-size: 24px;
        }
        .star-rating .fa-star {
            color: #ffd700;
            cursor: pointer;
        }
        .feedback-list .feedback-item {
            background-color: #fff;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .feedback-list .feedback-item .rating {
            font-size: 20px;
        }
        .feedback-list .feedback-item .feedback-text {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="feedback-form p-4">
                    <h2 class="text-center mb-4">Dental Clinic Feedback</h2>
                    <?php if ($message): ?>
                        <div class="alert alert-success"><?php echo $message; ?></div>
                    <?php endif; ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <div class="star-rating">
                                <i class="far fa-star" data-rating="1"></i>
                                <i class="far fa-star" data-rating="2"></i>
                                <i class="far fa-star" data-rating="3"></i>
                                <i class="far fa-star" data-rating="4"></i>
                                <i class="far fa-star" data-rating="5"></i>
                            </div>
                            <input type="hidden" name="rating" id="rating" required>
                        </div>
                        <div class="mb-3">
                            <label for="feedback" class="form-label">Feedback</label>
                            <textarea class="form-control" id="feedback" name="feedback" rows="4" required></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit Feedback</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <h2 class="text-center mb-4">Recent Feedbacks</h2>
                <div class="feedback-list">
                    <?php foreach ($feedbacks as $feedback): ?>
                        <div class="feedback-item">
                            <div class="d-flex justify-content-between">
                                <h5><?php echo htmlspecialchars($feedback['name']); ?></h5>
                                <div class="rating">
                                    <?php for ($i = 0; $i < $feedback['rating']; $i++): ?>
                                        <i class="fas fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <p class="feedback-text"><?php echo nl2br(htmlspecialchars($feedback['feedback'])); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if ($totalPages > 1): ?>
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                            </li>
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star-rating .fa-star');
            const ratingInput = document.getElementById('rating');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = this.getAttribute('data-rating');
                    ratingInput.value = rating;
                    updateStars(rating);
                });

                star.addEventListener('mouseover', function() {
                    const rating = this.getAttribute('data-rating');
                    updateStars(rating);
                });
            });

            document.querySelector('.star-rating').addEventListener('mouseout', function() {
                updateStars(ratingInput.value);
            });

            function updateStars(rating) {
                stars.forEach(star => {
                    if (star.getAttribute('data-rating') <= rating) {
                        star.classList.add('fas');
                        star.classList.remove('far');
                    } else {
                        star.classList.add('far');
                        star.classList.remove('fas');
                    }
                });
            }
        });
    </script>
</body>
</html>
