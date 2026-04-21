
<?php
include'connect.php';
$conn = mysqli_connect("localhost","root","","SD");

if(!$conn){
die("Connection failed: ".mysqli_connect_error());
}

/* -------- ADD COURSE + SECTION -------- */

if(isset($_POST['add'])){

$course_id = $_POST['course_id'];
$course_name = $_POST['course_name'];
$section_id = $_POST['section_id'];
$section_name = $_POST['section_name'];

mysqli_query($conn,"INSERT INTO course(course_id,course_name,section_id,section_name)
VALUES('$course_id','$course_name','$section_id','$section_name')");

}

/* -------- DELETE SECTION -------- */

if(isset($_GET['delete_course']) && isset($_GET['delete_section'])){

$course_id = $_GET['delete_course'];
$section_id = $_GET['delete_section'];

mysqli_query($conn,"DELETE FROM course 
WHERE course_id='$course_id' AND section_id='$section_id'");

}

/* -------- DELETE WHOLE COURSE -------- */

if(isset($_GET['delete_whole_course'])){

$course_id = $_GET['delete_whole_course'];

mysqli_query($conn,"DELETE FROM course WHERE course_id='$course_id'");

}

?>

<!DOCTYPE html>
<html>

<head>

<title>Course Section Management</title>

<style>

body{
font-family:Arial;
background:#f2f2f2;
}

.container{
width:450px;
margin:40px auto;
background:white;
padding:20px;
border-radius:8px;
box-shadow:0 0 10px gray;
}

input,select{
width:100%;
padding:10px;
margin:10px 0;
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
background:gray;
color:white;
padding:5px 10px;
text-decoration:none;
border-radius:4px;
}

</style>

</head>

<body>

<div class="container">

<h2>Add Course & Section</h2>

<form method="POST">

<label>Course Name</label>

<select name="course_name" onchange="courseID(this.value)" required>

<option value="">Select Course</option>
<option value="BCA">BCA</option>
<option value="BBA">BBA</option>
<option value="BA">BA</option>
<option value="BCom">BCom</option>
<option value="BSc">BSc</option>

</select>

<input type="number" name="course_id" id="course_id" placeholder="Course ID" required>


<label>Section</label>

<select name="section_name" onchange="sectionID(this.value)" required>

<option value="">Select Section</option>
<option value="A">A</option>
<option value="B">B</option>
<option value="C">C</option>
<option value="D">D</option>

</select>

<input type="number" name="section_id" id="section_id" placeholder="Section ID" required>

<button type="submit" name="add">Add</button>

</form>

<a class="back" href="home.php">Back</a>

</div>


<h2 style="text-align:center;">Course Section List</h2>

<table>

<tr>
<th>Course ID</th>
<th>Course</th>
<th>Section ID</th>
<th>Section</th>
<th>Action</th>
</tr>

<?php

$result = mysqli_query($conn,"SELECT * FROM course ORDER BY course_id,section_id");

while($row=mysqli_fetch_assoc($result)){

?>

<tr>

<td><?php echo $row['course_id']; ?></td>
<td><?php echo $row['course_name']; ?></td>
<td><?php echo $row['section_id']; ?></td>
<td><?php echo $row['section_name']; ?></td>

<td>

<a class="delete"
href="?delete_course=<?php echo $row['course_id']; ?>&delete_section=<?php echo $row['section_id']; ?>">
Delete Section
</a>

<br><br>

<a class="delete"
href="?delete_whole_course=<?php echo $row['course_id']; ?>">
Delete Course
</a>

</td>

</tr>

<?php } ?>

</table>


<script>

function courseID(name){

let ids={
"BCA":1,
"BBA":2,
"BA":3,
"BCom":4,
"BSc":5
};

document.getElementById("course_id").value=ids[name]||"";

}

function sectionID(name){

let ids={
"A":1,
"B":2,
"C":3,
"D":4
};

document.getElementById("section_id").value=ids[name]||"";

}

</script>

</body>

</html>