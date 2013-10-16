<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <meta charset="utf-8">
        <title>微信公众平台营销管理系统</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
    <link href="__PUBLIC__/css/bootstrap.min.css" rel="stylesheet">
<link href="__PUBLIC__/css/docs.css" rel="stylesheet">
<link href="__PUBLIC__/css/bootstrap-responsive.min.css" rel="stylesheet">
<script src="__PUBLIC__/js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo U('js/url');?>"></script>
<script type="text/javascript">
    var module_name="<?php echo ($module_name); ?>";
    var action_name="<?php echo ($action_name); ?>";
</script>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="__ROOT__/public/js/html5shiv.js"></script>
    <![endif]-->
</head>

<body>
    <!--nav-->
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container" style="width:98%">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="#">微信公众平台营销管理系统</a>
            <div class="nav-collapse collapse navbar-inverse-collapse">
                <ul class="nav">
                    <li<?php if($module_name=='main') echo ' class="active"'; ?>><a href="<?php echo U('/main');?>">首页</a></li>
                    <?php if(session('admin')==1){ ?>
                    <li class="dropdown<?php if(in_array($module_name,array('weixin_menu','subscribe','config'))) echo ' active'; ?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">基础配置 <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo U('config/index');?>">系统配置</a></li>
                            <li><a href="<?php echo U('subscribe/index');?>">新订阅管理</a></li>
                            <li><a href="<?php echo U('/weixin_menu');?>">微信菜单管理</a></li>
                        </ul>
                    </li>

                    <li class="dropdown<?php if($module_name=='zhiling' || $module_name=='reply_database') echo ' active'; ?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">回复管理 <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo U('zhiling/index');?>">文本/菜单指令管理</a></li>
                            <li><a href="<?php echo U('reply_database/index');?>">智能回复管理</a></li>
                        </ul>
                    </li>
                    <?php } ?>
                    <li class="dropdown<?php if(in_array($module_name,array('choujiang','choujiang_duijiang','duijiang','choujiang_award'))) echo ' active'; ?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">活动管理 <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php if(session('admin')==1){ echo '<li><a href="'.U('choujiang/index').'">活动管理</a></li>'; } ?>
                            <li><a href="<?php echo U('choujiang_duijiang/index');?>">奖品兑换记录</a></li>
                            <li><a href="<?php echo U('duijiang/index');?>">奖品兑换</a></li>
                        </ul>
                    </li>
                    
                    <li class="dropdown<?php if($module_name=='seckill_goods' || $module_name=='seckill_duihuan') echo ' active'; ?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">微信秒杀管理 <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php if(session('admin')==1){ echo '<li><a href="'.U('seckill_goods/index').'">秒杀商品管理</a></li>'; } ?>
                            <li><a href="<?php echo U('seckill_duihuan/index');?>">兑换记录</a></li>
                            <li><a href="<?php echo U('seckill_duihuan/duihuan');?>">秒杀兑换</a></li>
                        </ul>
                    </li>

                    <!--                            <li class="dropdown">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">网站开发 <b class="caret"></b></a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="#">客户案例</a></li>
                                                        <li class="divider"></li>
                                                        <li><a href="#">开发流程</a></li>
                                                        <li class="divider"></li>
                                                        <li><a href="#">常见问题</a></li>
                                                    </ul>
                                                </li>
                    -->
                </ul>
                <ul class="nav pull-right">
                    <?php if(session('admin')==1){ ?>
                        <li<?php if($module_name=='user') echo ' class="active"'; ?>><a href="<?php echo U('user/change_password');?>"><small><i class="icon-user"></i> 修改密码</small></a></li>
                    <?php } ?>
                    <?php if(session('admin')=='1'){ echo '<li><a href="/login"><small><i class="icon-wrench"></i> 系统管理</small></a></li>'; } ?>
                    <li><a href="<?php echo U('index/out');?>"><small><i class="icon-off"></i> 安全退出</small></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <!--            <ul class="breadcrumb">
                    <li><a href="#">首页</a> <span class="divider">/</span></li>
                    <li><a href="#">Library</a> <span class="divider">/</span></li>
                    <li class="active">Data</li>
                </ul>-->
    <div class="page-header"><h4>系统配置</h4></div>

    <!--<p class="view"><b>功能：</b>管理&nbsp;|&nbsp;添加|&nbsp;添加|&nbsp;添加|&nbsp;添加|&nbsp;添加</p>-->
    <!--    <div class="row">
            <div class="span12">
                <div class="pull-left">
                    <a href="<?php echo U('/'.$module_name);?>" class="btn btn-primary">列 表</a>&nbsp;&nbsp;
                    <a href="<?php echo U($module_name.'/add');?>" class="btn btn-primary">新 增</a>&nbsp;&nbsp;
                    <a class="btn btn-primary" onclick="history.go(-1);">返 回</a>
                </div>
            </div>
        </div>-->
    <div class="row">
        <div class="span12" style="margin-top:10px;">
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1" data-toggle="tab">系统配置</a></li>
                    <li><a href="#tab2" data-toggle="tab">微信回复配置</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <form class="form-horizontal">
                            <fieldset>
                                <div class="control-group">
                                    <label class="control-label" for="input01">微信通信密钥</label>
                                    <div class="controls">
                                        <input type="text" placeholder="微信通信密钥" class="input-xlarge">
                                        <p class="help-block">与微信公众平台通信token密钥一致</p>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="tab-pane" id="tab2">
                        <p><span>图文列表返回数量：</span><input type="text" size="20" name="count" /></p>
                        <p><span>默认回复文本：</span><input type="text" size="20" name="count" /></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="span12">
            <button class="btn btn-primary" type="button">保存全部</button>
        </div>
    </div>

</div>
</div>

<script src="__PUBLIC__/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('[name=msg_type]').change(function() {
            msg_type_change()
        });

        $('[name=main]').change(function() {
            main_change()
        });


        function main_change() {
            var id = $('[name=main]').val();
            if (id == '0') {
                $('[name=sort]').parent().parent().hide();
            } else {
                $('[name=sort]').parent().parent().show();
            }
        }



        function msg_type_change() {
            var value = $('[name=msg_type]').val();

            switch (value) {
                case "1":
                    $('[name=click_url]').parent().parent().hide();
                    $('#pic_upload').hide();
                    $('[name=main]').parent().parent().hide();
                    $('[name=sort]').parent().parent().hide();
                    break;
                case "2":
                    $('[name=click_url]').parent().parent().show();
                    $('#pic_upload').show();
                    $('[name=main]').parent().parent().hide();
                    $('[name=sort]').parent().parent().hide();
                    break;
                case "3":
                    $('[name=click_url]').parent().parent().show();
                    $('#pic_upload').show();
                    $('[name=main]').parent().parent().show();
//                $('[name=sort]').parent().parent().hide();
                    break;
            }
        }



        $('#save').click(function() {
            contents_editor.sync();
            var data = $('form').serialize();
            $.ajax({
                type: "POST",
                url: app_url + "/<?php echo ($module_name); ?>/update",
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
            if (data.data == 1) {
                $('#pop').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>信息修改成功！</div>')
                        .fadeIn("slow")
                        .fadeOut(5000);
            } else {
                $('#pop').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>信息修改失败或者信息并无改变！</div>')
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
</script>
</body>
</html>