<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" />
        <meta name="format-detection" content="telephone=no" />
        <title>秒杀成功记录</title>
        <link href="__PUBLIC__/css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="wrap">
            <div class="credit_top">
                <!-- top begin -->
                <div class="credit"></div>
                <!-- top end -->
            </div> 
            <div class="regtion_min_box">
                <!-- credit_centen begin -->
                <div class="set_main">
                    <div class="credit_dashed cf">
                        <div class="credit_right">
                            <div class="creadit_integ" onclick="location.href='<?php echo U('/seckill');?>';">秒杀首页</div>
                        </div>
                        <div class="soike_recor_title">成功秒杀记录</div>
                        <div class="spike_push_right">
                            <?php if($type==1){ echo '<a href="'.U('seckill/record?type=2').'">显示全部</a>'; }else{ echo '<a href="'.U('seckill/record').'">显示未兑换</a>'; } ?>
                        </div>
                        <div class="spike_list_recor">
                            <ul>
                                <?php if(is_array($list)): foreach($list as $key=>$vo): ?><li>
                                        <div class="spike_conne"><a href="<?php echo U('/seckill-'.$vo['seckill_id']);?>"><?php echo ($vo["goods_title"]); ?></a></div> 
                                        <p>商品名称：<?php echo ($vo["goods_name"]); ?></p>
                                        <p>商品原价：<del><?php echo ($vo["goods_cost_price"]); ?>元</del></p>
                                        <p>秒杀价格：<span class="red"><?php echo ($vo["goods_price"]); ?>元</span></p>
                                        <p>兑&nbsp;换&nbsp;码：<?php echo ($vo["code"]); ?></p>
                                        <p>秒杀时间：<?php echo get_date_full($vo['record_create_time']);?></p>
                                        <p>兑换截止日期：<?php if(empty($vo['exchange_stop_time'])) echo '无限制'; else echo get_date_full($vo['exchange_stop_time']); ?></p>
                                    <p>兑换状态：
                                    <?php if($vo['record_status']){ echo '<span class="gray">已兑换</span>'; }else{ echo '<span class="orange">未兑换</span>'; } ?>
                                    </p>
                                    <div class="recor_submit"><a href="<?php echo U('/seckill-'.$vo['seckill_id']);?>">点击查看详情</a></div>
                                    </li><?php endforeach; endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="http://tajs.qq.com/stats?sId=27434495" charset="UTF-8"></script>
    </body>
</html>