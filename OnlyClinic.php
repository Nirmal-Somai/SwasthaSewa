<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OnlyClinic</title>
</head>
<style>
    .hospital-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 20px;
    padding: 20px;
}

.hospital-card {
    background: #1f2937;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    transition: transform 0.3s ease;
}

.hospital-card:hover {
    transform: translateY(-5px);
}

.hospital-img {
    width: 100%;
    height: 200px;
    overflow: hidden;
}

.hospital-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    opacity: 0.7;
}

.hospital-content {
    padding: 1.5rem;
}

.hospital-content h3 {
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
    color: #fff;
}

.hospital-content p {
    color: #9CA3AF;
    font-size: 0.9rem;
    margin: 0;
}
</style>
<body>
<div class="hospital-grid">
<a href="lolang_medical_clinic.php" style="text-decoration:none;">
                    <div class="hospital-card">
                        <div class="hospital-img">
                            <img src="2.png" alt="Clinic Interior">
                        </div>
                        <div class="hospital-content">
                            <h3>Lolang Medical Clinic</h3>
                            <p>
                                <i class="fa-solid fa-location-dot"></i>
                                Lolang, Kathmandu
                            </p>
                        </div>
                    </div>
                </a>

    <!-- Card 4 -->
    <a href="gorkha_medical_clinic.php" style="text-decoration:none;">
        <div class="hospital-card">
            <div class="hospital-img">
                <img src="4.png" alt="Gorkha Medical Clinic">
            </div>
            <div class="hospital-content">
                <h3>Gorkha Medical Clinic</h3>
                <p>
                    <i class="fa-solid fa-location-dot"></i>
                    40 Gorkha, Nepal
                </p>
            </div>
        </div>
    </a>

    <!-- Card 5 -->
    <a href="bus_park_clinic.php" style="text-decoration:none;">
        <div class="hospital-card">
            <div class="hospital-img">
                <img src="5.png" alt="Bus Park Clinic">
            </div>
            <div class="hospital-content">
                <h3>Bus Park Clinic</h3>
                <p>
                    <i class="fa-solid fa-location-dot"></i>
                    46 Bus Park, Nepal
                </p>
            </div>
        </div>
    </a>

    <!-- Card 6 -->
    <a href="machapokhari_medical_clinic.php" style="text-decoration:none;">
        <div class="hospital-card">
            <div class="hospital-img">
                <img src="6.png" alt="Machapokhari Medical Clinic">
            </div>
            <div class="hospital-content">
                <h3>Machapokhari Medical Clinic</h3>
                <p>
                    <i class="fa-solid fa-location-dot"></i>
                    4 Machapokhari, Nepal
                </p>
            </div>
        </div>
    </a>

</div>
</body>
</html>