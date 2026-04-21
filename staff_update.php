
<?php
$conn = mysqli_connect("localhost","root","","sd");

// Step 1: Fetch data
$staff = null;

if(isset($_POST['fetch'])){
    $staff_id = $_POST['staff_id'];

    $result = $conn->query("SELECT * FROM staff_management WHERE staff_id='$staff_id'");
    
    if($result->num_rows > 0){
        $staff = $result->fetch_assoc();
    } else {
        echo "<script>alert('Staff ID does not exist');</script>";
    }
}

// Step 2: Update data
if(isset($_POST['update'])){
    $staff_id = $_POST['staff_id'];
    $name = $_POST['name'];
    $department = $_POST['department'];
    $date_of_joining = $_POST['date_of_joining'];
    $email_id = $_POST['email_id'];
    $contact_number = $_POST['contact_number'];

    $conn->query("UPDATE staff_management SET 
        name='$name',
        department='$department',
        date_of_joining='$date_of_joining',
        email_id='$email_id',
        contact_number='$contact_number'
        WHERE staff_id='$staff_id'
    ");

    echo "<script>alert('Staff details updated successfully');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Staff</title>
    <style>
        body {
            font-family: Arial;
            background: linear-gradient(to right, #667eea, #764ba2);
            text-align: center;
            color: white;
        }
        .box {
            background: white;
            color: black;
            width: 400px;
            margin: auto;
            padding: 20px;
            margin-top: 50px;
            border-radius: 10px;
        }
        input {
            width: 90%;
            padding: 8px;
            margin: 5px;
        }
        button {
            padding: 10px 20px;
            margin-top: 10px;
            border: none;
            background: #667eea;
            color: white;
            cursor: pointer;
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
            margin-left:0%;
        }
        .back:hover{
            background:green;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<h2>Update Staff Details</h2>

<div class="box">

    <!-- Enter Staff ID -->
    <form method="POST">
        <input type="number" name="staff_id" placeholder="Enter Staff ID" required>
        <button type="submit" name="fetch">Fetch Details</button>
    </form>

    <br>

    <!-- Show Data -->
    <?php if($staff){ ?>
    <form method="POST">
        <input type="hidden" name="staff_id" value="<?php echo $staff['staff_id']; ?>">

        <input type="text" name="name" value="<?php echo $staff['name']; ?>" required>
        <input type="text" name="department" value="<?php echo $staff['department']; ?>" required>
        <input type="date" name="date_of_joining" value="<?php echo $staff['date_of_joining']; ?>" required>
        <input type="email" name="email_id" value="<?php echo $staff['email_id']; ?>" required>
        <input type="text" name="contact_number" value="<?php echo $staff['contact_number']; ?>" required>

        <button type="submit" name="update">Update</button>
    </form>
    <?php } ?>

    <br>

    <!-- Back Button -->
    <a href="staff_dashboard.php">
       
    </a>

</div>
<a class="back" href="staff_dashboard.php">Back</a> 
</body>
</html>