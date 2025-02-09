<?php
session_start();
include 'dbFunctions.php';




// $sql = "SELECT appointment.*, users.username 
//         FROM appointment 
//         JOIN users ON appointment.user_id = users.user_id";

// $stmt = $link->prepare($sql);
// $stmt->execute();
// $result = $stmt->get_result();

$sql = "SELECT closed_dates.*, users.username 
        FROM closed_dates 
        JOIN users ON closed_dates.user_id = users.user_id
        WHERE closed_dates.visible = 1";

$stmt = $link->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// $sql = "SELECT closed_dates.*, users.username 
//         FROM closed_dates 
//         JOIN users ON closed_dates.user_id = users.user_id
//         WHERE closed_dates.visible = 1";  // Add this WHERE clause

// Check if appointments exist

// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     // Display an alert and redirect
//     echo "<script>
//         alert('Access Restricted. You must be logged in as a admin to access this page.');
//         history.back();

//     </script>";
//     exit(); // Ensure no further code is executed
// }

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
    .closedDate {
        background-color:rgb(252, 11, 11) !important;
            color: #fff !important;
    }
    .closedDate:hover {
        background-color:rgb(102, 56, 56) !important;
            color: #fff !important;
    }
.closedDate.selected {
        background-color:rgb(102, 56, 56) !important;
            color: #fff !important;
    }
    .btn-date.closed-date {
    background-color: #dc3545 !important; /* Bootstrap red color */
    color: white !important;
    border-color: #dc3545 !important;
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
      <a href="adminApptView.php">Appointments</a>
      <div class="separator"></div>
      <a href="vacation.php" class="active">Vacation</a>
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

      <!-- <div class="mb-4 position-relative w-50">
  <input type="text" id="searchBar" class="form-control" placeholder="Search patient's name" />
  <div id="searchClear" class="position-absolute end-0 top-50 translate-middle-y me-2" style="cursor: pointer; display: none;">×</div>

</div> -->


<!-- Add this after the search bar div -->
<!-- <div class="d-flex gap-2 mb-4">
    <div class="position-relative ">
        <input type="text" id="searchBar" class="form-control" placeholder="Search patient's name" />
        <div id="searchClear" class="position-absolute end-0 top-50 translate-middle-y me-2" style="cursor: pointer; display: none;">×</div>
    </div>
    <button class="btn btn-secondary" id="closeDatesBtn">Close Dates</button>
    <button class="btn btn-secondary" id="openDatesBtn">Open Dates</button>
</div> -->

<div class="d-flex gap-2 mb-4">
    
    <div class="me-auto w-50">
        <input type="text" id="searchBar" class="form-control" placeholder="Search patient's name" />
        <div id="searchClear" class="position-absolute end-0 top-50 translate-middle-y me-2" style="cursor: pointer; display: none;">×</div>
    </div>
    <div class="position-relative w-0"> <!-- Push buttons to the left -->
        <button class="btn btn-secondary" id="closeDatesBtn">Close Dates</button>
        <button class="btn btn-secondary" id="openDatesBtn">Open Dates</button>
    </div>
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


    $today = strtotime(date('Y-m-d')); // Get today's timestamp
    if ($result->num_rows > 0) {
      $closedDates = [];
  
      // Fetch all appointments into an array
      while ($row = $result->fetch_assoc()) {
          $closedDates[] = $row;
      }
  
      // Sort appointments chronologically by date and time
    //   usort($appointments, function ($a, $b) {
    //       $dateTimeA = strtotime($a['appt_date'] . ' ' . $a['appt_time']);
    //       $dateTimeB = strtotime($b['appt_date'] . ' ' . $b['appt_time']);
    //       return $dateTimeA <=> $dateTimeB; // Ascending order
    //   });

    usort($closedDates, function ($a, $b) {
        return strtotime($a['date']) <=> strtotime($b['date']); // Descending order
    });

      $closedDates = array_filter($closedDates, function ($row) use ($today) {
        return strtotime($row['date']) >= $today; // Keep only today or future dates
    });
     
      // Loop through sorted appointments and display them
      foreach ($closedDates as $row) {
          $date = new DateTime($row['date']);
          $day = $date->format('d'); // Day with leading zero (01-31)
          $shortDay = strtoupper($date->format('D')); // Short day name in uppercase
          $month = strtoupper($date->format('M')); // Short month name in uppercase
          $year = $date->format('Y'); // Four-digit year (e.g., 2024)

          $formattedDate = $date->format('Y-m-d'); // Full date format (YYYY-MM-DD)
  
        //   $time = $row['appt_time'];
        //   $filterTime = strtotime($time);
        //   $time12h = date('h:i A', $filterTime); // 12-hour format with AM/PM

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
                    <p>Dr. Ty </p>
                </div>
                <div class='d-flex flex-column'>
                
                <button class='btn btn-custom cancel-btn' 
                >
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

//   $datesClose = [];
// foreach ($closedDates as $cd) {
//     $datesClosed[] = [
//         'date' => $cd['date']
//     ];
// }
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
var closedDates = <?php echo json_encode($datesClosed); ?>;
</script>
    
</div>
</div>
</div>


<!-- Add this modal at the end of the body -->
<div class="modal fade" id="closeDatesModal" tabindex="-1" aria-labelledby="closeDatesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="closeDatesModalLabel">Close Dates</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="row mb-4">
            <div class="col-12">
              <div class="d-flex justify-content-between align-items-center">
                <button id="modalClosePrev" class="btn btn-outline-secondary">‹</button>
                <h5 id="modalCloseMonth"></h5>
                <button id="modalCloseNext" class="btn btn-outline-secondary">›</button>
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
              <div id="closeDateGrid" class="row g-2"></div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-12">
              <select class="form-select" id="closeReason">
                <option value="">Select closure reason</option>
                <option value="vacation">Vacation</option>
                <option value="renovation">Renovation</option>
                <option value="sick_leave">Sick Leave</option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-12">
              <textarea class="form-control" id="closeMessage" placeholder="Additional message"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="confirmClose" style="display: none;">Confirm Closure</button>
      </div>
    </div>
  </div>
</div>  

<!-- Add this modal at the end of the body -->
<div class="modal fade" id="openDatesModal" tabindex="-1" aria-labelledby="openDatesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="openDatesModalLabel">Reopen Dates</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="row mb-4">
            <div class="col-12">
              <div class="d-flex justify-content-between align-items-center">
                <button id="modalOpenPrev" class="btn btn-outline-secondary">‹</button>
                <h5 id="modalOpenMonth"></h5>
                <button id="modalOpenNext" class="btn btn-outline-secondary">›</button>
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
              <div id="openDateGrid" class="row g-2"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="confirmOpen" style="display: none;">Confirm Reopen</button>
      </div>
    </div>
  </div>
</div>



<!-- Bootstrap JS and Popper.js -->
 <!-- Add this ABOVE the Bootstrap JS -->

 
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
   

    <script>


function formatDateToLocalString(date) {
    if (typeof date === 'string') {
        date = new Date(date);
    }
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

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

                // const dateToCompare = new Date(currentDate.getFullYear(), currentDate.getMonth(), dayCount);
                // const dateStr = dateToCompare.toISOString().split('T')[0]; // Format as YYYY-MM-DD
                const dateToCompare = new Date(currentDate.getFullYear(), currentDate.getMonth(), dayCount);
                const dateStr = formatDateToLocalString(dateToCompare);


        //         const isClosed = closedDates.some(cd => 
        //     cd.date === dateStr 
        // );

//         const isClosed = closedDates.some(cd => {
//     // If cd.date is a string, it works directly. If it's a Date object, we need to format it.
//     const closedDateStr = cd.date instanceof Date ? cd.date.toISOString().split('T')[0] : cd.date;
//     return closedDateStr === dateStr;
// });
//         if (isClosed) {
//                     dateButton.classList.add('closedDate');
//                 }

// Convert all dates in closedDates to the 'YYYY-MM-DD' format using local time
const isClosed = closedDates.some(cd => {
    // If cd.date is a string, it works directly. If it's a Date object, we need to format it
    const closedDateStr = cd.date instanceof Date 
        ? formatDateToLocalString(cd.date) 
        : cd.date;
    return closedDateStr === dateStr;
});

if (isClosed) {
                    dateButton.classList.add('closedDate');
                }


//         const isClosed = closedDates.some(cd => {
//     const bookedDate = new Date(cd.date); // Assuming cd.date is a string
//     console.log(`Comparing: ${bookedDate.getTime()} with ${dateToCompare.getTime()}`);
//     return bookedDate.getTime() === dateToCompare.getTime();
// });

// if (isClosed) {
//     console.log(`Date ${dateToCompare.toLocaleDateString()} is closed.`);
//     dateButton.classList.add('closed-date');
// }

                // if (dateToCompare < today) {
                //     dateButton.classList.add('disabled-date');
                // }

                if (!isClosed) {
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

// Close Dates Modal Logic
let closeModalCurrentDate = new Date();
let selectedCloseDates = new Set();

// Initialize close dates modal
// document.getElementById('closeDatesBtn').addEventListener('click', () => {
//     $('#closeDatesModal').modal('show');
//     updateCloseModalCalendar();
// });

// To this vanilla JS implementation:
document.getElementById('closeDatesBtn').addEventListener('click', () => {
    const modal = new bootstrap.Modal(document.getElementById('closeDatesModal'));
    modal.show();
    updateCloseModalCalendar();
});



function updateCloseModalCalendar() {
    const grid = document.getElementById('closeDateGrid');
    const monthName = closeModalCurrentDate.toLocaleString('default', {
        month: 'long',
        year: 'numeric'
    });
    document.getElementById('modalCloseMonth').textContent = monthName;

    const daysInMonth = new Date(
        closeModalCurrentDate.getFullYear(),
        closeModalCurrentDate.getMonth() + 1,
        0
    ).getDate();
    
    const firstDay = new Date(
        closeModalCurrentDate.getFullYear(),
        closeModalCurrentDate.getMonth(),
        1
    ).getDay();

    grid.innerHTML = '';
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    let date = 1;
    for (let i = 0; i < 6; i++) {
        const row = document.createElement('div');
        row.className = 'row g-2';

        for (let j = 0; j < 7; j++) {
            const cell = document.createElement('div');
            cell.className = 'col';
            
            if (i === 0 && j < firstDay) {
                cell.classList.add('empty');
            } else if (date > daysInMonth) {
                cell.classList.add('empty');
            } else {
                const button = document.createElement('button');
                button.className = 'btn btn-outline-secondary btn-date w-100';
                button.textContent = date;
                
                const currentDate = new Date(
                    closeModalCurrentDate.getFullYear(),
                    closeModalCurrentDate.getMonth(),
                    date + 1
                );
                const dateString = currentDate.toISOString().split('T')[0];
                // const isAlreadyClosed = closedDates.some(cd => cd.date === dateString);

//                 const isAlreadyClosed = closedDates.some(cd => {
//     let cdDate = new Date(cd.date); // Ensure it's a Date object
//     cdDate.setDate(cdDate.getDate()); // Add 1 day


    
//     const formattedCDDate = cdDate.toISOString().split('T')[0]; // Convert to 'YYYY-MM-DD'
//     return formattedCDDate === dateString;
// });

const isAlreadyClosed = closedDates.some(cd => {
        // Compare dates using local timezone
        const cdDate = new Date(cd.date);
        const cdDateString = formatDateToLocalString(cdDate);
        return cdDateString === dateString;
    });
                if (currentDate < today || isAlreadyClosed) {
                    button.disabled = true;
                    button.classList.add('disabled-date');
                    if (isAlreadyClosed) {
                        button.classList.add('closedDate');
                        button.innerHTML = `${date}<br><small>(closed)</small>`;
                    }
                } else {
                    button.addEventListener('click', () => toggleDateSelection(currentDate, button));
                }

                cell.appendChild(button);
                date++;
            }
            row.appendChild(cell);
        }
        grid.appendChild(row);
    }
}

function toggleDateSelection(date, button) {
    // date.setDate(date.getdate() + 1);
    const dateString = date.toISOString().split('T')[0];
    
    if (selectedCloseDates.has(dateString)) {
        selectedCloseDates.delete(dateString);
        button.classList.remove('selected');
    } else {
        selectedCloseDates.add(dateString);
        button.classList.add('selected');
    }
    updateConfirmButtonState();
}

function updateConfirmButtonState() {
    const reason = document.getElementById('closeReason').value;
    const message = document.getElementById('closeMessage').value.trim();
    const confirmBtn = document.getElementById('confirmClose');
    
    confirmBtn.style.display = (selectedCloseDates.size > 0 && reason && message) 
        ? 'block' 
        : 'none';
}

// Event listeners for input changes
document.getElementById('closeReason').addEventListener('change', updateConfirmButtonState);
document.getElementById('closeMessage').addEventListener('input', updateConfirmButtonState);

// Month navigation
document.getElementById('modalClosePrev').addEventListener('click', () => {
    closeModalCurrentDate.setMonth(closeModalCurrentDate.getMonth() - 1);
    updateCloseModalCalendar();
});

document.getElementById('modalCloseNext').addEventListener('click', () => {
    closeModalCurrentDate.setMonth(closeModalCurrentDate.getMonth() + 1);
    updateCloseModalCalendar();
});

// Confirm closure
document.getElementById('confirmClose').addEventListener('click', () => {
    const dates = Array.from(selectedCloseDates).sort();
    const reason = document.getElementById('closeReason').value;
    const message = document.getElementById('closeMessage').value;
    
    if (confirm(`Are you sure you want to close these dates?\n${dates.join('\n')}`)) {
        fetch('save_closed_dates.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                dates: dates,
                reason: reason,
                message: message
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Dates closed successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }

        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to save closed dates');
        });
    }
});


// Open Dates Modal Logic
let openModalCurrentDate = new Date();
let selectedOpenDates = new Set();

// Initialize open dates modal
document.getElementById('openDatesBtn').addEventListener('click', () => {
    const modal = new bootstrap.Modal(document.getElementById('openDatesModal'));
    modal.show();
    updateOpenModalCalendar();
});

function updateOpenModalCalendar() {
    const grid = document.getElementById('openDateGrid');
    const monthName = openModalCurrentDate.toLocaleString('default', {
        month: 'long',
        year: 'numeric'
    });
    document.getElementById('modalOpenMonth').textContent = monthName;

    const daysInMonth = new Date(
        openModalCurrentDate.getFullYear(),
        openModalCurrentDate.getMonth() + 1,
        0
    ).getDate();
    
    const firstDay = new Date(
        openModalCurrentDate.getFullYear(),
        openModalCurrentDate.getMonth(),
        1
    ).getDay();

    grid.innerHTML = '';
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    let date = 1;
    for (let i = 0; i < 6; i++) {
        const row = document.createElement('div');
        row.className = 'row g-2';

        for (let j = 0; j < 7; j++) {
            const cell = document.createElement('div');
            cell.className = 'col';
            
            if (i === 0 && j < firstDay) {
                cell.classList.add('empty');
            } else if (date > daysInMonth) {
                cell.classList.add('empty');
            } else {
                const button = document.createElement('button');
                button.className = 'btn btn-outline-secondary btn-date w-100';
                button.textContent = date;
                
                const currentDate = new Date(
                    openModalCurrentDate.getFullYear(),
                    openModalCurrentDate.getMonth(),
                    date + 1
                );
                const dateString = currentDate.toISOString().split('T')[0];
                const isClosed = closedDates.some(cd => {
                    const cdDate = new Date(cd.date);
                    const cdDateString = formatDateToLocalString(cdDate);
                    return cdDateString === dateString;
                });

                if (currentDate < today || !isClosed) {
                    button.disabled = true;
                    button.classList.add('disabled-date');
                   
                } else {
                    if (isClosed) {
                        button.classList.add('closedDate');
                    }
                    button.addEventListener('click', () => toggleOpenDateSelection(currentDate, button));
                }

                cell.appendChild(button);
                date++;
            }
            row.appendChild(cell);
        }
        grid.appendChild(row);
    }
}

function toggleOpenDateSelection(date, button) {
    const dateString = date.toISOString().split('T')[0];
    
    if (selectedOpenDates.has(dateString)) {
        selectedOpenDates.delete(dateString);
        button.classList.remove('selected');
    } else {
        selectedOpenDates.add(dateString);
        button.classList.add('selected');
    }
    updateOpenConfirmButtonState();
}

function updateOpenConfirmButtonState() {
    const confirmBtn = document.getElementById('confirmOpen');
    confirmBtn.style.display = (selectedOpenDates.size > 0) ? 'block' : 'none';
}

// Month navigation
document.getElementById('modalOpenPrev').addEventListener('click', () => {
    openModalCurrentDate.setMonth(openModalCurrentDate.getMonth() - 1);
    updateOpenModalCalendar();
});

document.getElementById('modalOpenNext').addEventListener('click', () => {
    openModalCurrentDate.setMonth(openModalCurrentDate.getMonth() + 1);
    updateOpenModalCalendar();
});

// Confirm reopening
document.getElementById('confirmOpen').addEventListener('click', () => {
    const dates = Array.from(selectedOpenDates).sort();
    
    if (confirm(`Are you sure you want to reopen these dates?\n${dates.join('\n')}`)) {
        fetch('reopen_dates.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                dates: dates
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Dates reopened successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to reopen dates');
        });
    }
});



</script>

   
    </body>

</html>