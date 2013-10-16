<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" />
        <meta name="format-detection" content="telephone=no" />
        <title>我的中奖记录</title>
        <link href="__PUBLIC__/css/style.css" rel="stylesheet" type="text/css">
    </head>

    <body class="record_bg">
        <div class="min_box">
            <div class="record_main">
                <div class="record_box">
                    <?php if(is_array($prize_list)): foreach($prize_list as $key=>$vo): ?><div class="record_list">
                            <p>奖　项：<?php echo get_award_name($vo['award_id']);?></p>
                            <p>兑奖码：<?php echo ($vo["award_code"]); ?></p>
                            <p>时　间：<?php echo ($vo["create_date"]); ?></p>
                            <p>兑奖截止：<?php echo get_award_stop_time($vo['choujiang_id']);?></p>
                        </div><?php endforeach; endif; ?>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="http://tajs.qq.com/stats?sId=27434495" charset="UTF-8"></script>
    </body>
</html>