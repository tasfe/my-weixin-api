jQuery(function($) {
    $('[name=user_name]').focus();
    $('#login').click(function() {
        check_form();
    });

    $("body").keydown(function() {
        if (event.keyCode == "13") {
            //keyCode=13是回车键
            check_form();
        }
    });

    $("#verifyImg").click(function() {
        fleshVerify();
    });
});


function check_form() {
    if ($('[name=user_name]').val() == '') {
        $('#pop').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>请填写用户名！</div>')
                .slideDown(1000);
        setTimeout(function() {
            $('#pop').slideUp(2000);
        }, 2500);
        $('[name=user_name]').focus();
        fleshVerify();
        return false;
    }

    if ($('[name=user_pwd]').val() == '') {
        $('#pop').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>请填写登录密码！</div>')
                .slideDown(1000);
        setTimeout(function() {
            $('#pop').slideUp(2000);
        }, 2500);
        $('[name=user_pwd]').focus();
        fleshVerify();
        return false;
    }

    if ($('[name=verify]').val() == '') {
        $('#pop').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>请填写验证码！</div>')
                .slideDown(1000);
        setTimeout(function() {
            $('#pop').slideUp(2000);
        }, 2500);
        $('[name=verify]').focus();
        fleshVerify();
        return false;
    } else {
        login();
    }
}

function login() {
    var data = $('form').serialize();
    $.ajax({
        type: "POST",
        url: app_url + "/index/login",
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
}

function error() {
    $('#pop').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>远程服务器请求失败！</div>')
            .slideDown(1000);
    setTimeout(function() {
        $('#pop').slideUp(2000);
    }, 2500);
    fleshVerify();
}

function success(data) {
    switch (data.data) {
        case 0:
            $('#pop').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>该用户不存在！</div>')
                    .slideDown(1000);
            setTimeout(function() {
                $('#pop').slideUp(2000);
            }, 2500);
            $('[name=user_name]').val('').focus();
            fleshVerify();
            break;
        case 1:
            $('#pop').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>登录成功！</div>')
                    .slideDown(1000);
            location.href = app_url + "/main";
            break;
        case 2:
            $('#pop').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>登录密码错误！</div>')
                    .slideDown(1000);
            setTimeout(function() {
                $('#pop').slideUp(2000);
            }, 2500);
            $('[name=user_pwd]').val('').focus();
            fleshVerify();
            break;
        case 3:
            $('#pop').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>验证码错误！</div>')
                    .slideDown(1000);
            setTimeout(function() {
                $('#pop').slideUp(2000);
            }, 2500);
            $('[name=verify]').val('').focus();
            fleshVerify();
            break;
    }
}

function fleshVerify()
{
    var time = new Date().getTime();
    $("#verifyImg").attr('src', app_url + "/Index/verify?type=gif?rand=" + time);
}

