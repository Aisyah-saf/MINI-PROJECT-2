<?php 
include 'config.php'; 
include 'header.php';

// check login
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

// check assignment id
if(!isset($_GET['id'])){
    header("Location: dashboard.php");
    exit();
}

$assignment_id = $_GET['id'];
$message = "";

if(isset($_POST['upload'])){

    if(isset($_FILES['doc']) && $_FILES['doc']['error'] == 0){

        $folder = "uploads/";

        if(!is_dir($folder)){
            mkdir($folder, 0777, true);
        }

        $file_name = time() . "_" . basename($_FILES['doc']['name']);
        $path = $folder . $file_name;

        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // optional validation (PDF only)
        if($ext != "pdf"){
            $message = "<div class='alert alert-danger'>Only PDF allowed</div>";
        }
        else if(move_uploaded_file($_FILES['doc']['tmp_name'], $path)){

            $stmt = $conn->prepare("INSERT INTO submissions (user_id, assignment_id, file) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $_SESSION['user_id'], $assignment_id, $file_name);

            if($stmt->execute()){
                $message = "<div class='alert alert-success'>Assignment Submitted Successfully!</div>";
            } else {
                $message = "<div class='alert alert-danger'>Database error</div>";
            }

        } else {
            $message = "<div class='alert alert-danger'>Upload failed</div>";
        }

    } else {
        $message = "<div class='alert alert-danger'>Please select file</div>";
    }
}
?>

<div class="card-box col-md-6 mx-auto">

<h3 class="text-center mb-4">Submit Assignment</h3>

<?= $message; ?>

<form action="submit_assignment.php?id=<?= htmlspecialchars($assignment_id) ?>" 
      method="POST" 
      enctype="multipart/form-data">

    <!-- SELECT ASSIGNMENT -->
    <div class="mb-3">
        <select name="assignment_id" class="form-control">
            <?php
            $res = $conn->query("SELECT * FROM assignments");
            while($row = $res->fetch_assoc()){
                $selected = ($row['id'] == $assignment_id) ? "selected" : "";
                echo "<option value='{$row['id']}' $selected>{$row['title']}</option>";
            }
            ?>
        </select>
    </div>

    <!-- FILE INPUT -->
    <div class="mb-3">
        <input type="file" name="doc" class="form-control" required>
    </div>

    <!-- BUTTON -->
    <button name="upload" class="btn btn-primary w-100">Submit</button>

</form>

<div class="text-center mt-3">
    <a href="dashboard.php">Back to Dashboard</a>
</div>

</div>

<?php include 'footer.php'; ?>