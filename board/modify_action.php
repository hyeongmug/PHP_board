<?php
    require_once("../common.php");
    // 관리자
    if ( isset($_SESSION['user_authority']) && $_SESSION['user_authority'] == "ADMIN") {
        $sql = "UPDATE board SET title = ?, content = ? WHERE bno = ?";
        $params = [$title, $content, $bno];

    // 회원
    } else if ( isset($_SESSION['user_authority']) && $_SESSION['user_authority'] == "MEMBER" ) {
        $sql = "UPDATE board SET title = ?, content = ? WHERE bno = ? AND id = ?";
        $params = [$title, $content, $bno, $_SESSION['user_id']];

    // 비회원
    } else if ( isset($_SESSION['board_pwd']) ) {
        $sql = "UPDATE board SET title = ?, content = ? WHERE bno = ? AND bpwd = ?";
        $params = [$title, $content, $bno, $_SESSION['board_pwd']];
        unset($_SESSION['board_pwd']);
    } else {
        alert("잘못된 접근!!");
        move();
        exit;
    }

    try {
        query($sql, $params);

        // 업도드 된 파일 해당 글하고 매핑
        if (isset($file_id)) {
            foreach($file_id as $fid) {
                query("UPDATE file SET bno = ? WHERE file_name = ?", [$bno, $fid]);
            }
        }

        // 파일 삭제
        if (isset($del_file)) {
            foreach($del_file as $fno) {
                // 실제 파일 삭제
                $unlink_file = fetch("SELECT path, file_name FROM file WHERE fno = ?", [$fno]);
                unlink($unlink_file->path."/".$unlink_file->file_name);

                // db에서 삭제
                query("DELETE FROM file WHERE fno = ?", [$fno]);
            }
        }

        move("view.php?bno=".$bno);
    } catch (Exception $e) {
        alert("글수정을 실패하셨습니다.\\n시스템 관리자에게 문의하세요.");
        move("modify.php?bno=".$bno);
    }
