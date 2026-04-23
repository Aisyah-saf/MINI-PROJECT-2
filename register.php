<?php 
include 'db.php'; 
include 'header.php';

$message = ""; // Initialize message variable to avoid "undefined" errors

if(isset($_POST['register'])) {
    // Collect data from form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; 
    $role = $_POST['role'];

    //Server-side validation: Check if fields are empty
    if(empty($name) || empty($email) || empty($password)) {
        $message = "<div class='alert alert-danger text-center'>All fields required</div>";
    } else {

        // Check if email already exists using prepared statement
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if($result->num_rows > 0) {
            // When email is already registered
            $message = "<div class='alert alert-warning text-center'>Email already exists</div>";
        } else {
            // Hash password for security 
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            // Proceed to insert with role included
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $hashed, $role);

            if($stmt->execute()) {
                $message = "<div class='alert alert-success text-center'>Registration successful</div>";
            } else {
                $message = "<div class='alert alert-danger text-center'>Registration failed</div>";
            }
        }
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
    <div class="col-md-5">
        <div class="card register-card p-4">

            <div class="text-center mb-3">
                <h3 class="title">Create Account</h3>
                <p class="text-muted">Join us by filling the details below</p>
            </div>

            <?= $message; ?>

            <form method="POST">
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                </div>

                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                </div>

                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <div class="mb-3">
                    <select name="role" class="form-select">
                        <option value="student"> Student</option>
                        <option value="admin"> Admin</option>
                    </select>
                </div>

                <button name="register" class="btn btn-success w-100">Register</button>
            </form>

            <div class="mt-3 text-center">
                <small>Already have an account? 
                    <a href="login.php" class="fw-bold text-decoration-none">Login here</a>
                </small>
            </div>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>