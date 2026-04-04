<?php
session_start();
include("db.php");

/* PROTECT PAGE */
if (!isset($_SESSION['admin_id'])) {
    header("Location: HospitalAdminLogin.php");
    exit();
}

/* COUNTS */
$users = 0;
$admins = 0;
$appointments = 0;

/* USERS COUNT */
$result = $conn->query("SHOW TABLES LIKE 'users'");
if ($result && $result->num_rows > 0) {
    $users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
}

/* ADMINS COUNT */
$result = $conn->query("SHOW TABLES LIKE 'admins'");
if ($result && $result->num_rows > 0) {
    $admins = $conn->query("SELECT COUNT(*) as total FROM admins")->fetch_assoc()['total'];
}

/* APPOINTMENTS COUNT */
$result = $conn->query("SHOW TABLES LIKE 'appointments'");
if ($result && $result->num_rows > 0) {
    $appointments = $conn->query("SELECT COUNT(*) as total FROM appointments")->fetch_assoc()['total'];
}

/* USERS DATA */
$user_data = [];
$result = $conn->query("SELECT first_name, last_name, email, phone FROM users LIMIT 5");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $user_data[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #2dd4bf, #06b6d4);
}
button {
    padding: 8px 12px;
    border: none;
    background: #06b6d4;
    color: white;
    border-radius: 6px;
    cursor: pointer;
}

button:hover {
    background: #0891b2;
}
/* LAYOUT */
.container {
    display: block;
}

/* SIDEBAR */
.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    height: 100vh;
    width: 230px;
    background: #0f172a;
    z-index: 1000;
    padding: 20px;
    overflow-y: auto;
   
}

.sidebar h2 {
    color: #06b6d4;
}

.sidebar a {
    display: block;
    padding: 10px;
    margin: 8px 0;
    text-decoration: none;
    color: white;
    border-radius: 8px;
    transition: 0.2s;
}

.sidebar a:hover {
    background: #06b6d4;
    color: black;
}

/* MAIN */
.main {
    margin-left: 260px;
    padding: 40px;
    width: calc(100% - 260px);
    box-sizing: border-box;
}
html {
    scroll-behavior: smooth;
}

/* HEADER */
.header {
    width: 100%;
    box-sizing: border-box;
}
.header h1 {
    color: white;
    margin-bottom: 20px;
}

/* CARDS */
.cards {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin: 20px 0;
}
.cards, .table-box {
    max-width: 1200px;
}

.card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    width: 200px;
    text-align: center;
}

.card h3 {
    margin: 0;
}

.card p {
    font-size: 24px;
    color: #06b6d4;
}

/* TABLE */
.table-box {
    background: white;
    padding: 20px;
    border-radius: 12px;
    margin: 20px 0;   /* 👈 IMPORTANT: only vertical spacing */
}

html {
    scroll-behavior: smooth;
}

.table-box {
    scroll-margin-top: 20px;  /* prevents weird jump into sidebar area */
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

th {
    text-align: left;
    color: #06b6d4;
}

/* DOCTOR CARDS */
.doctors {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.doctor img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #06b6d4;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.status {
    margin-top: 10px;
    font-size: 14px;
    color: green;
}
body {
    margin: 0;
    overflow-x: hidden;
}
</style>
</head>

<body>

<div class="container">

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>🏥 <?php echo $_SESSION['admin_name']; ?></h2>
    <a href="#">Dashboard</a>
    <a href="#users">Users</a>
    <a href="#doctors">Doctors</a>
    <a href="#appointments">Appointments</a>
    <a href="user_dashboard.php">Logout</a>
</div>

<!-- MAIN -->
<div class="main">

    <div class="header">
        <h1>Welcome, <?php echo $_SESSION['admin_name']; ?></h1>
    </div>

    <!-- STATS -->
    <div class="cards">
        <div class="card">
            <h3>Users</h3>
            <p><?php echo $users; ?></p>
        </div>

        <div class="card">
            <h3>Admins</h3>
            <p><?php echo $admins; ?></p>
        </div>

        <div class="card">
            <h3>Appointments</h3>
            <p><?php echo $appointments; ?></p>
        </div>
    </div>

    <!-- USERS TABLE -->
    <div class="table-box" id="users">
        <h3>Recent Users</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
            <?php foreach ($user_data as $u): ?>
            <tr>
                <td><?php echo $u['first_name'] . " " . $u['last_name']; ?></td>
                <td><?php echo $u['email']; ?></td>
                <td><?php echo $u['phone']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <!-- DOCTORS (STATIC SIMPLE) -->
    <div class="table-box" id="doctors">
        <h3>Doctors</h3>
        <div class="doctors">
            <div class="doctor">
                <img src="nirmal.jpg">
                <h4>Dr Nirmal</h4>
                <p>ENT</p>
                <div class="status">Available</div>
            </div>

            <div class="doctor">
                <img src="sujan.jpg">
                <h4>Dr Sujan</h4>
                <p>Dermatologist</p>
                <div class="status">Available</div>
            </div>

            <div class="doctor">
                <img src="anish.jpg">
                <h4>Dr Anish</h4>
                <p>Dentist</p>
                <div class="status">Available</div>
            </div>
        </div>
    </div>

    <!-- APPOINTMENTS -->
   <!-- APPOINTMENTS -->
<div class="table-box" id="appointments">
    <h3>Appointments</h3>

    <?php
    $appointments_data = [];

    $sql = "SELECT a.*, u.first_name, u.last_name, u.email
            FROM appointments a
            JOIN users u ON a.user_id = u.id
            ORDER BY a.created_at DESC";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0):
    ?>

    <table>
        <tr>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Specialty</th>
            <th>Problem</th>
            <th>Date</th>
            <th>Time</th>
            <th>Type</th>
            <th>Status</th>
        </tr>

        <?php while ($a = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $a['first_name'] . " " . $a['last_name']; ?></td>
            <td><?php echo $a['doctor_name']; ?></td>
            <td><?php echo $a['doctor_specialty']; ?></td>
            <td><?php echo $a['problem_type']; ?></td>
            <td><?php echo $a['appointment_date']; ?></td>
            <td><?php echo $a['appointment_time']; ?></td>
            <td><?php echo $a['appointment_type']; ?></td>
            <td><?php echo $a['status']; ?></td>
        </tr>
        <?php endwhile; ?>

    </table>

    <?php else: ?>
        <p>No appointments yet</p>
    <?php endif; ?>
</div>

</div>

</div>

</body>
</html>