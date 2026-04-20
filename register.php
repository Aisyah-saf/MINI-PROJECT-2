<?php 
include 'config.php'; 
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
        $message = "<p class='error'>All fields required</p>";
    } else {

        // Check if email already exists using prepared statement
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if($result->num_rows > 0) {
            // When email is already registered
            $message = "<p class='error'>Email already exists</p>";
        } else {
            // Hash password for security 
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            // Proceed to insert with role included
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $hashed, $role);

            if($stmt->execute()) {
                $message = "<p class='success'>Registration successful.</p>";
            } else {
                $message = "<p class='error'>Registration failed</p>";
            }
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-5 card">
        <h2 class="text-center">Create Account</h2>
        
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
                    <option value="student">Student</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button name="register" class="btn btn-success w-100">Register</button>
        </form>

        <div class="mt-3 text-center">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>