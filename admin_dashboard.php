<?php
session_start();
include'connect.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            margin: 0;
            padding: 0;
        }
        .navbar {
            background: #fff;
            padding: 15px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .navbar h1 {
            margin: 0;
            color: #2575fc;
        }
        .home-btn {
            display: inline-block;
            margin: 20px auto;
            padding: 10px 20px;
            background: #2575fc;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.3s, transform 0.3s;
        }
        .home-btn:hover {
            background: #6a11cb;
            transform: scale(1.05);
        }
        .container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 40px;
        }
        .card {
            background: white;
            color: #333;
            padding: 30px;
            margin: 20px;
            border-radius: 12px;
            width: 220px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            text-decoration: none;
        }
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.3);
        }
        .card h2 {
            margin-top: 15px;
            color: #2575fc;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Admin Dashboard</h1>
    </div>
    <div class="container">
        <a href="semester_management.php" class="card">
            <h2>Semester Management</h2>
        </a>
        <a href="subject_management.php" class="card">
            <h2>Subject Management</h2>
        </a>
        <a href="section_management.php" class="card">
            <h2>Section Management</h2>
        </a>
        <a href="staff_management.php" class="card">
            <h2>Staff Management</h2>
        </a>
        <a href="subject_allocation.php" class="card">
            <h2>Subject Allocation</h2>
        </a>
    </div>
    <!-- Home Button at Bottom -->
    <div style="text-align:center; padding:20px;">
        <a href="index.html" class="home-btn">Home</a>
    </div>
</body>
</html>


