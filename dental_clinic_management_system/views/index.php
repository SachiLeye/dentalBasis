<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Dental Clinic Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet"> <!-- Custom CSS -->
    <style>
        /* Ensures all cards are the same size */
        .card {
            height: 100%;
        }

        /* Ensures the images fit and stretch inside the card */
        .card-img-top {
            height: 250px; /* Fixed height for images */
            object-fit: cover; /* Stretch the image to cover the area */
        }

        /* Optional: Set a fixed height for card bodies */
        .card-body {
            min-height: 150px; /* Ensure the text area is consistent */
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <h1 class="text-center">Welcome to Our Dental Clinic</h1>
        <p class="text-center">Your health and smile are our top priorities.</p>
        
        <div class="text-center">
            <a href="appointment.php" class="btn btn-primary btn-lg">Book an Appointment</a>
        </div>

        <h2 class="mt-5 text-center">Our Services</h2>
        <div class="row text-center">
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="../assets/images/dental2.jpg" class="card-img-top" alt="Whitening service">
                    <div class="card-body">
                        <h5 class="card-title">Whitens</h5>
                        <p class="card-text">Professional cleaning to maintain your oral health.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="../assets/images/dental3.jpg" class="card-img-top" alt="Filling service">
                    <div class="card-body">
                        <h5 class="card-title">Saving</h5>
                        <p class="card-text">Restore your teeth with high-quality filling materials.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="../assets/images/Dental1.jpg" class="card-img-top" alt="Whitening treatment">
                    <div class="card-body">
                        <h5 class="card-title">Equipped</h5>
                        <p class="card-text">Get a brighter smile with our whitening treatments.</p>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mt-5 text-center">What Our Patients Say</h2>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <p class="card-text">"The staff are incredibly friendly and professional! I always feel at ease during my visits."</p>
                        <h5 class="card-title">- Sarah T.</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <p class="card-text">"I had a great experience! The treatments were quick and painless."</p>
                        <h5 class="card-title">- John D.</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <p class="card-text">"Highly recommend this clinic! They really care about their patients."</p>
                        <h5 class="card-title">- Emily R.</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <h2>Contact Us</h2>
            <p>For inquiries, call us at <strong>0930 195 2054</strong> or visit us at our clinic.</p>
            
            <form action="submit_message.php" method="POST" class="mt-4">
    <h1>Send a Message</h1>
    <div class="mb-3">
        <input type="text" name="full_name" class="form-control" placeholder="Full Name" required>
    </div>
    <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email Address" required>
    </div>
    <div class="mb-3">
        <input type="text" name="contact_number" class="form-control" placeholder="Contact Number" required>
    </div>
    <div class="mb-3">
        <label for="concern_type" class="form-label">Concern Type</label>
        <select name="concern_type" class="form-select" id="concern_type" required>
            <option value="" disabled selected>Select Concern Type</option>
            <option value="reschedule">Reschedule</option>
            <option value="cancel">Cancel</option>
            <option value="inquiry">Inquiry</option>
            <option value="other">Other</option>
        </select>
    </div>
    <div class="mb-3">
        <textarea name="concerns" class="form-control" rows="4" placeholder="Your Concerns" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Send Message</button>
</form>


        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include 'includes/footer.php'; ?>
