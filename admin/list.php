<?php
    require_once("../header.php");

    require_once("../board/pagination.php");

    $page = isset($page)  && $page != "" ? $page : 1;
    $limit = 10; // 한페이지에 보여줄 리스트 수
    $bl = 10; // 페이지네이션 칸 수 
    $offset = ($page - 1) * 10; // 불러올 게시글의 시작점
    
    $sql = "SELECT bno, title, IF(writer IS NULL OR writer = '', m.name, b.writer) writer, b.id, rdate, depth
            FROM board b LEFT JOIN member m 
            ON b.id = m.id
            ORDER BY grpno DESC, grpord ASC
            LIMIT ?, ?";
    $result = fetchAll($sql, [$offset, $limit]);

    // 페이지에 아무글도 없으면 list.php로 이동
    if (isset($_GET["page"]) && count($result) == 0) {
        move("list.php");
    }


?>
                <a href="../board/write.php" class="btn btn-primary">글작성</a>
                <form id="form" action="#" method="post" >
                    <input type="hidden" name="page" value="<?php echo $page ?>">
                    <input type="hidden" name="limit" value="<?php echo $limit ?>">

                    <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">번호</th>
                        <th scope="col">제목</th>
                        <th scope="col">작성자</th>
                        <th scope="col">작성일</th>
                        <th scope="col">선택</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach($result as $row) {
                        ?>
                            <tr>
                            <td scope="row"><?php echo  $row->bno ?></td>
                            <td>
                                <a href="../board/view.php?bno=<?php echo $row->bno ?>" style="padding-left: <?php echo ($row->depth-2) * 20 ?>px">
                                    <?php if ($row->depth > 1) { ?>
                                    <i class="bi bi-arrow-return-right"></i>
                                    <?php }
                                    echo $row->title
                                    ?>
                                </a>
                            </td>
                            <td><?php echo  $row->writer ?></td>
                            <td><?php echo  $row->rdate ?></td>
                            <td><input type="checkbox" name="chk[]" value="<?php echo $row->bno ?>" list-chk></td>
                            </tr>
                        <?php 
                            }

                            if (count($result) == 0) {
                        ?>
                            <tr>
                                <td colspan="5" class="text-center">등록된 글이 없습니다.</td>
                            </tr>
                        <?php
                            }
                        ?>
                        
                    </tbody>
                    </table>
                </form>

                <div id="admin_btns" class="d-flex justify-content-end">
                    <button type="button" class="btn btn-warning" chk-delete>선택 삭제</button>
                </div>

                <?php 
                    if (count($result) > 0) {
                        $total = rowCount("SELECT * FROM board");
                        $pagination = new Pagination($limit, $bl, $total, $page);
                        echo $pagination->getPaginationHTML();
                    }
                ?>

                <script>
                    $('[chk-delete]').click(function() {

                        if ( $('[list-chk]:checked').length == 0 ) {
                            alert("아무것도 선택하지 않으셨습니다.");
                            return;
                        }

                        if ( confirm("정말 삭제 하시겠습니까?") ) {
                            $("#form").attr("action","chk_delete.php");
                            $("#form").submit();
                        }
                    });
                </script>

<?php require_once("footer.php"); ?>