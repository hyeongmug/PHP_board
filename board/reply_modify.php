<?php
    require_once("../common.php");

    extract($_POST);

    if (!$_SESSION['user_id'] || !isset($rno) || isset($rno) && $rno == "" ) {
        alert("잘못된 접근입니다.");
        exit;
    }
    
    if ( $_SESSION['user_authority'] == "ADMIN") {

        $sql = "UPDATE reply SET rcontent = ?, udate = now() WHERE rno = $rno";
        $params = [$rcontent, $rno];
    
    } else {

        $sql = "UPDATE reply SET rcontent = ?, udate = now() WHERE rno = ? AND id = ?";
        $params = [$rcontent, $rno, $_SESSION['user_id']];
    
    }

    try {
        $result = query($sql, $params);
    
        $sql2 = "SELECT rno, rcontent, rdate, udate, r.id, m.name
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
