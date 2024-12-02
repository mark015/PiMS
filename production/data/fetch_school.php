<?php
    include('../incl/config.php');
    header('Content-Type: application/json');

    // Fetch the role and other query parameters
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $limit = 5; // Number of records per page
    $offset = ($page - 1) * $limit;

    // Base SQL query for fetching documents
    $sql = "SELECT * from school
            WHERE (`school_name` LIKE '%$search%' OR `school_id` LIKE '%$search%') LIMIT $limit OFFSET $offset";

    // Base SQL query for counting total records
    $count_sql = "SELECT COUNT(*) as total 
                FROM `school`
                WHERE (`school_name` LIKE '%$search%' OR `school_id` LIKE '%$search%')";


    // Execute the main query
    $result = $conn->query($sql);

    // Execute the count query
    $count_result = $conn->query($count_sql);
    $total_records = $count_result->fetch_assoc()['total'];

    // Prepare the response data
    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    // Prepare and output the response
    $response = [
        "success" => true,
        "data" => $data,
        "total" => $total_records,
        "page" => $page,
        "limit" => $limit,
    ];
    echo json_encode($response);

    // Close connections
    $conn->close();
?>
