<?php
    require_once("../common.php");

    if (!isset($_SESSION['user_authority']) ||  $_SESSION['user_authority'] != "ADMIN" ) {
        alert("잘못된 접근!!");
        move();
    }

    $sql = "DELETE FROM board WHERE bno = ?";

    foreach($chk as $bno) {
        query($sql, [$bno]);
    }

    // 마지막 페이지에서 삭제시 처리
    $total = rowCount("SELECT * FROM board");
    if ( ($page - 1) == ceil($total / $limit)  && $total % $limit == 0) {
        $page = $page - 1;
    }

    echo $page;

    move("list.php?page=".$page);
