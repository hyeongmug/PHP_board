<?php require_once("../header.php"); ?>

<?php 
    $sql = "SELECT title, content, IF(writer IS NULL OR writer = '', m.name, b.writer) writer, rdate, bpwd, m.id 
            FROM board b LEFT JOIN member m 
            ON b.id = m.id
            WHERE bno = ?";
    $param = [$bno];
    $result = fetch($sql, $param);

    

    // 비회원인 경우 게시글 비밀번호가 없으면 접근 차단
    if (!isset($_SESSION['user_id']) && !isset($_SESSION['board_pwd'])) {
        alert("잘못된 접근!!");
        move();
        exit;
    }

    // 회원인 경우 해당 게시글 작성자 아이디와 로그인 아이디가 같지 않으면 접근 차단
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $result->id) {
        alert("잘못된 접근!!");
        move();
        exit;
    }


    // 파일 가져오기
    $files = fetchAll("SELECT fno, file_name, real_name, reg_date FROM file WHERE bno = ?", [$bno]);
?>
            <form action="modify_action.php" method="post" id="baord_form" onsubmit="return form_check(this);">
                <input type="hidden" name="bno" value="<?php echo $bno ?>">

                <div class="form-group mb-3">
                    <label for="title">제목</label>
                    <input type="text" name="title" id="title" class="form-control" value="<?php echo $result->title ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="content">내용</label>
                    <textarea name="content" id="content" cols="30" rows="10" class="form-control"><?php echo $result->content ?></textarea>
                </div>
                
                <div class="form-group mb-3">
                    <label for="file">첨부파일</label>
                    <div id="file_upload">
                        <input type="file" name="file" id="file" class="form-control" multiple>
                    </div>

                    <?php
                    if ($files) {
                        echo '<ul>';
                        foreach($files as $file) {
                            echo '<li class="mt-2">
                                    <a href="file_download.php?filename='.$file->file_name.'">'.$file->real_name.'<i class="bi bi-download btn btn-sm btn-light mx-2"></i></a> 
                                    <button type="button" class="btn btn-sm btn-light px-0" file-delete data-fno="'.$file->fno.'"><i class="bi bi-x mx-2"></i></button>
                                </li>';
                        }
                        echo '</ul>';
                    }
                    ?>
                </div>
                
                <div class="mt-5">
                    <button class="btn btn-primary" type="submit">수정</button>
                    <a href="delete.php?bno=<?php echo $bno ?>" class="btn btn-danger" onclick="return delete_confirm()">삭제</a>
                    <a href="view.php?bno=<?php echo $bno ?>" class="btn btn-warning" onclick="return cancle_confirm()">취소</a>
                </div>

            </form>

            <script>

                function form_check(f) {
                    if (!f.title.value.trim() ) {
                        alert("제목을 입력해주세요.");
                        f.title.focus();
                        return false;
                    }   

                    if (!f.content.value.trim() ) {
                        alert("내용을 입력해주세요.");
                        f.content.focus();
                        return false;
                    }   
                }

                $('[file-delete]').click(function() {
                    if (confirm("파일을 삭제하시겠습니까?")) {
                        var fno = $(this).data("fno");
                        $('#file_upload').prepend('<input type="hidden" name="del_file[]" value="' + fno + '">');
                        $(this).closest("li").remove();
                    };
                });

                $('#title').on('keyup', function() {
                    var byte = 150;
                    var str = $(this).val();
                    if ( byte < CalcByte.getByteLength(str) ) {
                        alert("제목은 150 Byte를 넘을 수 없습니다.");
                        $(this).val(CalcByte.cutByteLength(str, byte));
                    }
                });
            </script>

<?php require_once("../footer.php"); ?>