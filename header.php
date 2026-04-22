<?php 
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Pastikan fail ini wujud dalam folder MINI-PROJECT-2. 
// Jika nama fail database anda adalah config.php, tukar 'db.php' kepada 'config.php'
if (file_exists('db.php')) {
    include 'db.php'; 
} elseif (file_exists('config.php')) {
    include 'config.php';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ASM System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: #f4f4f4;
    font-family: Arial, sans-serif;
}

nav {
    background: #64a1e7;
    padding: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

nav a {
    color: white;
    margin-right: 20px;
    text-decoration: none;
    font-weight: 500;
}

nav a:hover {
    color: #226732;
}

.auth-box {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding-top: 70px;
}

.card-box {
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    max-width: 450px;
    width: 100%;
    border: 1px solid #ccc;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}
</style>
</head>
<body>

<nav>
<div class="container d-flex justify-content-between align-items-center">

    <div>
        <a href="dashboard.php"><strong>ASM System</strong></a>
    </div>

    <div class="d-flex align-items-center">
        <?php if(isset($_SESSION['user_id'])): ?>

            <a href="dashboard.php">Dashboard</a>

            <?php if($_SESSION['role'] == 'student'): ?>
                <a href="submit_assignment.php">Submit Assignment</a>
                <a href="view_submission.php">View Submission</a>
            <?php endif; ?>

            <?php if($_SESSION['role'] == 'admin'): ?>
                <a href="create_assignment.php">Create Assignment</a>
                <a href="view_submission.php">View Submission</a>
            <?php endif; ?>

            <a href="logout.php" class="btn btn-danger btn-sm px-3 ms-2">Logout</a>

        <?php else: ?>
            <a href="login.php" class="btn btn-light btn-sm px-3 me-2">Login</a>
            <a href="register.php" class="btn btn-light btn-sm px-3">Register</a>
        <?php endif; ?>
    </div>
</div>
</nav>

<div class="container mt-4">