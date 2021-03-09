<?php
    require_once("../header.php");

    extract($_GET);

    $page = isset($page) ? $page : 1;

    $sql = "SELECT title, content, IF(writer IS NULL OR writer = '', m.name, b.writer) writer, rdate, bpwd, m.id 
            FROM board b LEFT JOIN member m 
            ON b.id = m.id
            WHERE bno = ?";
    $params = [ $bno ];
    $result = fetch($sql, $params);
    if (!$result) {
        alert("잘못된 접근입니다.");
        move();
        exit;
    }
    
    // 댓글 수
    $reply_count = fetch("SELECT COUNT(*) cnt FROM reply WHERE bno = ?", [$bno])->cnt; 

    // 파일 가져오기
    $files = fetchAll("SELECT file_name, real_name, reg_date FROM file WHERE bno = ?", [$bno]);
?>


            <div class="form-group mb-3">
                <h3 class="text-break"><?php echo $result->title ?></h3>
            </div>
            <div class="form-group mb-3 py-2">
                <span class="mx-2">
                    작성자 : <?php echo $result->writer ?>
                </span>
                <span class="mx-2">
                    작성일 : <?php echo $result->rdate ?>
                </span>
            </div>
            <div class="form-group mb-3">
                <div class="text-break">
                <?php echo nl2br($result->content); ?>
                </div>
            </div>

                <?php
                if ($files) {
                    echo '<div class="form-group mb-3">';
                    echo '<strong>첨부파일</strong>';
                    echo '<ul>';
                    foreach($files as $file) {
                        echo '<li class="mt-2">
                                <a href="file_download.php?filename='.$file->file_name.'">'.$file->real_name.'<i class="bi bi-download btn btn-sm btn-light mx-2"></i></a> 
                            </li>';
                    }
                    echo '</ul>';
                    echo '</div>';
                }
                ?>

            <div class="mt-5">
                <a href="list.php?page=<?php echo $page ?>" class="btn btn-primary">목록</a>
                <a class="btn btn-success" href="write.php?bno=<?php echo $bno ?>&page=<?php echo $page ?>">답글</a>
                <?php 
                // 회원 글인 경우 작성자 아이디와 로그인 아이디를 비교,
                // 비회원 글인 경우 로그아웃 상태일 때만 볼 수 있함. 
                if (!isset($_SESSION['user_id']) && $result->bpwd || isset($_SESSION['user_id']) && $result->id == $_SESSION['user_id']) {
                    echo '<a href="modify.php?bno='.$bno.'" class="btn btn-warning" modify-btn>수정</a>';
                }
                ?>
            </div>

            <div class="card mt-5">
                <div class="card-header">
                    <h6 class="mt-2"><strong>댓글</strong> <span class="badge bg-secondary text-white"><?php echo $reply_count ?></span></h6>
                </div>
                <div class="card-body">
                    <ul class="list-group" id="reply_list"></ul>
                    <?php if(isset($_SESSION['user_id'])) { ?>
                    <div class="d-flex mt-3 reply-form input-group">
                        <textarea class="form-control" name="rcontent" id="reply_content"></textarea>
                        <button class="btn btn-success" id="reply_btn">댓글 등록</button>
                    </div>
                    <?php } else {?>
                        <small class="text-center d-block">댓글을 작성하시려면 <a href="../member/login.php">로그인</a> 하세요.</small>
                    <?php } ?>
                </div>
            </div>
            <div class="mt-5">
                <a href="list.php?page=<?php echo $page ?>" class="btn btn-primary">목록</a>
                <a class="btn btn-success" href="write.php?bno=<?php echo $bno ?>&page=<?php echo $page ?>">답글</a>
                <?php 
                // 회원 글인 경우 작성자 아이디와 로그인 아이디를 비교,
                // 비회원 글인 경우 로그아웃 상태일 때만 볼 수 있게함. 
                if (!isset($_SESSION['user_id']) && $result->bpwd || isset($_SESSION['user_id']) && $result->id == $_SESSION['user_id']) {
                    echo '<a href="modify.php?bno='.$bno.'" class="btn btn-warning" modify-btn>수정</a>';
                }
                ?>
            </div>



            <!-- 글 수정 비밀번호 입력 모달 -->
            <div class="modal" tabindex="-1" role="dialog" id="board_pwd_modal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">글 비밀번호</h5>
                            <button type="button" class="close btn p-0" data-dismiss="modal" modal-close>
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input class="form-control" type="password" modal-password>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" modal-confirm>확인</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" modal-close>취소</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                // 댓글 관련
                var bno =  '<?php echo $bno ?>';
                var sid = '<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "" ?>';
                var sauth = '<?php echo isset($_SESSION['user_authority']) ? $_SESSION['user_authority'] : "" ?>';

                $(function() {
                    reply_list(bno, sid, sauth);
                });
                
                $('#reply_btn').click(function() {
                    var rcontent = $('#reply_content').val();
                    write_reply(rcontent, bno, sid);
                    $('#reply_content').val("");
                });



                // 수정 관련
                <?php if ( !isset($_SESSION['user_id']) ) { ?>
                    $("[modify-btn]").click(function(e) {
                        e.preventDefault();
                        $('#board_pwd_modal').modal("show");
                        $('[modal-password]').focus();

                    });

                    $('[modal-close]').click(function(e) {
                        $('#board_pwd_modal').modal("hide");
                        $("[modal-password]").val("");
                    });

                    $('[modal-confirm]').click(function(e) {
                        var bpwd = $("[modal-password]").val();
                        board_pwd_ajax(bpwd, bno);
                    });

                    $('[modal-password]').keypress(function(e) {
                        if (e.keyCode == 13) {
                            var bpwd = $("[modal-password]").val();
                        board_pwd_ajax(bpwd, bno);
                        }
                    });
                <?php } ?>

            </script>

<?php require_once("../footer.php"); ?>
