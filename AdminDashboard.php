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
    display: flex;
}

/* SIDEBAR */
.sidebar {
    width: 230px;
    background: #ffffff;
    min-height: 100vh;
    padding: 20px;
}

.sidebar h2 {
    color: #06b6d4;
}

.sidebar a {
    display: block;
    padding: 10px;
    margin: 8px 0;
    text-decoration: none;
    color: #333;
    border-radius: 8px;
}

.sidebar a:hover {
    background: #e0f7f6;
    color: #06b6d4;
}

/* MAIN */
.main {
    flex: 1;
    padding: 30px;
}

/* HEADER */
.header {
    color: white;
    margin-bottom: 20px;
}

/* CARDS */
.cards {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
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
    margin-bottom: 20px;
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
</style>
</head>

<body>

<div class="container">

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>🏥 Admin</h2>
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
                <p>Cardiologist</p>
                <div class="status">Available</div>
            </div>

            <div class="doctor">
                <img src="sujan.jpg">
                <h4>Dr Sujan</h4>
                <p>Dentist</p>
                <div class="status">Available</div>
            </div>

            <div class="doctor">
                <img src="anish.jpg">
                <h4>Dr Anish</h4>
                <p>Dermatology</p>
                <div class="status">Available</div>
            </div>
        </div>
    </div>

    <!-- APPOINTMENTS -->
    <div class="table-box" id="appointments">
        <h3>Appointments</h3>
        <p>No appointments yet</p>
    </div>

</div>

</div>

</body>
</html>