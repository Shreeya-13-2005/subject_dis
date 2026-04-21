<?php
$conn = new mysqli("localhost", "root", "", "sd");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// INSERT WITH MAX 16 HOURS CONDITION
if (isset($_POST['submit'])) {
    $semester = $_POST['semester'];
    $staff_id = $_POST['staff_id'];
    $subject_id = $_POST['subject_id'];
    $section = $_POST['section'];
    $allocated_hours = (int)$_POST['allocated_hours'];

    $lec_total = $conn->query("SELECT SUM(allocated_hours) AS total_lec_hours FROM subject_allocation WHERE staff_id='$staff_id'");
    $lec_total_row = $lec_total->fetch_assoc();
    $current_lec_hours = $lec_total_row['total_lec_hours'] ?? 0;

    $check = $conn->query("SELECT * FROM subject_allocation 
                           WHERE staff_id='$staff_id' AND subject_id='$subject_id' 
                           AND section_name='$section' AND semester='$semester'");
    if ($check->num_rows > 0) {
        echo "<script>alert('This lecturer already has this subject in this section for this semester!');</script>";
    } elseif (($current_lec_hours + $allocated_hours) > 16) {
        echo "<script>alert('Cannot allocate! Lecturer exceeds 16 hours/week');</script>";
    }elseif(isset($_POST['submit'])) {
    $semester = $_POST['semester'];
    $staff_id = $_POST['staff_id'];
    $subject_id = $_POST['subject_id'];
    $section = $_POST['section'];
    $allocated_hours = (int)$_POST['allocated_hours'];

    // Get subject's max hours per week
    $subject_info = $conn->query("SELECT hours_per_week FROM subjects WHERE id='$subject_id'");
    $subject_row = $subject_info->fetch_assoc();
    $max_hours = $subject_row['hours_per_week'];

    // Total hours already allocated for this subject in this section+semester
    $total_alloc = $conn->query("SELECT SUM(allocated_hours) AS total_hours 
                                 FROM subject_allocation 
                                 WHERE subject_id='$subject_id' 
                                 AND section_name='$section' 
                                 AND semester='$semester'");
    $total_row = $total_alloc->fetch_assoc();
    $current_subject_hours = $total_row['total_hours'] ?? 0;

    // Lecturer’s current workload
    $lec_total = $conn->query("SELECT SUM(allocated_hours) AS total_lec_hours 
                               FROM subject_allocation 
                               WHERE staff_id='$staff_id'");
    $lec_total_row = $lec_total->fetch_assoc();
    $current_lec_hours = $lec_total_row['total_lec_hours'] ?? 0;

    // Duplicate check
    $check = $conn->query("SELECT * FROM subject_allocation 
                           WHERE staff_id='$staff_id' AND subject_id='$subject_id' 
                           AND section_name='$section' AND semester='$semester'");
    if ($check->num_rows > 0) {
        echo "<script>alert('This lecturer already has this subject in this section for this semester!');</script>";
    } elseif (($current_lec_hours + $allocated_hours) > 16) {
        echo "<script>alert('Cannot allocate! Lecturer exceeds 16 hours/week');</script>";
    } elseif (($current_subject_hours + $allocated_hours) > $max_hours) {
        $remaining = $max_hours - $current_subject_hours;
        echo "<script>alert('Cannot allocate! Only $remaining hours remaining for this subject in this section.');</script>";
    } else {
        $sql = "INSERT INTO subject_allocation (semester, staff_id, subject_id, section_name, allocated_hours)
                VALUES ('$semester', '$staff_id', '$subject_id', '$section', '$allocated_hours')";
        $conn->query($sql);
        echo "<script>alert('Subject Allocated Successfully');</script>";
    }
}

     else {
        $sql = "INSERT INTO subject_allocation (semester, staff_id, subject_id, section_name, allocated_hours)
                VALUES ('$semester', '$staff_id', '$subject_id', '$section', '$allocated_hours')";
        $conn->query($sql);
        echo "<script>alert('Subject Allocated Successfully');</script>";
    }
}

// DELETE
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $conn->query("DELETE FROM subject_allocation WHERE id='$delete_id'");
    echo "<script>alert('Deleted Successfully'); window.location.href='subject_allocation.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Subject Allocation</title>
<style>
body { font-family: Arial; background: linear-gradient(to right, #667eea, #764ba2); margin:0; padding:0; }
.box { width: 90%; max-width: 900px; margin: 30px auto; background: white; padding: 20px; border-radius: 10px; box-shadow:0 0 10px gray; }
.back { display:inline-block; margin:20px auto; padding:10px 20px; background:#12b809f1; color:#fff; border:none; border-radius:6px; font-weight:600; text-decoration:none; transition:background 0.3s, transform 0.3s; }
.back:hover { background:green; transform:scale(1.05); }
select, input, button { width:90%; padding:10px; margin:10px 0; }
button { background:#28a745; color:white; border:none; border-radius:5px; padding:10px; font-size:16px; cursor:pointer; transition:background 0.3s; }
button:hover { background:#218838; }
table { width:100%; margin-top:20px; border-collapse:collapse; }
th, td { padding:8px; text-align:center; border:1px solid #ddd; }
th { background:#ddd; }
.delete-btn { background:red; color:white; padding:5px 10px; text-decoration:none; border-radius:4px; }
</style>
</head>
<body>

<!-- FORM BOX -->
<div class="box">
<h2>Subject Allocation Form</h2>
<form method="POST">
<select name="semester" required>
    <option value="">Select Semester</option>
    <?php
    $semesters = $conn->query("SELECT * FROM semester_management ORDER BY semester_id ASC");
    while ($row = $semesters->fetch_assoc()) {
        echo "<option value='{$row['semester_name']}'>{$row['semester_name']}</option>";
    }
    ?>
</select>

<select name="staff_id" required>
<option value="">Select Lecturer</option>
<?php
$staff = $conn->query("SELECT * FROM staff_management");
while ($row = $staff->fetch_assoc()) {
    echo "<option value='{$row['staff_id']}'>{$row['staff_id']} - {$row['name']}</option>";
}
?>
</select>

<select name="subject_id" required>
<option value="">Select Subject</option>
<?php
$subjects = $conn->query("SELECT * FROM subjects");
while ($row = $subjects->fetch_assoc()) {
    echo "<option value='{$row['id']}'>{$row['subject_name']} ({$row['subject_code']})</option>";
}
?>
</select>

<select name="section" required>
<option value="">Select Section</option>
<?php
$sections = $conn->query("SELECT * FROM section_management ORDER BY course_name, section_name ASC");
while ($row = $sections->fetch_assoc()) {
    echo "<option value='{$row['section_name']}'>{$row['course_name']} -  {$row['section_name']}</option>";
}
?>
</select>

<input type="number" name="allocated_hours" placeholder="Enter Hours for this allocation" required>
<button type="submit" name="submit">Allocate</button>
</form>
<a class="back" href="admin_dashboard.php">Back</a>
</div>

<!-- ALLOCATED SUBJECTS BOX -->
<div class="box">
<h2>Allocated Subjects</h2>
<table>
<tr>
    <th>ID</th>
    <th>Semester</th>
    <th>Staff</th>
    <th>Subject</th>
    <th>Code</th>
    <th>Allocated Hours</th>
    <th>Section</th>
    <th>Action</th>
</tr>
<?php
$result = $conn->query("SELECT sa.id, sa.semester, sm.name, s.subject_name, s.subject_code, sa.allocated_hours, sa.section_name
                        FROM subject_allocation sa
                        JOIN staff_management sm ON sa.staff_id = sm.staff_id
                        JOIN subjects s ON sa.subject_id = s.id");
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['semester']}</td>
            <td>{$row['name']}</td>
            <td>{$row['subject_name']}</td>
            <td>{$row['subject_code']}</td>
            <td>{$row['allocated_hours']}</td>
            <td>{$row['section_name']}</td>
            <td><a class='delete-btn' href='?delete_id={$row['id']}' onclick=\"return confirm('Delete this allocation?')\">Delete</a></td>
          </tr>";
}
?>
</table>
</div>

<!-- WEEKLY WORKLOAD BOX -->
<div class="box">
<h2>Weekly Workload</h2>
<table>
<tr>
    <th>Staff ID</th>
    <th>Name</th>
    <th>Total Hours</th>
</tr>
<?php
$load = $conn->query("SELECT sm.staff_id, sm.name, SUM(sa.allocated_hours) AS total_hours
                      FROM subject_allocation sa
                      JOIN staff_management sm ON sa.staff_id = sm.staff_id
                      GROUP BY sm.staff_id");
while ($row = $load->fetch_assoc()) {
    echo "<tr>
            <td>{$row['staff_id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['total_hours']}</td>
          </tr>";
}
?>
</table>
</div>

</body>
</html>