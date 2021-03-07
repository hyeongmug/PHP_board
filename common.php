<?php
    session_start();
    require_once("config.php");
    require_once("lib.php");

    // XSS 방지
    foreach ($_REQUEST as $key => $value) {
        if ( is_array( $value ) ) {
            //값이 배열인 경우
            foreach ($value as $key2 => $value2) {
                $_REQUEST[$key][$key2] = htmlspecialchars($value2, ENT_QUOTES,"UTF-8");
            }
        } else {
            $_REQUEST[$key] = htmlspecialchars($value, ENT_QUOTES,"UTF-8");
        }
    }

    // 배열에서 각 변수 만들기
    extract($_REQUEST);

    // 쿼리 스트링
    $queryString =  http_build_query($_GET);