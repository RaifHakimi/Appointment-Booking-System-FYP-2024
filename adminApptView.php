<?php
session_start();
include 'dbFunctions.php';




$sql = "SELECT appointment.*, users.username 
        FROM appointment 
        JOIN users ON appointment.user_id = users.user_id";

$stmt = $link->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$sql = "SELECT closed_dates.*, users.username 
        FROM closed_dates 
        JOIN users ON closed_dates.user_id = users.user_id
        WHERE closed_dates.visible = 1";

$stmt1 = $link->prepare($sql);
$stmt1->execute();
$result1 = $stmt1->get_result();
// Check if appointments exist

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Display an alert and redirect
    echo "<script>
        alert('Access Restricted. You must be logged in as a admin to access this page.');
        history.back();

    </script>";
    exit(); // Ensure no further code is executed
}


?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointment Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
    .selected {
            background-color: #6c757d !important;
            color: #fff !important;
        }

    .appointment-card {
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 15px;
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

    .nav-link.activenav-link.active {
      font-weight: bold;
      /* color: red !important; */
    }

.btn-time,
        .btn-date {
            width: 100%;
            height: 60px;
            /* padding: 10%;
            margin: 2%; */
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

.modal .btn-date, 
.modal .btn-time {
    padding: 10px;
    margin: 2px;
   
}


.modal .selected {
    
    color: white !important;
    
}

#timeSlots {
    margin-top: 15px;
     
    
}

.btn-time.disabled {
    background-color: #e9ecef !important;
    color: #6c757d !important;
    cursor: not-allowed;
    border-color: #dee2e6 !important;
} 

#confirmReschedule{
    background-color: red !important; 
    color: white !important;
}

.day-header-row {
    margin-bottom: 0.5rem;
}

.day-header {
    text-align: center;
    font-weight: bold;
    padding: 0.5rem;
    color: #6c757d;
    background-color: #f8f9fa;
    border-radius: 4px;
}


  

  </style>
</head>

<body>

<!-- Navigation -->
<div class="navbar">
    <div class="logo">LOGO</div>
    <div class="nav-links">
      <a href="viewAllPatients.php">Patients</a>
      <div class="separator"></div>
      <a href="adminApptView.php" class="active" >Appointments</a>
      <div class="separator"></div>
      <a href="vacation.php">Vacation</a>
      <div class="separator"></div>
      <a href="showMeds.php" >Completed</a>
    </div>
    <a href="adminApptView.php" class="button">
      <i class="icon">📅</i> Book Appointment
    </a>
    <a href="settings.php" class="button">
      <i class="settings">⚙️</i>
    </a>
  </div>


<div class = "container mt-3">

<!-- <div class="mb-4 d-flex justify-content-between align-items-center">
  <input type="text" id="searchBar" placeholder="Search patient's name" />
  <div id="searchClear" class="ms-2" style="cursor: pointer; display: none;">×</div>
      </div> -->

      <div class="mb-4 position-relative w-50">
  <input type="text" id="searchBar" class="form-control" placeholder="Search patient's name" />
  <div id="searchClear" class="position-absolute end-0 top-50 translate-middle-y me-2" style="cursor: pointer; display: none;">×</div>
</div>


    <!-- <h3 class="text-center">Appointment</h3> -->


<div class="row">
   <!-- Month Navigation with Arrows -->
   <div class="col-md-4">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <button id="prev-month" class="btn btn-outline-secondary">&#8592; Previous</button>
            <h4 id="month-name"><?php echo date("F Y"); ?></h4>
            <button id="next-month" class="btn btn-outline-secondary">Next &#8594;</button>
        </div>

        <div class="row">
            <!-- Date Picker -->
            <div>
                <!-- <h4><b>Date</b></h4> -->
                <!-- <div class="container" id="date-grid"> -->
                    <!-- Dates will be dynamically added here -->
                <!-- </div> -->
                 <!-- Day headers row -->
    <div class="row g-2 day-header-row">
        <div class="col day-header">Su</div>
        <div class="col day-header">Mo</div>
        <div class="col day-header">Tu</div>
        <div class="col day-header">We</div>
        <div class="col day-header">Th</div>
        <div class="col day-header">Fr</div>
        <div class="col day-header">Sa</div>
    </div>
                <div class="row g-2" id="date-grid">
    
    <!-- Existing date grid rows... -->
</div>
<!-- <div class="container" id="date-grid"></div> -->

                
            </div>
        </div>
    </div>


<div class="col-md-8">

<?php 
$closedDates = []; // Initialize as empty array
if ($result->num_rows > 0) {
    $closedDates = [];
}

$appointments = []; // Initialize as empty array

    $today = strtotime(date('Y-m-d')); // Get today's timestamp
    if ($result->num_rows > 0) {
      $appointments = [];
  
      // Fetch all appointments into an array
      while ($row = $result->fetch_assoc()) {
          $appointments[] = $row;
      }
  
      // Sort appointments chronologically by date and time
      usort($appointments, function ($a, $b) {
          $dateTimeA = strtotime($a['appt_date'] . ' ' . $a['appt_time']);
          $dateTimeB = strtotime($b['appt_date'] . ' ' . $b['appt_time']);
          return $dateTimeA <=> $dateTimeB; // Ascending order
      });

      $appointments = array_filter($appointments, function ($row) use ($today) {
        return strtotime($row['appt_date']) >= $today; // Keep only today or future dates
    });
     
      // Loop through sorted appointments and display them
      foreach ($appointments as $row) {
          $date = new DateTime($row['appt_date']);
          $day = $date->format('d'); // Day with leading zero (01-31)
          $shortDay = strtoupper($date->format('D')); // Short day name in uppercase
          $month = strtoupper($date->format('M')); // Short month name in uppercase
          $year = $date->format('Y'); // Four-digit year (e.g., 2024)

          $formattedDate = $date->format('Y-m-d'); // Full date format (YYYY-MM-DD)
  
          $time = $row['appt_time'];
          $filterTime = strtotime($time);
          $time12h = date('h:i A', $filterTime); // 12-hour format with AM/PM

          $patientName = $row['username'];
  
          echo "
        
              <div >
                <!-- Appointment Cards -->
                <div class='appointment-card d-flex' data-date='$formattedDate' data-patient-name='" . strtolower(htmlspecialchars($patientName)) . "'>
                  <div class='date-section text-center me-3'>
                    <div>" . htmlspecialchars($month) . "<br> " . htmlspecialchars($year) . " </div>
                    <div class='fs-1 day-sect'>" . htmlspecialchars($day) . "</div>
                    <div> " . htmlspecialchars($shortDay) . " </div>
                  </div>
                  <div class='flex-grow-1'>
                    <h5>Doctor Consult</h5>
                    <p>Booked for <span class='text-muted'>$patientName</span></p>
                    <p class='text-danger'>" . htmlspecialchars($time12h) . "</p>
                    <p>Dr. Ty </p>
                </div>
                <div class='d-flex flex-column'>
                <button class='btn btn-custom mb-2 reschedule-btn' 
                            data-bs-toggle='modal' 
                            data-bs-target='#rescheduleModal'
                            data-appointment-id='{$row['appt_id']}'
                            data-current-date='{$formattedDate}'
                            data-current-time='{$row['appt_time']}'>
                        Reschedule
                    </button>
                <button class='btn btn-custom cancel-btn' 
                data-appointment-id='{$row['appt_id']}'>
            Cancel
        </button>
                </div>
              </div>
              
          ";
      }
  }
   else {
      echo "<p>No appointments found.</p>";
  }

  $bookedSlots = [];
foreach ($appointments as $appt) {
    $bookedSlots[] = [
        'date' => $appt['appt_date'],
        'time' => date('H:i', strtotime($appt['appt_time']))
    ];
}

$datesClosed = [];
foreach ($closedDates as $cd) {
    $date = new DateTime($cd['date']);
    $datesClosed[] = [
        'date' => $date->format('Y-m-d') // Format as local date string
    ];
}
    
    // Close the connection
    // $link->close();
    
    ?>

<script>
var bookedAppointments = <?php echo json_encode($bookedSlots); ?>;
var closedDates = <?php echo json_encode($datesClosed); ?>;
</script>
    
</div>
</div>
</div>

<!-- Reschedule Modal -->
<div class="modal fade" id="rescheduleModal" tabindex="-1" aria-labelledby="rescheduleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rescheduleModalLabel">Reschedule Appointment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="row mb-4">
            <div class="col-12">
              <div class="d-flex justify-content-between align-items-center">
                <button id="modalPrevMonth" class="btn btn-outline-secondary">‹</button>
                <h5 id="modalMonthName"></h5>
                <button id="modalNextMonth" class="btn btn-outline-secondary">›</button>
              </div>
              
              <div class="row g-2 day-header-row">
        <div class="col day-header">Su</div>
        <div class="col day-header">Mo</div>
        <div class="col day-header">Tu</div>
        <div class="col day-header">We</div>
        <div class="col day-header">Th</div>
        <div class="col day-header">Fr</div>
        <div class="col day-header">Sa</div>
    </div>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-12">
              <div id="modalDateGrid" class="row g-2"></div>
            </div>
          </div>
          <div class="row">
    <div class="col-12">
        <h5>Select Time Slot</h5>
        <div id="timeSlotMessage" class="alert alert-info">Please select a date to view available time slots.</div>
        <div id="timeSlots" class="row g-2" style="display: none;"></div>
    </div>
</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn " id="confirmReschedule">Confirm</button>
      </div>
    </div>
  </div>
</div>

  


<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
   

    <script>
// Search Functionality


const searchBar = document.getElementById('searchBar');
let activeSearchQuery = '';

function filterAppointments() {
    const allCards = document.querySelectorAll('.appointment-card');
    const todayTimestamp = new Date().setHours(0,0,0,0);

    allCards.forEach(card => {
        const cardDate = new Date(card.dataset.date).setHours(0,0,0,0);
        const patientName = card.dataset.patientName;
        const isFutureOrToday = cardDate >= todayTimestamp;
        const matchesSearch = patientName.includes(activeSearchQuery);

        if (activeSearchQuery) {
            // Search active - show matches regardless of calendar month
            if (matchesSearch && isFutureOrToday) {
                card.style.removeProperty('display');
                card.style.setProperty('display', 'flex', 'important');
            } else {
                card.style.setProperty('display', 'none', 'important');
            }
        } else {
            // No search - apply calendar filters
            const currentYearMonth = currentDate.toISOString().slice(0,7);
            const cardYearMonth = card.dataset.date.slice(0,7);
            const isSelectedMonth = cardYearMonth === currentYearMonth;
            
            if (isFutureOrToday && isSelectedMonth) {
                card.style.removeProperty('display');
                card.style.setProperty('display', 'flex', 'important');
            } else {
                card.style.setProperty('display', 'none', 'important');
            }
        }
    });
}

searchBar.addEventListener('input', (e) => {
    activeSearchQuery = e.target.value.trim().toLowerCase();
    filterAppointments();
    
    // Reset calendar to current month and clear selection
    if (activeSearchQuery) {
        currentDate = new Date();
        currentDate.setDate(1);
        updateCalendar();
        document.querySelectorAll('.btn-date.selected').forEach(btn => btn.classList.remove('selected'));
    }
});


    let currentDate = new Date();
    currentDate.setDate(1);

    function filterCardsByMonth() {
        if (activeSearchQuery) return;
        
    const currentYear = currentDate.getFullYear();
    const currentMonth = String(currentDate.getMonth() + 1).padStart(2, '0');
    const monthPrefix = `${currentYear}-${currentMonth}`;

    const cards = document.querySelectorAll('.appointment-card');
    cards.forEach(card => {
        const cardDate = card.getAttribute('data-date');
        if (cardDate.startsWith(monthPrefix)) {
            card.style.setProperty('display', 'flex', 'important');
        } else {
            card.style.setProperty('display', 'none', 'important');
        }
    });
}

    function updateCalendar() {
        const dateGrid = document.getElementById('date-grid');
        const monthName = currentDate.toLocaleString('default', {
            month: 'long',
            year: 'numeric'
        });
        document.getElementById('month-name').textContent = monthName;

        const daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();
        const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();

        const totalSlots = 42;
        const dateSlots = [];
        let dayCount = 1;

        const today = new Date();
        today.setHours(0, 0, 0, 0);

        for (let i = 0; i < totalSlots; i++) {
            const col = document.createElement('div');
            col.className = 'col';

            if (i >= firstDayOfMonth && dayCount <= daysInMonth) {
                const dateButton = document.createElement('button');
                dateButton.className = 'btn btn-outline-secondary btn-date';
                dateButton.textContent = dayCount;

                const dateToCompare = new Date(currentDate.getFullYear(), currentDate.getMonth(), dayCount);

                if (dateToCompare < today) {
                    dateButton.classList.add('disabled-date');
                }

dateButton.addEventListener('click', () => {
    if (!dateButton.classList.contains('disabled-date')) {
        const wasSelected = dateButton.classList.contains('selected');

        // Remove selection from all dates
        document.querySelectorAll('.btn-date').forEach(el => el.classList.remove('selected'));

        if (wasSelected) {
            // If clicking the already selected date, show all appointments for current month
            updateCalendar();
        } else {
            // Select the clicked date and filter appointments
            dateButton.classList.add('selected');
            
            const selectedDay = parseInt(dateButton.textContent);
            const selectedMonth = currentDate.getMonth() + 1;
            const selectedYear = currentDate.getFullYear();
            const formattedDate = `${selectedYear}-${String(selectedMonth).padStart(2, '0')}-${String(selectedDay).padStart(2, '0')}`;

            const cards = document.querySelectorAll('.appointment-card');
            
            cards.forEach(card => {
                const cardDate = card.getAttribute('data-date');
                if (cardDate === formattedDate) {
                    card.style.setProperty('display', 'flex', 'important');
                } else {
                    card.style.setProperty('display', 'none', 'important');
                }
            });
        }
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

        dateGrid.innerHTML = '';

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

        filterCardsByMonth();
    }

    updateCalendar();

    document.getElementById('prev-month').addEventListener('click', () => {

        if (activeSearchQuery) return;
        currentDate.setMonth(currentDate.getMonth() - 1);
        updateCalendar();
    });

    document.getElementById('next-month').addEventListener('click', () => {

        if (activeSearchQuery) return;
    // Set to first day of current month before changing
    currentDate.setDate(1);
    currentDate.setMonth(currentDate.getMonth() + 1);
    updateCalendar();
});

// Cancel Appointment Handler
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('cancel-btn')) {
        const appointmentId = e.target.dataset.appointmentId;
        if (confirm('Are you sure you want to cancel this appointment?')) {
            fetch('cancelAppointment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    appt_id: appointmentId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Appointment canceled successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Failed to cancel appointment'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to cancel appointment');
            });
        }
    }
});

// Modal Calendar Logic
let modalCurrentDate = new Date();
let selectedModalDate = null;
let selectedTimeSlot = null;




function updateModalCalendar() {
    const modalDateGrid = document.getElementById('modalDateGrid');
    const modalMonthName = document.getElementById('modalMonthName');
    
    modalMonthName.textContent = modalCurrentDate.toLocaleString('default', {
        month: 'long',
        year: 'numeric'
    });

    const daysInMonth = new Date(modalCurrentDate.getFullYear(), modalCurrentDate.getMonth() + 1, 0).getDate();
    const firstDayOfMonth = new Date(modalCurrentDate.getFullYear(), modalCurrentDate.getMonth(), 1).getDay();

    modalDateGrid.innerHTML = '';
    
    let dayCount = 1;

    // Create 5 rows of 7 columns each
    for (let row = 0; row < 6; row++) {
        const rowDiv = document.createElement('div');
        rowDiv.className = 'row g-2';

        for (let col = 0; col < 7; col++) {
            const cellIndex = row * 7 + col;
            const colDiv = document.createElement('div');
            colDiv.className = 'col';

            // Determine if current cell should display a date
            if (dayCount <= daysInMonth) {
                if ((row === 0 && cellIndex >= firstDayOfMonth) || row > 0) {
                    const dateButton = document.createElement('button');
                    dateButton.className = 'btn btn-outline-secondary btn-date';
                    dateButton.textContent = dayCount;

                    // Disable past dates
                    const currentDate = new Date();
                    currentDate.setHours(0, 0, 0, 0);
                    const buttonDate = new Date(
                        modalCurrentDate.getFullYear(),
                        modalCurrentDate.getMonth(),
                        dayCount
                    );

                    const isClosed = closedDates.some(cd => {
    // If cd.date is a string, it works directly. If it's a Date object, we need to format it
    const closedDateStr = cd.date instanceof Date 
        ? formatDateToLocalString(cd.date) 
        : cd.date;
    return closedDateStr === buttonDate;
});
if (isClosed) {
                        dateButton.classList.add('disabled-date');
                    } 
                    if (buttonDate < currentDate) {
                        dateButton.classList.add('disabled-date');
                    } else {

                        

// In the updateModalCalendar function, modify the dateButton click handler:
    dateButton.addEventListener('click', () => {
    document.querySelectorAll('#modalDateGrid .btn-date').forEach(btn => {
        btn.classList.remove('selected');
    });
    dateButton.classList.add('selected');
    selectedModalDate = buttonDate;
    
    // Generate time slots based on selected date
    generateTimeSlots(buttonDate);
});

                        
                    }

                    colDiv.appendChild(dateButton);
                    dayCount++;
                } else {
                    colDiv.classList.add('empty');
                }
            } else {
                colDiv.classList.add('empty');
            }

            rowDiv.appendChild(colDiv);
        }

        modalDateGrid.appendChild(rowDiv);
    }

    // Reset time slot visibility when month changes
    document.getElementById('timeSlotMessage').style.display = 'block';
    document.getElementById('timeSlots').style.display = 'none';

}



function generateTimeSlots(selectedDate) {
    const timeSlotsContainer = document.getElementById('timeSlots');
    timeSlotsContainer.innerHTML = '';
    const day = selectedDate.getDay();

    if (day === 0 || day === 1) {
        document.getElementById('timeSlotMessage').textContent = "No available slots on Sunday and Monday";
        document.getElementById('timeSlotMessage').style.display = 'block';
        document.getElementById('timeSlots').style.display = 'none';
        return;
    }

    let startTime, endTime;
    if (day === 6) { // Saturday
        startTime = 10.5; // 10:30 AM
        endTime = 16.5;   // 4:30 PM
    } else { // Tuesday-Friday
        startTime = 11;   // 11:00 AM
        endTime = 17;     // 5:00 PM
    }

    // Get selected date in local 'YYYY-MM-DD' format
    const year = selectedDate.getFullYear();
    const month = String(selectedDate.getMonth() + 1).padStart(2, '0');
    const dayOfMonth = String(selectedDate.getDate()).padStart(2, '0');
    const selectedDateFormatted = `${year}-${month}-${dayOfMonth}`;

    let current = startTime;
    while (current < endTime) {
        const hours = Math.floor(current);
        const minutes = (current % 1) * 60;
        const time = new Date(0);
        time.setHours(hours, minutes);

        // Get 24-hour time format 'HH:mm'
        const hours24 = String(time.getHours()).padStart(2, '0');
        const minutes24 = String(time.getMinutes()).padStart(2, '0');
        const time24Formatted = `${hours24}:${minutes24}`;

        // Check if slot is booked (excluding original appointment)
        const isBooked = bookedAppointments.some(appt => 
            appt.date === selectedDateFormatted && 
            appt.time === time24Formatted
        );
        
        // Create time button
        const timeString = time.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
        const col = document.createElement('div');
        col.className = 'col-3 mb-2';
        const timeButton = document.createElement('button');
        timeButton.className = 'btn btn-outline-secondary btn-time w-100';
        timeButton.textContent = timeString;

        

        if (isBooked) {
            timeButton.disabled = true;
            timeButton.classList.add('disabled');
        }

        timeButton.addEventListener('click', () => {
            document.querySelectorAll('.btn-time').forEach(btn => btn.classList.remove('selected'));
            timeButton.classList.add('selected');
            selectedTimeSlot = timeString;
        });

        col.appendChild(timeButton);
        timeSlotsContainer.appendChild(col);
        current += 0.25; // Increment by 15 minutes
    }

    document.getElementById('timeSlotMessage').style.display = 'none';
    document.getElementById('timeSlots').style.display = 'flex';
}


// Month Navigation
document.getElementById('modalPrevMonth').addEventListener('click', () => {
    modalCurrentDate.setMonth(modalCurrentDate.getMonth() - 1);
    updateModalCalendar();
});

document.getElementById('modalNextMonth').addEventListener('click', () => {
    modalCurrentDate.setMonth(modalCurrentDate.getMonth() + 1);
    updateModalCalendar();
});


document.getElementById('confirmReschedule').addEventListener('click', () => {
    if (!selectedModalDate || !selectedTimeSlot) {
        alert('Please select both date and time');
        return;
    }

    // Convert time to 24-hour format
    const [time, modifier] = selectedTimeSlot.split(' ');
    let [hours, minutes] = time.split(':');
    hours = parseInt(hours);
    minutes = parseInt(minutes);

    if (modifier === 'PM' && hours < 12) hours += 12;
    if (modifier === 'AM' && hours === 12) hours = 0;

    const formattedTime = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:00`;
    const formattedDate = `${selectedModalDate.getFullYear()}-${(selectedModalDate.getMonth()+1).toString().padStart(2, '0')}-${selectedModalDate.getDate().toString().padStart(2, '0')}`;
    const appointmentId = window.currentReschedulingAppt.apptId;

    // AJAX request
    fetch('rescheduleAppointment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            appt_id: appointmentId,
            new_date: formattedDate,
            new_time: formattedTime
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Appointment rescheduled successfully!');
            location.reload(); // Refresh to show changes
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to reschedule.');
    });
});

// Initialize modal calendar
updateModalCalendar();


// Update the modal hidden event listener
document.getElementById('rescheduleModal').addEventListener('hidden.bs.modal', () => {
    selectedModalDate = null;
    selectedTimeSlot = null;
    document.querySelectorAll('.selected').forEach(el => el.classList.remove('selected'));
    
    // Reset time slot display
    document.getElementById('timeSlotMessage').style.display = 'block';
    document.getElementById('timeSlots').style.display = 'none';
});

document.getElementById('rescheduleModal').addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const appointmentId = button.getAttribute('data-appointment-id');
    const currentDate = button.getAttribute('data-current-date');
    const currentTime = button.getAttribute('data-current-time');
    const timeParts = currentTime.split(':');
    const currentTimeFormatted = `${timeParts[0]}:${timeParts[1]}`;
    
    window.currentReschedulingAppt = {
        apptId: appointmentId,
        date: currentDate,
        time: currentTimeFormatted
    };
    
    const originalDate = new Date(currentDate);
    modalCurrentDate = new Date(originalDate.getFullYear(), originalDate.getMonth(), 1);
    updateModalCalendar();
});

// Add clear search functionality
document.getElementById('searchClear').addEventListener('click', () => {
    searchBar.value = '';
    activeSearchQuery = '';
    filterAppointments();
    document.getElementById('searchClear').style.display = 'none';
});

searchBar.addEventListener('input', (e) => {
    document.getElementById('searchClear').style.display = e.target.value ? 'block' : 'none';
});




</script>

   
    </body>

</html>