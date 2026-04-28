<?php
include "db.php";

echo "<h1>🏥 SwasthaSewa Dashboard</h1>";

$sql = "SELECT appointment_date, COUNT(*) as total 
        FROM appointments 
        WHERE status IN ('Pending','Confirmed')
        GROUP BY appointment_date";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div style='padding:10px;margin:10px;background:#f2f2f2'>
                <b>Date:</b> {$row['appointment_date']} <br>
                <b>Crowd:</b> {$row['total']}
              </div>";
    }
} else {
    echo "<p>No crowd data found</p>";
}
?>