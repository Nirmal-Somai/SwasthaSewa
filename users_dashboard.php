<?php
session_start();
include("db.php");

// Default Fallback
$user_name = "My Profile";
$user_initials_query = "User";

// Fetch the user's name if they are logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT first_name, last_name FROM users WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $user_name = htmlspecialchars($user['first_name'] . ' ' . $user['last_name']);
            $user_initials_query = urlencode($user['first_name'] . ' ' . $user['last_name']);
        }
        $stmt->close();
    }
} else {
    // If somehow accessed without login, send to login
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SwasthaSewa - Find Premium Care Near You</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Main Style -->
    <link rel="stylesheet" href="user_dashboard.css">
</head>

<body>

    <!-- Header Navbar -->
    <header class="navbar">
        <a href="#" class="logo">
            <i class="fa-solid fa-heart-pulse"></i>
            SwasthaSewa
        </a>
        <nav class="nav-links">
            <a href="#">Hospitals</a>
            <a href="#">Clinics</a>
            <a href="Book_Appointment.php">Book Appointment</a>
            <a href="#"> View Crowd Level</a>
        </nav>


        <!-- Replaced Login Button with User Profile Button -->
        <a href="user_profile.php" class="user-profile-btn"
            style="display: flex; align-items: center; gap: 0.5rem; text-decoration: none; color: var(--text-primary);">
            <span style="font-weight: 600; font-size: 0.95rem;">
                <?php echo $user_name; ?>
            </span>
            <img src="https://ui-avatars.com/api/?name=<?php echo $user_initials_query; ?>&background=4F46E5&color=fff"
                alt="User Photo"
                style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid var(--accent-color);">
        </a>
    </header>

    <!-- Main Hero Section -->
    <main>
        <section class="hero">
            <div class="badge-wrapper">
                <span class="badge">Trusted Healthcare Providers</span>
            </div>

            <h1>Find Premium Care<br>Near You</h1>
            <p>Discover top-rated hospitals, specialized clinics, and urgent care centers in moments, tailored to your
                immediate needs.</p>

            <div class="search-container">
                <div class="search-field">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search by hospital name, specialty...">
                </div>
                <div class="search-divider"></div>
                <div class="search-field" style="max-width: 200px;">
                    <i class="fa-solid fa-location-dot"></i>
                    <input type="text" value="All Nepal">
                </div>
                <button class="btn-search">Search</button>
            </div>

            <div class="tags-wrapper">
                <button class="tag active">All</button>
                <button class="tag" onclick="window.location.href='Book_Appointment.php'"><i class="fa-solid fa-heart-pulse"></i> Select Doctor</button>
                <button class="tag"><i class="fa-regular fa-clock"></i> ENT</button>
                <button class="tag"><i class="fa-solid fa-heart-pulse"></i> Cardiology</button>
                <button class="tag"><i class="fa-solid fa-baby"></i> Pediatrics</button>
                <button class="tag"><i class="fa-solid fa-brain"></i> Dental</button>
                <button class="tag"><i class="fa-solid fa-brain"></i> Skin</button>
                <button class="tag"><i class="fa-solid fa-brain"></i>Eye</button>

                <button class="tag"><i class="fa-solid fa-brain"></i>Child</button>
            </div>
        </section>

        <!-- Top Results Content -->
        <section class="main-content">
            <div class="section-header">
                <div class="section-title">
                    Top Results <span class="count-badge">6</span>
                </div>
                <div class="view-options">
                    <button class="view-btn"><i class="fa-solid fa-bars"></i></button>
                    <button class="view-btn"><i class="fa-solid fa-map"></i></button>
                </div>
            </div>

            <div class="results-grid">
                <!-- Card 1 -->
                <a href="goldhhunga_hospital.php" style="text-decoration:none;">
                    <div class="hospital-card">
                        <div class="hospital-img">
                            <img src="1.png" alt="Hospital Building"
                                style="width:100%; height:100%; object-fit:cover; opacity: 0.9;">
                        </div>
                        <div style="padding: 1.5rem;">
                            <h3 style="font-size:1.1rem; margin-bottom:0.5rem; color:white;">Goldhhunga Hospital</h3>
                            <p style="color:#9CA3AF; font-size:0.9rem;">
                                <i class="fa-solid fa-location-dot" style="margin-right:0.4rem;"></i>145 Goldhhunga,
                                Nepal
                            </p>
                        </div>
                    </div>
                </a>

                <!-- Card 2 -->
                <a href="lolang_medical_clinic.php" style="text-decoration:none;">
                    <div class="hospital-card">
                        <div class="hospital-img">
                            <img src="2.png" alt="Clinic Interior"
                                style="width:100%; height:100%; object-fit:cover; opacity: 0.9;">
                        </div>
                        <div style="padding: 1.5rem;">
                            <h3 style="font-size:1.1rem; margin-bottom:0.5rem; color:white;">Lolang Medical Clinic</h3>
                            <p style="color:#9CA3AF; font-size:0.9rem;">
                                <i class="fa-solid fa-location-dot" style="margin-right:0.4rem;"></i> 49 Lolang, Nepal
                            </p>
                        </div>
                    </div>
                </a>

                <!-- Card 3 -->
                <a href="dhading_urgent_care.php" style="text-decoration:none;">
                    <div class="hospital-card">
                        <div class="hospital-img">
                            <img src="3.png" alt="Medical Center"
                                style="width:100%; height:100%; object-fit:cover; opacity: 0.5;">
                        </div>
                        <div style="padding: 1.5rem;">
                            <h3 style="font-size:1.1rem; margin-bottom:0.5rem; color:white;">Dhading Urgent Care</h3>
                            <p style="color:#9CA3AF; font-size:0.9rem;">
                                <i class="fa-solid fa-location-dot" style="margin-right:0.4rem;"></i> 780 Dhading, Nepal
                            </p>
                        </div>
                    </div>
                </a>

                <!-- Card 4 -->
                <a href="gorkha_medical_clinic.php" style="text-decoration:none;">
                    <div class="hospital-card">
                        <div class="hospital-img">
                            <img src="4.png" alt="Clinic Interior"
                                style="width:100%; height:100%; object-fit:cover; opacity: 0.9;">
                        </div>
                        <div style="padding: 1.5rem;">
                            <h3 style="font-size:1.1rem; margin-bottom:0.5rem; color:white;">Gorkha Medical Clinic</h3>
                            <p style="color:#9CA3AF; font-size:0.9rem;">
                                <i class="fa-solid fa-location-dot" style="margin-right:0.4rem;"></i> 40 Gorkha, Nepal
                            </p>
                        </div>
                    </div>
                </a>
                <!-- Card 5 -->
                <a href="bus_park_clinic.php" style="text-decoration: none;">
                    <div class="hospital-card">
                        <div class="hospital-img">
                            <img src="5.png" alt="Medical Center"
                                style="width:100%; height:100%; object-fit:cover; opacity: 0.5;">
                        </div>
                        <div style="padding: 1.5rem;">
                            <h3 style="font-size:1.1rem; margin-bottom:0.5rem; color:white;">Bus Park Clinic</h3>
                            <p style="color:#9CA3AF; font-size:0.9rem;">
                                <i class="fa-solid fa-location-dot" style="margin-right:0.4rem;"></i> 46 Bus Park, Nepal
                            </p>
                        </div>
                    </div>
                </a>
                <!-- Card 6 -->

                <a href="machapokhari_medical_clinic.php" style="text-decoration: none;">
                    <div class="hospital-card">
                        <div class="hospital-img">
                            <img src="6.png" alt="Hospital Building"
                                style="width:100%; height:100%; object-fit:cover; opacity: 0.9;">
                        </div>
                        <div style="padding: 1.5rem;">
                            <h3 style="font-size:1.1rem; margin-bottom:0.5rem; color:white;">
                                Machapokhari Medical Clinic
                            </h3>
                            <p style="color:#9CA3AF; font-size:0.9rem;">
                                <i class="fa-solid fa-location-dot" style="margin-right:0.4rem;"></i> 4 Machapokhari,
                                Nepal
                            </p>
                        </div>
                    </div>
                </a>


            </div>
        </section>

    </main>

    <script>
        document.querySelector('.btn-search').addEventListener('click', function () {
            const query = document.querySelector('.search-field input[type="text"]').value.toLowerCase().trim();

            if (query.includes('gorkha')) {
                window.location.href = 'gorkha_medical_clinic.php';
            } else if (query.includes('goldhhunga')) {
                window.location.href = 'goldhhunga_hospital.php';
            } else if (query.includes('lolang')) {
                window.location.href = 'lolang_medical_clinic.php';
            } else if (query.includes('dhading')) {
                window.location.href = 'dhading_urgent_care.php';
            } else if (query.includes('machapokhari')) {
                window.location.href = 'machapokhari_medical_clinic.php';
            } else if (query.includes('bus park') || query.includes('buspark')) {
                window.location.href = 'bus_park_clinic.php';
            } else if (query === "") {
                alert("Please enter a hospital name to search.");
            } else {
                alert('No hospital found. Try searching for Gorkha, Lolang, Dhading, etc.');
            }
        });

        // Also handle "Enter" key press
        document.querySelector('.search-field input[type="text"]').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                document.querySelector('.btn-search').click();
            }
        });
    </script>
</body>

</html>