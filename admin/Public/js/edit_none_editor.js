$(function() {
    $('#save').click(function() {
        var data = $('form').serialize();
        $('#save').attr('disabled', 'disabled');
        $.ajax({
            type: "POST",
            url: app_url + "/"+module_name+"/update",
            data: data,
            timeout: 5000,
            dataType: 'json',
            cache: false,
            success: function(data) {
                success(data);
            },
            error: function() {
                error();
            }
        });
    });


    $('#pop').ajaxStart(function() {
        $('#pop').html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">×</button>数据请求中，请稍候...</div>')
                .fadeIn("slow");
    });

    function success(data) {
        $('#save').removeAttr('disabled');
        if (data.data == 1) {
            $('#pop').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>信息修改成功！</div>')
                    .fadeIn("slow");
        } else {
            $('#pop').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>信息修改失败或者信息并无改变！</div>')
                    .fadeIn("slow");
        }
    }

    function error() {
        $('#pop').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>远程服务器请求失败！</div>')
                .fadeIn("slow");
    }
});