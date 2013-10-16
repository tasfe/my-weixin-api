<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
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
    <div class="page-header"><h4>微信菜单管理</h4></div>
    <div class="row">
        <div class="span12">
            <div class="pull-left">
                <a href="<?php echo U($module_name.'/add');?>" class="btn btn-primary">新增菜单</a>&nbsp;&nbsp;
                <a class="btn btn-primary" href="<?php echo U($module_name.'/get_weixin_server_menu');?>">查询当前菜单</a>&nbsp;&nbsp;
                <a class="btn btn-primary" id="put_weixin_server">上传到微信服务器</a>&nbsp;&nbsp;
                <a class="btn btn-primary" id="delete_weixin_menu">删除微信服务器菜单</a>
            </div>
        </div>
        <div class="span12" style="margin-top:10px;">
            <div id='pop'></div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>菜单名称</th>
                        <th>菜单响应KEY</th>
                        <th>子菜单数量</th>
                        <th>排序</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="7"><div class="row pagination page"><div class="span12"><?php echo ($page); ?></div></div></td>
                    </tr>
                </tfoot>
                <tbody>
                <?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr id='tr_<?php echo ($vo["id"]); ?>'>
                        <td><?php echo ($vo["id"]); ?></td>
                        <td><?php echo ($vo["name"]); ?></td>
                        <td><?php echo ($vo["menu_key"]); ?></td>
                        <td><?php echo get_submenu_count($vo['id']);?></td>
                        <td><?php echo ($vo["sort"]); ?></td>
                        <td><?php echo get_status_img($vo['status']);?></td>
                        <td>
                            <a href="<?php echo U($module_name.'/edit?id='.$vo['id']);?>">编辑</a>&nbsp;&nbsp;
                            <a href="<?php echo U($module_name.'/index_submenu?menu_id='.$vo['id']);?>">子菜单管理</a>&nbsp;&nbsp;
                            <a href="###" onclick="delete_tr(<?php echo ($vo["id"]); ?>);">删除</a>
                        </td>
                    </tr><?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="__PUBLIC__/js/bootstrap.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/list.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/weixin_menu_action.js"></script>
</body>
</html>