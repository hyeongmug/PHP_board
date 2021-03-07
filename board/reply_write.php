<?php
    require_once("../common.php");

    if (!$_SESSION['user_id']) {
        alert("잘못된 접근입니다.");
        exit;
    }
    
    $sql = "INSERT INTO reply (rcontent, bno, id, rdate) VALUES (?, ?, ?, now())";
    $params = [$rcontent, $bno, $_SESSION['user_id']];

    try {
        $result = query($sql, $params);
        
        $rno = $result['insert_pk'];

        $sql2 = "SELECT rno, rcontent, rdate, IFNULL(udate,'') udate, r.id, m.name
                 FROM reply r JOIN member m 
                 ON r.id = m.id 
                 WHERE r.rno = ?";

        $reply = fetch($sql2, [$rno]);
        
        echo '{
            "result" : "success",
            "rno" : "'.$reply->rno.'",
            "rcontent" : "'.$reply->rcontent.'",
            "rdate" : "'.$reply->rdate.'",
            "udate" : "'.$reply->udate.'",
            "id" : "'.$reply->id.'",
            "name" : "'.$reply->name.'"
        }';
    } catch (Exception $e) {
        echo '{
            "result" : "error",
            "message" : "'.$e->getMessage().'"
        }';
    }
