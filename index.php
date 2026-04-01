<?php
$error_message = '';
$success_message = '';
$email = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']);
    if (empty($email) || empty($password)) {
        $error_message = "Please fill in all required fields.";
    } 
    // Validation Password 
    elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters long.";
    } 
    else {
        // 3. Simple Authentication Check
        // Added admin@example.com for dummy logic
        $valid_email = "admin@example.com";
        $valid_password = "password123";
        // condication lako 
        if (($email === $valid_email || $email === 'admin') && $password === $valid_password) {
            $success_message = "Login successful! Welcome back.";
        } else {
            $error_message = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SwasthaSewa Login</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="main-wrapper">
        <div class="login-card">
            
            <!-- Left Side: Login Form -->
            <div class="login-left">
               <h1>SwasthaSewa</h1>
                
                <p class="subtitle">Please login to your account</p>
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-error">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($success_message)): ?>
                    <div class="alert alert-success">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <!-- Form starts here -->
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    
                    <div class="input-group">
                        <div class="icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </div>
                        <input type="text" name="email" value="<?php echo $email; ?>" placeholder="Email" required>
                    </div>
                    
                    <div class="input-group">
                        <div class="icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </div>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>

                    <div class="forgot-password">
                        <a href="#">Forgot your password ?</a>
                    </div>

                    <button type="submit" class="btn-login">Login</button>
                    
                    <div class="create-account">
                        <a href="#">Create a new account</a>
                    </div>

                    <div class="social-login">
                        <button type="button" class="btn-facebook">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="#1877f2"><path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.312h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/></svg>
                            Facebook
                        </button>
                        <button type="button" class="btn-google">
                            <svg width="18" height="18" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                            Google
      </button>
     </div>
      </form>
    </div>
     <!-- Right Side Image and Decorations -->
     <div class="login-right">
     <div class="circle-bg"></div>
     <img src="doctor_image.png" alt="Doctor displaying app" class="hero-img">
     </div>
    </div>
    </div>
</body>
</html>
