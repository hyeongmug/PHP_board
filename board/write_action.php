<?php
    require_once("../common.php");

    $incbno = fetch("SELECT IFNULL(MAX(bno) + 1, 1) incbno FROM board")->incbno;

    if (isset($bno) && $bno != "") {

        $result = fetch("SELECT grpno, grpord, depth FROM board WHERE bno = ? ", [$bno]);

        $grpno = $result->grpno;
        $grpord = $result->grpord + 1;
        $depth = $result->depth + 1;

        query("UPDATE board SET grpord = grpord + 1 where grpord >1 and grpno = ?", [$grpno]);
    } else {
        $grpno = $incbno;
        $grpord = 0;
        $depth = 1;
    }

    if (isset($bpwd)) {
        // 비회원
        $bpwd = hash("sha256", $bpwd);
        $sql = "INSERT INTO board (bno, title, content, writer, bpwd, rdate, grpno, grpord, depth) VALUES (?, ?, ?, ?, ?, now(), ?, ?, ?)";
        $params = [$incbno, $title, $content, $writer, $bpwd, $grpno, $grpord, $depth];
    } else {
        // 회원
        $sql = "INSERT INTO board (bno, title, content, id, rdate, grpno, grpord, depth) VALUES (?, ?, ?, ?, now(), ?, ?, ?)";
        $params = [$incbno, $title, $content, $_SESSION['user_id'], $grpno, $grpord, $depth];
    }

    try {

        query($sql, $params);

        
        // 업도드 된 파일 해당 글하고 매핑
        if (isset($file_id)) {
            foreach($file_id as $fid) {
                query("UPDATE file SET bno = ? WHERE file_name = ?", [$incbno, $fid]);
            }
        }

        move("view.php?bno=".$incbno);
    } catch (Exception $e) {
        echo $e;
    }
