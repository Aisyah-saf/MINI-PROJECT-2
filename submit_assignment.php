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

// Check if ID is provided in URL, otherwise redirect to dashboard
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$assignment_id = $_GET['id'];
$message = "";

if(isset($_POST['upload'])) {
    // Basic validation to ensure a file was actually uploaded
    if (isset($_FILES['doc']) && $_FILES['doc']['error'] == 0) {
        
        $folder = "uploads/";
        
        // Ensure the directory exists
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $file_name = time() . "_" . basename($_FILES['doc']['name']);
        $path = $folder . $file_name;

        // Secure file handling: move from temp to uploads folder
        if(move_uploaded_file($_FILES['doc']['tmp_name'], $path)) {
            
            // Prepared statement for database integrity
            $stmt = $conn->prepare("INSERT INTO submissions (user_id, assignment_id, file) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $_SESSION['user_id'], $assignment_id, $file_name);
            
            if($stmt->execute()) {
                $message = "<div class='alert alert-success'>Assignment Submitted Successfully!</div>";
            } else {
                $message = "<div class='alert alert-danger'>Database error. Please try again.</div>";
            }
        } else {
            $message = "<div class='alert alert-danger'>Failed to move uploaded file.</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>Please select a valid file.</div>";
    }
}
?>

<div class="card col-md-6 mx-auto mt-4">
    <h4>Upload Submission</h4>
    <hr>
    
    <?= $message; ?>

    <form action="submit_assignment.php?id=<?= htmlspecialchars($assignment_id) ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label text-muted">Select File (PDF, Word, or Text):</label>
            <input type="file" name="doc" class="form-control" required>
        </div>
        <button name="upload" class="btn btn-success w-100">Upload and Turn In</button>
    </form>
    
    <div class="mt-3 text-center">
        <a href="dashboard.php" class="text-decoration-none">Back to Dashboard</a>
    </div>
</div>

<?php include 'footer.php'; ?>
>>>>>>> 95a277c3ff048c7410068ae391569b451962cdc4
