<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Patients</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        header .logo {
            font-size: 24px;
            font-weight: bold;
        }

        header nav {
            display: flex;
            gap: 20px;
        }

        header nav a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
        }

        header nav a:hover {
            text-decoration: underline;
        }

        .container {
            padding: 20px;
        }

        .search-bar {
            margin-bottom: 20px;
        }

        .search-bar input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .patient-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .patient-card {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .patient-card h3 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }

        .patient-card p {
            margin: 5px 0;
            color: #666;
        }

        .patient-card button {
            background-color: #b00;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 15px;
            cursor: pointer;
            margin-top: 10px;
        }

        .patient-card button:hover {
            background-color: #900;
        }
    </style>
    <div class="navbar">
        <div class="logo">LOGO</div>
        <div class="nav-links">
            <a href="viewAllPatients.php" class="active">Patients</a>
            <div class="separator"></div>
            <a href="adminApptView.php">Appointments</a>
            <div class="separator"></div>
            <a href="medication.php">Medication</a>
        </div>
        <a href="adminApptView.php" class="button">
            <i class="icon">📅</i> Book Appointment
        </a>
        <a href="settings.php" class="button">
            <i class="settings">⚙️</i>
        </a>
    </div>

    <div class="container">
        <div class="search-bar">
            <input type="text" placeholder="Search for patient’s name">
        </div>
        <div class="patient-grid">
            <?php
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbName = "sinnamdb";

            $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch patients
            $sql = "SELECT user_id, username, dob FROM users WHERE role = 'patient'";
            $result = $conn->query($sql);

            // Display patients
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $name = htmlspecialchars($row['username']);
                    $userId = htmlspecialchars($row['user_id']);
                    $dob = htmlspecialchars($row['dob']);
                    echo "<div class='patient-card'>";
                    echo "<h3>$name</h3>";
                    echo "<p>DOB: $dob</p>";
                    echo "<button onclick=\"location.href='viewPatientDetails.php?user_id=$userId'\">View Details</button>";
                    echo "</div>";
                }
            } else {
                echo "<p>No patients registered.</p>";
            }

            // Close connection
            $conn->close();
            ?>
        </div>
    </div>
    </body>

</html>