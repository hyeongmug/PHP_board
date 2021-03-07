<?php require_once("../common.php") ?>
<?php
    if (!isset($_SESSION['user_authority']) || $_SESSION['user_authority'] != "ADMIN") {
        alert("잘못된 접근!!");
        move();
        exit;
    }
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBoard - 관리자</title>
    <link rel="stylesheet" href="../static/css/bootstrap.min.css">
    <link rel="stylesheet" href="../static/css/custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <script src="../static/js/jquery-3.5.1.min.js"></script>
    <script src="../static/js/bootstrap.min.js"></script>
    <script src="../static/js/board.js"></script>
    <script src="../static/js/fileUpload.js"></script>
</head>
<body>

<div class="wrapper">
