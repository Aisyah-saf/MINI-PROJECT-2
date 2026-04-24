<?php
include 'db.php';

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

// hanya student boleh delete
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: dashboard.php");
    exit();
}

// check ID
if(isset($_GET['id']) && is_numeric($_GET['id'])) {

    $submission_id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];

    // ambil nama file dulu
    $stmt = $conn->prepare("SELECT file FROM submissions WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $submission_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($row = $result->fetch_assoc()) {

        $file_path = "uploads/" . $row['file'];

        // delete database
        $del_stmt = $conn->prepare("DELETE FROM submissions WHERE id = ? AND user_id = ?");
        $del_stmt->bind_param("ii", $submission_id, $user_id);

        if($del_stmt->execute()) {

            // delete file dari folder
            if(file_exists($file_path)) {
                unlink($file_path);
            }

            header("Location: view_submission.php?msg=deleted");
            exit();

        } else {
            echo "Failed to delete record.";
        }

    } else {
        echo "No permission or file not found.";
    }

} else {
    echo "Invalid request.";
}
?>