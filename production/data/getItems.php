<?php
if (isset($_GET['query'])) {
    $query = $_GET['query'];
    
    include('../incl/config.php');
    header('Content-Type: application/json');

    $sql = "SELECT 
            ei.item_code as code, ei.item_desc as `desc`,
            ei.quantity AS total_quantity,
            IFNULL(SUM(wi.quantity), 0) AS withdrawn_quantity,
            (ei.quantity - IFNULL(SUM(wi.quantity), 0)) AS remaining_quantity
        FROM 
            encoded_item ei
        LEFT JOIN 
            withdral_item wi
        ON 
            ei.item_code = wi.item_id  WHERE item_code LIKE ?
        GROUP BY 
            ei.item_code LIMIT 10";
    $stmt = $conn->prepare($sql);
    $search = "%$query%";
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = ['item_code' => $row['code'], 'item_desc' => $row['desc'], 'rQuantity' => $row['remaining_quantity']];
    }

    echo json_encode(['success' => true, 'items' => $items]);
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'No query provided.']);
}

