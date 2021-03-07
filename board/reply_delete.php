<?php
    require_once("../common.php");

    extract($_GET);

    $sql = "DELETE FROM reply WHERE rno = ?";
    $params = [$rno];

    try {
        $result = rowCount($sql, $params);

        echo json_encode( $result );

    } catch (Exception $e) {
        echo '{
            "result" : "error",
            "message" : "'.$e->getMessage().'"
        }';
    }
