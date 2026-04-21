<?php
$conn = new mysqli("localhost", "root", "", "sd");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$staff_id = "";
?>

<!DOCTYPE html>
<html>
<head>
<title>View Allocated Subjects</title>

<style>
body { font-family: Arial;  background: linear-gradient(to right, #667eea, #764ba2); }
.box {
    width: 600px;
    margin: 40px auto;
    background: white;
    padding: 20px;
    border-radius: 10px;
}
input, button {
    width: 90%;
    padding: 10px;
    margin: 10px 0;
}
button {
    background: blue;
    color: white;
    border: none;
}
table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}
th, td {
    padding: 8px;
    text-align: center;
    
}
th { background: #4663e5; }
button[name="view"]{
    width:35%;
    border-radius:10px;
}
button[name="view"]:hover{
    background: #4d0db5;
}
 .back{
            display: inline-block;
            margin: 20px auto;
            padding: 10px 20px;
            background: #12b809f1;;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.3s, transform 0.3s;
            margin-left:50%;
        }
        .back:hover{
            background:green;
            transform: scale(1.05);
        }



</style>

</head>
<body>

<div class="box">
<h2>View Allocated Subjects</h2>

<form method="POST">
    <input type="text" name="staff_id" placeholder="Enter Staff ID" required>
    <button type="submit" name="view">View</button>
</form>

<?php
if (isset($_POST['view'])) {

    $staff_id = $_POST['staff_id'];

    // CHECK STAFF EXISTS
    $check = $conn->query("SELECT * FROM staff_management WHERE staff_id='$staff_id'");
    if ($check->num_rows == 0) {
        echo "<p style='color:red;'>Staff ID not found!</p>";
    } else {

        echo "<h3>Allocated Subjects</h3>";
        echo "<table border='1'>
        <tr>
            <th>Semester</th>
            <th>Subject</th>
            <th>Code</th>
            <th>Section</th>
            <th>Hours/Week</th>
            
            
        </tr>";

        $result = $conn->query("
            SELECT 
                s.semester,
                s.subject_name,
                s.subject_code,
                sa.section_name,
                s.hours_per_week
                
            FROM subject_allocation sa
            JOIN subjects s ON sa.subject_id = s.id
            WHERE sa.staff_id = '$staff_id'
        ");

        $total_hours = 0;

        while ($row = $result->fetch_assoc()){
            $total_hours += $row['hours_per_week'];

            echo "<tr>
                    <td>{$row['semester']}</td>
                    <td>{$row['subject_name']}</td>
                    <td>{$row['subject_code']}</td>
                    <td>{$row['section_name']}</td>
                    <td>{$row['hours_per_week']}</td>
                  </tr>";
                  
        }


        echo "</table>";

        echo "<h3>Total Workload: $total_hours Hours/Week</h3>";

        // WARNING if near limit
        if ($total_hours >= 12) {
            echo "<p style='color:orange;'>Warning: Near maximum workload</p>";
        }
        if ($total_hours >= 15) {
            echo "<p style='color:red;'>Maximum workload reached!</p>";
        }
    }
}
?>

</div>
<a class="back" href="staff_dashboard.php">Back</a>
</body>
</html>