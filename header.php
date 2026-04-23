<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Portal - Assignment System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { 
            background: #f4f6f9; 
            font-family: 'Segoe UI', sans-serif; 
        }

        /* NAVBAR STYLE */
        nav {
            background: linear-gradient(45deg, #667eea, #764ba2);
            padding: 15px 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        nav a:hover {
            color: #ffd369;
            transform: translateY(-2px);
        }

        .brand {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .nav-center a {
            position: relative;
        }

        .nav-center a::after {
            content: '';
            position: absolute;
            width: 0%;
            height: 2px;
            bottom: -5px;
            left: 0;
            background: #ffd369;
            transition: 0.3s;
        }

        .nav-center a:hover::after {
            width: 100%;
        }

        .btn-danger {
            border-radius: 20px;
            padding: 5px 15px;
            font-size: 14px;
        }

        .btn-danger:hover {
            transform: scale(1.05);
        }

        .btn-auth {
            border: 1px solid white;
            padding: 5px 12px;
            border-radius: 20px;
            margin-left: 5px;
            display: inline-block; /* Fixed: Prevents overlap */
            white-space: nowrap;   /* Fixed: Prevents text wrapping */
            text-decoration: none;
            color: white;
        }

        .btn-auth:hover {
            background: white;
            color: #764ba2;
        }

        /* CARD GLOBAL STYLE */
        .card { 
            background: white; 
            padding: 25px; 
            margin-top: 20px; 
            border-radius: 15px; 
            border: none; 
            box-shadow: 0 6px 15px rgba(0,0,0,0.1); 
        }
    </style>
</head>
<body>

<nav>
    <div class="container d-flex align-items-center">
        
        <div style="flex: 2;">
            <a href="dashboard.php" class="brand">ASM System</a>
        </div>

        <div class="d-flex justify-content-center nav-center" style="flex: 6;">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php">Dashboard</a>
                
                <?php if($_SESSION['role'] == 'student'): ?>
                    <a href="dashboard.php">Submit Assignment</a>
                    <a href="view_submission.php">My Submissions</a>
                
                <?php elseif($_SESSION['role'] == 'admin'): ?>
                    <a href="create_assignment.php">Create Task</a>
                    <a href="view_submission.php">All Submissions</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="d-flex justify-content-end align-items-center" style="flex: 2;">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
            <?php else: ?>
                <div class="d-flex">
                    <a href="login.php" class="btn-auth">Login</a>
                    <a href="register.php" class="btn-auth">Register</a>
                </div>
            <?php endif; ?>
        </div>

    </div>
</nav>

<div class="container mt-4">