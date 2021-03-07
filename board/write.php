<?php
    require_once("../header.php");

    extract($_GET);

    $page = isset($page) ? $page : 1;

    // 답글관련
    if ( isset($bno) && $bno != "" ) {
        $cnt = fetch("SELECT COUNT(*) cnt FROM board WHERE bno = ?", [ $bno ])->cnt;
        if ($cnt == 0) {
            alert("잘못된 접근입니다.");
            move();
            exit;
        }
    }

?>

            <form action="write_action.php" id="baord_form" method="post" onsubmit="return form_check(this)">
                        
                <?php if ( !isset($_SESSION["user_id"]) ) { ?>

                <div class="row">
                    <div class="form-group mb-3 col-sm-3">
                        <label for="writer">작성자</label>
                        <input type="text" name="writer" id="writer" class="form-control">
                    </div>
                    <div class="form-group mb-3 col-sm-3">
                        <label for="bpwd">글 비밀번호</label>
                        <input type="password" name="bpwd" id="bpwd" class="form-control">
                    </div>
                </div>
                <?php }  ?>

                <?php if ( isset($bno) && $bno != "" ) { ?>
                    <input type="hidden" name="bno" value="<?php echo $bno ?>">
                <?php }  ?>

                <div class="form-group mb-3">
                    <label for="title">제목</label>
                    <input type="text" name="title" id="title" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="content">내용</label>
                    <textarea name="content" id="content" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="file">첨부파일 <small>(10MB 제한)</small></label>
                    <div id="file_upload">
                        <input type="file" name="file" id="file" class="form-control" multiple>
                    </div>
                </div>

                <div class="mt-5">
                    <button class="btn btn-primary" type="submit">등록</button>
                    <a href="list.php?page=<?php echo $page ?>" class="btn btn-warning" type="reset" onclick="return list_confirm();">목록</a>
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

                    <?php if ( !isset($_SESSION["user_id"]) ) { ?>
                    if (!f.writer.value.trim() ) {
                        alert("작성자를 입력해주세요.");
                        f.writer.focus();
                        return false;
                    } 

                    if (!f.bpwd.value.trim() ) {
                        alert("글 비밀번호를 입력해주세요.");
                        f.bpwd.focus();
                        return false;
                    }
                    <?php } ?>
                }

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