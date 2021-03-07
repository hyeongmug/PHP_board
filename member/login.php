<?php require_once("../header.php") ?>

    <div class="card login-card">
        <div class="card-header">
            <h4>로그인</h4>
        </div>
        <div class="card-body">
            <form action="login_action.php" id="login_form" method="post" onsubmit="return login_check(this)">
                <div class="form-group mb-3 d-flex">
                    <label for="id" class="col-3">아이디</label>
                    <input type="text" name="id" id="id" class="form-control" placeholder="아이디 입력">
                </div>
                <div class="form-group mb-3 d-flex">
                    <label for="pwd" class="col-3">비밀번호</label>
                    <input type="password" name="pwd" id="pwd" class="form-control" placeholder="비밀번호 입력">
                </div>

                <?php if ( isset($_SESSION['message']) ) {
                    echo '<p class="small text-danger">'.$_SESSION["message"].'</p>';
                    unset($_SESSION["message"]);
                } ?>

                <div class="mt-5">
                    <button class="btn btn-primary" type="submit">로그인</button>
                </div>


                <div class="mt-3">
                    <a href="register.php">회원가입 하시겠습니까? </a>
                </div>
            </form>
        </div>
    </div>


    <script>
    function login_check(f) {
        
        if (!f.id.value.trim() ) {
            alert("아이디를 입력해주세요.");
            f.id.focus();
            return false;
        }   

        if (!f.pwd.value.trim() ) {
            alert("비밀번호를 입력해주세요.");
            f.pwd.focus();
            return false;
        }
    }
    </script>


<?php require_once("../footer.php") ?>