<?php
session_start();
include("db.php");

/* protect */
if (!isset($_SESSION['admin_id'])) {
    header("Location: HospitalAdminLogin.php");
    exit();
}

/* PAGE SWITCH SYSTEM */
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

/* SAFE COUNTS */
$users = 0;
$admins = 0;
$appointments = 0;

if ($conn->query("SHOW TABLES LIKE 'users'")->num_rows > 0) {
    $users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
}

if ($conn->query("SHOW TABLES LIKE 'admins'")->num_rows > 0) {
    $admins = $conn->query("SELECT COUNT(*) as total FROM admins")->fetch_assoc()['total'];
}

if ($conn->query("SHOW TABLES LIKE 'appointments'")->num_rows > 0) {
    $appointments = $conn->query("SELECT COUNT(*) as total FROM appointments")->fetch_assoc()['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
body {
    margin:0;
    font-family:Poppins;
    background:linear-gradient(135deg,#2dd4bf,#06b6d4);
}

.container { display:flex; }

/* SIDEBAR */
.sidebar {
    width:230px;
    background:white;
    min-height:100vh;
    padding:20px;
}

.sidebar h2 {
    color:#06b6d4;
}

.sidebar a {
    display:block;
    padding:10px;
    margin:6px 0;
    text-decoration:none;
    color:#333;
    border-radius:8px;
}

.sidebar a:hover {
    background:#e0f7f6;
    color:#06b6d4;
}

/* MAIN */
.main {
    flex:1;
    padding:30px;
}

h1 { color:white; }

/* CARDS */
.cards {
    display:flex;
    gap:20px;
}

.card {
    background:white;
    padding:20px;
    border-radius:12px;
    width:200px;
    text-align:center;
}

.card p {
    font-size:24px;
    font-weight:bold;
    color:#06b6d4;
}

/* USERS TABLE */
table {
    width:100%;
    background:white;
    border-collapse:collapse;
    border-radius:10px;
    overflow:hidden;
}

th, td {
    padding:12px;
    border-bottom:1px solid #eee;
}

/* DOCTOR CARDS */
.doctors {
    display:flex;
    flex-wrap:wrap;
    gap:20px;
}

.doctor-card {
    width:220px;
    background:white;
    border-radius:12px;
    padding:15px;
    text-align:center;
}

.doctor-card img {
    width:80px;
    height:80px;
    border-radius:50%;
    object-fit:cover;
}

.small {
    font-size:13px;
    color:gray;
}
</style>

</head>

<body>

<div class="container">

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>🏥 Admin</h2>

    <a href="AdminDashboard.php?page=dashboard">Dashboard</a>
    <a href="AdminDashboard.php?page=users">Users</a>
    <a href="AdminDashboard.php?page=doctors">Doctors</a>
    <a href="#" onclick="return false;">Appointments</a>
    <a href="logout.php">Logout</a>
</div>

<!-- MAIN -->
<div class="main">

<?php if ($page == 'dashboard') { ?>

    <h1>Dashboard</h1>

    <div class="cards">
        <div class="card">
            <h3>Users</h3>
            <p><?= $users ?></p>
        </div>

        <div class="card">
            <h3>Admins</h3>
            <p><?= $admins ?></p>
        </div>

        <div class="card">
            <h3>Appointments</h3>
            <p><?= $appointments ?></p>
        </div>
    </div>

<?php } ?>

<!-- USERS PAGE -->
<?php if ($page == 'users') { ?>

    <h1>User Data</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>

        <?php
        $result = $conn->query("SELECT id, first_name, last_name, email, phone FROM users");
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['first_name']} {$row['last_name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['phone']}</td>
                </tr>";
            }
        }
        ?>
    </table>

<?php } ?>

<!-- DOCTORS PAGE -->
<?php if ($page == 'doctors') { ?>

    <h1>Doctors</h1>

    <div class="doctors">

        <?php
        /* SAMPLE STATIC DOCTORS (you can later connect DB) */
        $doctors = [
            ["name"=>"Dr. Sharma", "special"=>"Cardiologist", "time"=>"10AM - 2PM"],
            ["name"=>"Dr. Gupta", "special"=>"Neurologist", "time"=>"2PM - 6PM"],
            ["name"=>"Dr. Rai", "special"=>"Dermatologist", "time"=>"9AM - 1PM"]
        ];

        foreach ($doctors as $doc) {
            echo "
            <div class='doctor-card'>
                <img src='https://i.imgur.com/8Km9tLL.png'>
                <h3>{$doc['name']}</h3>
                <p class='small'>{$doc['special']}</p>
                <p class='small'>Available: {$doc['time']}</p>
            </div>";
        }
        ?>

    </div>

<?php } ?>

</div>

</div>

</body>
</html>