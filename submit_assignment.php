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