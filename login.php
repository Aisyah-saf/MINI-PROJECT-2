<?php
include 'db.php';
include 'header.php';

$message = ""; // Initialize message variable

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Get user using prepared statement (Prevents SQL Injection)
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($row = $result->fetch_assoc()) {
        // Verify hashed password 
        if(password_verify($password, $row['password'])) {
            
            // Prevent Session Fixation 
            session_regenerate_id(true); 
            
            // Store session data
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['role'] = $row['role']; 
            
            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
                
        } else {
            $message = "<div class='alert alert-danger text-center'>Wrong password</div>";
        }
    } else {
        $message = "<div class='alert alert-danger text-center'>User not found</div>";
    }
}
?>

<style>
    body {
        background: linear-gradient(135deg, #667eea, #764ba2);
        min-height: 100vh;
    }

    .register-card {
        border-radius: 15px;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .form-control, .form-select {
        border-radius: 10px;
    }

    .btn-success {
        border-radius: 10px;
        background: linear-gradient(45deg, #43e97b, #38f9d7);
        border: none;
        transition: 0.3s;
    }

    .btn-success:hover {
        opacity: 0.85;
        transform: scale(1.02);
    }

    .title {
        font-weight: bold;
        color: #333;
    }

    .logo {
        font-size: 40px;
        font-weight: bold;
        color: #764ba2;
    }
</style>

<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="col-md-4">
        <div class="card login-card p-4">

            <div class="text-center mb-3">
                <h3 class="login-title">Welcome Back</h3>
                <p class="text-muted">Please login to your account</p>
            </div>

            <?= $message; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                </div>

                <button name="login" class="btn btn-primary w-100">Login</button>
            </form>

            <div class="mt-3 text-center">
                <small>Don't have an account? 
                    <a href="register.php" class="fw-bold text-decoration-none">Register here</a>
                </small>
            </div>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>