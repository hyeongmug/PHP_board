
<script>
   function register_check(f) {
        
        if (!f.id.value.trim() ) {
            alert("아이디를 입력해주세요.");
            f.id.focus();
            return false;
        }   

        if (!ValidationCheck.id(f.id.value.trim()) ) {
            alert("아이디를 형식이 맞지 않습니다. 영문+숫자 5~15");
            f.id.focus();
            return false;
        }   

        if (!f.pwd.value.trim() ) {
            alert("비밀번호를 입력해주세요.");
            f.pwd.focus();
            return false;
        }

        if (!ValidationCheck.pwd(f.pwd.value.trim())) {
            alert("비밀번호 형식이 맞지 않습니다.");
            f.pwd.focus();
            return false;
        }

        if (!f.pwd_re.value.trim() ) {
            alert("비밀번호 확인을 입력해주세요.");
            f.pwd_re.focus();
            return false;
        }   

       if (f.pwd.value != f.pwd_re.value) {
           alert("비밀번호가 서로 다릅니다. 확인해주세요.");
           f.pwd_re.focus();
           return false;
       }

       if (!f.name.value.trim() ) {
            alert("이름을 입력해주세요.");
            f.name.focus();
            return false;
        }   

        if (!ValidationCheck.name(f.name.value.trim()) ) {
            alert("이름 형식이 맞지 않습니다. 한글이름 1~5자");
            f.name.focus();
            return false;
        }   

        if ( !id_check ) {
            alert("아이디 중복확인을 해주세요.");
            $('#id_check').focus();
            return false;
        }
   }

   var id_check = false;
   $("#id").keyup(function() {
        $('#id').removeClass(["is-invalid", "is-valid"]);
        $('#id-valid').hide();
        id_check = false;
   });

   // 비밀번호 정규식 체크
   $('#pwd').keyup(function(){
        if ( ValidationCheck.pwd( $(this).val().trim() )) {
            $(this).addClass("is-valid");
        } else {
            $(this).removeClass("is-valid");
        }

        // 비밀번호 확인란도 체크~
        if ( $(this).val() == $('#pwd_re').val()  ) {
            $('#pwd_re').addClass("is-valid");
       } else {
            $('#pwd_re').removeClass("is-valid");
       }
   });

   // 비밀번호 확인
   $('#pwd_re').keyup(function(){
       if ( $(this).val() == $('#pwd').val()  ) {
            $('#pwd_re').addClass("is-valid");
       } else {
            $('#pwd_re').removeClass("is-valid");
       }
  });

  // 이름 체크
  $('#name').keyup(function(){
       if ( ValidationCheck.name($(this).val() ) ) {
            $(this).addClass("is-valid");
       } else {
            $(this).removeClass("is-valid");
       }
  });

  // 아이디 중복확인
   $('#id_check').click(function() {
        $.ajax({
            url : "register_id_check.php",
            dataType : "json",
            data : {
                id : $('#id').val() 
            },
            success : function(data) {
                if ( data.result === "1") {
                    $('#id').addClass("is-invalid");
                    $('#id-valid').attr("class","invalid-feedback").text("이미 가입된 아이디 입니다.").show();
                    id_check = false;
                } else {
                    $('#id').removeClass("is-invalid").addClass("is-valid");
                    $('#id-valid').attr("class","valid-feedback").text("사용가능한 아이디 입니다.").show(); 
                    id_check = true;
                }
            } 
        });
   });
</script>
