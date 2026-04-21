<?php 
include 'config.php'; 
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
    background: #333;
    padding: 15px;
}

nav a {
    color: white;
    margin-right: 20px;
    text-decoration: none;
}

nav a:hover {
    color: #28a745;
}

.auth-box {
    min-height: 90vh;
    display: flex;
    justify-content: center;
    align-items: center;
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
<?php if(isset($_SESSION['user_id'])): ?>
    <a href="logout.php">Logout</a>
<?php else: ?>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
<?php endif; ?>
</div>
</div>
</nav>

<div class="container mt-4">