function uuidv4() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
}

function file_upload_ajax(formData, file_id) {

    var  $progress_bar = $('[data-file-id="' + file_id + '"] .progress-bar');

    $.ajax({
        url : "file_upload.php",
        type : "post",
        data : formData,
        enctype: 'multipart/form-data',
        contentType : false,
        processData : false,
        dataType : 'json',
        xhr: function() { //XMLHttpRequest 재정의 가능
            var xhr = $.ajaxSettings.xhr();
            xhr.upload.onprogress = function(e) { //progress 이벤트 리스너 추가
                var percent = e.loaded * 100 / e.total;

                $progress_bar.css({
                    'width' : percent + '%'
                })
                .text(percent + '%');
                
                //console.log(percent);
            };
            return xhr;
        },
    }).done(function(data){
        if (data.result == 'fail') {
            $progress_bar.addClass('bg-danger')
            .text(data.message);
            return;
        }

        $('#file_upload').append('<input type="hidden" name="file_id[]" value="' + file_id + '">');
        $('.file_item[data-file-id="' + file_id + '"]').find('.file_name').after('<button type="button" class="btn btn-sm btn-light px-0" write-file-delete><i class="bi bi-x mx-2"></i></button>');
        //console.log(data);
    });
}

$(function() {
    var file_input = document.getElementById("file");
    var file_upload_done = false;

    $('[type="file"]').change(function() {

        file_upload_done = false;

        files = file_input.files;
        
        for (var i = 0; i < files.length; i++) {

            var max_size  = 1024*1024*10; // 10MB
            if ( files[i].size > max_size ) {
                alert("파일 크기가 10MB를 초과했습니다.");
                break;
            }

            
            var formData = new FormData();
            formData.append("file[]", files[i]);

            var file_id = uuidv4();
            formData.append("file_ids[]", file_id);

            var file_html = '';
            file_html+='<div class="file_item mt-2" data-file-id="' + file_id + '">';
            file_html+='    <span class="file_name">' + files[i].name + '</span>';
            file_html+='    <div class="progress mt-1">';
            file_html+='        <div class="progress-bar" role="progressbar" style="width: 0%;">0%</div>';
            file_html+='    </div>';
            file_html+='</div>';
            
            $("#file_upload").append(file_html);

            file_upload_ajax(formData,file_id); // 파일업로드 ajax 실행

        }

    });
    
});

$(document).on('click', '[write-file-delete]', function() {
    var $file_item = $(this).closest(".file_item");
    var file_id = $file_item.data("file-id");
    $file_item.remove();
    $('input[value="' + file_id + '"]').remove();
    
});
