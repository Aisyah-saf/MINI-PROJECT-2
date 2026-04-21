<?php include 'header.php'; ?>

<h3 class="text-center mt-4">Welcome <?= $_SESSION['name']; ?></h3>
<hr class="w-25 mx-auto">

<div class="card-box col-md-6 mx-auto">

<input type="text" placeholder="Search assignments..." class="form-control search-box">

<?php
$res=$conn->query("SELECT * FROM assignments");

if($res->num_rows>0){
    while($row=$res->fetch_assoc()){
        echo "<div class='assignment-item'>{$row['title']}</div>";
    }
}else{
    echo "<p class='text-center'>No assignments found.</p>";
}
?>

</div>

<?php include 'footer.php'; ?>