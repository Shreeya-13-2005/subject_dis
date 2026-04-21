\<?php
include'connect.php';
$conn = new mysqli("localhost", "root", "", "SD");

// INSERT
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $date = $_POST['date'];
    $dept = $_POST['dept'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
 // Check if staff with same name and email already exists
    $check = $conn->query("SELECT * FROM staff_management 
                           WHERE email_id='$email'");

    if($check->num_rows > 0){
        echo "<script>alert('Staff  email already exists!');</script>";
    } else {
    $conn->query("INSERT INTO staff_management (name, date_of_joining, department, email_id, contact_number)
                  VALUES ('$name','$date','$dept','$email','$contact')");
                   echo "<script>alert('Staff added successfully!');</script>";
    }
}

// DELETE
if(isset($_GET['del'])){
    $id = intval($_GET['del']);
    if($conn->query("DELETE FROM staff_management WHERE staff_id=$id")){
        header("Location: ".$_SERVER['PHP_SELF']."?deleted=1");
        exit;
    } else {
        header("Location: ".$_SERVER['PHP_SELF']."?deleted=0");
        exit;
    }
}


// SELECT
$result = $conn->query("SELECT * FROM staff_management");
?>

<!DOCTYPE html>
<html>
<head>
<title>Staff Management</title>
<style>
body{font-family: Arial, sans-serif;
    background: linear-gradient(to right, #667eea, #764ba2);
    margin: 0;
    padding: 20px;}
form,table{padding:10px;margin:10px;}
input,select,button{width: 90%;
    padding: 10px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 5px;}

table{  width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
    background: white;}
th,td{padding: 10px;
    border: 1px solid #ddd;
    text-align: center;}
th{ background: #007bff;
    color: white;}

/* Back Button */
.back {
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
    margin-left: 50%;
}
.back:hover {
    background: green;
    transform: scale(1.05);
}
.container {
    background: white;
    padding: 20px;
    width: 450px;
    margin: auto;
    border-radius: 10px;
    box-shadow: 0 0 10px gray;
}
h2 {
    text-align: center;
    margin-bottom: 20px;
}
button[name="submit"] {
    background: #28a745;   /* green success color */
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s;
}
button[name="submit"]:hover {
    background: #218838;   /* darker green */
}
a.delete {
    color: red;
    text-decoration: none;
    font-weight: bold;
}
a.delete:hover {
    color: #cc0000;
}
</style>
</head>
<body>

<?php
if (isset($_GET['deleted'])) {
    if ($_GET['deleted'] == 1) {
        echo "<script>alert('Staff deleted successfully!');</script>";
    } else {
        echo "<script>alert('Delete unsuccessful!');</script>";
    }
}
?>


<div class="container">
<h2>Add Staff</h2>
<form method="POST">
<input type="text" name="name" placeholder="Name" required>
<input type="date" name="date" required>

<select name="dept" required>
<option value="">Department</option>
<option>BCA</option>
<option>BSc</option>
<option>BA</option>
<option>BBA</option>
<option>B.Com</option>
</select>

<input type="email" name="email" placeholder="Email" required>
<input type="text" name="contact" placeholder="Contact" required>

<button name="submit">Add</button>
</div>
</form>

<h2>Staff List</h2>
<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Date</th>
<th>Dept</th>
<th>Email</th>
<th>Contact</th>
<th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()){ ?>
<tr>
<td><?php echo $row['staff_id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['date_of_joining']; ?></td>
<td><?php echo $row['department']; ?></td>
<td><?php echo $row['email_id']; ?></td>
<td><?php echo $row['contact_number']; ?></td>
<td><a href="?del=<?php echo $row['staff_id']; ?>">Delete</a></td>
</tr>
<?php } ?>

</table>
<!-- ✅ BACK BUTTON -->
<a href="admin_dashboard.php" class="back"> Back</a>
</body>
</html>