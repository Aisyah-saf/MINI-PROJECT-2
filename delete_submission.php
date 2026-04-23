<?php
include 'db.php';
if(session_status() == PHP_SESSION_NONE) { session_start(); }

// make sure that only the student is able to delete
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: dashboard.php");
    exit();
}

if(isset($_GET['id'])) {
    $submission_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // get the file name first to delete from the folder
    $stmt = $conn->prepare("SELECT file FROM submissions WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $submission_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($row = $result->fetch_assoc()) {
        $file_path = "uploads/" . $row['file'];

        // delete record from database
        $del_stmt = $conn->prepare("DELETE FROM submissions WHERE id = ? AND user_id = ?");
        $del_stmt->bind_param("ii", $submission_id, $user_id);
        
        if($del_stmt->execute()) {
            // if successfully deleted in the database, delete the physical file
            if(file_exists($file_path)) {
                unlink($file_path);
            }
            header("Location: view_submission.php?msg=deleted");
        }
    } else {
        echo "Error: you do not have access to delete this file.";
    }
}
?>