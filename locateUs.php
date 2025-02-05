<?php
// Fetch latest notice from the database
include("dbFunctions.php");
$query = "SELECT notice FROM noticeboard ORDER BY id DESC LIMIT 1";
$result = mysqli_query($link, $query);
$notice = mysqli_fetch_assoc($result)['notice'] ?? 'No notices available.';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locate Us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">
        
        <style>
    .appointment-card {
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 15px;
      background-color: #fff;
    }

    .date-section {
      font-weight: bold;
      color: black;
    }

    .day-sect {
      font-weight: bold;
      color: red;
      
    }

    .btn-custom {
      border: 1px solid red;
      color: red;
    }

    .btn-custom:hover {
      background-color: red;
      color: white;
    }

    .nav-link.active {
      font-weight: bold;
      color: red !important;
    }
  </style>
</head>
<body>
    
    <!-- Navigation -->
  <div class="navbar">
    <div class="logo">LOGO</div>
    <div class="nav-links">
      <a href="dashboard.php">Home</a>
      <div class="separator"></div>
      <a href="#" class="active">Appointments</a>
      <div class="separator"></div>
      <a href="#">Medication</a>
    </div>
    <a href="bookAppt.php" class="button">
      <i class="icon">📅</i> Book Appointment
    </a>
    <i class="settings">⚙️</i>
  </div>
    
    <div class="container mt-5">
        <h2>Our Location</h2>
        <ul class="list-group">
            <li class="list-group-item"><strong>Postal Code:</strong> Singapore 760729</li>
            <li class="list-group-item"><strong>Street Number:</strong> #01-101 Yishun Street 71, Block 729</li>
            <li class="list-group-item"><strong>Email:</strong> <a href="mailto:contact@example.com">contact@example.com</a></li>
            <li class="list-group-item"><strong>Phone Number:</strong> +65 6257 0881</li>
        </ul>

        <h2 class="mt-4">Opening Hours</h2>
<ul class="list-group">
    <li class="list-group-item"><strong>Monday:</strong> Closed</li>
    <li class="list-group-item"><strong>Tuesday:</strong> 11:00 AM - 4:30 PM</li>
    <li class="list-group-item"><strong>Wednesday:</strong> 11:00 AM - 4:30 PM</li>
    <li class="list-group-item"><strong>Thursday:</strong> 11:00 AM - 4:30 PM</li>
    <li class="list-group-item"><strong>Friday:</strong> 11:00 AM - 4:30 PM</li>
    <li class="list-group-item"><strong>Saturday:</strong> 10:30 AM - 4:30 PM</li>
    <li class="list-group-item"><strong>Sunday:</strong> Closed</li>
</ul>

        <h2 class="mt-4">Noticeboard</h2>
        <div class="alert alert-info">
            <?php echo htmlspecialchars($notice); ?>
        </div>
    </div>
    
    <div class="mt-4 text-center">
    <h2>Our Location</h2>
    <div style="width: 600px; height: 300px; margin: 0 auto; border-radius: 10px; overflow: hidden; margin-bottom: 100px;">
        <iframe 
            width="100%" 
            height="100%" 
            frameborder="0" 
            style="border:0; border-radius: 10px;" 
            allowfullscreen 
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBRk2GM65wSQsSEKPVwQJyzw6_oTgHELFo&q=01-101+Yishun+Street+71,+Block+729,+Singapore+760729"
        ></iframe>
    </div>
</div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>

