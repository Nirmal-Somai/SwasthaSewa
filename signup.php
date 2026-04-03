<?php
session_start();
include("db.php");

$error_message = '';
$success_message = '';

$first_name = '';
$last_name = '';
$gender = '';
$phone = '';
$email = '';

if (isset($_SESSION['success'])) {
    $success_message = $_SESSION['success'];
    unset($_SESSION['success']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $gender = htmlspecialchars(trim($_POST['gender']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']);

    // honeypot (bot protection)
    $honeypot = $_POST['website_url'] ?? '';
    if (!empty($honeypot)) {
        die("Invalid request.");
    }

    // validation
    if (empty($first_name) || empty($last_name) || empty($gender) || empty($phone) || empty($email) || empty($password)) {
        $error_message = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address.";
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters long.";
    } else {

        // check if email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_message = "An account with this email already exists.";
        } else {

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // insert user
            $insert_stmt = $conn->prepare(
                "INSERT INTO users (first_name, last_name, gender, phone, email, password)
                 VALUES (?, ?, ?, ?, ?, ?)"
            );

            if ($insert_stmt) {

                $insert_stmt->bind_param(
                    "ssssss",
                    $first_name,
                    $last_name,
                    $gender,
                    $phone,
                    $email,
                    $hashed_password
                );

                if ($insert_stmt->execute()) {
                    $_SESSION['user_id'] = $insert_stmt->insert_id;
                    $_SESSION['success'] = "Account created successfully!";
                    header("Location: user_profile.php");
                    exit();
                } else {
                    $error_message = "Could not create account. Try again.";
                }

                $insert_stmt->close();
            } else {
                $error_message = "Database error.";
            }
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SwasthaSewa Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .hidden-field {
            display: none !important;
        }

        /* Override layout to be centered and single-column on signup page */
        .login-card {
            max-width: 550px !important;
            margin: 0 auto;
        }

        .login-left {
            flex: 1 !important;
            padding: 2.5rem 3rem !important;
        }

        .login-right {
            display: none !important;
        }

        /* Setup grid for 2 columns for shorter fields */
        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .input-group {
            flex: 1;
        }

        .gender-options {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 10px 0;
            margin-bottom: 1.2rem;
            color: #333;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .gender-options label {
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
        }
    </style>
</head>
<?php if (isset($_SESSION['redirect'])): ?>
    <script>
        setTimeout(() => {
            const msg = document.querySelector(".alert-success");
            if (msg) {
                msg.style.opacity = "0";

                setTimeout(() => {
                    window.location.href = "login.php";
                }, 500);
            } else {
                window.location.href = "login.php";
            }
        }, 3000);
    </script>
    <?php unset($_SESSION['redirect']); endif; ?>

<body>
    <div class="main-wrapper">
        <div class="login-card">

            <div class="login-left">
                <h1 style="text-align: center; color: #212121; margin-bottom: 0.5rem; font-size: 2rem;">SwasthaSewa</h1>
                <p class="subtitle" style="text-align: center;">Create your personal account</p>

                <?php if (!empty($success_message)): ?>
                    <div class="alert alert-success">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-error">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                    <div class="input-group hidden-field">
                        <input type="text" name="website_url" tabindex="-1" autocomplete="off"
                            placeholder="Leave this empty">
                    </div>

                    <div class="form-row">
                        <div class="input-group">
                            <input type="text" name="first_name" value="<?php echo $first_name; ?>"
                                placeholder="First Name" required>
                        </div>
                        <div class="input-group">
                            <input type="text" name="last_name" value="<?php echo $last_name; ?>"
                                placeholder="Last Name" required>
                        </div>
                    </div>

                    <div class="gender-options">
                        <span style="color: #8ab4f8; margin-right: 5px;">Gender:</span>
                        <label>
                            <input type="radio" name="gender" value="Male" <?php if ($gender == 'Male')
                                echo 'checked'; ?>
                                required> Male
                        </label>
                        <label>
                            <input type="radio" name="gender" value="Female" <?php if ($gender == 'Female')
                                echo 'checked'; ?> required> Female
                        </label>
                    </div>

                    <div class="input-group">
                        <div class="icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                </path>
                            </svg>
                        </div>
                        <input type="tel" name="phone" value="<?php echo $phone; ?>" placeholder="Phone Number"
                            required>
                    </div>

                    <div class="input-group">
                        <div class="icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                </path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                        <input type="email" name="email" value="<?php echo $email; ?>" placeholder="Email Address"
                            required>
                    </div>

                    <div class="input-group">
                        <div class="icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </div>
                        <input type="password" name="password" placeholder="Password (min 6 chars)" required>
                    </div>

                    <button type="submit" class="btn-login" style="margin-top: 10px;">Create Account</button>

                    <div class="create-account">
                        <a href="login.php">Already have an account? Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>