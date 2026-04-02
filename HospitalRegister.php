<?php
session_start();
include("db.php");

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if ($name && $email && $_POST['password']) {

        $stmt = $conn->prepare("INSERT INTO admins (name,email,password) VALUES (?,?,?)");
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            $success = "Admin created successfully!";
        } else {
            $error = "Something went wrong!";
        }

    } else {
        $error = "All fields required!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>SwasthaSewa Hospital Register</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="HospitalRegister.css">

</head>

<body>

<div class="card">

<h2>Register Hospital</h2>
<p class="subtitle">Create admin account</p>

<?php if($error) echo "<div class='msg error'>$error</div>"; ?>
<?php if($success) echo "<div class='msg success'>$success</div>"; ?>

<form method="POST">

<input type="text" name="name" placeholder="Hospital Name">
<input type="email" name="email" placeholder="Hospital Email">
<input type="password" name="password" placeholder="Password">

<button type="submit">Create Account</button>

</form>

<a href="HospitalAdminLogin.php">Already have account? Login</a>

</div>

</body>
</html>