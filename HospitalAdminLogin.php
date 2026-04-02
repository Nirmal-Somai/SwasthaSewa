<?php
session_start();
include("db.php");

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($email && $password) {

        $stmt = $conn->prepare("SELECT id, name, password FROM admins WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {

            $admin = $result->fetch_assoc();

            if (password_verify($password, $admin['password'])) {

                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];

                header("Location: AdminDashboard.php");
                exit();

            } else {
                $error = "Wrong password!";
            }

        } else {
            $error = "Admin not found!";
        }

    } else {
        $error = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>SwasthaSewa Hospital Login</title>

<link rel="stylesheet" href="HospitalRegister.css">
</head>

<body>

<div class="card">

<h2>Admin Login</h2>
<p class="subtitle">Access Hospital System</p>

<?php if($error) echo "<div class='msg error'>$error</div>"; ?>

<form method="POST">

<input type="email" name="email" placeholder="Hospital Email" required>
<input type="password" name="password" placeholder="Password" required>

<button type="submit">Login</button>

</form>

<a href="HospitalRegister.php">Create new admin account</a>

</div>

</body>
</html>