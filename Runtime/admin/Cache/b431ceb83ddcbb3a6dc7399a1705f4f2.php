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
    <div class="page-header"><h4>秒杀商品兑换</h4></div>
    <div class="row">
        <div class="span12">
            <div class="pull-left">
                <a href="<?php echo U('/'.$module_name.'/duihuan');?>" class="btn btn-primary">返回兑换其他秒杀兑换码</a>&nbsp;&nbsp;
            </div>
        </div>
    </div>
    <div class="row">
        <div class="span12" style="margin-top:10px;">
            <form class="form-horizontal" method="post" action="<?php echo U('/'.$module_name.'/duihuan_action');?>">
                <fieldset>
                    <div id="legend" class="">
                        <legend class=""></legend>
                    </div>
                    <?php if(!empty($goods_info)){ ?>
                    <div id="legend" class="">
                        <legend class="">秒杀信息</legend>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input01">微信识别码</label>
                        <div class="controls" style="margin-top: 5px;">
                            <?php echo ($weixin_id); ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="input01">秒杀时间</label>
                        <div class="controls" style="margin-top: 5px;">
                            <?php echo get_date_full($create_time);?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="input01">商品兑换码</label>
                        <div class="controls" style="margin-top: 5px;">
                            <?php echo ($code); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input01">兑换截止时间</label>
                        <div class="controls" style="margin-top: 5px;">
                            <?php echo get_date_full($goods_info['exchange_stop_time']);?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input01">兑换状态</label>
                        <div class="controls" style="margin-top: 5px;">
                            <?php if($status==0) echo '未兑换'; else echo '已经兑换'; ?>
                        </div>
                    </div>
                    <div id="legend" class="">
                        <legend class="">商品信息</legend>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input01">秒杀活动名称</label>
                        <div class="controls" style="margin-top: 5px;">
                            <?php echo ($goods_info["goods_title"]); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input01">商品名称</label>
                        <div class="controls" style="margin-top: 5px;">
                            <?php echo ($goods_info["goods_name"]); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input01">商品原价</label>
                        <div class="controls" style="margin-top: 5px;">
                            <?php echo ($goods_info["goods_cost_price"]); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input01">秒杀价格</label>
                        <div class="controls" style="margin-top: 5px;color:red;">
                            <?php echo ($goods_info["goods_price"]); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input01">活动开始时间</label>
                        <div class="controls" style="margin-top: 5px;">
                            <?php echo get_date_full($goods_info['begin_time']);?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input01">活动结束时间</label>
                        <div class="controls" style="margin-top: 5px;">
                            <?php echo get_date_full($goods_info['stop_time']);?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input01">商品备注</label>
                        <div class="controls" style="margin-top: 5px;">
                            <?php echo ($goods_info["remark"]); ?>
                        </div>
                    </div>
                    <div id="legend" class="">
                        <legend class="">填写客户信息</legend>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input01">用户姓名</label>
                        <div class="controls">
                            <input type="text" placeholder="" class="input-xlarge" name="user_name">
                            <p class="help-block"></p>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="input01">联系电话</label>
                        <div class="controls">
                            <input type="text" placeholder="" class="input-xlarge" name="user_telephone">
                            <p class="help-block"></p>
                        </div>
                    </div>

                    <div class="form-actions">
                        <input name="id" type="hidden" value="<?php echo ($id); ?>">
                        <button type="submit" class="btn btn-primary">确认兑换</button>
                    </div>
                    <?php }else{ echo '该兑换码不存在或者已经兑换！'; } ?>
                </fieldset>
            </form>
        </div>
    </div>
</div>
</div>
<script src="__PUBLIC__/js/bootstrap.min.js"></script>
</body>
</html>