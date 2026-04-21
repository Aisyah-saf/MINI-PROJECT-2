<?php 
include 'header.php'; 
?>

<?php
$msg="";
if(isset($_POST['login'])){
    $email=$_POST['email'];
    $pass=$_POST['password'];

    $stmt=$conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $res=$stmt->get_result();

    if($res->num_rows>0){
        $user=$res->fetch_assoc();
        if(password_verify($pass,$user['password'])){
            $_SESSION['user_id']=$user['id'];
            $_SESSION['user_name']=$user['name'];
            $_SESSION['role']=$user['role'];

<<<<<<< Updated upstream
            header("Location: dashboard.php");
            exit();
        }
=======
    if($row = $result->fetch_assoc()) {
        // Verify hashed password 
        if(password_verify($password, $row['password'])) {
            
            // Prevent Session Fixation 
            session_regenerate_id(true); 
            
            // Store session data
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = $row['role']; 
            
            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
                
        } else {
            $message = "<p class='error text-danger text-center'>Wrong password!</p>";
        }
    } else {
        $message = "<p class='error text-danger text-center'>User not found!</p>";
>>>>>>> Stashed changes
    }
    $msg="Invalid username or password.";
}
?>

<div class="auth-box">
<div class="card-box">

<h3 class="text-center mb-4">Login</h3>

<p class="text-danger text-center"><?= $msg ?></p>

<form method="POST">
<input name="email" class="form-control mb-3" placeholder="Username">
<input name="password" type="password" class="form-control mb-3" placeholder="Password">

<div class="text-center">
<button name="login" class="btn btn-primary px-4">Login</button>
</div>
</form>

<p class="text-center mt-3">
Don't have account? <a href="register.php">Register here</a>
</p>

</div>
</div>

<?php 
include 'footer.php'; 
?>