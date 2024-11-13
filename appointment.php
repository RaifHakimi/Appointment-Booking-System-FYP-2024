

<html lang="en">
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
  </style>
</head>
<body>

  <!-- Navigation -->
  <div class="navbar">
    <div class="logo">LOGO</div>
    <div class="nav-links">
        <a href="dashboard.php" >Home</a>
        <div class="separator"></div>
        <a href="#" class="active">Appointments</a>
        <div class="separator"></div>
        <a href="#">Medication</a>
    </div>
    <a href="#" class="button">
        <i class="icon">📅</i> Book Appointment
    </a>
    <i class="settings">⚙️</i>
</div>

  <!-- Main Content -->
  <div class="container mt-4">
    <h3 class="text-center">Appointment</h3>

    <!-- Appointment Cards -->
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

    <!-- Duplicate appointment card for other dates -->
    <div class="appointment-card d-flex">
      <div class="date-section text-center me-3">
        <div>OCT<br>2024</div>
        <div class="fs-1">20</div>
        <div>SUN</div>
      </div>
      <div class="flex-grow-1">
        <h5>Doctor Consult</h5>
        <p>Booked for <span class="text-muted">[Name 2]</span></p>
        <p class="text-danger">5:58 PM</p>
        <p>Dr. Heisenberg</p>
      </div>
      <div class="d-flex flex-column">
        <button class="btn btn-custom mb-2">Reschedule</button>
        <button class="btn btn-custom">Cancel</button>
      </div>
    </div>

    <div class="appointment-card d-flex">
      <div class="date-section text-center me-3">
        <div>OCT<br>2024</div>
        <div class="fs-1">22</div>
        <div>TUE</div>
      </div>
      <div class="flex-grow-1">
        <h5>Doctor Consult</h5>
        <p>Booked for <span class="text-muted">[Name 3]</span></p>
        <p class="text-danger">5:58 PM</p>
        <p>Dr. Heisenberg</p>
      </div>
      <div class="d-flex flex-column">
        <button class="btn btn-custom mb-2">Reschedule</button>
        <button class="btn btn-custom">Cancel</button>
      </div>
    </div>

    <div class="appointment-card d-flex">
      <div class="date-section text-center me-3">
        <div>OCT<br>2024</div>
        <div class="fs-1">24</div>
        <div>THU</div>
      </div>
      <div class="flex-grow-1">
        <h5>Doctor Consult</h5>
        <p>Booked for <span class="text-muted">[Name 4]</span></p>
        <p class="text-danger">5:58 PM</p>
        <p>Dr. Heisenberg</p>
      </div>
      <div class="d-flex flex-column">
        <button class="btn btn-custom mb-2">Reschedule</button>
        <button class="btn btn-custom">Cancel</button>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>