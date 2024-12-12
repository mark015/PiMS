<?php
include('../incl/config.php');
header('Content-Type: application/json');

// Fetch the role and other query parameters
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$month = isset($_GET['month']) ? $conn->real_escape_string($_GET['month']) : '';
$limit = 10; // Number of records per page
$offset = ($page - 1) * $limit;

// Build the WHERE clause
$whereClauses = ["(`item_code` LIKE '%$search%' OR `item_desc` LIKE '%$search%')"];

if (!empty($month)) {
    $whereClauses[] = "DATE_FORMAT(`date`, '%Y-%m') = '$month'";
}

$whereSql = implode(' AND ', $whereClauses);

// Base SQL query for fetching documents
$sql = "SELECT wi.id as wId, `item_code`, `item_desc`, wi.quantity as wQuantity, `date`, sc.school_id as scId, school_name 
        FROM `withdral_item` as wi
        LEFT JOIN encoded_item as ei ON wi.item_id = ei.item_code 
        LEFT JOIN school as sc ON wi.school_id = sc.id
        WHERE $whereSql 
        LIMIT $limit OFFSET $offset";

// Base SQL query for counting total records
$count_sql = "SELECT COUNT(*) as total 
              FROM `withdral_item` as wi
              LEFT JOIN encoded_item as ei ON wi.item_id = ei.id 
              LEFT JOIN school as sc ON wi.school_id = sc.id
              WHERE $whereSql";

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