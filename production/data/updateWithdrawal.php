<?php
include('../incl/config.php');
header('Content-Type: application/json');
// Get POST data
$id = $_POST['id'];// Get POST data
$itemCode = $_POST['itemCode'];
$itemDesc = $_POST['itemDesc'];
$itemQuantity = $_POST['itemQuantity'];
$school = $_POST['school'];

// Update query
$sql = "UPDATE withdral_item 
        SET school_id = ?, item_id = ? , `quantity` = ?
        WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $school, $itemCode, $itemQuantity ,$id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update the Withdrawal item."]);
}

$stmt->close();
$conn->close();
?>
