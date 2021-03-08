<?php
    require_once("../common.php");

    if (!isset($_SESSION['user_authority']) ||  $_SESSION['user_authority'] != "ADMIN" ) {
        alert("잘못된 접근!!");
        move();
    }

    $sql = "DELETE FROM board WHERE bno = ?";

    foreach($chk as $bno) {
        // 파일 삭제
        $unlink_file = fetch("SELECT path, file_name FROM file WHERE bno = ?", [$bno]);
        unlink($unlink_file->path."/".$unlink_file->file_name);

        // 게시글 db에서 삭제
        query($sql, [$bno]);
    }

    // 마지막 페이지에서 삭제시 처리
    $total = rowCount("SELECT * FROM board");
    if ( ($page - 1) == ceil($total / $limit)  && $total % $limit == 0) {
        $page = $page - 1;
    }

    echo $page;

    move("list.php?page=".$page);
