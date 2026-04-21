<?php
$conn = new mysqli("localhost", "root", "", "sd");

$staff = null;
$message = null;

if(isset($_POST['search'])){
    $staff_id = $_POST['staff_id'];

    $result = $conn->query("SELECT * FROM staff_management WHERE staff_id='$staff_id'");

    if($result->num_rows > 0){
        $staff = $result->fetch_assoc();
    } else {
        $message = "No staff found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Profile</title>
    <style>
        body{
            font-family: Arial;
            background: linear-gradient(to right, #36d1dc, #5b86e5);
            padding: 20px;
        }
        .box{
            background: white;
            padding: 20px;
            width: 400px;
            margin: auto;
            border-radius: 10px;
        }
        input, button{
            width: 90%;
            padding: 10px;
            margin: 10px 0;
        }
        .profile, .error{
            margin-top: 20px;
           
            padding: 15px;
            border-radius: 10px;
        }
        .error{
            color: red;
            font-weight: bold;
            text-align: center;
        }
        button[name="search"] {
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }
        button[name="search"]:hover {
            background: #0056b3;
            transform: scale(1.05);
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
            margin-left:48%;
        }
        .back:hover{
            background:green;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="box">
    <h2>View Staff Profile</h2>

    <!-- SEARCH FORM -->
    <form method="POST">
        <input type="number" name="staff_id" placeholder="Enter Staff ID" required>
        <button type="submit" name="search">View Profile</button>
    </form>

    <!-- DISPLAY DATA -->
    <?php if($staff){ ?>
        <div class="profile">
            <p><b>Name:</b> <?php echo $staff['name']; ?></p>
            <p><b>Date of Joining:</b> <?php echo $staff['date_of_joining']; ?></p>
            <p><b>Department:</b> <?php echo $staff['department']; ?></p>
            <p><b>Email:</b> <?php echo $staff['email_id']; ?></p>
            <p><b>Contact:</b> <?php echo $staff['contact_number']; ?></p>
            <p><b>Staff ID:</b> <?php echo $staff['staff_id']; ?></p>
        </div>
    <?php } elseif($message){ ?>
        <div class="error"><?php echo $message; ?></div>
    <?php } ?>
</div>
<a class="back" href="staff_dashboard.php">Back</a>
</body>
</html>
