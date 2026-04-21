<?php
$conn = new mysqli("localhost", "root", "", "sd");

// ADD SUBJECT
if(isset($_POST['add'])){
    $course = $_POST['course'];
    $semester = $_POST['semester'];
    $name = $_POST['subject_name'];
    $code = $_POST['subject_code'];
    $hours = $_POST['hours'];
    
    $check = $conn->query("SELECT * FROM subjects WHERE subject_code='$code'");
    if($check->num_rows > 0){
        header("Location: ".$_SERVER['PHP_SELF']."?added=exists");
        exit;
    } else {
        if($conn->query("INSERT INTO subjects (course, semester, subject_name, subject_code, hours_per_week) 
                  VALUES ('$course', '$semester', '$name', '$code', '$hours')")){
            header("Location: ".$_SERVER['PHP_SELF']."?added=1");
            exit;
        } else {
            header("Location: ".$_SERVER['PHP_SELF']."?added=0");
            exit;
        }
    }
}

// DELETE SUBJECT
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    if($conn->query("DELETE FROM subjects WHERE id=$id")){
        header("Location: ".$_SERVER['PHP_SELF']."?deleted=1");
        exit;
    } else {
        header("Location: ".$_SERVER['PHP_SELF']."?deleted=0");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Subject Management</title>
    <style>
        body{
            font-family: Arial;
            background: linear-gradient(to right, #667eea, #764ba2);
            padding: 20px;
        }
        .container{
            background: white;
            padding: 20px;
            width: 500px;
            margin: auto;
            border-radius: 10px;
        }
        input, select, button{
            width: 90%;
            padding: 10px;
            margin: 8px 0;
        }
        table{
            width: 90%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td{
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        a{
            color: red;
            text-decoration: none;
        }
        button[name="add"] {
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button[name="add"]:hover {
            background: #218838;
        }
        .back{
            display: inline-block;
            margin: 20px auto;
            padding: 10px 20px;
            background: #12b809f1;
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
        .delete{
            background:red;
            color:white;
            padding:5px 10px;
            text-decoration:none;
            border-radius:4px;
        }
    </style>
</head>
<body>

<?php
if (isset($_GET['added'])) {
    if ($_GET['added'] == 1) {
        echo "<script>alert('Subject added successfully!');</script>";
    } elseif ($_GET['added'] == 'exists') {
        echo "<script>alert('Subject code already exists!');</script>";
    } else {
        echo "<script>alert('Error adding subject!');</script>";
    }
}

if (isset($_GET['deleted'])) {
    if ($_GET['deleted'] == 1) {
        echo "<script>alert('Subject deleted successfully!');</script>";
    } else {
        echo "<script>alert('Delete unsuccessful!');</script>";
    }
}
?>


<div class="container">
    <h2>Subject Management</h2>

    <!-- FORM -->
    <form method="POST">
        <select name="course" required>
            <option value="">Select Course</option>
            <option>BCA</option>
            <option>BCom</option>
            <option>BBA</option>
            <option>BA</option>
            <option>BSc</option>
        </select>

        <select name="semester" required>
            <option value="">Select Semester</option>
            <?php
            $semesters = $conn->query("SELECT * FROM semester_management ORDER BY semester_id ASC");
            while ($row = $semesters->fetch_assoc()) {
                echo "<option value='{$row['semester_name']}'>{$row['semester_name']}</option>";
            }
            ?>
        </select>

        <input type="text" name="subject_name" placeholder="Subject Name" required>
        <input type="text" name="subject_code" placeholder="Subject Code" required>
        <input type="number" name="hours" placeholder="Hours per Week" required>

        <button type="submit" name="add">Add Subject</button>
    </form>

    <!-- DISPLAY TABLE -->
    <table>
        <tr>
            <th>Course</th>
            <th>Sem</th>
            <th>Name</th>
            <th>Code</th>
            <th>Hours</th>
            <th>Action</th>
        </tr>

        <?php
        $result = $conn->query("SELECT * FROM subjects");
        while($row = $result->fetch_assoc()){
            echo "<tr>
                <td>{$row['course']}</td>
                <td>{$row['semester']}</td>
                <td>{$row['subject_name']}</td>
                <td>{$row['subject_code']}</td>
                <td>{$row['hours_per_week']}</td>
                <td><a class='delete' href='?delete={$row['id']}' onclick=\"return confirm('Are you sure you want to delete this subject?');\">Delete</a></td>
            </tr>";
        }
        ?>
    </table>
</div><br>
<a class="back" href="admin_dashboard.php">Back</a>
</body>
</html>
