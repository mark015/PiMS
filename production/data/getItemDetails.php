<?php
include('../incl/config.php');
header('Content-Type: application/json');

$itemId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($itemId) {
    $sql = "SELECT  `id`, `item_code`, `item_desc`, `quantity`, `date` 
            FROM encoded_item 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode(["success" => true, "data" => $data]);
    } else {
        echo json_encode(["success" => false, "message" => "Item not found."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid Item ID."]);
}
?>
