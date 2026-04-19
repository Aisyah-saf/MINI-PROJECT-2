<?php include 'header.php'; ?>

<?php
$msg = "";

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    if(empty($name) || empty($email) || empty($pass)){
        $msg = "Please fill all fields";
    } else {
        // password hash
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users(name,email,password) VALUES (?,?,?)");
        $stmt->bind_param("sss",$name,$email,$hash);

        if($stmt->execute()){
            header("Location: login.php");
        } else {
            $msg = "Error register";
        }
    }
}
?>

<div class="auth-container">
    <div class="auth-card">

        <h3 class="auth-title">Register</h3>

        <?php if($msg) echo "<div class='error'>$msg</div>"; ?>

        <form method="POST">

            <div class="input-group mb-3">
                <input type="text" name="name" class="form-control" placeholder="Name">
            </div>

            <div class="input-group mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email">
            </div>

            <div class="input-group mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>

            <button name="submit" class="btn-custom">Register</button>

        </form>

        <div class="link">
            Already have account? <a href="login.php">Login here</a>
        </div>

    </div>
</div>

</body>
</html>