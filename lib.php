<?php

    // 경고메세지
    function alert ($str) {
        echo "<script>alert('{$str}')</script>";
    }

    // 페이지이동
    function move ($str = false) {
        echo "<script>";
        echo $str ? "location.replace('{$str}')" : "history.back();";
        echo "</script>";
        exit;
    }

    // 조건 검사 + 경고창 + 페이지이동
    function access ($bool, $msg, $url = false) {
        if (!$bool) { // 조건을 만족하지 못하면
            alert($msg); // 경고창을 띄운 후
            move($url); // 페이지 이동
        }
    }

    // 한 줄로 출력
    function println ($ele) {
        echo "<p>{$ele}</p>";
    }

    // 디버그를 위한 print
    function print_pre ($ele) {
        echo "<pre>";
        print_r($ele);
        echo "</pre>";
        }

    // DB연결 객체 가져오기
    function get_db() {
        $dbHost = DB_HOST;      // 호스트 주소
        $dbName = DB_NAME;      // DB 이름
        $dbUser = DB_ID;          // DB 아이디
        $dbPass = DB_PASS;        // DB 패스워드

        // PDO 연결하기
        $db = new PDO("mysql:host={$dbHost};dbname={$dbName}", $dbUser, $dbPass); //mySQL conneting
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $db;
    }

    // 쿼리문 실행
    function query ($sql, $arr = []) {
        $db = get_db();

        // 미리 변수를 선언한다.
        $res = null;
        if (count($arr)) {
            $res = $db->prepare($sql);  // 쿼리문을 준비하고
            $res->execute($arr);        // $arr를 쿼리문에 바인딩한다.
        } else {
            $res = $db->query($sql);
        }

        if ($res) {
            // 정상적으로 실행 시, 결과를 반환한다.
            return ['res' => $res, 'insert_pk' => $db->lastInsertId()]; // 인서트시에는 마지막 인서트 pk 반환
        } else {
            // 에러가 있을 시 쿼리문과 에러 출력 후 프로그램 중지
            println($sql);
            print_pre($db->errorInfo());
            exit;
        }

        // 쿼리문 실행 후 DB와의 연결을 종료한다.
        $db = null;
    }

    // 단일 데이터 가져오기
    function fetch ($sql, $arr = []) {
        return query($sql, $arr)['res']->fetch(PDO::FETCH_OBJ);
    }

    // 다중 데이터 가져오기
    function fetchAll ($sql, $arr = []) {
        return query($sql, $arr)['res']->fetchAll(PDO::FETCH_OBJ);
    }

    // 데이터의 갯수 가져오기
    function rowCount ($sql, $arr = []) {
        return query($sql, $arr)['res']->rowCount();
    }

    // UUID 생성
    function uuidgen4() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
       mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
       mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000,
       mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
     );
 }