// 글 수정 비밀번호 확인
function board_pwd_ajax(bpwd, bno) {
    $.ajax({
        url : "board_pwd_check.php",
        type : "post",
        dataType : "json",
        data : { 
            "bpwd" : bpwd,
            "bno" : bno
        },
        success : function(data) {
            if ( data.result == 'success') {
                location.href = $('[modify-btn]').attr("href");
            } else {
                alert(data.message);
                $('#board_pwd_modal').modal("hide");
                $('[modal-password]').val("");
            }
        }
    })
}



// 댓글 목록
function reply_list(bno, sid, sauth) {
    $.ajax({
        url : 'reply_list.php',
        type : 'post',
        dataType: 'json',
        data : {
            bno : bno
        },
        success : function(res) {
            var html = "";
            $.each(res, function(index, reply){
                reply.sid = sid;
                reply.sauth = sauth;
                html += reply_template(reply);
            });
            $('#reply_list').html(html);

        }
    });
}

// 댓글 등록
function write_reply(rcontent, bno, sid) {
    $.ajax({
        url : 'reply_write.php',
        type : 'post',
        dataType: 'json',
        data : {
            rcontent : rcontent,
            bno : bno
        },
        success : function(res) {
            res.sid = sid;
            if (res.result == 'success') {
                $('#reply_list').append( reply_template(res) );
            }
        }
    });
}

// 댓글 목록 템플릿
function reply_template(data) {
    var html = "";
    html += '<li class="list-group-item d-flex flex-column" data-rno="' + data.rno + '">';
    html += '    <div class="d-flex justify-content-between">';
    html += '        <small class="text-secondary">';
    html += '           <span class="name">' + data.name + ' (' + data.id + ') </span>';
    html += '           <span class="rdate">' + data.rdate + '</span>';
    html += '           <span class="udate">' + data.udate + '</span>';
    html += '       </small>';
    if (data.sid == data.id) {
    html += '         <div class="small">';
    html += '            <a href="#" class="link text-secondary" data-reply-modify>수정</a>';
    html += '            <a href="#" class="link text-secondary" data-reply-delete>삭제</a>';
    html += '        </div>';
    } else if (data.sauth == "ADMIN") {
    html += '         <div class="small">';
    html += '            <a href="#" class="link text-secondary" data-reply-delete>삭제</a>';
    html += '        </div>';
    }
    html += '    </div>';
    html += '    <p class="rcontent">' + data.rcontent + '</p>';
    html += '</li>';
    return html;
}

// 댓글 삭제
$(document).on('click', '[data-reply-delete]', function(e) {
    if ( confirm("정말 삭제 하시겠습니까?") ) {
        e.preventDefault();
        $li = $(this).closest("li");
        $.ajax({
            url : 'reply_delete.php',
            data : {
                rno : $li.data('rno')
            },
            success : function(res) {
                if ( res == 1 ) {
                    $li.remove();
                }
            }
        })
    }
});

// 댓글 수정 클릭
$(document).on('click', '[data-reply-modify]', function(e) {
    e.preventDefault();

    var $li = $(this).closest("li");

    if( $li.find('.reply_modify_form').length > 0 ) { // 수정 폼이 이미 생성 되어있으면
        return;
    }

    var $rcontent = $li.find('.rcontent');

    var $reply_modify_form = $([
        '<div class="reply_modify_form">',
        '   <textarea class="form-control" style="resize:none;">' + $rcontent.text() + '</textarea>',
        '   <div>',
        '       <button class="btn btn-sm btn-primary" type="button" reply-modify-save>저장</button>',
        '       <button class="btn btn-sm btn-secondary" type="button" reply-modify-cancle>취소</button>',
        '   </div>',
        '</div>'
    ].join(""));

    $rcontent.hide(); // 댓글 숨김
    $li.append($reply_modify_form); // 수정폼 생성
});

// 댓글 수정 취소
$(document).on('click', '[reply-modify-cancle]', function() {
    var $li = $(this).closest("li");
    var $rcontent = $li.find('.rcontent');

    $rcontent.show(); // 원래있던 댓글 보여줌
    $li.find('.reply_modify_form').remove(); // 수정폼 삭제
});

// 댓글 수정 저장
$(document).on('click', '[reply-modify-save]', function() {
    var $li = $(this).closest("li");
    var $rcontent = $li.find('.rcontent');

    $.ajax({
        url : 'reply_modify.php',
        type : "post",
        dataType : "json",
        data : {
            rno : $li.data('rno'),
            rcontent : $li.find('textarea').val()
        },
        success : function(res) {
            console.log(res);
            $rcontent.text(res.rcontent);
            $li.find('.udate').text(res.udate);
        },
        complete : function() {
            $rcontent.show();
            $li.find('.reply_modify_form').remove();
        }
    });
});

// 확인창
function delete_confirm() {
    if (!confirm("정말 삭제 하시겠습니까?")) {
        return false;
    }
}

function cancle_confirm() {
    if (!confirm("수정 중인 글이 있습니다.\n정말 취소 하시겠습니까?")) {
        return false;
    }
}

function list_confirm() {
    if (!confirm("작성 중인 글이 있습니다.\n정말 목록으로 이동 하시겠습니까?")) {
        return false;
    }
};




