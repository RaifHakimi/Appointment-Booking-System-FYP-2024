<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .password {
            position: relative;
        }

        .password input[type="password"] {
            width: 100%;
        }

        .password:hover input[type="password"] {
            display: none;
        }

        .password:hover input[type="text"] {
            display: inline;
        }

        .password input[type="text"] {
            display: none;
            width: 100%;
        }

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

        .btn-gender {
            flex: 1;
            /* Equal width */
            margin: 5px;
            /* Space between buttons */
            color: #8A3C3C;
            border: 1px solid #8A3C3C;

        }

        .btn-gender.selected {
            background-color: #8A3C3C;
            color: white;
        }

        .gender-buttons {
            display: flex;
            /* Flexbox for equal size */
        }

        .text-border {
            border: 1px solid #8A3C3C;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <div class="logo">LOGO</div>
        <div class="nav-links">
            <a href="dashboard.php">Home</a>
            <div class="separator"></div>
            <a href="appointment.php">Appointments</a>
            <div class="separator"></div>
            <a href="medication.php">Medication</a>
        </div>
        <a href="bookAppt.php" class="button">
            <i class="icon">📅</i> Book Appointment
        </a>
        <a href="settings.php">
            <i class="settings">⚙️</i>
        </a>
    </div>



    <h2 class="text-center pt-4">Settings</h2>
    <div class="container">
        <div class="center-box text-center">
            <div class="p-3">
                <!-- Action Buttons -->
                <div id="actionButtons" class="mb-3 d-flex justify-content-start">
                    <!-- Edit Button -->
                    <button type="button" class="btn btn-primary" id="editButton" onclick="startEdit()">Edit</button>

                    <!-- Save and Cancel Buttons (Initially Hidden) -->
                    <div id="saveCancelButtons" style="display: none;">
                        <button type="button" class="btn btn-success ms-2" id="saveButton" onclick="saveChanges()">Save Changes</button>
                        <button type="button" class="btn btn-danger ms-2" id="cancelButton" onclick="cancelChanges()">Cancel Changes</button>
                    </div>
                </div>

                <!-- Input fields -->
                <div class="row mb-3 g-2">
                    <div class="col-12 col-md-6">
                        <label for="firstName" class="form-label text-start d-block">First Name*</label>
                        <input type="text" class="form-control text-border" id="firstName" name="firstName" placeholder="Enter first name" required readonly>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="lastName" class="form-label text-start d-block">Last Name*</label>
                        <input type="text" class="form-control text-border" id="lastName" name="lastName" placeholder="Enter last name" required readonly>
                    </div>
                </div>

                <!-- Gender Display (Non-editable) -->
                <div class="mb-3">
                    <label class="form-label text-start">Gender*</label>
                    <input type="text" class="form-control text-border" id="gender" name="gender" required readonly>
                </div>

                <!-- Phone Number -->
                <div class="mb-3">
                    <label for="phoneNumber" class="form-label text-start">Phone Number*</label>
                    <input type="text" class="form-control text-border" id="phoneNumber" name="phoneNumber" placeholder="Enter phone number" required readonly>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label text-start">Email*</label>
                    <input type="text" class="form-control text-border" id="email" name="email" placeholder="Enter email" required readonly>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Button -->
    <form action="logout.php" method="post" id="logoutForm">
        <button type="button" class="btn btn-secondary position-fixed" style="bottom: 20px; right: 20px; padding: 10px 20px;" onclick="confirmLogout()">Log Out</button>
    </form>

    <script>
        // Set all inputs and buttons to readonly/disabled mode initially
        window.onload = function() {
            toggleInputs(false);
            // Load the gender from the database and populate the input
            loadGender();
        };

        function startEdit() {
            document.getElementById('editButton').style.display = 'none';
            document.getElementById('saveCancelButtons').style.display = 'inline';
            toggleInputs(true);
        }

        function saveChanges() {
            alert('Changes have been saved!');
            document.getElementById('saveCancelButtons').style.display = 'none';
            document.getElementById('editButton').style.display = 'inline';
            toggleInputs(false);
            // You can add an AJAX call here to save the changes to the database
        }

        function cancelChanges() {
            alert('Changes have been canceled.');
            document.getElementById('saveCancelButtons').style.display = 'none';
            document.getElementById('editButton').style.display = 'inline';
            toggleInputs(false);
            // Optionally, reload the form to revert changes
            // location.reload();
        }

        function toggleInputs(enable) {
            const inputs = document.querySelectorAll('input, select');
            inputs.forEach(input => {
                // Only enable the fields that are not gender
                

                if (input.id !== 'gender') {
                    input.readOnly = !enable;
                    input.disabled = !enable;
                }


            });
        }

        function confirmLogout() {
            if (confirm('Are you sure you want to log out?')) {
                document.getElementById('logoutForm').submit();
            }
        }

        // Example function to load gender from SQL (this is a placeholder for actual SQL interaction)
        function loadGender() {
            // You would replace this with an actual AJAX call to retrieve gender from the database
            // For now, we'll just simulate that the user is "male"
            const genderFromDB = "Male"; // Simulate pulling this value from the database
            document.getElementById('gender').value = genderFromDB;
        }
    </script>



</body>

</html>