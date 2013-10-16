$(function() {
    $('[name=user_name]').focus();

    $('#login').click(function() {
        var data = $('form').serialize();
        if ($('[name=user_name]').val() == '') {
            $('#pop').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>请填写用户名！</div>')
                    .slideDown()
                    .fadeOut(2000);
            $('[name=user_name]').focus();
            return false;
        }

        if ($('[name=user_pwd]').val() == '') {
            $('#pop').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>请填写登录密码！</div>')
                    .slideDown()
                    .fadeOut(2000);
            $('[name=user_pwd]').focus();
            return false;
        }

        $.ajax({
            type: "POST",
            url: app_url + "/index/login",
            data: data,
            timeout:5000,
            dataType: 'json',
            cache: false,
            success: function(data) {
                success(data);
            },
            error: function() {
                error();
            }
        });

        function error() {
            $('#pop').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>远程服务器请求失败！</div>')
                    .slideDown()
                    .fadeOut(2000);
        }

        function success(data) {
            switch (data.data) {
                case 0:
                    $('#pop').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>该用户不存在！</div>')
                            .slideDown()
                            .fadeOut(2000);
                    $('[name=user_name]').val('').focus();
                    break;
                case 1:
                    $('#pop').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>登录成功！</div>')
                            .slideDown();
                    location.href = app_url + "/main";
                    break;
                case 2:
                    $('#pop').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>登录密码错误！</div>')
                            .slideDown()
                            .fadeOut(2000);
                    $('[name=user_pwd]').val('').focus();
                    break;
            }
        }

    });
});