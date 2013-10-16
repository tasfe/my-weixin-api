<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" />
        <meta name="format-detection" content="telephone=no" />
        <title><?php echo ($name); ?></title>
        <link href="__PUBLIC__/css/style.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo U('js/url');?>"></script>
    <?php if(empty($msg)){ ?>
    <script type="text/javascript">
        $('document').ready(function() {
            var backimage = {'url': app_url + '/choujiang/guaguaka_make/id/<?php echo $id; ?>', 'img': null};
            var canvas = {'temp': null, 'draw': null};
            var mouseDown = false;
            // canvas 合成	
            function recompositeCanvases() {
                var main = document.getElementById('main');
                var tempctx = canvas.temp.getContext('2d');
                var mainctx = main.getContext('2d');
                canvas.temp.width = canvas.temp.width;
                tempctx.drawImage(canvas.draw, 0, 0);
                tempctx.globalCompositeOperation = 'source-atop';
                tempctx.drawImage(backimage.img, 0, 0);
                mainctx.fillStyle = "#888";
                mainctx.fillRect(0, 0, backimage.img.width, backimage.img.height);
                mainctx.drawImage(canvas.temp, 0, 0);
            }

            //画线
            function scratch(canv, x, y, fresh) {
                var ctx = canv.getContext('2d');
                ctx.lineWidth = 10;
                ctx.lineCap = ctx.lineJoin = 'round';
                if (fresh) {
                    ctx.beginPath();
                    ctx.moveTo(x + 0.01, y);
                }
                ctx.lineTo(x, y);
                ctx.stroke();
            }

            function setupCanvases() {
                var c = document.getElementById('main');
                c.width = 120;
                c.height = 42;

                canvas.temp = document.createElement('canvas');
                canvas.draw = document.createElement('canvas');

                canvas.temp.width = canvas.draw.width = c.width;
                canvas.temp.height = canvas.draw.height = c.height;

                recompositeCanvases();

                function mousedown_handler(e) {
                    var local = getLocalCoords(c, e);
                    mouseDown = true;
                    scratch(canvas.draw, local.x, local.y, true);
                    recompositeCanvases();
                    if (e.cancelable) {
                        e.preventDefault();
                    }
                    return false;
                }

                function mousemove_handler(e) {
                    if (!mouseDown) {
                        return true;
                    }

                    var local = getLocalCoords(c, e);

                    scratch(canvas.draw, local.x, local.y, false);
                    recompositeCanvases();

                    if (e.cancelable) {
                        e.preventDefault();
                    }
                    return false;
                }

                function mouseup_handler(e) {
                    if (mouseDown) {
                        mouseDown = false;
                        if (e.cancelable) {
                            e.preventDefault();
                        }
                        return false;
                    }

                    return true;
                }
                c.addEventListener('mousedown', mousedown_handler, false);
                c.addEventListener('touchstart', mousedown_handler, false);

                window.addEventListener('mousemove', mousemove_handler, false);
                window.addEventListener('touchmove', mousemove_handler, false);

                window.addEventListener('mouseup', mouseup_handler, false);
                window.addEventListener('touchend', mouseup_handler, false);
            }

            function getLocalCoords(elem, ev) {
                var ox = 0, oy = 0;
                var first;
                var pageX, pageY;

                while (elem != null) {
                    ox += elem.offsetLeft;
                    oy += elem.offsetTop;
                    elem = elem.offsetParent;
                }

                if (ev.hasOwnProperty('changedTouches')) {
                    first = ev.changedTouches[0];
                    pageX = first.pageX;
                    pageY = first.pageY;
                } else {
                    pageX = ev.pageX;
                    pageY = ev.pageY;
                }
                return {'x': pageX - ox, 'y': pageY - oy};
            }
            backimage.img = document.createElement('img');
            backimage.img.addEventListener('load', setupCanvases, false);
            backimage.img.src = backimage.url;
        });
    </script>
    <?php } ?>
</head>

<body>
    <div class="card_top">
        <div class="card_info">
            <div class="card_title"></div>
            <div class="card_main">
                <?php if(empty($msg)){ echo '<canvas id="main"></canvas>'; }else{ echo $msg; } ?>
            </div>
        </div>
    </div>
    <div class="min_box">
        <div class="set_main">
            <div class="set_box">
                <div class="set_box_layer"><a href="<?php echo U('/my_prize');?>">查看中奖记录</a></div>
                <p><?php echo ($prize); ?></p>
            </div>
        </div>
        <div class="event_main">
            <div class="event_box">
                <p><?php echo ($explain); ?></p>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="http://tajs.qq.com/stats?sId=27434495" charset="UTF-8"></script>
</body>
</html>