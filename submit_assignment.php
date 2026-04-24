<?php 
include 'db.php'; 
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$assignment_id = $_GET['id'] ?? $_POST['assignment_id'] ?? null;

if (!$assignment_id) {
    echo "<script>alert('Please select assignment first'); window.location='dashboard.php';</script>";
    exit();
}

$message = "";

if(isset($_POST['upload'])) {
    if(isset($_FILES['doc']) && $_FILES['doc']['error'] == 0) {
        $folder = "uploads/";

        // CREATE FOLDER IF NOT EXIST
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $file_extension = strtolower(pathinfo($_FILES['doc']['name'], PATHINFO_EXTENSION));
        $file_type = mime_content_type($_FILES['doc']['tmp_name']);
        $file_size = $_FILES['doc']['size'];

        // VALIDATION START
        // 1. FILE TYPE (PDF ONLY)
        if($file_extension !== 'pdf' || $file_type !== 'application/pdf') {

            $message = "<div class='alert alert-danger text-center'>
                        Only PDF files are allowed!
                        </div>";
        }
        // 2. FILE SIZE (MAX 2MB)
        else if($file_size > 2 * 1024 * 1024) {

            $message = "<div class='alert alert-danger text-center'>
                        File too large! Max 2MB only.
                        </div>";
        }
        else {

            // RENAME FILE
            $file_name = time() . "_user" . $_SESSION['user_id'] . ".pdf";
            $path = $folder . $file_name;

            // UPLOAD
            if(move_uploaded_file($_FILES['doc']['tmp_name'], $path)) {

                $stmt = $conn->prepare("INSERT INTO submissions (user_id, assignment_id, file) VALUES (?, ?, ?)");
                $stmt->bind_param("iis", $_SESSION['user_id'], $assignment_id, $file_name);

                if($stmt->execute()) {
                    $message = "<div class='alert alert-success text-center fw-bold'>
                                Assignment Submitted Successfully!
                                </div>";
                } else {

                    $message = "<div class='alert alert-danger text-center'>
                                Database error
                                </div>";
                }
            } else {
                $message = "<div class='alert alert-danger text-center'>
                            Upload failed
                            </div>";
            }
        }
    } else {
        $message = "<div class='alert alert-danger text-center'>
                    Please select a file
                    </div>";
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
}
</style>

<div class="container d-flex justify-content-center">
    <div class="col-md-6">

        <div class="upload-card">

            <div class="text-center mb-4">
                <h4 class="fw-bold">Upload Submission</h4>
                <p class="text-muted">
                    Assignment ID: <?= htmlspecialchars($assignment_id) ?>
                </p>
            </div>

            <?= $message; ?>

            <!-- IMPORTANT: PASS ID -->
            <form action="submit_assignment.php?id=<?= $assignment_id ?>" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="assignment_id" value="<?= $assignment_id ?>">

                <div class="mb-3">
                    <label class="fw-bold">Upload PDF only (Max 2MB)</label>
                    <input type="file" name="doc" class="form-control" accept=".pdf" required>
                </div>

                <button name="upload" class="btn btn-success w-100">
                    Submit Assignment
                </button>

            </form>

            <div class="text-center mt-3">
                <a href="dashboard.php">← Back to Dashboard</a>
            </div>

        </div>

    </div>
</div>

<?php include 'footer.php'; ?>