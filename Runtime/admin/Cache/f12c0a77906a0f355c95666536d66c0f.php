<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <meta charset="utf-8">
        <title>微信公众平台营销管理系统登录</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="__PUBLIC__/css/bootstrap.min.css" rel="stylesheet">
        <style type="text/css">
            body {
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
            }

            .form-signin {
                max-width: 300px;
                padding: 19px 29px 29px;
                margin: 0 auto 20px;
                background-color: #fff;
                border: 1px solid #e5e5e5;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
                -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
            }
            .form-signin .form-signin-heading,
            .form-signin .checkbox {
                margin-bottom: 10px;
            }
            .form-signin input[type="text"],
            .form-signin input[type="password"] {
                font-size: 16px;
                height: auto;
                margin-bottom: 15px;
                padding: 7px 9px;
            }

            #pop{
                display: none;
            }

        </style>
        <link href="__PUBLIC__/css/bootstrap-responsive.min.css" rel="stylesheet">
        <!--[if lt IE 9]>
          <script src="//cdnjs.bootcss.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
        <![endif]-->
    </head>

    <body>

        <div class="container">
            <form class="form-signin" method="post">
                <h3 class="form-signin-heading">管理系统登录</h3>
                <div id="pop"></div>
                <input type="text" class="input-block-level" name="user_name" placeholder="用户名">
                <input type="password" class="input-block-level" name="user_pwd" placeholder="密码">
                <button class="btn btn-large btn-primary" type="button" id="login">登 录</button>
            </form>

        </div>
        <script src="__PUBLIC__/js/jquery.min.js"></script>
        <script src="__PUBLIC__/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo U('js/url');?>"></script>
        <script type="text/javascript" src="__PUBLIC__/js/login.js"></script>
    </body>
</html>