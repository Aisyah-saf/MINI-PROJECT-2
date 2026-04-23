<?php
include 'db.php';
include 'header.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

$submission_id = $_GET['id'];
$user_id = $_SESSION['user_id'];
$message = "";

// Ambil data asal untuk dipaparkan
$stmt = $conn->prepare("SELECT assignments.title, submissions.file FROM submissions 
                        JOIN assignments ON submissions.assignment_id = assignments.id 
                        WHERE submissions.id = ? AND submissions.user_id = ?");
$stmt->bind_param("ii", $submission_id, $user_id);
$stmt->execute();
$res = $stmt->get_result();
$data = $res->fetch_assoc();

if(!$data) {
    die("Submission not found.");
}

// Proses kemas kini (Update)
if(isset($_POST['update'])) {
    $file_name = $_FILES['new_file']['name'];
    $file_tmp = $_FILES['new_file']['tmp_name'];

    if(!empty($file_name)) {
        // Padam fail lama
        if(file_exists("uploads/" . $data['file'])) {
            unlink("uploads/" . $data['file']);
        }

        // Simpan fail baru
        $new_file_name = time() . "_" . $file_name;
        move_uploaded_file($file_tmp, "uploads/" . $new_file_name);

        // Update database
        $up_stmt = $conn->prepare("UPDATE submissions SET file = ? WHERE id = ?");
        $up_stmt->bind_param("si", $new_file_name, $submission_id);
        
        if($up_stmt->execute()) {
            header("Location: view_submission.php?msg=updated");
            exit();
        }
    } else {
        $message = "<p class='error text-center'>Sila pilih fail baru untuk diubah.</p>";
    }
}
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card shadow p-4 border-0" style="border-radius: 15px;">
            <h3 class="text-center fw-bold">Edit Submission</h3>
            <p class="text-center text-muted">Assignment: <strong><?= htmlspecialchars($data['title']) ?></strong></p>
            
            <?= $message; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Current File:</label>
                    <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($data['file']) ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Upload New File:</label>
                    <input type="file" name="new_file" class="form-control" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="view_submission.php" class="btn btn-secondary px-4" style="border-radius: 20px;">Cancel</a>
                    <button name="update" class="btn btn-primary px-4" style="border-radius: 20px;">Update File</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>