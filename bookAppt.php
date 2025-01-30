<?php
/**
 * File created by Raif
 */
?>
<!DOCTYPE html>
<html lang="en">

<?php
session_start();

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='style.css' rel="stylesheet">
    <style>
        .selected {
            background-color: #6c757d !important;
            color: #fff !important;
        }

        .card-body {
            padding: 0.5rem;
        }

        .btn-time,
        .btn-date {
            width: 100%;
            height: 60px;
        }

        .empty {
            visibility: hidden;
        }

        .date-cell {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .disabled-date {
            pointer-events: none;
            opacity: 0.5;
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
            <a href="appointment.php">Appointments</a>
            <div class="separator"></div>
            <a href="medication.php">Medication</a>
        </div>
        <a href="#" class="button">
            <i class="icon">📅</i> Book Appointment
        </a>
        <i class="settings">⚙️</i>
    </div>

    <div class="container mt-5">
        <h1 class="text-center mb-4"><b>Select Date & Time</b></h1>

        <!-- Month Navigation with Arrows -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <button id="prev-month" class="btn btn-outline-secondary">&#8592; Previous</button>
            <h4 id="month-name"><?php echo date("F Y"); ?></h4>
            <button id="next-month" class="btn btn-outline-secondary">Next &#8594;</button>
        </div>

        <div class="row">
            <!-- Date Picker -->
            <div class="col-md-6">
                <h4><b>Date</b></h4>
                <div class="container" id="date-grid">
                    <!-- Dates will be dynamically added here -->
                </div>
            </div>

            <!-- Time Picker -->
            <div class="col-md-6">
                <h4><b>Time</b></h4>
                <div class="row row-cols-2 g-2" id="time-grid">
                    <!-- Times will be dynamically added here -->
                </div>
            </div>
        </div>

        <!-- Appointment Details -->
        <div class="mt-4">
            <h4><b>Details</b></h4>
            <div class="mb-3">
                <label for="reason" class="form-label">State reason for appointment</label>
                <select class="form-select" id="reason">
                    <option value="">Select a reason</option>
                    <option value="consultation">Consultation</option>
                    <option value="checkup">Checkup</option>
                    <option value="treatment">Treatment</option>
                </select>
            </div>
            <div class="mb-3">
                <textarea class="form-control" id="additional-details" rows="4" placeholder="Add any additional details here"></textarea>
            </div>
            <button class="btn btn-danger btn-lg mb-4" id="book-btn">Book</button>
            <div class="mb-4"></div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Assuming currentDate is defined globally or earlier in your script
        let currentDate = new Date();
        let displayedMonth = currentDate.getMonth(); // Current month

        // Function to update the calendar
        function updateCalendar() {
            const dateGrid = document.getElementById('date-grid');
            const monthName = currentDate.toLocaleString('default', {
                month: 'long',
                year: 'numeric'
            });
            document.getElementById('month-name').textContent = monthName;

            const daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();
            const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();

            // Calculate total slots needed (6 rows, 7 columns)
            const totalSlots = 42;
            const dateSlots = [];
            let dayCount = 1;

            // Get today's date
            const today = new Date();
            today.setHours(0, 0, 0, 0); // Set time to 00:00:00 for comparison

            // Fill dateSlots with date buttons, starting from the first day of the month
            for (let i = 0; i < totalSlots; i++) {
                const col = document.createElement('div');
                col.className = 'col';

                if (i >= firstDayOfMonth && dayCount <= daysInMonth) {
                    const dateButton = document.createElement('button');
                    dateButton.className = 'btn btn-outline-secondary btn-date';
                    dateButton.textContent = dayCount;

                    // Create a Date object for the current day being created
                    const dateToCompare = new Date(currentDate.getFullYear(), currentDate.getMonth(), dayCount);

                    // Disable past dates (i.e., dates earlier than today)
                    if (dateToCompare < today) {
                        dateButton.classList.add('disabled-date');
                    }

                    dateButton.addEventListener('click', () => {
                        if (!dateButton.classList.contains('disabled-date')) {
                            // Remove 'selected' class from all other buttons
                            document.querySelectorAll('.btn-date').forEach(el => el.classList.remove('selected'));
                            dateButton.classList.add('selected');

                            // Get the clicked date details
                            const selectedDay = parseInt(dateButton.textContent); // The day number
                            const selectedMonth = currentDate.getMonth(); // Current month index (0-based)
                            const selectedYear = currentDate.getFullYear(); // Year

                            // Create a Date object for the selected date
                            const selectedDate = new Date(selectedYear, selectedMonth, selectedDay);

                            // Format the date as YYYY-MM-DD (for example: "2024-11-30")
                            const formattedDate = selectedDate.toISOString().split('T')[0]; // Output: "2024-11-30"

                            // Output the full date for debugging (you can remove this later)
                            console.log(`Formatted date: ${formattedDate}`);

                            // Now append the full date to the formData
                            formData.append('date', formattedDate); // Send the complete date (YYYY-MM-DD)

                            // Display the full date (Optional, for debugging or display)
                            alert(`You selected: ${formattedDate}`);
                        }
                    });


                    const dateCell = document.createElement('div');
                    dateCell.className = 'date-cell';
                    dateCell.appendChild(dateButton);
                    col.appendChild(dateCell);
                    dayCount++;
                } else {
                    col.classList.add('btn-date', 'empty');
                }

                dateSlots.push(col);
            }

            // Clear the current grid
            dateGrid.innerHTML = '';

            // Create rows with 7 columns
            let index = 0;
            for (let row = 0; row < 6; row++) {
                const rowDiv = document.createElement('div');
                rowDiv.className = 'row g-2';

                for (let col = 0; col < 7; col++) {
                    if (index < dateSlots.length) {
                        rowDiv.appendChild(dateSlots[index]);
                        index++;
                    }
                }

                dateGrid.appendChild(rowDiv);
            }
        }




        // Generate the times (Unchanged)
        const timeGrid = document.getElementById('time-grid');
        const times = [
            '11:30', '11:45', '12:00', '12:45', '13:00', '13:15',
            '13:30', '13:45', '14:00', '14:15', '14:30', '14:45'
        ];

        times.forEach(time => {
            const timeButton = document.createElement('button');
            timeButton.className = 'btn btn-outline-secondary btn-time';
            timeButton.textContent = time;
            timeButton.addEventListener('click', () => {
                document.querySelectorAll('.btn-time').forEach(el => el.classList.remove('selected'));
                timeButton.classList.add('selected');
            });
            const col = document.createElement('div');
            col.className = 'col';
            col.appendChild(timeButton);
            timeGrid.appendChild(col);
        });

        // Update the calendar with the current month
        updateCalendar();

        // Arrow navigation buttons
        document.getElementById('prev-month').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            updateCalendar();
        });

        document.getElementById('next-month').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            updateCalendar();
        });

        // Booking functionality
        document.getElementById('book-btn').addEventListener('click', () => {
    const selectedDate = document.querySelector('.btn-date.selected')?.textContent;
    const selectedTime = document.querySelector('.btn-time.selected')?.textContent;
    const reason = document.getElementById('reason').value;
    const details = document.getElementById('additional-details').value;

    // Check if a date, time, and reason are selected
    if (!selectedDate || !selectedTime || !reason) {
        alert('Please fill out all required fields.');
        return;
    }

    // Get the current selected date (full date with year, month, and day)
    const selectedDay = parseInt(selectedDate) + 1; // The selected day
    const selectedMonth = currentDate.getMonth(); // Current month index (0-based)
    const selectedYear = currentDate.getFullYear(); // Current year

    // Format the day to always have two digits (e.g., "09" instead of "9")
    const formattedDay = selectedDay < 10 ? `0${selectedDay}` : selectedDay;

    // Create a Date object for the selected date (no off-by-one error here)
    const selectedDateObject = new Date(selectedYear, selectedMonth, selectedDay); // Ensure no off-by-one

    // Format the date as YYYY-MM-DD (e.g., "2024-11-30")
    const formattedDate = selectedDateObject.toISOString().split('T')[0]; // Output: "2024-11-30"

    console.log('Formatted Date:', formattedDate);  // Debugging output

    // Prepare the data to send to the backend
    const formData = new URLSearchParams();
    formData.append('date', formattedDate);  // Send the complete date
    formData.append('time', selectedTime);  // Send the selected time
    formData.append('reason', reason);  // Send the reason
    formData.append('details', details);  // Send the details

    // Make the request to the backend (doBookAppt.php)
    fetch('doBookAppt.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: formData.toString()
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);  // Show success message
            console.log("Redirecting to dashboard...");
            
        } else {
            alert(data.message);  // Show error message
            console.log("Fail Redirect...");
        }
    })
    .catch(error => console.error('Error:', error));  // Log any errors
    alert("Appointment Booked!")
    window.location.href = 'dashboard.php'; //Latest Fix
});

    </script>
    <?php
    echo "<pre>";
    print_r($_SESSION); // Outputs session data
    echo "</pre>";


    echo "<pre>";
    print_r($_POST); // Outputs session data
    echo "</pre>";
    ?>
</body>

</html>