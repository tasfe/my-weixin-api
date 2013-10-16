<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" />
        <meta name="format-detection" content="telephone=no" />
        <title>微信秒杀</title>
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
                            <div class="spike_ti_right" onclick="location.href='<?php echo U('seckill/record');?>';">秒杀成功记录</div>
                        </div>
                        <div class="spike_text_title" style="margin-top:22px;">当前进行中的活动</div>
                        <div class="spike_center">
                            <ul>
                                <?php if(is_array($start_array)): foreach($start_array as $key=>$vo): ?><li>
                                        <img src="<?php echo ($vo["pic_url"]); ?>" />
                                        <div class="credit_tit"><?php echo ($vo["goods_title"]); ?></div>
                                        <p>秒杀价格：<span class="red"><?php echo ($vo["goods_price"]); ?>元</span></p>
                                        <p>商品原价：<span class="gray"><del><?php echo ($vo["goods_cost_price"]); ?>元</del></span></p>
                                        <p>商品数量：<span class="red"><?php echo ($vo["goods_num"]); ?></span></p>
                                        <p>剩余数量：<span class="red"><?php echo get_seckill_surplus($vo['id']);?></span></p>
                                    <?php if(get_seckill_surplus($vo['id'])>0){ echo '<div class="credit_submit_t"><a href="'.U('/seckill-'.$vo['id']).'">点击前往秒杀</a></div>'; }else{ echo '<div class="credit_submit_end"><a href="'.U('/seckill-'.$vo['id']).'">已被抢光</a></div>'; } ?>
                                    <!--<div class="credit_submit_end">已经结束</div>-->
                                    </li><?php endforeach; endif; ?>
                            </ul>
                        </div>
                        <div class="spike_text_title">活动预告</div>
                        <div class="spike_center">
                            <ul>
                                <?php if(is_array($future_array)): foreach($future_array as $key=>$vo): ?><li>
                                        <img src="__PUBLIC__/images/tmp/img3.jpg" />
                                        <div class="credit_tit"><?php echo ($vo["goods_title"]); ?></div>
                                        <p>商品数量：<span class="red"><?php echo ($vo["goods_num"]); ?></span></p>
                                        <p>商品原价：<span class="gray"><del><?php echo ($vo["goods_cost_price"]); ?>元</del></span></p>
                                        <p>秒杀价格：<span class="red"><?php echo ($vo["goods_price"]); ?>元</span></p>
                                        <p>开始时间：<span class="red"><?php echo get_date_full($vo['begin_time']);?></span></p>
                                        <div class="credit_submit_end"><a href="<?php echo U('/seckill-'.$vo['id']);?>">即将开始</a></div>
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