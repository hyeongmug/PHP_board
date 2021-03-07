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

var CalcByte = {
    getByteLength : function(s) {
        // 입력된 글자 전체의 byte를 계산
        if (s == null || s.length == 0) {
            return 0;
        }
        var size = 0;

        for ( var i = 0; i < s.length; i++) {
            size += this.charByteSize(s.charAt(i));
        }

        return size;
    },
    cutByteLength : function(s, len) {
        // 원하는 byte 만큼 글자를 잘라서 반환
        if (s == null || s.length == 0) {
            return 0;
        }
        var size = 0;
        var rIndex = s.length;

        for ( var i = 0; i < s.length; i++) {
            size += this.charByteSize(s.charAt(i));
            if( size == len ) {
                rIndex = i + 1;
                break;
            } else if( size > len ) {
                rIndex = i;
                break;
            }
        }

        return s.substring(0, rIndex);
    },
    charByteSize : function(ch) {
        // 한글자에 대한 byte를 계산
        if (ch == null || ch.length == 0) {
            return 0;
        }

        var charCode = ch.charCodeAt(0);

        if (charCode <= 0x00007F) {
            return 1;
        } else if (charCode <= 0x0007FF) {
            return 2;
        } else if (charCode <= 0x00FFFF) {
            return 3;
        } else {
            return 4;
        }
    }
};