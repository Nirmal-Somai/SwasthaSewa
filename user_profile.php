<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$success_message = '';
$error_message = '';

if (isset($_SESSION['success'])) {
    $success_message = $_SESSION['success'];
    unset($_SESSION['success']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $gender = htmlspecialchars(trim($_POST['gender']));
    $phone = htmlspecialchars(trim($_POST['phone']));

    if (empty($first_name) || empty($last_name) || empty($gender) || empty($phone)) {
        $error_message = "Please fill in all required fields.";
    } else {
        $update_stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, gender=?, phone=? WHERE id=?");
        if ($update_stmt) {
            $update_stmt->bind_param("ssssi", $first_name, $last_name, $gender, $phone, $user_id);
            if ($update_stmt->execute()) {
                $success_message = "Profile updated successfully!";
            } else {
                $error_message = "Error updating profile.";
            }
            $update_stmt->close();
        }
    }
}

$user = null;
$stmt = $conn->prepare("SELECT first_name, last_name, gender, phone, email FROM users WHERE id = ?");
if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
    }
    $stmt->close();
}
$conn->close();

if (!$user) {
    echo "User not found.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SwasthaSewa - Modify Profile</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Main Style -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="user_dashboard.css">
    <style>
        .profile-container {
            max-width: 650px;
            margin: 4rem auto;
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .profile-header {
            margin-bottom: 2rem;
        }

        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid var(--accent-color);
            margin-bottom: 1rem;
            object-fit: cover;
        }

        .profile-name {
            font-family: var(--font-heading);
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 1rem;
        }

        .form-row .input-group {
            flex: 1;
            margin-bottom: 0;
        }

        .input-group {
            background-color: var(--bg-input);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            padding: 0.8rem 1rem;
            margin-bottom: 1rem;
            text-align: left;
        }

        .input-group i {
            color: var(--text-secondary);
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .input-group input,
        .input-group select {
            background: transparent;
            border: none;
            color: var(--text-primary);
            flex: 1;
            font-size: 1rem;
            outline: none;
            width: 100%;
        }

        .input-group input[readonly] {
            color: var(--text-secondary);
            cursor: not-allowed;
        }

        .btn-update {
            background-color: var(--accent-color);
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
            margin-top: 1rem;
        }

        .btn-update:hover {
            background-color: var(--accent-hover);
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
        }

        .btn-back {
            display: inline-block;
            margin-top: 1.5rem;
            background-color: transparent;
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-back:hover {
            color: var(--accent-color);
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.2);
            color: #10B981;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .alert-error {
            background-color: rgba(239, 68, 68, 0.2);
            color: #EF4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .field-label {
            display: block;
            text-align: left;
            margin-bottom: 0.4rem;
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 500;
        }


        .navbar {
            position: fixed;
            /* stick to top */
            top: 0;
            left: 0;

            background: #5a5a5a;
            /* same as your design */
            padding: 25px 50px;

        }
    </style>
</head>

<body>
    <header class="navbar">
        <a href="users_dashboard.php" class="logo">
            <i class="fa-solid fa-heart-pulse"></i>
            SwasthaSewa
        </a>
    </header>

    <main>
        <div class="profile-container">
            <div class="profile-header">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['first_name'] . ' ' . $user['last_name']); ?>&background=4F46E5&color=fff&size=200"
                    alt="Profile Picture" class="profile-pic">
                <div class="profile-name">
                    <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
                </div>
            </div>

            <?php if (!empty($success_message)): ?>
                <div class="alert alert-success">
                    <i class="fa-solid fa-check-circle" style="margin-right: 8px;"></i>
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-error">
                    <i class="fa-solid fa-exclamation-circle" style="margin-right: 8px;"></i>
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">

                <div class="form-row">
                    <div style="flex: 1;">
                        <label class="field-label">First Name</label>
                        <div class="input-group">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" name="first_name"
                                value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                        </div>
                    </div>
                    <div style="flex: 1;">
                        <label class="field-label">Last Name</label>
                        <div class="input-group">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" name="last_name"
                                value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                        </div>
                    </div>
                </div>

                <div style="text-align: left;">
                    <label class="field-label">Email Address (Read Only)</label>
                    <div class="input-group">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                    </div>
                </div>

                <div style="text-align: left;">
                    <label class="field-label">Phone Number</label>
                    <div class="input-group">
                        <i class="fa-solid fa-phone"></i>
                        <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                    </div>
                </div>

                <div style="text-align: left;">
                    <label class="field-label">Gender</label>
                    <div class="input-group">
                        <i class="fa-solid fa-venus-mars"></i>
                        <select name="gender" required
                            style="background: transparent; border: none; color: var(--text-primary); outline: none; width: 100%;">
                            <option value="Male" style="color: black;" <?php echo ($user['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" style="color: black;" <?php echo ($user['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                            <option value="Other" style="color: black;" <?php echo ($user['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-update">Update Profile</button>
            </form>

            <a href="users_dashboard.php" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </main>
</body>

</html>