<?php
include 'config.php';

$id=$_GET['id'];

$stmt=$conn->prepare("DELETE FROM submissions WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

header("Location: view_assignment.php");