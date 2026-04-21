<?php
// Connect to the database
include'connect.php';
$conn = mysqli_connect("localhost","root","","sd");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


/* ===================== ADD SEMESTER ===================== */
if (isset($_POST['add'])) {
    $semester_name = mysqli_real_escape_string($conn, $_POST['semester_name']); // safe input

    // Check if semester already exists
    $check_query = "SELECT * FROM semester_management WHERE semester_name='$semester_name'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Semester already exists
        echo "<script>alert('Semester already exists!');</script>";
    } else {
        // Insert new semester
        $query = "INSERT INTO semester_management(semester_name) VALUES('$semester_name')";
        if (mysqli_query($conn, $query)) {
            header("Location: ".$_SERVER['PHP_SELF']."?success=1"); // prevent resubmission + success flag
            exit;
        } else {
            echo "Error adding semester: " . mysqli_error($conn);
        }
    }
}

/* ===================== DELETE SEMESTER ===================== */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']); // safe integer
    mysqli_query($conn,"DELETE FROM semester_management WHERE semester_id='$id'");
    header("Location: ".$_SERVER['PHP_SELF']); // redirect after deletion
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Semester Management</title>
    <style>
        body{
            font-family: Arial, sans-serif;
             background: linear-gradient(to right, #667eea, #764ba2);
            margin:0;
            padding:0;
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
        .back:hover
        {
            background:green;
            transform: scale(1.05);
        }

        .container{
            width:400px;
            margin:40px auto;
            background:white;
            padding:20px;
            border-radius:8px;
            box-shadow:0 0 10px gray;
        }
        h2{
            text-align:center;
            margin-bottom:20px;
        }
        input{
            width:90%;
            padding:10px;
            margin:10px 0;
            border:1px solid #ccc;
            border-radius:5px;
        }
        button{
            width:100%;
            padding:10px;
            background:#007bff;
            color:white;
            border:none;
            border-radius:5px;
            cursor:pointer;
            font-size:16px;
        }
        button:hover{
            background:#0056b3;
        }
        table{
            width:80%;
            max-width:600px;
            margin:30px auto;
            border-collapse: collapse;
            background:white;
        }
        th, td{
            padding:12px;
            border:1px solid #ddd;
            text-align:center;
        }
        th{
            background:#007bff;
            color:white;
        }
        .delete{
            background:red;
            color:white;
            padding:5px 10px;
            text-decoration:none;
            border-radius:4px;
            font-weight:bold;
        }
        .delete:hover{
            background:#cc0000;
        }
    </style>
</head>
<body>

<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <script>alert('Semester added successfully!');</script>
<?php endif; ?>

<div class="container">
    <h2>Add Semester</h2>
    <form method="POST">
        <input type="text" name="semester_name" placeholder="Enter Semester Name" required>
        <button type="submit" name="add">Add Semester</button>
    </form>
</div>

<h2 style="text-align:center;">Semester List</h2>
<table>
    <tr>
        <th>Semester ID</th>
        <th>Semester Name</th>
        <th>Action</th>
    </tr>
    <?php
    $result = mysqli_query($conn,"SELECT * FROM semester_management ORDER BY semester_id ASC");
    while($row = mysqli_fetch_assoc($result)) {
    ?>
    <tr>
        <td><?php echo $row['semester_id']; ?></td>
        <td><?php echo $row['semester_name']; ?></td>
        <td>
            <a class="delete" href="?delete=<?php echo $row['semester_id']; ?>" onclick="return confirm('Are you sure you want to delete this semester?');">Delete</a>
        </td>
    </tr>
    <?php
    }
    ?>
</table>
<a class="back" href="admin_dashboard.php">Back</a>

</body>
</html>
