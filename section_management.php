<?php

$conn = mysqli_connect("localhost","root","","SD");

if(!$conn){
die("Connection failed: ".mysqli_connect_error());
}

/* ---------- ADD SECTION ---------- */

if(isset($_POST['add'])){

$course = $_POST['course_name'];
$section = $_POST['section_name'];
// Check if this course + section already exists
    $check = mysqli_query($conn, "SELECT * FROM section_management 
                                  WHERE course_name='$course' 
                                  AND section_name='$section'");

    if(mysqli_num_rows($check) > 0){
        echo "<script>alert('This course and section already exist!');</script>";
    } else {
mysqli_query($conn,"INSERT INTO section_management(course_name,section_name)
VALUES('$course','$section')");
 echo "<script>alert('Section added successfully!');</script>";
    }

}

/* ---------- DELETE SECTION ---------- */
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    if(mysqli_query($conn,"DELETE FROM section_management WHERE section_id='$id'")){
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

<title>Section Management</title>

<style>

body{
font-family:Arial;
 background: linear-gradient(to right, #667eea, #764ba2);
margin:0;
padding:0;
}

.container{
width:450px;
margin:40px auto;
background:white;
padding:20px;
border-radius:8px;
box-shadow:0 0 10px gray;
}

h2{
text-align:center;
}

select{
width:100%;
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
}

button:hover{
background:#0056b3;
}

table{
width:90%;
margin:30px auto;
border-collapse:collapse;
background:white;
}

th,td{
padding:10px;
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
            margin-left:45%;
}
.back:hover{
      background:green;
            transform: scale(1.05);
}
</style>

</head>

<body>

<?php
if (isset($_GET['deleted'])) {
    if ($_GET['deleted'] == 1) {
        echo "<script>alert('Section deleted successfully!');</script>";
    } else {
        echo "<script>alert('Delete unsuccessful!');</script>";
    }
}
?>

<div class="container">

<h2>Section Management</h2>

<form method="POST">

<label>Course</label>

<select name="course_name" required>

<option value="">Select Course</option>
<option value="BCA">BCA</option>
<option value="BBA">BBA</option>
<option value="BA">BA</option>
<option value="BCom">BCom</option>
<option value="BSc">BSc</option>

</select>


<label>Section</label>

<select name="section_name" required>

<option value="">Select Section</option>
<option value="A">A</option>
<option value="B">B</option>
<option value="C">C</option>
<option value="D">D</option>

</select>

<button type="submit" name="add">Add Section</button>

</form>

<br>

<a class="back" href="admin_dashboard.php">Back</a>

</div>


<h2 style="text-align:center;">Section List</h2>

<table>

<tr>
<th>ID</th>
<th>Course</th>
<th>Section</th>
<th>Action</th>
</tr>

<?php

$result = mysqli_query($conn,"SELECT * FROM section_management");

while($row=mysqli_fetch_assoc($result)){

?>

<tr>

<td><?php echo $row['section_id']; ?></td>
<td><?php echo $row['course_name']; ?></td>
<td><?php echo $row['section_name']; ?></td>

<td>

<a class="delete" href="?delete=<?php echo $row['section_id']; ?>">
Delete
</a>

</td>

</tr>

<?php } ?>

</table>

</body>
</html>