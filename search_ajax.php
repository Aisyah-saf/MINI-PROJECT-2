<?php
include 'config.php';
$q = isset($_GET['q']) ? "%" . $_GET['q'] . "%" : "%%";

$stmt = $conn->prepare("SELECT * FROM assignments WHERE title LIKE ?");
$stmt->bind_param("s", $q);
$stmt->execute();
$result = $stmt->get_result();

$assignments = [];
while($row = $result->fetch_assoc()) {
    $assignments[] = $row;
}

header('Content-Type: application/json');
echo json_encode($assignments);
?>