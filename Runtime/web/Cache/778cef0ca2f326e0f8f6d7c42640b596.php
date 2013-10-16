<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" />
        <meta name="format-detection" content="telephone=no" />
        <title><?php echo ($title); ?></title>
        <link href="__PUBLIC__/css/style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo U('js/url');?>"></script>
    </head>

    <body style="background:#6a3807;">
        <div class="wrap">
            <div class="wei_img">
                <div class="wei_back">
                    <div class="min_tente">
                        <?php if($is_sign){ echo '<span class="submit_point" id="sign_in_ready"><a href="###" >今日已签到</a></span>'; }else{ echo '<span class="submit" id="sign_in"><a href="###" >立即签到</a></span>'; } ?>
                    </div>
                </div>
            </div>
            <div class="regtion_min_box">
                <div class="set_main">
                    <div class="integ_dashed">
                        <div class="sign"> 
                            您已经签到<strong><?php echo ($sign_count); ?></strong>天，获得<span class="red"><?php echo ($sign_integral); ?></span>积分，可到【<a href="#">积分中心</a>】中进行兑换。
                        </div>
                    </div>
                </div>
                <div class="set_main">
                    <div class="min_dashed">
                        <div class="bus_text"><?php echo ($sign_instructions); ?></div>
                    </div>
                </div>  
                <div class="set_main">
                    <div class="busin_dashed">
                        <div class="bus_text"><?php echo ($business_description); ?></div>
                    </div>
                </div>  
                <div class="set_main">
                    <div class="gration_dashed">
                        <div class="reg_t_right"><a href="#">更多&gt;&gt;</a></div>
                        <div class="reg_center">
                            <ul>
                                <?php if(is_array($sign_near_list)): foreach($sign_near_list as $key=>$vo): ?><li><?php echo ($vo["create_date"]); ?> 获得<?php echo ($vo["integral"]); ?>积分</li><?php endforeach; endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
        <script type="text/javascript">
            $(function() {
                var Sign = {
                    btn: $('#sign_in'),
                    ajax: function() {
                        var _this = this;
                        _this.btn.html('签到中...请稍候');
                        _this.btn.removeClass('submit');
                        _this.btn.addClass('submit_point');
                        $.ajax({
                            type: "POST", //请求方式
                            url: app_url + "/sign_in/insert_sign_in",
                            dataType: 'json', //返回数据类型
                            cache: false, //是否缓存
                            timeout: 20000, //超时时间
                            success: function(data) {
                                _this.ajax_success_callback(data);
                            },
                            error: function() {
                                _this.ajax_error_callback();
                            }
                        });
                    },
                    ajax_success_callback: function(data) {
                        var _this = this;
                        _this.btn.removeAttr('disabled');
                        switch (data.data) {
                            case 0:
                                alert('今日您已经签到！请明日继续签到！');
                                _this.btn.html('已签到');
                                _this.btn.removeClass('submit');
                                _this.btn.addClass('submit_point');
                                break;
                            case 1:
                                alert('今日签到成功！');
                                _this.btn.removeClass('submit');
                                _this.btn.addClass('submit_point');
                                location.reload();
                                break;
                            default:
                                alert('远程服务器处理签到数据错误，请您重新进行签到！');
                                location.reload();
                                break;
                        }
                    },
                    ajax_error_callback: function() {
                        alert('远程服务器处理签到数据错误，请您重新进行签到！');
                        location.reload();
                    }
                };

                Sign.btn.click(function() {
                    Sign.ajax();
                });

            });
        </script>
        <script type="text/javascript" src="http://tajs.qq.com/stats?sId=27434495" charset="UTF-8"></script>
    </body>
</html>