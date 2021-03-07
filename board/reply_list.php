<?php
    require_once("../common.php");

    extract($_POST);

    if (!isset($bno) || !$bno) {
        alert("잘못된 접근입니다.");
        exit;
    }

    $sql = "SELECT rno, rcontent, rdate, IFNULL(udate,'') udate, r.id, m.name
            FROM reply r JOIN member m 
            ON r.id = m.id 
            WHERE r.bno = ?";

    $params = [$bno];

    try {
        $result = fetchAll($sql, $params);

        echo json_encode( $result );

    } catch (Exception $e) {
        echo '{
            "result" : "error",
            "message" : "'.$e->getMessage().'"
        }';
    }
