<?php 
include 'config.php';
include 'header.php'; 

$msg = "";

if(isset($_POST['register'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if(empty($name) || empty($email) || empty($password)){
        $msg = "<div class='alert alert-danger text-center'>All fields required</div>";
    } else {

        $check = $conn->prepare("SELECT id FROM users WHERE email=?");
        $check->bind_param("s",$email);
        $check->execute();
        $check->store_result();

        if($check->num_rows > 0){
            $msg = "<div class='alert alert-danger text-center'>Email already exists</div>";
        } else {

            $pass = password_hash($password, PASSWORD_DEFAULT);

            $stmt=$conn->prepare("INSERT INTO users(name,email,password,role) VALUES (?,?,?,'student')");
            $stmt->bind_param("sss",$name,$email,$pass);

            if($stmt->execute()){
                $msg = "<div class='alert alert-success text-center'>Registered!</div>";
            } else {
                $msg = "<div class='alert alert-danger'>Error registering</div>";
            }
        }
    }
}
?>

<div class="auth-box">
<div class="card-box">

<h3 class="text-center mb-4">Register</h3>

<?= $msg ?>

<form method="POST">
<input name="name" class="form-control mb-3" placeholder="Name">
<input name="email" class="form-control mb-3" placeholder="Email">
<input name="password" type="password" class="form-control mb-3" placeholder="Password">

<div class="text-center">
<button name="register" class="btn btn-primary px-4">Register</button>
</div>
</form>

<p class="text-center mt-3">
Already have account? <a href="login.php">Login here</a>
</p>

</div>
</div>

<?php 
include 'footer.php'; 
?>