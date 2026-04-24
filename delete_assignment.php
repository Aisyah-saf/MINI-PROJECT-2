<?php
include 'db.php';
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    exit("Unauthorized");
}

$id = $_GET['id'] ?? null;

if($id){
    $stmt = $conn->prepare("DELETE FROM assignments WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

echo "Deleted";
?>