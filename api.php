<?php
header('Content-Type: application/json');
include 'db.php';

$lang = $_GET['lang'] ?? 'en';
$sql = "SELECT id, question, answer FROM faqs WHERE language='$lang'";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode($data);
?>
