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
            <a href="login.php">Hospitals</a>
            <a href="login.php">Clinics</a>
            <a href="login.php">Book Appointment</a>
            <a href="login.php">View Crowd Level</a>
        </nav>
        <a href="login.php" class="btn-login">User Sign Up</a>
        <a href="HospitalAdminLogin.php" class="btn-login">Admin Sign Up</a>
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
                <button class="btn-search" onclick="window.location.href='login.php'">Search</button>
            </div>

            <div class="tags-wrapper">
                <button class="tag active" onclick="window.location.href='login.php'">All</button>
                <button class="tag" onclick="window.location.href='login.php'"><i class="fa-solid fa-heart-pulse"></i>
                    Select Doctor</button>
                <button class="tag" onclick="window.location.href='login.php'"><i class="fa-regular fa-clock"></i>
                    ENT</button>
                <button class="tag" onclick="window.location.href='login.php'"><i class="fa-solid fa-heart-pulse"></i>
                    Cardiology</button>
                <button class="tag" onclick="window.location.href='login.php'"><i class="fa-solid fa-baby"></i>
                    Pediatrics</button>
                <button class="tag" onclick="window.location.href='login.php'"><i class="fa-solid fa-brain"></i>
                    Dental</button>
                <button class="tag" onclick="window.location.href='login.php'"><i class="fa-solid fa-brain"></i>
                    Skin</button>
                <button class="tag" onclick="window.location.href='login.php'"><i class="fa-solid fa-brain"></i>
                    Eye</button>
                <button class="tag" onclick="window.location.href='login.php'"><i class="fa-solid fa-brain"></i>
                    Child</button>
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
                <div class="hospital-card">
                    <div class="hospital-img">
                        <img src="1.png" alt="Hospital Building"
                            style="width:100%; height:100%; object-fit:cover; opacity: 0.9;">
                        <span class="status-badge status-open">Open Now</span>
                    </div>
                    <div style="padding: 1.5rem;">
                        <h3 style="font-size:1.1rem; margin-bottom:0.5rem; color:white;">Goldhhunga Hospital</h3>
                        <p style="color:#9CA3AF; font-size:0.9rem;"><i class="fa-solid fa-location-dot"
                                style="margin-right:0.4rem;"></i>145 Goldhhunga, Nepal</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="hospital-card">
                    <div class="hospital-img">
                        <img src="2.png" alt="Clinic Interior"
                            style="width:100%; height:100%; object-fit:cover; opacity: 0.9;">
                        <span class="status-badge status-open">Open Now</span>
                    </div>
                    <div style="padding: 1.5rem;">
                        <h3 style="font-size:1.1rem; margin-bottom:0.5rem; color:white;">Lolang Medical Clinic</h3>
                        <p style="color:#9CA3AF; font-size:0.9rem;"><i class="fa-solid fa-location-dot"
                                style="margin-right:0.4rem;"></i> 49 Lolang, Nepal</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="hospital-card">
                    <div class="hospital-img">
                        <img src="3.png" alt="Medical Center"
                            style="width:100%; height:100%; object-fit:cover; opacity: 0.5;">
                        <span class="status-badge status-closed">Closed</span>
                    </div>
                    <div style="padding: 1.5rem;">
                        <h3 style="font-size:1.1rem; margin-bottom:0.5rem; color:white;">Dhading Urgent Care</h3>
                        <p style="color:#9CA3AF; font-size:0.9rem;"><i class="fa-solid fa-location-dot"
                                style="margin-right:0.4rem;"></i> 780 Dhading, Nepal</p>
                    </div>
                </div>
            </div>
        </section>



    </main>

</body>

</html>