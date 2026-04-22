<?php 
include 'db.php'; 
include 'header.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
?>

<h3 class="text-center mt-4">
Welcome <?= htmlspecialchars($_SESSION['name'] ?? 'User') ?>
</h3>

<hr class="w-25 mx-auto">

<div class="card-box col-md-6 mx-auto">

<input type="text" placeholder="Search assignments..." class="form-control mb-3">

<?php
$res = $conn->query("SELECT * FROM assignments");

if($res->num_rows > 0){
    while($row = $res->fetch_assoc()){
        ?>
        
        <div class="d-flex justify-content-between align-items-center border p-2 mb-2 rounded">
            <span><?= htmlspecialchars($row['title']) ?></span>

            <?php if($_SESSION['role'] == 'student'): ?>
                <a href="submit_assignment.php?id=<?= $row['id'] ?>" 
                   class="btn btn-success btn-sm">
                   Submit
                </a>
            <?php endif; ?>

        </div>

        <?php
    }
}else{
    echo "<p class='text-center'>No assignments found.</p>";
}
?>

</div>

<?php include 'footer.php'; ?>