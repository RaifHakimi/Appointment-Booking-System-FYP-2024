<!DOCTYPE html>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sin Nam Medical Hall</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Center the box with increased size */
        .center-box {
            max-width: 600px;
            /* Increased width */
            background-color: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .go-back {
            color: #8A3C3C;
            font-size: medium;
        }

        /* Full-width red banner */
        .banner {
            background-color: #8A3C3C;
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: bold;
            width: 100%;
        }

        /* Custom button styling */
        .btn-signup {
            background-color: #8A3C3C;
            color: white;
            border-radius: 20px;
        }

        .btn-login {
            color: #8A3C3C;
            border: 1px solid #8A3C3C;
            border-radius: 20px;
        }

        /* Style for gender buttons */
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

<body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <div class="center-box text-center">
        <!-- Full-Width Banner -->
        <div class="banner">
            SIN NAM MEDICAL HALL
        </div>

        <!-- Content inside the box with added padding -->
        <div class="p-5 "> <!-- Increased padding -->
            <h1 class="mb-3">Sign Up</h1>

            <!-- Input fields -->

            <form method="POST" action="doSignUp.php">
                <div class="row mb-3">
                    <div class="col">
                        <div class="d-flex justify-content-start">
                            <label for="name1" class="form-label">First Name*</label>
                        </div>
                        <input type="text" class="form-control text-border" id="name1" name="firstName" placeholder="Enter first name" required>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-start">
                            <label for="name2" class="form-label">Last Name*</label>
                        </div>
                        <input type="text" class="form-control text-border" id="name2" name="lastName" placeholder="Enter last name" required>
                    </div>
                </div>

                <!-- Gender selection -->
                <div class="mb-2">
                    <label class="form-label mb-1 d-flex justify-content-left">Gender*</label>
                    <div class="gender-buttons">
                        <button type="button" class="btn btn-gender" id="male" onclick="setGender('male')">Male</button>
                        <button type="button" class="btn btn-gender" id="female" onclick="setGender('female')">Female</button>
                    </div>
                    <!-- Hidden input for gender -->
                    <input type="hidden" id="gender" name="gender">
                </div>



                <!-- Phone Number -->
                <div class="col mb-2">
                    <div class="d-flex justify-content-start">
                        <label for="name1" class="form-label">Phone Number*</label>
                    </div>
                    <input type="text" class="form-control text-border" id="name1" name="phoneNumber" placeholder="Enter phone number" required>
                </div>

                <!-- Email -->
                <div class="col mb-3">
                    <div class="d-flex justify-content-start">
                        <label for="name1" class="form-label">Email*</label>
                    </div>
                    <input type="text" class="form-control text-border" id="name1" name="email" placeholder="Enter email" required>
                </div>

                <!-- Password -->
                <div class="col mb-3">
                    <div class="d-flex justify-content-start">
                        <label for="name1" class="form-label">Password</label>
                    </div>
                    <input type="text" class="form-control text-border" id="name1" name="password" placeholder="Enter password" required>
                </div>

                <!-- DOB -->
                <div class="mb-4">
                    <label class="form-label d-flex justify-content-left">Date of Birth</label>
                    <div class="row">
                        <div class="col">
                            <select class="form-select" id="day" name="day" required>
                                <option value="" disabled selected>Day</option>
                                <!-- Generate day options -->
                                <script>
                                    for (let day = 1; day <= 31; day++) {
                                        document.write(`<option value="${day}">${day}</option>`);
                                    }
                                </script>
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-select" id="month" name="month" required>
                                <option value="" disabled selected>Month</option>
                                <!-- Generate month options -->
                                <script>
                                    for (let month = 1; month <= 12; month++) {
                                        document.write(`<option value="${month}">${month}</option>`);
                                    }
                                </script>
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-select" id="year" name="year" required>
                                <option value="" disabled selected>Year</option>
                                <!-- Generate year options from 1900 to current year -->
                                <script>
                                    const currentYear = new Date().getFullYear();
                                    for (let year = currentYear; year >= 1900; year--) {
                                        document.write(`<option value="${year}">${year}</option>`);
                                    }
                                </script>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-4 d-grid gap-3">
                    <button class="btn-signup" type="submit">
                        Sign Up
                    </button>
                </div>


            </form>
            <div class="d-flex justify-content-center mt-4">
                <a href="index.php" class="go-back" >Go back</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript to handle gender button selection
        document.querySelectorAll('.btn-gender').forEach(button => {
            button.addEventListener('click', function() {
                // Remove 'selected' class from all buttons
                document.querySelectorAll('.btn-gender').forEach(btn => btn.classList.remove('selected'));
                // Add 'selected' class to the clicked button
                this.classList.add('selected');
            });
        });
    </script>
    <script>
    // JavaScript to handle setting gender value when a button is clicked
    function setGender(value) {
        document.getElementById('gender').value = value;
        // Update button selection style
        document.querySelectorAll('.btn-gender').forEach(button => {
            button.classList.remove('selected');
        });
        document.getElementById(value).classList.add('selected');
    }
</script>
</body>

</html>