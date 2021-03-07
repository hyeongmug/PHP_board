// 아이디
var ValidationCheck = {
    id : function (str) {
        // 영문+숫자 아이디 5~15
        var reg = /^[a-z]+[a-z0-9]{5,15}$/g;
    
        if(reg.test(str)) {
            return true;
        }else {
            return false;
        }
    },
    pwd : function(str) {
        // 회원가입 비밀번호
        // 8자 이상, 숫자/대문자/소문자/특수문자를 모두 포함
        var reg = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/;
    
        if(reg.test(str)) {
            return true;
        }else {
            return false;
        }
    },
    name : function(str) {
        // 한글 이름 2~5자
        var reg = /^[가-힣]{2,5}$/;
    
        if(reg.test(str)) {
            return true;
        }else {
            return false;
        }
    }
}


