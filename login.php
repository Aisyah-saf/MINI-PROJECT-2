<?php
include 'config.php';
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
            $message = "<p class='error text-danger text-center'>Wrong password</p>";
        }
    } else {
        $message = "<p class='error text-danger text-center'>User not found</p>";
    }
}
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-4 card shadow-sm p-4">
        <h2 class="text-center mb-4">Login</h2>
        
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
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>