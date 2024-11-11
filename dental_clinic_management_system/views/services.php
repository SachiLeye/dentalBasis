<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - Dental Clinic Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet"> 
    <style>
        /* Set uniform size and style for the card images */
        .card-img-top {
            width: 100%;
            height: 200px; 
            object-fit: cover; 
        }
        
        .book-now-btn {
            font-size: 1.5rem;
            padding: 15px 30px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            text-transform: uppercase;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .book-now-btn:hover {
            background-color: #0056b3;
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <h1 class="text-center display-4">Our Dental Services</h1>
        <p class="text-center lead">We offer a comprehensive range of dental services to meet all your oral health needs.</p>
        
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">
            <!-- Dental Checkup -->
            <div class="col">
                <div class="card h-100 mb-4 shadow-sm">
                    <img src="../assets/images/Dental1.jpg" class="card-img-top" alt="Dental Checkup">
                    <div class="card-body">
                        <h5 class="card-title">Dental Checkup</h5>
                        <p class="card-text">Comprehensive dental checkups to ensure optimal oral health.</p>
                    </div>
                </div>
            </div>
            <!-- Teeth Cleaning -->
            <div class="col">
                <div class="card h-100 mb-4 shadow-sm">
                    <img src="../assets/images/cleaning.jpg" class="card-img-top" alt="Teeth Cleaning">
                    <div class="card-body">
                        <h5 class="card-title">Teeth Cleaning</h5>
                        <p class="card-text">Professional teeth cleaning to remove plaque and tartar buildup.</p>
                    </div>
                </div>
            </div>
            

            <div class="col">
                <div class="card h-100 mb-4 shadow-sm">
                    <img src="../assets/images/filling.jpg" class="card-img-top" alt="Filling">
                    <div class="card-body">
                        <h5 class="card-title">Filling</h5>
                        <p class="card-text">Restorative fillings to repair cavities and restore tooth function.</p>
                    </div>
                </div>
            </div>
            

            <div class="col">
                <div class="card h-100 mb-4 shadow-sm">
                    <img src="../assets/images/rootcanal.jpg" class="card-img-top" alt="Root Canal Treatment">
                    <div class="card-body">
                        <h5 class="card-title">Root Canal Treatment</h5>
                        <p class="card-text">Endodontic treatment to save and preserve your natural tooth.</p>
                    </div>
                </div>
            </div>
            

            <div class="col">
                <div class="card h-100 mb-4 shadow-sm">
                    <img src="../assets/images/dental2.jpg" class="card-img-top" alt="Teeth Whitening">
                    <div class="card-body">
                        <h5 class="card-title">Teeth Whitening</h5>
                        <p class="card-text">Effective whitening treatments for a brighter, whiter smile.</p>
                    </div>
                </div>
            </div>
            


            <div class="col">
                <div class="card h-100 mb-4 shadow-sm">
                    <img src="../assets/images/ortho.jpg" class="card-img-top" alt="Orthodontics">
                    <div class="card-body">
                        <h5 class="card-title">Orthodontics</h5>
                        <p class="card-text">Corrective orthodontic treatments to straighten teeth and improve bite.</p>
                    </div>
                </div>
            </div>
            

            <div class="col">
                <div class="card h-100 mb-4 shadow-sm">
                    <img src="../assets/images/extraction.jpg" class="card-img-top" alt="Extraction">
                    <div class="card-body">
                        <h5 class="card-title">Extraction</h5>
                        <p class="card-text">Safe and painless extractions for problematic or damaged teeth.</p>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
            <a href="../views/appointment.php" class="book-now-btn">BOOK NOW</a>
        </div>
    </div>
    <div class="text-center mt-5">
            <h2>Contact Us</h2>
            <p>If you have any questions, call us at <strong>0930 195 2054</strong> or visit our clinic at Gozar Street, Camilmil, Calapan City.</p>
        </div>
        </div>


        

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include 'includes/footer.php'; ?>
