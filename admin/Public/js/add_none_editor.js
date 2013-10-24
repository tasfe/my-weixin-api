$(function() {
    var save_button=$('#save');
    save_button.click(function() {
        var data = $('form').serialize();
        save_button.attr('disabled', 'disabled');
        $.ajax({
            type: "POST",
            url: app_url + "/" + module_name + "/insert",
            data: data,
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
        if (data.data == 1) {
            $('#pop').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>信息添加成功！</div>')
                    .fadeIn("slow")
                    .fadeOut(5000);
        } else {
            $('#pop').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>信息添加失败！</div>')
                    .fadeIn("slow")
                    .fadeOut(5000);
        }
    }


    function error() {
        $('#pop').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>远程服务器请求失败！</div>')
                .fadeIn("slow")
                .fadeOut(5000);
    }
});