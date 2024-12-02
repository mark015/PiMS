<?php
    include('../incl/config.php');
    header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get POST data
    $school_id = $_POST['school_id'];
    $school_name = $_POST['school_name'];

    // Insert the item into the database
    $sql = "INSERT INTO school (`school_id`, `school_name`) 
            VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ss", $school_id, $school_name);
        $stmt->execute();

        // Check if the insertion was successful
        if ($stmt->affected_rows > 0) {
            $response = [
                'status' => 'success',
                'message' => 'School added successfully!'
            ];
        } else {
            $response = ['status' => 'error', 'message' => 'Failed to add School.'];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Database error.'];
    }

    // Send the response as JSON
    echo json_encode($response);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
