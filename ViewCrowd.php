
<?php
include "db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Crowd Level</title>

<style>

body{
    font-family: Arial, sans-serif;
    background:#f4f7fc;
    margin:0;
    padding:30px;
}

h1{
    text-align:center;
    color:#1f2937;
    margin-bottom:30px;
}

h2{
    color:#1f2937;
    margin-top:40px;
}

/* Hospital Cards */

.hospital-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:20px;
    margin-bottom:40px;
}

.hospital-card{
    background:#1f2937;
    border-radius:15px;
    overflow:hidden;
    text-decoration:none;
    color:white;
    transition:0.3s ease;
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
}

.hospital-card:hover{
    transform:translateY(-8px);
    box-shadow:0 10px 25px rgba(0,0,0,0.3);
}

.hospital-card img{
    width:100%;
    height:200px;
    object-fit:cover;
}

.hospital-info{
    padding:15px;
}

.hospital-info h3{
    margin:0 0 8px;
}

.hospital-info p{
    margin:0;
    color:#9CA3AF;
}

/* Crowd Table */

.crowd-table{
    width:100%;
    border-collapse:collapse;
    background:white;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.crowd-table th{
    background:#4F46E5;
    color:white;
    padding:15px;
    text-align:left;
}

.crowd-table td{
    padding:14px;
    border-bottom:1px solid #eee;
}

.crowd-table tr:hover{
    background:#f8fafc;
}

.low{
    color:#10B981;
    font-weight:bold;
}

.medium{
    color:#F59E0B;
    font-weight:bold;
}

.high{
    color:#EF4444;
    font-weight:bold;
}

.no-data{
    background:white;
    padding:20px;
    border-radius:12px;
    margin-top:15px;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
}

</style>
</head>
<body>

<h1>🏥 SwasthaSewa Crowd Dashboard</h1>

<div class="hospital-grid">

    <a href="?hospital=Goldhhunga Hospital" class="hospital-card">
        <img src="1.png" alt="Goldhhunga Hospital">
        <div class="hospital-info">
            <h3>Goldhhunga Hospital</h3>
            <p>Click to view crowd level</p>
        </div>
    </a>

    <a href="?hospital=Lolang Medical Clinic" class="hospital-card">
        <img src="2.png" alt="Lolang Medical Clinic">
        <div class="hospital-info">
            <h3>Lolang Medical Clinic</h3>
            <p>Click to view crowd level</p>
        </div>
    </a>

    <a href="?hospital=Dhading Urgent Care" class="hospital-card">
        <img src="3.png" alt="Dhading Urgent Care">
        <div class="hospital-info">
            <h3>Dhading Urgent Care</h3>
            <p>Click to view crowd level</p>
        </div>
    </a>

    <a href="?hospital=Gorkha Medical Clinic" class="hospital-card">
        <img src="4.png" alt="Gorkha Medical Clinic">
        <div class="hospital-info">
            <h3>Gorkha Medical Clinic</h3>
            <p>Click to view crowd level</p>
        </div>
    </a>

    <a href="?hospital=Bus Park Clinic" class="hospital-card">
        <img src="5.png" alt="Bus Park Clinic">
        <div class="hospital-info">
            <h3>Bus Park Clinic</h3>
            <p>Click to view crowd level</p>
        </div>
    </a>

    <a href="?hospital=Machapokhari Medical Clinic" class="hospital-card">
        <img src="6.png" alt="Machapokhari Medical Clinic">
        <div class="hospital-info">
            <h3>Machapokhari Medical Clinic</h3>
            <p>Click to view crowd level</p>
        </div>
    </a>

</div>

<?php

if(isset($_GET['hospital'])){

    $hospital = $_GET['hospital'];

    echo "<h2>$hospital Crowd Level</h2>";

    if($hospital == "Goldhhunga Hospital"){

        $sql = "SELECT appointment_date,
                       COUNT(*) AS total
                FROM appointments
                WHERE status IN ('Pending','Confirmed')
                GROUP BY appointment_date
                ORDER BY appointment_date ASC";

        $result = $conn->query($sql);

        if($result->num_rows > 0){

            echo "<table class='crowd-table'>
                    <tr>
                        <th>Date</th>
                        <th>Day</th>
                        <th>Appointments</th>
                        <th>Crowd Level</th>
                    </tr>";

            while($row = $result->fetch_assoc()){

                $date = $row['appointment_date'];
                $count = $row['total'];

                if($count <= 5){
                    $crowd = '🟢 Low';
                    $class = 'low';
                }
                elseif($count <= 15){
                    $crowd = '🟡 Medium';
                    $class = 'medium';
                }
                else{
                    $crowd = '🔴 High';
                    $class = 'high';
                }

                $today = date('Y-m-d');
                $tomorrow = date('Y-m-d', strtotime('+1 day'));

                if($date == $today){
                    $dayLabel = 'Today';
                }
                elseif($date == $tomorrow){
                    $dayLabel = 'Tomorrow';
                }
                else{
                    $dayLabel = date('l', strtotime($date));
                }

                echo "<tr>
                        <td>$date</td>
                        <td>$dayLabel</td>
                        <td>$count</td>
                        <td class='$class'>$crowd</td>
                      </tr>";
            }

            echo "</table>";

        }else{
            echo "<div class='no-data'>No appointment data found.</div>";
        }

    }else{

        echo "<div class='no-data'>
                No crowd data found for this hospital.
              </div>";
    }
}
?>

</body>
</html>

