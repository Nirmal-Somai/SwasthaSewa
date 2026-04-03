<?php
session_start();
include("db.php");

// 1. MUST BE LOGGED IN AND HAVE PENDING APPOINTMENT
if (!isset($_SESSION['user_id']) || !isset($_SESSION['pending_appointment'])) {
    header("Location: users_dashboard.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$appt = $_SESSION['pending_appointment'];

// Fetch user details for display
$user_stmt = $conn->prepare("SELECT first_name, last_name, email, phone FROM users WHERE id = ?");
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_data = $user_stmt->get_result()->fetch_assoc();

$full_name = ($user_data['first_name'] ?? '') . ' ' . ($user_data['last_name'] ?? '');
$phone = $user_data['phone'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Appointment - SwasthaSewa</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Main Style -->
    <link rel="stylesheet" href="user_dashboard.css">
    <style>
        .receipt-card {
            background: var(--bg-card);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border: 1px solid var(--border-color);
            position: relative;
        }

        .receipt-body {
            padding: 4rem 3rem 3rem 3rem;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .status-icon {
            font-size: 4rem;
            color: #F59E0B; /* Warning/Pending Color */
            margin-bottom: 1.5rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2.5rem;
            margin-bottom: 3rem;
        }

        .info-item {
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 1rem;
        }

        .info-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-size: 1.1rem;
            color: var(--text-primary);
            font-weight: 500;
        }

        .receipt-actions {
            display: flex;
            gap: 1.5rem;
            margin-top: 3rem;
        }

        .btn-edit {
            flex: 1;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-edit:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .btn-confirm {
            flex: 1;
            padding: 1rem;
            background: var(--accent-color);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-confirm:hover {
            background: var(--accent-hover);
            transform: translateY(-2px);
        }
    </style>
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
            <a href="Book_Appointment.php">Book Appointment</a>
        </nav>
        <div class="auth-buttons">
            <a href="logout.php" class="btn-login">Logout</a>
        </div>
    </header>

    <div class="booking-container">
        <a href="Book_Appointment.php" class="back-link">
            <i class="fa-solid fa-arrow-left"></i> Back to Editing
        </a>

        <div class="receipt-card">
            <div class="receipt-body">
                <div class="receipt-header">
                    <div class="status-icon">
                        <i class="fa-solid fa-file-circle-question"></i>
                    </div>
                    <h1>Confirm Appointment</h1>
                    <p>Please review your appointment details before finalizing.</p>
                </div>

                <div class="info-grid">
                    <!-- Patient Info -->
                    <div class="info-item">
                        <p class="info-label">Patient Name</p>
                        <p class="info-value"><?php echo htmlspecialchars($full_name); ?></p>
                    </div>
                    <div class="info-item">
                        <p class="info-label">Contact Number</p>
                        <p class="info-value"><?php echo htmlspecialchars($phone); ?></p>
                    </div>

                    <!-- Appointment Info -->
                    <div class="info-item">
                        <p class="info-label">Physician</p>
                        <p class="info-value"><?php echo htmlspecialchars($appt['doctor_name']); ?> (<?php echo htmlspecialchars($appt['doctor_specialty']); ?>)</p>
                    </div>
                    <div class="info-item">
                        <p class="info-label">Scheduled Date</p>
                        <p class="info-value"><?php echo date('F d, Y', strtotime($appt['appointment_date'])); ?></p>
                    </div>

                    <div class="info-item">
                        <p class="info-label">Time Slot</p>
                        <p class="info-value"><?php echo htmlspecialchars($appt['appointment_time']); ?></p>
                    </div>
                    <div class="info-item">
                        <p class="info-label">Problem Type</p>
                        <p class="info-value"><?php echo htmlspecialchars($appt['problem_type']); ?></p>
                    </div>

                    <div class="info-item">
                        <p class="info-label">Appointment Type</p>
                        <p class="info-value"><?php echo htmlspecialchars($appt['appointment_type']); ?></p>
                    </div>
                </div>

                <div class="receipt-actions">
                    <a href="Book_Appointment.php" class="btn-edit">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                    <a href="user_receipt.php?action=confirm" class="btn-confirm">
                        <i class="fa-solid fa-circle-check"></i> Confirm
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
