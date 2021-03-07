<?php
    require_once("../common.php");

    extract($_POST);
    
    // 패스워드를 암호화
    $pwd = hash("sha256", $pwd);
    
    $sql = "SELECT id, name, authority FROM member WHERE id = ? AND pwd = ?";

    try {

        if ( fetch($sql, [$id, $pwd]) ) {

            $user_info = fetch($sql, [$id, $pwd]);
            
            $_SESSION['user_id'] = $user_info->id;
            $_SESSION['user_name'] = $user_info->name;
            $_SESSION['user_authority'] = $user_info->authority;

            // 관리자, 사용자 화면 분리
            if ( $_SESSION['user_authority'] == "ADMIN") {
                //alert("관리자님 안녕하세요. 관리자 페이지로 이동합니다.");
                move("../admin");
            } else {
                //alert($_SESSION['user_name']."님 안녕하세요. 게시판으로 이동합니다.");
                move("../board/list.php");
            }

        } else {
            //alert("아이디 또는 비밀번호가 정확하지 않습니다.");
            //
            $_SESSION['message'] = "아이디 또는 비밀번호가 정확하지 않습니다.";
            move("login.php");

        }
        
    } catch (Exception $e) {
        alert("로그인에 실패하셨습니다.\n시스템 관리자에게 문의하세요.");
        move("login.php");
    }
