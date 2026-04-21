<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: staff_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .dashboard {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            width: 400px;
            text-align: center;
        }
        h2 {
            color: #2575fc;
            margin-bottom: 25px;
        }
        .btn {
            display: block;
            background: #6a11cb;
            color: white;
            text-decoration: none;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            font-size: 16px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #2575fc;
        }
        .logout {
            background: #ff4b5c;
        }
        .logout:hover {
            background: #d90429;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <a href="staff_profile.php" class="btn">👤 View Profile</a>
        <a href="staff_subjects.php" class="btn">📚 View Allocated Subjects</a>
        <a href="staff_update.php" class="btn">✏️ Update Details</a>
        <a href="staff_logout.php" class="btn logout">🚪 Logout</a>
    </div>
</body>
</html>