<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Portal - Assignment System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f4f4; font-family: 'Arial', sans-serif; }
        nav { background: #333; padding: 15px; }
        nav a { color: white; margin-right: 20px; text-decoration: none; }
        nav a:hover { color: #28a745; }
        .card { background: white; padding: 25px; margin-top: 20px; border-radius: 8px; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .btn-custom { background: #28a745; color: white; border: none; padding: 10px 20px; }
    </style>
</head>
<body>
<nav>
    <div class="container d-flex justify-content-between">
        <div>
            <a href="dashboard.php"><strong>ASM System</strong></a>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php">Dashboard</a>

                <?php if($_SESSION['role'] == 'student'): ?>
                    <a href="submit_assignment.php">Submit Assignment</a>
                    <a href="view_submission.php">View Submissions</a>
                
                <?php elseif($_SESSION['role'] == 'admin'): ?>
                    <a href="create_assignment.php">Create Assignment</a>
                    <a href="view_submission.php">View Submissions</a>
                <?php endif; ?>

            <?php endif; ?>
        </div>
        <div>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<div class="container mt-4">