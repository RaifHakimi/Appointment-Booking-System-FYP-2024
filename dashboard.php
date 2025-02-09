<html lang="en">
<?php

/**
 * File created by Raif\
 * 
 * Use to view dashboard for Patients
 */

session_start();

/**echo "<pre>";
print_r($_SESSION); // Outputs session data
echo "</pre>";
**/


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .appointment-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            
            background-color: white;
        }

        .date-section {
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


        .color-bar-wrapper {
            background: linear-gradient(to right, grey, grey);
            /* Left-to-right color gradient */
            padding: 5px;
            /* Spacing to show the color bar around the card */
            border-radius: 12px;
            /* Rounded corners for the color bar */
            position: relative;
        }
        
        .help-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: red;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        transition: background-color 0.3s ease;
    }

    .help-button:hover {
        background-color: darkred;
    }
    </style>



</head>

<body>

    <!-- Navigation -->
    <div class="navbar">

        <div class="logo">LOGO</div>
        <div class="nav-links">
            <a href="dashboard.php" class="active">Home</a>
            <div class="separator"></div>
            <a href="appointment.php">Appointments</a>
            <div class="separator"></div>
            <a href="locateUs.php">Locate Us</a>
        </div>
        <a href="bookAppt.php" class="button">
            <i class="icon">📅</i> Book Appointment
        </a>
        <a href="settings.php" class="button">
        <i class="settings">⚙️</i>
        </a>
    </div>

    <!-- Main Content -->
    <div class="container mt-4">
        <h3 class="text-center">Dashboard</h3>

        <!-- Appointment Cards -->
        <h3 class="justify-align-left">Welcome <?php echo ($_SESSION['username']) ?></h3>
        <div class="color-bar-wrapper">
            <div class="appointment-card d-flex">
                <div class="date-section text-center me-3">
                    <div>OCT<br>2024</div>
                    <div class="fs-1">18</div>
                    <div>FRI</div>
                </div>
                <div class="flex-grow-1">
                    <h5>Doctor Consult</h5>
                    <p>Booked for <span class="text-muted">[Name]</span></p>
                    <p class="text-danger">5:58 PM</p>
                    <p>Dr. Heisenberg</p>
                </div>
                <div class="d-flex flex-column">
                    <button class="btn btn-custom mb-2">Reschedule</button>
                    <button class="btn btn-custom">Cancel</button>
                </div>
            </div>
        </div>
        <!-- Duplicate appointment card for other dates -->


<a href="helpFAQ.php" class="help-button">Get Help</a>



    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>