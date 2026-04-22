<?php 
include 'db.php'; 
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
}

nav a {
    color: white;
    margin-right: 20px;
    text-decoration: none;
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
<div class="container d-flex justify-content-between">

<div>
<a href="#"><strong>ASM System</strong></a>
</div>

<div>
    <div>
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

    <a href="logout.php" class="btn btn-danger btn-sm px-3">Logout</a>

<?php else: ?>
    <a href="login.php" class="btn btn-light btn-sm px-3 me-2">Login</a>
    <a href="register.php" class="btn btn-light btn-sm px-3">Register</a>
<?php endif; ?>
</div>
</div>
</div>
</nav>

<div class="container mt-4">