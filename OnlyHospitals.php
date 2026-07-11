<style>
    .hospital-card {
        width: 320px;
        background: #1f2937;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .hospital-card:hover {
        transform: translateY(-5px);
    }

    .hospital-img {
        width: 100%;
        height: 200px; /* Fixed image height */
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

    .hospital-content i {
        margin-right: 0.4rem;
    }
</style>

<div style="display:flex; gap:20px; flex-wrap:wrap;">

    <!-- Hospital 1 -->
    <a href="dhading_urgent_care.php" style="text-decoration:none;">
    <div class="hospital-card">
        <div class="hospital-img">
            <img src="3.png" alt="Dhading Urgent Care">
        </div>
        <div class="hospital-content">
            <h3>Dhading Urgent Care</h3>
            <p>
                <i class="fa-solid fa-location-dot"></i>
                780 Dhading, Nepal
            </p>
        </div>
    </div>
    </a>

    <!-- Hospital 2 -->
    <a href="goldhhunga_hospital.php" style="text-decoration:none;">
                    <div class="hospital-card">
                        <div class="hospital-img">
                            <img src="1.png" alt="Clinic Interior">
                        </div>
                        <div class="hospital-content">
                            <h3>Goldhhunga Hospital</h3>
                            <p>
                                <i class="fa-solid fa-location-dot"></i>
                                40 Goldhunga, Kathmandu
                            </p>
                        </div>
                    </div>
                </a>

</div>