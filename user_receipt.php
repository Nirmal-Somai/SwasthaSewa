<?php
session_start();
include("db.php");

// 1. MUST BE LOGGED IN
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// 1a. HANDLE CONFIRMATION ACTION
if (isset($_GET['action']) && $_GET['action'] == 'confirm' && isset($_SESSION['pending_appointment'])) {
    $p = $_SESSION['pending_appointment'];
    $stmt = $conn->prepare("INSERT INTO appointments (user_id, doctor_name, doctor_specialty, problem_type, appointment_date, appointment_time, appointment_type, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("issssss", $user_id, $p['doctor_name'], $p['doctor_specialty'], $p['problem_type'], $p['appointment_date'], $p['appointment_time'], $p['appointment_type']);
    
    if ($stmt->execute()) {
        $appointment_id = $stmt->insert_id;
        $stmt->close();
        unset($_SESSION['pending_appointment']); // Clear the session
        header("Location: user_receipt.php?id=$appointment_id&status=success");
        exit();
    }
    $stmt->close();
}

$appointment_id = $_GET['id'] ?? null;

if (!$appointment_id) {
    header("Location: users_dashboard.php");
    exit();
}

// 2. FETCH APPOINTMENT DETAILS
// We join with the users table to get the full name (security: only for the logged-in user)
$stmt = $conn->prepare("SELECT a.*, u.first_name, u.last_name, u.email, u.phone 
                        FROM appointments a 
                        JOIN users u ON a.user_id = u.id 
                        WHERE a.id = ? AND a.user_id = ?");
$stmt->bind_param("ii", $appointment_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Either appointment doesn't exist or it doesn't belong to this user
    header("Location: users_dashboard.php");
    exit();
}

$appt = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Receipt - SwasthaSewa</title>
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

        .receipt-badge {
            position: absolute;
            top: 2rem;
            right: 2rem;
            padding: 0.5rem 1.2rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .badge-pending {
            background: rgba(245, 158, 11, 0.15);
            color: #F59E0B;
            border: 1px solid rgba(245, 158, 11, 0.3);
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
            color: var(--accent-color);
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

        .btn-print {
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
        }

        .btn-print:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .btn-dashboard {
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

        .btn-dashboard:hover {
            background: var(--accent-hover);
            transform: translateY(-2px);
        }

        @media print {
            .navbar, .back-link, .receipt-actions {
                display: none;
            }
            body {
                background: white;
                color: black;
            }
            .receipt-card {
                box-shadow: none;
                border: 1px solid #ddd;
            }
            .info-label { color: #666; }
            .info-value { color: #000; }
        }
    </style>
</head>

<body>

    <!-- Reuse Navbar -->
    <header class="navbar">
        <a href="users_dashboard.php" class="logo">
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
        <a href="users_dashboard.php" class="back-link">
            <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
        </a>

        <div class="receipt-card">

            <div class="receipt-body">
                <div class="receipt-header">
                    <div class="status-icon">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <h1>Appointment Receipt</h1>
                    <p>Your appointment has been successfully booked and is currently being processed.</p>
                </div>

                <div class="info-grid">
                    <!-- Patient Info -->
                    <div class="info-item">
                        <p class="info-label">Patient Name</p>
                        <p class="info-value"><?php echo htmlspecialchars($appt['first_name'] . ' ' . $appt['last_name']); ?></p>
                    </div>
                    <div class="info-item">
                        <p class="info-label">Contact Number</p>
                        <p class="info-value"><?php echo htmlspecialchars($appt['phone']); ?></p>
                    </div>

                    <!-- Appointment Info -->
                    <div class="info-item">
                        <p class="info-label">Physician</p>
                        <p class="info-value"><?php echo htmlspecialchars($appt['doctor_name']); ?> (<?php echo htmlspecialchars($appt['doctor_specialty']); ?>)</p>
                    </div>
                    <div class="info-item">
                        <p class="info-label">Appointment ID</p>
                        <p class="info-value">#APT-<?php echo str_pad($appt['id'], 5, '0', STR_PAD_LEFT); ?></p>
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
                    <button onclick="window.print()" class="btn-print">
                        <i class="fa-solid fa-print"></i> Print Receipt
                    </button>
                    <a href="users_dashboard.php" class="btn-dashboard">
                        <i class="fa-solid fa-house"></i> Go to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
