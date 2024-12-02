<?php
include('../incl/config.php');
header('Content-Type: application/json');
// Get POST data
$itemId = $_POST['itemId'];
$itemCode = $_POST['itemCode'];
$itemDesc = $_POST['itemDesc'];
$itemQuantity = $_POST['itemQuantity'];
$itemDate = $_POST['itemDate'];

// Update query
$sql = "UPDATE encoded_item 
        SET item_code = ?, item_desc = ?, quantity = ? , `date` = ?
        WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $itemCode, $itemDesc, $itemQuantity , $itemDate ,$itemId);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update the document."]);
}

$stmt->close();
$conn->close();
?>
