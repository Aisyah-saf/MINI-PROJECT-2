<?php 
include 'db.php'; 
include 'header.php';

//  Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

//  Capture Assignment ID from GET (initial visit) or POST (form submission)
$assignment_id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['assignment_id']) ? $_POST['assignment_id'] : null);

//  Redirect ONLY if we have absolutely no ID to work with
if (!$assignment_id) {
    echo "<script>alert('Please select an assignment from the dashboard first.'); window.location.href='dashboard.php';</script>";
    exit();
}

$message = "";

if(isset($_POST['upload'])) {
    if (isset($_FILES['doc']) && $_FILES['doc']['error'] == 0) {
        
        $folder = "uploads/";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        // Clean filename to prevent issues
        $file_extension = pathinfo($_FILES['doc']['name'], PATHINFO_EXTENSION);
        $file_name = time() . "_user" . $_SESSION['user_id'] . "." . $file_extension;
        $path = $folder . $file_name;

        if(move_uploaded_file($_FILES['doc']['tmp_name'], $path)) {
            
            // Prepared statement
            $stmt = $conn->prepare("INSERT INTO submissions (user_id, assignment_id, file) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $_SESSION['user_id'], $assignment_id, $file_name);
            
            if($stmt->execute()) {
                $message = "<div class='alert alert-success text-center fw-semibold'>✅ Submitted Successfully!</div>";
            } else {
                $message = "<div class='alert alert-danger text-center'>❌ Database error: " . $conn->error . "</div>";
            }
        } else {
            $message = "<div class='alert alert-danger text-center'>❌ Failed to save file. Check folder permissions.</div>";
        }
    } else {
        $message = "<div class='alert alert-danger text-center'>❌ Please select a valid file to upload.</div>";
    }
}
?>

<style>
    body {
        background: linear-gradient(135deg, #e0eafc, #cfdef3);
        min-height: 100vh;
    }
    .upload-card {
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        padding: 40px;
        margin-top: 50px;
    }
    .btn-success {
        border-radius: 30px;
        padding: 12px;
        font-weight: 600;
        background: linear-gradient(45deg, #28a745, #20c997);
        border: none;
        transition: 0.3s;
    }
    .btn-success:hover {
        transform: scale(1.02);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }
</style>

<div class="container d-flex justify-content-center">
    <div class="col-md-6">
        <div class="upload-card">
            <div class="text-center mb-4">
                <h4 class="fw-bold">Upload Submission</h4>
                <p class="text-muted">You are submitting for Assignment #<?= htmlspecialchars($assignment_id) ?></p>
            </div>

            <?= $message; ?>

            <form action="submit_assignment.php" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="assignment_id" value="<?= htmlspecialchars($assignment_id) ?>">
                
                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary">Select File (PDF, Docx, TXT):</label>
                    <input type="file" name="doc" class="form-control" required>
                </div>

                <button name="upload" type="submit" class="btn btn-success w-100">
                    Upload and Turn In
                </button>
            </form>
            
            <div class="mt-4 text-center">
                <a href="dashboard.php" class="text-muted text-decoration-none">← Back to Dashboard</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>