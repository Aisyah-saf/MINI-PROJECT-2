<?php
include 'config.php';

header('Content-Type: application/json');

$q = $_GET['q'] ?? '';
$search = "%$q%";

$stmt = $conn->prepare("SELECT id, title, description FROM assignments WHERE title LIKE ?");
$stmt->bind_param("s", $search);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);