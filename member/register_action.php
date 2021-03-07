<?php
    require_once("../common.php");

    extract($_POST);
    
    // 패스워드를 암호화
    $pwd = hash("sha256", $pwd);
    
    $sql = "INSERT INTO member (id, pwd, name) VALUES (?, ?, ?)";

    try {
        query($sql, [$id, $pwd, $name]);
        alert("회원가입 되셨습니다. 로그인 페이지로 이동합니다.");
        move("login.php");
    } catch (Exception $e) {
        alert("회원가입에 실패하셨습니다.");
        move("register.php");
    }
