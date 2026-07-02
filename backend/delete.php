<?php 
include 'config/conn.php';

$id = $_GET['id'];
$goto_page = $_GET['goto_page'];
$table = $_GET['table'];

$deleteQuery = "DELETE FROM $table WHERE id = $id;";
$stmt = $conn->prepare($deleteQuery);
$stmt->execute();
header("Location: $goto_page?msg=deleted");
exit;

?>