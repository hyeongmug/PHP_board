<?php
    require_once("../common.php");

    extract($_GET);

    if (!isset($bno) || !$bno) {
        alert("잘못된 접근입니다.");
        move();
    }

    if ($_SESSION['user_authority'] == "ADMIN") {
        $sql = "DELETE FROM board WHERE bno = ?";
        $params = [$bno];
    } else if ( $_SESSION['user_authority'] == "MEMBER" ) {
        $sql = "DELETE FROM board WHERE bno = ? AND id = ?";
        $params = [$bno, $_SESSION['user_id']];
    } else {
        $sql = "DELETE FROM board WHERE bno = ? AND bpwd = ?";
        $params = [$bno, $bpwd];
    }

    try {
        $result = rowCount($sql, $params);
        if ( $result == 1) {
            move("list.php");
        } else {
            alert("잘못된 접근입니다.");
            move();
        }
    } catch (Exception $e) {
        alert("글수정을 실패하셨습니다.\\n시스템 관리자에게 문의하세요.");
        move("modify.php?bno=".$bno);
    }
