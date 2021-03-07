<?php
require_once("../common.php");

$allowedExts = ["exe", "php", "php3", "php4", "htm", "inc", "html"];

//var_dump($_FILES);
//var_dump($file_ids);

if (isset($_FILES) && $_FILES) {
    $file = $_FILES["file"];
    $error = $file["error"];
    $name = $file["name"];
    $type = $file["type"];
    $size = $file["size"];
    $tmp_name = $file["tmp_name"];

    for ($i = 0; $i < count($name) && $name[$i] != ""; $i++) { // 해당 인덱스의 파일명이 ""이 아니면 for문 실행

        //echo "for문 돈다~~";

        if ( $error[$i] > 0 ) {
            echo '{
                "result" : "fail",
                "message" : "'.$error[$i] .'"
            }';
            exit;
        }
        else {
            $temp = explode(".", $name[$i]);
            $extension = end($temp);
           
            if ( ($size[$i]/1024/1024) > 10 ) {
                echo '{
                    "result" : "fail",
                    "message" : "10MB 초과했습니다."
                }';
                exit;
            }
    
            if ( in_array($extension, $allowedExts) ) {
                echo '{
                    "result" : "fail",
                    "message" : "업로드 할수 없는 파일 유형 입니다."
                }';
                exit;
            }
    
            $Y = date("Y");
            $M = date("m");
            $D = date("d");
    
            $upload_name = $file_ids[$i];
    
            $path = UPLOAD_DIR."/".$Y."/".$M."/".$D."/";
    
            if ( !is_dir($path) ) {
                mkdir($path, 0777, true);
            }
    
            if (file_exists($path . $upload_name)) {
                echo '{
                    "result" : "fail",
                    "message" : "파일명 중복!"
                }';
                exit;
            }
            else {
                move_uploaded_file($tmp_name[$i], $path . $upload_name);

                $sql = "INSERT INTO file ( path, file_name, real_name, reg_date )
                        VALUES (?, ?, ?, now())";
                $params = [
                    $path, 
                    $upload_name, 
                    $name[$i] 
                ];

                try {
                    query($sql, $params);

                    echo '{
                        "result" : "success",
                        "message" : "파일 업로드가 완료 되었습니다."
                    }';
                    
                } catch (\Throwable $th) {
                    echo '{
                        "result" : "fail",
                        "message" : "'.$th->getMessage().'"
                    }';
                    
                } finally {
                    exit;
                }

               
            }
        }
    }
   
} else {
    echo '{
        "result" : "fail",
        "message" : "잘못된 접근!!"
    }';
    exit;
}
?>