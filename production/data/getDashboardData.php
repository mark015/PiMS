<?php
include('../incl/config.php'); // Include your database connection file
header('Content-Type: application/json');

// SQL query to count items and schools based on service years
$query = "
        SELECT 
    (SELECT COUNT(*) FROM `encoded_item`) AS encoded_item_count,
    (SELECT COUNT(*) FROM `withdral_item`) AS withdral_item_count,
    (SELECT COUNT(*) FROM `school`) AS school_count;
";

// Execute the query and fetch the result
$result = $conn->query($query);

// Check if the query was successful
if ($result) {
    $data = $result->fetch_assoc();
    echo json_encode([
        'success' => true,
        'data' => $data
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching data'
    ]);
}
?>
