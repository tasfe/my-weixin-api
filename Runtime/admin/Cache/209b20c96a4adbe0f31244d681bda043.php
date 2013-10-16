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
    <div class="page-header"><h4>活动编辑</h4></div>

    <!--<p class="view"><b>功能：</b>管理&nbsp;|&nbsp;添加|&nbsp;添加|&nbsp;添加|&nbsp;添加|&nbsp;添加</p>-->
    <div class="row">
        <div class="span12">
            <div class="pull-left">
                <a href="<?php echo U('/'.$module_name);?>" class="btn btn-primary">列 表</a>&nbsp;&nbsp;
                <!--<a href="<?php echo U($module_name.'/add');?>" class="btn btn-primary">新 增</a>&nbsp;&nbsp;-->
                <a class="btn btn-primary" href="<?php echo ($pre_url); ?>">返 回</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="span12" style="margin-top:10px;">
            <form class="form-horizontal" method="post">
                <fieldset>
                    <div id="legend" class="">
                        <legend class=""></legend>
                    </div>
                    <div class="control-group">

                        <!-- Text input-->
                        <label class="control-label" for="input01">秒杀活动标题</label>
                        <div class="controls">
                            <input type="text" placeholder="" value="<?php echo ($info["goods_title"]); ?>" name="goods_title" class="input-xlarge">
                            <p class="help-block"></p>
                        </div>
                    </div>

                    <div class="control-group">

                        <!-- Text input-->
                        <label class="control-label" for="input01">商品名称</label>
                        <div class="controls">
                            <input type="text" placeholder="" value="<?php echo ($info["goods_name"]); ?>" name="goods_name" class="input-xlarge">
                            <p class="help-block"></p>
                        </div>
                    </div>

                    <div class="control-group">

                        <!-- Text input-->
                        <label class="control-label" for="input01">秒杀商品数量</label>
                        <div class="controls">
                            <input type="text" placeholder="" value="<?php echo ($info["goods_num"]); ?>" name="goods_num" class="input-xlarge">
                            <p class="help-block">请输入商品数量，该数值为大于0的整数</p>
                        </div>
                    </div>

                    <div class="control-group">

                        <!-- Text input-->
                        <label class="control-label" for="input01">商品原价</label>
                        <div class="controls">
                            <input type="text" placeholder="" value="<?php echo ($info["goods_cost_price"]); ?>" name="goods_cost_price" class="input-xlarge">
                            <p class="help-block">可以精确到小数点后1位</p>
                        </div>
                    </div>

                    <div class="control-group">

                        <!-- Text input-->
                        <label class="control-label" for="input01">秒杀价格</label>
                        <div class="controls">
                            <input type="text" placeholder="" value="<?php echo ($info["goods_price"]); ?>" name="goods_price" class="input-xlarge">
                            <p class="help-block"></p>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">商品图片</label>

                        <!-- Button -->
                        <div class="controls">
                            <script type="text/javascript" src="__PUBLIC__/swfupload/swfupload.js"></script><script type="text/javascript">var img_id="imgupload";var img_name="imgupload";var lfy_root_path="/weixin_api";</script><script type="text/javascript" src="__PUBLIC__/swfupload/handlers.js"></script><script type="text/javascript" src="__PUBLIC__/swfupload/config_img.js"></script><div style="border: solid 1px #7FAAFF; background-color: #C5D9FF;width:80px;"><span id="spanButtonPlaceholder_imgupload"></span></div><div id="imgupload_imgupload"><a href='<?php echo ($info["pic_url"]); ?>' target='_blank'><img width='80' height='80' src='<?php echo ($info["pic_url"]); ?>' /></a></div>
                            <p class="help-block">图片尺寸：640*320</p>
                        </div>
                    </div>

                    <div class="control-group">

                        <!-- Text input-->
                        <label class="control-label" for="input01">开始时间</label>
                        <div class="controls">
                            <input type="text" placeholder="请填写活动开始时间" value="<?php echo ($info["begin_time"]); ?>" name="begin_time" class="input-xlarge">
                            <p class="help-block">秒杀活动开始时间，格式为2013-09-29 15:30:25</p>
                        </div>
                    </div>

                    <div class="control-group">

                        <!-- Text input-->
                        <label class="control-label" for="input01">结束时间</label>
                        <div class="controls">
                            <input type="text" placeholder="请填写活动结束时间" value="<?php echo ($info["stop_time"]); ?>" name="stop_time" class="input-xlarge">
                            <p class="help-block">秒杀活动结束时间，格式为2013-09-29 15:30:25</p>
                        </div>
                    </div>

                    <div class="control-group">

                        <!-- Text input-->
                        <label class="control-label" for="input01">兑换截止时间</label>
                        <div class="controls">
                            <input type="text" placeholder="请填写兑换截止时间" value="<?php echo ($info["exchange_stop_time"]); ?>" name="exchange_stop_time" class="input-xlarge">
                            <p class="help-block">商品兑换截止时间，格式为2013-09-29 15:30:25</p>
                        </div>
                    </div>

                    <div class="control-group">

                        <!-- Select Basic -->
                        <label class="control-label">显示状态</label>
                        <div class="controls">
                            <select class="input-xlarge" name="status">
                                <option value="1"<?php if($info['status']==1) echo ' selected="selected"'; ?>>显示</option>
                                <option value="0"<?php if($info['status']==0) echo ' selected="selected"'; ?>>隐藏</option></select>
                        </div>

                    </div><div class="control-group">

                        <!-- Text input-->
                        <label class="control-label" for="input01">排序</label>
                        <div class="controls">
                            <input type="text" placeholder="" name="sort" value="<?php echo ($info["sort"]); ?>" class="input-xlarge">
                            <p class="help-block">同时开始的活动，排序越小越靠前</p>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="input01">兑换码位数</label>
                        <div class="controls">
                            <input type="text" placeholder="" name="code_num" value="<?php echo ($info["code_num"]); ?>" class="input-xlarge">
                            <p class="help-block">默认为10位</p>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="input01">每微信账号参与次数</label>
                        <div class="controls">
                            <input type="text" placeholder="" name="wx_user_num" value="<?php echo ($info["wx_user_num"]); ?>" class="input-xlarge">
                            <p class="help-block">默认为1次，填写0为不限制秒杀次数</p>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">商品说明</label>
                        <div class="controls">
                            <div class="textarea">
                                <script type='text/javascript'> var lfy_root_path='/weixin_api/admin';var lfy_editor_upload_path='/weixin_api/uploadfiles/';</script><script type="text/javascript" src="__PUBLIC__/ueditor/editor_config.js"></script><script type="text/javascript" src="__PUBLIC__/ueditor/editor_all_min.js"></script><link rel="stylesheet" type="text/css" href="__PUBLIC__/ueditor/themes/default/ueditor.css" /><script type="text/plain" id="goods_explain_editor" name="goods_explain" style="width:70%;"><?php echo ($info["goods_explain"]); ?></script><script type='text/javascript'> var  goods_explain_editor = new baidu.editor.ui.Editor({ minFrameHeight:'300'});$(function(){ $('document').ready(function(){ goods_explain_editor.render('goods_explain_editor');});});</script>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">兑换说明</label>
                        <div class="controls">
                            <div class="textarea">
                                <textarea type="" class="" name="exchange_explain" style="width:500px;height: 100px"><?php echo ($info["exchange_explain"]); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">备注</label>
                        <div class="controls">
                            <div class="textarea">
                                <textarea type="" class="" name="remark" style="width:500px;height: 100px"><?php echo ($info["remark"]); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div id='pop'></div>

                    <div class="form-actions">
                        <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>">
                        <button type="button" class="btn btn-primary" id='save'>保 存</button>&nbsp;&nbsp;
                        <a class="btn" href="<?php echo ($pre_url); ?>">返 回</a>
                    </div>

                </fieldset>
            </form>
        </div>
    </div>

</div>
</div>

<script src="__PUBLIC__/js/bootstrap.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/edit_none_editor.js"></script>
</body>
</html>