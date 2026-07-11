<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Select Doctor</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background:#f4f8fc;
}

.header{
    text-align:center;
    padding:60px 20px 30px;
}

.header h1{
    font-size:3rem;
    color:#0f172a;
    margin-bottom:10px;
}

.header p{
    color:#64748b;
    font-size:1.1rem;
}

.doctor-container{
    max-width:1300px;
    margin:auto;
    padding:30px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
    gap:30px;
}

.doctor-card{
    background:white;
    border-radius:25px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    transition:.3s;
}

.doctor-card:hover{
    transform:translateY(-10px);
}

.doctor-image{
    height:320px;
    overflow:hidden;
}

.doctor-image img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.doctor-content{
    padding:25px;
}

.department{
    display:inline-block;
    background:#dbeafe;
    color:#1d4ed8;
    padding:8px 14px;
    border-radius:30px;
    font-size:.8rem;
    font-weight:bold;
    margin-bottom:15px;
}

.doctor-content h2{
    color:#0f172a;
    margin-bottom:8px;
}

.doctor-content h4{
    color:#2563eb;
    margin-bottom:15px;
}

.doctor-content p{
    color:#64748b;
    line-height:1.7;
    margin-bottom:20px;
}

.book-btn{
    display:inline-block;
    width:100%;
    text-align:center;
    text-decoration:none;
    background:#2563eb;
    color:white;
    padding:14px;
    border-radius:12px;
    font-weight:600;
    transition:.3s;
}

.book-btn:hover{
    background:#1d4ed8;
}
.available-btn{
    background:#22c55e;
    color:white;
    border:none;
    padding:8px 16px;
    border-radius:20px;
    font-size:14px;
    font-weight:600;
    margin:12px 0;
    cursor:default;
}

</style>
</head>
<body>

<div class="header">
    <h1>Choose Your Specialist</h1>
    <p>Select a doctor and schedule your appointment instantly.</p>
</div>

<div class="doctor-container">

    <!-- ENT -->
    <div class="doctor-card">

        <div class="doctor-image">
            <img src="nirmal.jpg" alt="Dr Nirmal Somai">
        </div>

        <div class="doctor-content">

            <span class="department">ENT DEPARTMENT</span>

            <h2>Dr. Nirmal Somai</h2>
            <h4>Consultant ENT Specialist</h4>
            <button class="available-btn">Available</button>

            <p>
                Expert in treating ear, nose, throat, sinus,
                allergy, and hearing-related conditions with
                personalized patient care.
            </p>

            <a href="Book_Appointment.php?doctor=Nirmal" class="book-btn">
                Book Appointment
            </a>

        </div>

    </div>

    <!-- Dermatologist -->
    <div class="doctor-card">

        <div class="doctor-image">
            <img src="sujan.jpg" alt="Dr Sujan Sodari">
        </div>

        <div class="doctor-content">

            <span class="department">DERMATOLOGY</span>

            <h2>Dr. Sujan Sodari</h2>

            <h4>Consultant Dermatologist</h4>
            <button class="available-btn">Available</button>

            <p>
                Specialized in acne treatment, skin allergies,
                pigmentation disorders, hair loss management,
                and overall skin health.
            </p>

            <a href="Book_Appointment.php?doctor=Sujan" class="book-btn">
                Book Appointment
            </a>

        </div>

    </div>

    <!-- Dentist -->
    <div class="doctor-card">

        <div class="doctor-image">
            <img src="anish.jpg" alt="Dr Anish Putuwar">
        </div>

        <div class="doctor-content">

            <span class="department">DENTAL DEPARTMENT</span>

            <h2>Dr. Anish Putuwar</h2>

            <h4>Consultant Dentist</h4>
            <button class="available-btn">Available</button>

            <p>
                Providing preventive dental care, smile
                enhancement, oral health consultations,
                and restorative dental treatments.
            </p>

            <a href="Book_Appointment.php?doctor=Anish" class="book-btn">
                Book Appointment
            </a>

        </div>

    </div>

</div>

</body>
</html>