<?php require_once("../header.php") ?>

    <div class="card register-card">
        <div class="card-header">
            <h4>회원가입</h4>
        </div>
        <div class="card-body">
            <form action="register_action.php" method="post" id="register_form" onsubmit="return register_check(this);">
                <div class="form-group mb-3 d-flex">
                    <label for="id" class="col-3">아이디</label>
                    <div class="flex-fill">
                        <div class="d-flex">
                            <input type="text" name="id" id="id" class="form-control" placeholder="아이디 입력">
                            <button type="button" class="btn btn-sm btn-success col-4" id="id_check">중복확인</button>
                        </div>
                        <div class="valid-feedback" id="id-valid"></div>
                    </div>
                </div>
                <div class="form-group mb-3 d-flex">
                    <label for="pwd" class="col-3">비밀번호</label>
                    <div class="w-100">
                        <input type="password" name="pwd" id="pwd" class="form-control mb-2" placeholder="비밀번호 입력">
                        <label class="w-100">
                            <input type="password" name="pwd_re" id="pwd_re" class="form-control" placeholder="비밀번호 확인">  
                        </label>
                        <small class="d-block mt-1">8자 이상, 숫자/대문자/소문자/특수문자 모두 포함</small>
                    </div>
                </div>
                <div class="form-group mb-3 d-flex">
                    <label for="name" class="col-3">이름</label>
                    <div class="w-100">
                        <input type="text" name="name" id="name" class="form-control" placeholder="이름 입력">
                        <small class="d-block mt-1 mb-2">한글 이름 2~5자</small>
                    </div>
                    
                </div>

                <div class="mt-5">
                    <button class="btn btn-primary" type="submit">회원가입</button>
                </div>
                
                <div class="mt-3">
                    <a href="login.php">로그인 하시겠습니까? </a>
                </div>

            </form>
        </div>
    </div>


<?php require_once("register_script.php") ?>
<?php require_once("../footer.php") ?>