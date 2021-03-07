<?php 
    require_once("../common.php");

    $bpwd = hash("sha256", $bpwd);
    $count = rowCount("SELECT * FROM board WHERE bno = ? AND bpwd = ?", [$bno, $bpwd]);

    if ($count > 0) {
        $_SESSION['board_pwd'] = $bpwd;
        echo '{
            "result" : "success",
            "message" : "성공!!"
        }';
    } else {
        echo '{
            "result" : "fail",
            "message" : "비밀번호가 맞지 않습니다."
        }';
    }

?>