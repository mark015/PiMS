<?php
include('../incl/config.php');
header('Content-Type: application/json');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id) {
    // Query to get withdrawal item details
    $sql = "SELECT 		
                wi.id AS wid,
                wi.item_id AS wiid,
                wi.quantity as wquantity,
                sc.school_name AS scName,
                sc.id AS sid,
                ei.item_code AS code,
                ei.item_desc AS `desc`,
                ei.quantity AS total_quantity
            FROM 
                withdral_item wi
            LEFT JOIN 
                encoded_item ei
            ON 
                wi.item_id = ei.item_code
            LEFT JOIN
                school sc
            ON 
                wi.school_id = sc.id
            WHERE 
                wi.id = ?
            GROUP BY 
                ei.item_code";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $itemId = $data['wiid'];

            // Query to get remaining quantity
            $sqlRQuantity = "SELECT 
                                ei.item_code, 
                                IFNULL(SUM(wi.quantity), 0) AS withdrawn_quantity, 
                                (ei.quantity - IFNULL(SUM(wi.quantity), 0)) AS remaining_quantity 
                            FROM 
                                withdral_item wi
                            LEFT JOIN 
                                encoded_item ei
                            ON 
                                wi.item_id = ei.item_code 
                            WHERE 
                                wi.item_id = ? 
                            GROUP BY 
                                ei.item_code ";

            $stmtRQuantity = $conn->prepare($sqlRQuantity);

            if ($stmtRQuantity) {
                $stmtRQuantity->bind_param("s", $itemId);
                $stmtRQuantity->execute();
                $resultRQuantity = $stmtRQuantity->get_result();
                $dataRQuantity = $resultRQuantity->fetch_assoc();

                // Combine data and return JSON response
                echo json_encode([
                    "success" => true, 
                    "data" => $data, 
                    "remainingQuantity" => $dataRQuantity['remaining_quantity']
                ]);
            } else {
                echo json_encode(["success" => false, "message" => "Error preparing remaining quantity query."]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Item not found."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Error preparing main query."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid Item ID."]);
}

$conn->close();
?>
