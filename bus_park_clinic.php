<?php
session_start();
include("db.php");

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Hospital Data
$hospital_name = "Bus Park Clinic"; // Change this for each hospital
$hospital_img = "5.png";            // Change image file
$hospital_loc = "46 Bus Park, Nepal"; // Change location

// Optional: Customize services for each hospital
$services = [
    "Community Health",
    "Family Planning",
    "Health Education"
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $hospital_name; ?> - SwasthaSewa
    </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="user_dashboard.css">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            overflow-x: hidden;
            background: #111827;
        }

        /* Navbar */
        .navbar {
            padding: 10px 20px;
            background: #1F2937;
        }

        .logo {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        /* Main card */
        .detail-card {
            max-width: 600px;
            margin: 20px auto;
            background: #1E293B;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #374151;
        }

        /* Image */
        .detail-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        /* Content */
        .detail-content {
            padding: 15px;
        }

        .btn-back-home {
            display: inline-block;
            margin-bottom: 10px;
            color: #9CA3AF;
            font-size: 14px;
            text-decoration: none;
        }

        .btn-back-home:hover {
            color: #10B981;
        }

        /* Title & Location */
        .detail-content h1 {
            font-size: 20px;
            color: white;
            margin-bottom: 8px;
        }

        .detail-content p {
            font-size: 13px;
            color: #9CA3AF;
            margin-bottom: 12px;
        }

        /* Services */
        .service-box {
            background: rgba(255, 255, 255, 0.05);
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #374151;
        }

        .service-box h3 {
            font-size: 14px;
            margin-bottom: 8px;
            color: #10B981;
        }

        .service-box ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .service-box li {
            font-size: 12px;
            margin-bottom: 5px;
            color: #9CA3AF;
        }

        /* Button */
        .btn-search {
            margin-top: 15px;
            width: 100%;
            padding: 10px;
            font-size: 13px;
            background: #10B981;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-search:hover {
            background: #059669;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <header class="navbar">
        <a href="users_dashboard.php" class="logo">
            <i class="fa-solid fa-heart-pulse"></i> SwasthaSewa
        </a>
    </header>

    <!-- Main Content -->
    <main>
        <div class="detail-card">

            <!-- Image -->
            <img src="<?php echo $hospital_img; ?>" alt="<?php echo $hospital_name; ?>" class="detail-img">

            <!-- Content -->
            <div class="detail-content">

                <!-- Back -->
                <a href="users_dashboard.php" class="btn-back-home">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>

                <!-- Title -->
                <h1>
                    <?php echo $hospital_name; ?>
                </h1>

                <!-- Location -->
                <p>
                    <i class="fa-solid fa-location-dot" style="color:#10B981;"></i>
                    <?php echo $hospital_loc; ?>
                </p>

                <!-- Services -->
                <div class="service-box">
                    <h3>Available Services</h3>
                    <ul>
                        <?php foreach ($services as $service) { ?>
                            <li><i class="fa-solid fa-check" style="color:#10B981;"></i>
                                <?php echo $service; ?>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

                <!-- Button -->
                <a href="Book_Appointment.php">
                    <button class="btn-search">Book Appointment</button>
                </a>

            </div>
        </div>
    </main>
</body>

</html>