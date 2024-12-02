<?php
include('../incl/config.php');
header('Content-Type: application/json');

$schoolId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($schoolId) {
    $sql = "SELECT `id`, `school_id`, `school_name` FROM `school`
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $schoolId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode(["success" => true, "data" => $data]);
    } else {
        echo json_encode(["success" => false, "message" => "Item not found."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid School ID."]);
}
?>
