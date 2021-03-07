<?php
    require_once("../common.php");

    $count = rowCount("SELECT * FROM member WHERE id = ?", [$id]);

    if ( $count > 0 ) {
        echo '{
            "result" : "1"
        }';
    } else {
        echo '{
            "result" : "0"
        }';
    }