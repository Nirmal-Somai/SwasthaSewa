<?php
session_start();
include("db.php");


// Define time slots
$slots = [
    "10:00 AM - 11:00 AM",
    "11:00 AM - 12:00 PM",
    "01:00 PM - 02:00 PM",
    "02:00 PM - 03:00 PM",
    "03:00 PM - 04:00 PM",
    "04:00 PM - 05:00 PM"
];

// Track number of bookings in last 12 hours for each slot
$slot_counts = [];
foreach ($slots as $slot) {
    $sql = "SELECT COUNT(*) as count FROM appointments 
            WHERE appointment_time = '$slot'
            AND status IN ('Pending','Confirmed')
            AND created_at > NOW() - INTERVAL 12 HOUR";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $slot_counts[$slot] = $row['count'];
}


// 1. PROTECT PAGE: MUST BE LOGGED IN
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$success_message = "";
$error_message = "";

// 2. FETCH USER DETAILS
$user_stmt = $conn->prepare("SELECT first_name, last_name, email, phone, gender FROM users WHERE id = ?");
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user_data = $user_result->fetch_assoc();

$first_name = $user_data['first_name'] ?? '';
$last_name = $user_data['last_name'] ?? '';
$email = $user_data['email'] ?? '';
$phone = $user_data['phone'] ?? '';
$gender = $user_data['gender'] ?? '';

// 3. PRE-POPULATE FROM SESSION (FOR EDITING)
$p_doctor_name = $_SESSION['pending_appointment']['doctor_name'] ?? '';
$p_doctor_specialty = $_SESSION['pending_appointment']['doctor_specialty'] ?? '';
$p_problem_type = $_SESSION['pending_appointment']['problem_type'] ?? '';
$p_appointment_date = $_SESSION['pending_appointment']['appointment_date'] ?? '';
$p_appointment_time = $_SESSION['pending_appointment']['appointment_time'] ?? '';
$p_appointment_type = $_SESSION['pending_appointment']['appointment_type'] ?? 'Normal';

// 3. HANDLE FORM SUBMISSION
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['pending_appointment'] = [
        'doctor_name' => htmlspecialchars(trim($_POST['doctor_name'])),
        'doctor_specialty' => htmlspecialchars(trim($_POST['doctor_specialty'])),
        'problem_type' => htmlspecialchars(trim($_POST['problem_type'])),
        'appointment_date' => $_POST['appointment_date'],
        'appointment_time' => htmlspecialchars(trim($_POST['appointment_time'])),
        'appointment_type' => $_POST['appointment_type']
    ];

    $doctor_name = $_SESSION['pending_appointment']['doctor_name'];
    $appointment_date = $_SESSION['pending_appointment']['appointment_date'];
    $appointment_time = $_SESSION['pending_appointment']['appointment_time'];
    $problem_type = $_SESSION['pending_appointment']['problem_type'];

    if (empty($doctor_name) || empty($appointment_date) || empty($appointment_time) || empty($problem_type)) {
        $error_message = "Please fill all required fields.";
    } else {
        header("Location: confirm_appointment.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - SwasthaSewa</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Main Style -->
    <link rel="stylesheet" href="user_dashboard.css">
</head>

<body>

    <!-- Reuse Navbar -->
    <header class="navbar">
        <a href="user_dashboard.php" class="logo">
            <i class="fa-solid fa-heart-pulse"></i>
            SwasthaSewa
        </a>
        <nav class="nav-links">
            <a href="users_dashboard.php">Home</a>
            <a href="user_profile.php">Profile</a>
            <a href="Book_Appointment.php" style="color: var(--accent-color);">Book Appointment</a>
        </nav>
        <div class="auth-buttons">
            <a href="logout.php" class="btn-login">Logout</a>
        </div>
    </header>

    <div class="booking-container">
        <a href="users_dashboard.php" class="back-link">
            <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
        </a>

        <div class="booking-card">
            <div class="booking-header">
                <h1>Book Your Appointment</h1>
                <p>Fill in the details below to schedule your visit with our specialists.</p>
            </div>

            <div class="booking-body">
                <?php if (!empty($success_message)): ?>
                    <div class="alert alert-success">
                        <i class="fa-solid fa-circle-check"></i>
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-error">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="Book_Appointment.php">
                    <div class="form-grid">
                        <!-- Patient Details (Read Only) -->
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" value="<?php echo $first_name; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" value="<?php echo $last_name; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" value="<?php echo $email; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" value="<?php echo $phone; ?>" readonly>
                        </div>

                        <!-- Doctor Selection -->
                        <div class="form-group">
                            <label>Select Doctor</label>
                            <select name="doctor_name" id="doctor_select" required onchange="updateSpecialty()">
                                <option value="">Choose a Physician</option>
                                <option value="Dr Nirmal" <?php echo ($p_doctor_name == 'Dr Nirmal') ? 'selected' : ''; ?>>Dr Nirmal</option>
                                <option value="Dr Sujan" <?php echo ($p_doctor_name == 'Dr Sujan') ? 'selected' : ''; ?>>Dr Sujan</option>
                                <option value="Dr Anish" <?php echo ($p_doctor_name == 'Dr Anish') ? 'selected' : ''; ?>>Dr Anish</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Specialty</label>
                            <input type="text" name="doctor_specialty" id="doctor_specialty" readonly
                                value="<?php echo $p_doctor_specialty; ?>" placeholder="Auto-filled">
                        </div>

                        <!-- Problem Details -->
                        <div class="form-group">
                            <label>Problem Type</label>
                            <select name="problem_type" required>
                                <option value="">Select category</option>
                                <option value="Teeth Problem" <?php echo ($p_problem_type == 'Teeth Problem') ? 'selected' : ''; ?>>Teeth Problem</option>
                                <option value="Skin Problem" <?php echo ($p_problem_type == 'Skin Problem') ? 'selected' : ''; ?>>Skin Problem</option>
                                <option value="Fever/Cold" <?php echo ($p_problem_type == 'Fever/Cold') ? 'selected' : ''; ?>>Fever/Cold</option>
                                <option value="Heart Problem" <?php echo ($p_problem_type == 'Heart Problem') ? 'selected' : ''; ?>>Heart Problem</option>
                                <option value="Other" <?php echo ($p_problem_type == 'Other') ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="appointment_time">Time Slot</label>
                            <select name="appointment_time" id="appointment_time" class="form-input" required>
                                <option value="">Choose a time</option>
                                <?php foreach ($slots as $slot):
                                    // Disable slot if already 3 bookings
                                    $disabled = $slot_counts[$slot] >= 3 ? "disabled" : "";
                                    ?>
                                    <option value="<?= $slot ?>" <?= $disabled ?> <?php echo ($p_appointment_time == $slot) ? 'selected' : ''; ?>>
                                        <?= $slot ?> (
                                        <?= $slot_counts[$slot] ?>/3 booked)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Appointment Date</label>
                            <input type="date" name="appointment_date" min="<?php echo date('Y-m-d'); ?>" required
                                value="<?php echo $p_appointment_date; ?>" class="date-input">
                        </div>

                        <style>
                            .date-input {
                                background-color: white;
                                /* input background */
                                color: black;
                                /* text color */
                                border: 1px solid #ccc;
                                padding: 8px;
                                border-radius: 4px;
                            }

                            /* Chrome, Safari, Edge */
                            .date-input::-webkit-calendar-picker-indicator {
                                background-color: white;
                                /* make the calendar button white */
                                border-radius: 4px;
                                padding: 5px;
                                cursor: pointer;
                            }

                            /* Firefox */
                            .date-input::-moz-calendar-picker-indicator {
                                background-color: white;
                                border-radius: 4px;
                                padding: 5px;
                                cursor: pointer;
                            }
                        </style>
                    </div> <!-- End of form-grid -->

                    <div class="form-group">
                        <label>Appointment Type</label>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="appointment_type" value="Normal" <?php echo ($p_appointment_type == 'Normal') ? 'checked' : ''; ?>> Normal
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="appointment_type" value="Emergency" <?php echo ($p_appointment_type == 'Emergency') ? 'checked' : ''; ?>> Emergency
                            </label>
                        </div>
                    </div>


                    <button type="submit" class="btn-submit">Book Appointment</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const doctors = {
            "Dr Nirmal": "ENT Specialist",
            "Dr Sujan": "Dermatologist",
            "Dr Anish": "Dentist"
        };

        function updateSpecialty() {
            const select = document.getElementById('doctor_select');
            const specialtyInput = document.getElementById('doctor_specialty');
            const doctorName = select.value;

            if (doctors[doctorName]) {
                specialtyInput.value = doctors[doctorName];
            } else {
                specialtyInput.value = "";
            }
        }
    </script>
</body>

</html>