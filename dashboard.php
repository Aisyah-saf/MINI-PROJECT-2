<?php 
include 'header.php'; 
?>

<?php
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
?>

<h3 class="text-center mt-4">
Welcome <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?>
</h3>

<hr class="w-25 mx-auto">
<div class="card-box col-md-6 mx-auto">
<input type="text" placeholder="Search assignments..." class="form-control mb-3">

<?php
$res = $conn->query("SELECT * FROM assignments");

if($res->num_rows > 0){
    while($row = $res->fetch_assoc()){
        echo "<div class='p-2 border mb-2'>{$row['title']}</div>";
    }
}else{
    echo "<p class='text-center'>No assignments found.</p>";
}
?>

</div>

<?php 
include 'footer.php';
?>