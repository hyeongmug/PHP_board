<?php
    require_once("../common.php");

    // 세션 변수 초기화
    $_SESSION = array();

    // 세션 쿠키 삭제
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // 세션 삭제
    session_destroy();

    //alert("로그아웃 되셨습니다. 로그인 화면으로 이동합니다.");
    move("login.php");