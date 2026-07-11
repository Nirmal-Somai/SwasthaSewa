<div class="doctor-showcase">

    <div class="doctor-photo">
        <img src="sujan.jpg" alt="Dr Sujan Sodari">
    </div>

    <div class="doctor-details">

        <span class="department-tag">DERMATOLOGY DEPARTMENT</span>

        <h1>Dr. Sujan Sodari</h1>

        <h3>Consultant Dermatologist & Skin Care Specialist</h3>

        <p>
            Dr. Sujan Sodari is a dedicated dermatologist specializing in the
            diagnosis, treatment, and prevention of skin, hair, and nail
            disorders. He is committed to helping patients achieve healthy skin
            through evidence-based treatments and personalized care plans.
        </p>

        <p>
            With expertise in managing acne, eczema, psoriasis, skin allergies,
            pigmentation concerns, hair loss, and other dermatological
            conditions, Dr. Sodari focuses on delivering effective treatments
            while ensuring patient comfort and confidence.
        </p>

        <div class="specialties">

            <div class="specialty">
                ✨ Acne Treatment
            </div>

            <div class="specialty">
                🌿 Skin Allergies
            </div>

            <div class="specialty">
                💇 Hair & Scalp Care
            </div>

            <div class="specialty">
                🩺 General Dermatology
            </div>

        </div>

        <div class="doctor-stats">

            <div class="stat">
                <h2>300+</h2>
                <span>Patients Treated</span>
            </div>

            <div class="stat">
                <h2>97%</h2>
                <span>Patient Satisfaction</span>
            </div>

            <div class="stat">
                <h2>24/7</h2>
                <span>Support Team</span>
            </div>

        </div>

        <a href="Book_Appointment.php" class="appointment-btn">
            Book Appointment →
        </a>

    </div>

</div>
<style>
    body{
    background:#eef5ff;
}

.doctor-showcase{
    max-width:1200px;
    margin:50px auto;
    display:flex;
    align-items:center;
    gap:50px;

    background:linear-gradient(
        135deg,
        #0f172a,
        #1e3a8a
    );

    border-radius:30px;
    padding:50px;
    color:white;

    box-shadow:
        0 20px 40px rgba(0,0,0,.15);
}

.doctor-photo{
    flex:0 0 320px;
}

.doctor-photo img{
    width:100%;
    height:420px;
    object-fit:cover;

    border-radius:25px;

    border:4px solid rgba(255,255,255,.2);
}

.department-tag{
    background:#38bdf8;
    color:#082f49;

    padding:8px 15px;
    border-radius:50px;

    font-size:.8rem;
    font-weight:bold;
}

.doctor-details h1{
    margin:20px 0 10px;
    font-size:3rem;
}

.doctor-details h3{
    color:#93c5fd;
    margin-bottom:20px;
}

.doctor-details p{
    color:#dbeafe;
    line-height:1.8;
    font-size:1rem;
}

.specialties{
    display:flex;
    flex-wrap:wrap;
    gap:12px;
    margin-top:25px;
}

.specialty{
    background:rgba(255,255,255,.1);
    padding:12px 18px;
    border-radius:50px;
    backdrop-filter:blur(10px);
}

.doctor-stats{
    display:flex;
    gap:40px;
    margin-top:30px;
}

.stat h2{
    margin:0;
    color:#60a5fa;
}

.stat span{
    color:#cbd5e1;
    font-size:.9rem;
}

.appointment-btn{
    display:inline-block;
    margin-top:35px;

    background:white;
    color:#1e3a8a;

    padding:15px 30px;

    border-radius:12px;
    text-decoration:none;
    font-weight:bold;

    transition:.3s;
}

.appointment-btn:hover{
    transform:translateY(-3px);
}

@media(max-width:900px){

    .doctor-showcase{
        flex-direction:column;
        text-align:center;
    }

    .doctor-photo{
        width:100%;
        max-width:320px;
    }

    .doctor-stats{
        justify-content:center;
    }

    .specialties{
        justify-content:center;
    }

    .doctor-details h1{
        font-size:2.2rem;
    }
}
</style>