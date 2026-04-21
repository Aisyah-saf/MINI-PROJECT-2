<?php 
<<<<<<< HEAD
include 'config.php'; 
include 'header.php';
=======
include 'config.php'; include 'header.php';
>>>>>>> 95a277c3ff048c7410068ae391569b451962cdc4
if($_SESSION['role'] != 'admin') header("Location: dashboard.php");

if(isset($_POST['create'])) {
    $stmt = $conn->prepare("INSERT INTO assignments (title, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $_POST['title'], $_POST['desc']);
    $stmt->execute();
    echo "<p class='success text-center fw-bold d-block mt-3'>Assignment Created!</p>";
}
?>
<div class="card col-md-8 mx-auto">
    <h3>Post New Assignment</h3>
    <form method="POST">
        <input type="text" name="title" class="form-control mb-3" placeholder="Task Title" required>
        <textarea name="desc" class="form-control mb-3" placeholder="Task Instructions" rows="4"></textarea>
        <button name="create" class="btn btn-custom">Publish Assignment</button>
    </form>
</div>
<<<<<<< HEAD
<?php 
include 'footer.php'; 
?>
=======
<?php include 'footer.php'; ?>
>>>>>>> 95a277c3ff048c7410068ae391569b451962cdc4
