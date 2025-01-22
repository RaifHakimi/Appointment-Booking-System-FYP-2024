<!DOCTYPE html>
<?php
session_start();
include("dbFunctions.php");

// Fetch today's appointments
$date = date("Y-m-d"); // Get today's date
$stmt = $link->prepare("SELECT * FROM appointment WHERE appt_date = ?");
$stmt->bind_param('s', $date);
$stmt->execute();
$appointments = $stmt->get_result()
?>
<html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Schedule</title>
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

        .btn-custom {
      border: 1px solid red;
      color: red;
    }
    .btn-custom:hover {
      background-color: red;
      color: white;
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
        
        
    </style>
        
    </head>
    <body>
        <!-- Navigation -->
    <div class="navbar">
        <div class="logo">LOGO</div>
        <div class="nav-links">
            
            
            <a href="appointment.php">Appointments</a>
            <div class="separator"></div>
            <a href="medication.php">Medication</a>
        </div>
        </div>
        
        <i class="settings">⚙️</i>
    <div class="container mt-5">
    <h3>Appointments for Today</h3>
    <div id="appointments-list">
        <?php
        if (empty($appointments)) {
    echo "<p>No appointments for today.</p>";
} else {
    foreach ($appointments as $app) {
        echo "
        <div class='appointment-card color-bar-wrapper'>
            <div class='d-flex'>
                <div class='date-section text-center me-3'>
                    <div>" . date("m", strtotime($app['appt_date'])) . "<br>" . date("Y", strtotime($app['appt_date'])) . "</div>
                    <div class='fs-1'>" . date("d", strtotime($app['appt_date'])) . "</div>
                    <div>" . strtoupper(date("D", strtotime($app['appt_date']))) . "</div>
                </div>
                <div class='flex-grow-1'>
                    <h5>Doctor Consult</h5>
                    <p>Booked for <span class='text-muted'>{$app['user_id']}</span></p>
                    <p class='text-danger'>{$app['appt_time']}</p>
                    
                </div>
                <div class='d-flex flex-column'>
                    <a href='details.php' class='btn btn-custom mb-2'>Details</a>
                    <button class='btn btn-custom'>Medicine/Mark as Completed</button>
                </div>
            </div>
        </div>
        ";
    }
}
?>
</div>
    </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
