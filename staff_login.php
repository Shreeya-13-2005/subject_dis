<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Example hardcoded credentials (replace with DB check)
    if ($username === "staff" && $password === "staff123") {
        $_SESSION['role'] = 'staff';
        $_SESSION['username'] = $username;
        header("Location: staff_dashboard.php");
        exit();
    } else {
        $error = "Invalid Staff Credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #2575fc, #6a11cb);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-box {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            width: 350px;
            text-align: center;
        }
        h2 {
            margin-bottom: 25px;
            color: #6a11cb;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }
        button {
            background: #6a11cb;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #2575fc;
        }
        a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #2575fc;
            font-weight: 600;
        }
        a:hover {
            color: #6a11cb;
        }
        .message {
            margin-bottom: 15px;
            color: red;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Staff Login</h2>
        <?php if (!empty($error)) echo "<div class='message'>$error</div>"; ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <a href="index.html">⬅ Back to Home</a>
    </div>
</body>
</html>