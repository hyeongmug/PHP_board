<?php require_once("header_top.php") ?>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="<?php echo HOME_PATH ?>">My Board</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="<?php echo HOME_PATH ?>/board/list.php">게시판</a>
                    </li>
                </ul>

                <ul class="navbar-nav mb-2 mb-lg-0">
                    <?php if( !isset($_SESSION['user_id']) ) {  ?>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="<?php echo HOME_PATH ?>/member/login.php">로그인</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="<?php echo HOME_PATH ?>/member/register.php">회원가입</a>
                    </li>
                    <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="<?php echo HOME_PATH ?>/member/logout.php">로그아웃</a>
                    </li>
                    <?php
                    }

                    // 관리자일 때
                    if ( isset($_SESSION['user_authority']) && $_SESSION['user_authority'] == "ADMIN"  ) { ?>
                    <li class="nav-item">
                        <a class="btn btn-primary" aria-current="page" href="<?php echo HOME_PATH ?>/admin">관리자</a>
                    </li>
                    <?php } ?>
                </ul>

            </div>
        </div>
    </nav>


    <div class="container">
        <div class="content py-5">