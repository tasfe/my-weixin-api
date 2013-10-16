<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" />
        <meta name="format-detection" content="telephone=no" />
        <title><?php echo ($goods_info["goods_title"]); ?></title>
        <link href="__PUBLIC__/css/style.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo U('js/url');?>"></script>
    </head>

    <body>
        <div class="wrap">
            <div class="spike_top">
                <div class="spike_top_img"></div>
            </div>
            <div class="regtion_min_box">
                <div class="set_main">
                    <div class="spike_dashed">
                        <div class="spike_title">
                            <div class="spike_ti_left" onclick="location.href='<?php echo U('/seckill');?>';">秒杀首页</div>
                            <div class="spike_ti_right" onclick="location.href='<?php echo U('seckill/record');?>';">秒杀成功记录</div>
                            <!--<div class="spike_ti_right"><a href="#">历史活动</a></div>-->
                        </div>
                        <div class="detailed_spike_center">
                            <ul>
                                <li>
                                    <img src="__PUBLIC__/images/tmp/img3.jpg" />
                                    <div class="credit_tit"><?php echo ($goods_info["goods_title"]); ?></div>
                                    <p>商品名称：<?php echo ($goods_info["goods_name"]); ?></p>
                                    <p>商品数量：<span class="red"><?php echo ($goods_info["goods_num"]); ?></span></p>
                                    <p>剩余数量：<span class="red "><?php echo get_seckill_surplus($goods_info['id']);?></span></p>
                                    <p>商品原价：<span class="gray "><del><?php echo ($goods_info["goods_cost_price"]); ?></del></span></p>
                                    <p>秒杀价格：<span class="red "><?php echo ($goods_info["goods_price"]); ?></span></p>
                                    <p>开始时间：<span class="red "><?php echo get_date_full($goods_info['begin_time']);?></span></p>
                                    <p>结束时间：<span class="red "><?php echo get_date_full($goods_info['stop_time']);?></span></p>
                                    <p>
                                <?php if($goods_info['begin_time']>time()){ echo '距离活动开始还有：<span class="red ">'.time_format($goods_info['begin_time']-time()).'</span>'; }elseif($goods_info['begin_time']<time() and $goods_info['stop_time']>time()){ echo '距离活动结束还有：<span class="red ">'.time_format($goods_info['stop_time']-time()).'</span>'; } ?>
                                </p>
                                <input type="hidden" name="goods_id" value="<?php echo ($goods_info["id"]); ?>" />
                                <?php if($goods_info['begin_time']>time()){ echo '<div class="credit_submit_end">即将开始</div>'; }elseif($goods_info['stop_time']<time()){ echo '<div class="credit_submit_end">已经结束</div>'; }elseif(get_seckill_surplus($goods_info['id'])<=0){ echo '<div class="credit_submit_end">已经被抢光了</div>'; }elseif($partake_num>=$goods_info['wx_user_num'] and $goods_info['wx_user_num']!=0){ echo '<div class="credit_submit_end">已成功秒杀</div>'; }else{ echo '<div class="credit_submit_t" id="start_seckill"><a href="###">立即秒杀</a></div>'; } ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="set_main">
                    <div class="credit_textdashed">
                        <div class="credit_de_nr"><?php echo ($goods_info["goods_explain"]); ?></div>
                    </div>
                </div>
                <div class="set_main">
                    <div class="credit_exchange">
                        <div class="credit_de_nr"><?php echo ($goods_info["exchange_explain"]); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function() {
                var SecKill = {
                    start_btn: $('#start_seckill'),
                    goods_id: $('[name=goods_id]'),
                    ajax_status: 0,
                    ajax_start: function() {
                        var _this = this;
                        var goods_id = _this.goods_id.val();
                        _this.ajax_status = 1;
                        _this.start_btn.html('处理中请稍候...');
                        $.ajax({
                            type: "POST", //请求方式
                            url: "<?php echo U('seckill/insert_record_action');?>",
                            data: {id: goods_id}, //数据
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
                        _this.ajax_status = 0;
                        switch (data.data) {
                            case 4:
                                alert('秒杀活动不存在！');
                                location.reload();
                                break;
                            case 0:
                                alert('秒杀尚未开始！');
                                _this.start_btn.html('即将开始');
                                _this.start_btn.removeClass('credit_submit_t');
                                _this.start_btn.addClass('credit_submit_end');
                                _this.start_btn.off();
                                _this.start_btn.on("click", function() {
                                    alert('秒杀尚未开始');
                                });
                                break;
                            case 1:
                                alert('该活动已经结束');
                                _this.start_btn.html('已经结束');
                                _this.start_btn.removeClass('credit_submit_t');
                                _this.start_btn.addClass('credit_submit_end');
                                _this.start_btn.off();
                                _this.start_btn.on("click", function() {
                                    alert('该活动已经结束');
                                });
                                break;
                            case 2:
                                alert('很遗憾，您抢购的商品已经被抢光了，请下次在来！');
                                _this.start_btn.html('已被抢光');
                                _this.start_btn.removeClass('credit_submit_t');
                                _this.start_btn.addClass('credit_submit_end');
                                _this.start_btn.off();
                                _this.start_btn.on("click", function() {
                                    alert('很遗憾，您抢购的商品已经被抢光了，请下次在来！');
                                });
                                break;
                            case 3:
                                alert('您本次秒杀活动次数已经用完！');
                                _this.start_btn.html('已秒杀');
                                _this.start_btn.off();
                                _this.start_btn.on("click", function() {
                                    alert('您本次秒杀活动次数已经用完！');
                                });
                                break;
                            case 88:
                                alert('恭喜您，秒杀成功，请到[秒杀成功记录]中查看，请尽快按照兑换说明进行兑换！');
                                _this.start_btn.html('秒杀成功');
                                _this.start_btn.off();
                                _this.start_btn.on("click", function() {
                                    alert('您已经秒杀成功！');
                                });
                                break;
                            default:
                                alert('远程服务器处理签到数据错误，请您重新进行秒杀！');
                                location.reload();
                                break;
                        }
                    },
                    ajax_error_callback: function() {
                        alert('远程服务器处理签到数据错误，请您重新进行秒杀！');
                        location.reload();
                    }
                };
                SecKill.start_btn.click(function() {
                    if (SecKill.ajax_status == 0) {
                        SecKill.ajax_start();
                    } else {
                        alert('系统处理您的秒杀请求中，请稍候...');
                    }
                });
            });
        </script>
        <script type="text/javascript" src="http://tajs.qq.com/stats?sId=27434495" charset="UTF-8"></script>
    </body>
</html>