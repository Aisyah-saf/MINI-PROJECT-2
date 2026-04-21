<<<<<<< HEAD
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
        <button name="upload" class="btn btn-primary">Submit</button>

    </form>

</div>
=======
<?php 
include 'config.php'; 
include 'header.php';

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

// Get ID from URL
$assignment_id = $_GET['id'] ?? null;
$message = "";

// Check if assignment_id exists, otherwise redirect
if (!$assignment_id) {
    header("Location: dashboard.php");
    exit();
}

if(isset($_POST['upload'])) {
    // Check if a file was actually selected without errors
    if (isset($_FILES['doc']) && $_FILES['doc']['error'] == 0) {
        
        $folder = "uploads/";
        if (!is_dir($folder)) { mkdir($folder, 0777, true); }

        $file_name = time() . "_" . basename($_FILES['doc']['name']);
        $path = $folder . $file_name;

        if(move_uploaded_file($_FILES['doc']['tmp_name'], $path)) {
            $stmt = $conn->prepare("INSERT INTO submissions (user_id, assignment_id, file) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $_SESSION['user_id'], $assignment_id, $file_name);
            
            if($stmt->execute()) {
                $message = "<div class='success'><strong>Success!</strong> Assignment turned in.</div>";
            } else {
                $message = "<div class='error'>Database Error: " . $conn->error . "</div>";
            }
        } else {
            $message = "<div class='error'>Failed to move the file to the uploads folder.</div>";
        }
    } else {
        $message = "<div class='error'>Please select a file to upload.</div>";
    }
}
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6 card p-4 shadow">
        <h2 class="fw-bold mb-4">Submit Assignment</h2>
        
        <?= $message; ?>

        <form action="submit_assignment.php?id=<?= htmlspecialchars($assignment_id) ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="form-label small fw-bold text-muted">UPLOAD DOCUMENT</label>
                <input type="file" name="doc" class="form-control w3-input" required>
            </div>
            
            <button name="upload" class="btn btn-success w-100 py-2">TURN IN ASSIGNMENT</button>
        </form>
        
        <div class="mt-4 text-center">
            <a href="dashboard.php" class="text-decoration-none text-secondary small">&larr; Back to Dashboard</a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
>>>>>>> 95a277c3ff048c7410068ae391569b451962cdc4
