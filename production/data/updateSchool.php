<?php
include('../incl/config.php');
header('Content-Type: application/json');

// Get POST data
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$school_id = $_POST['school_id'] ?? '';
$school_name = $_POST['school_name'] ?? '';

// Validate input
if ($id && !empty($school_id) && !empty($school_name)) {
    // Update query
    $sql = "UPDATE school 
            SET school_id = ?, school_name = ? 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssi", $school_id, $school_name, $id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "School updated successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update the school."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Failed to prepare the query."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid input. Please provide all required fields."]);
}

$conn->close();
?>
