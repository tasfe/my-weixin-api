<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" />
        <meta name="format-detection" content="telephone=no" />
        <title>速来战-我的微信我主帅微信报名</title>
        <link href="__PUBLIC__/css/style.css" rel="stylesheet" type="text/css">
        <link href="__PUBLIC__/css/font-face.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo U('js/url');?>"></script>
    </head>

    <body class="signup_bg">
        <div class="signup_banner">
            <div class="signup_title">
                <div class="signup_title_l"><span class="glyphicon glyphicon-tags"></span></div>
                <div class="signup_title_txt">速来战-我的微信我主帅报名</div>
            </div>
            <img src="__PUBLIC__/images/tmp/tmp_img.jpg" alt="">
        </div>
        <div class="signup_txt_box">
            <b>速来战-我的微信我主帅，沈阳首届微信飞机大战及节奏大师比赛</b><br /><br />
            <b>举办时间：</b>10月7日下午2点（比赛报名人员下午1点签到） <br />
            <b>举办地点：</b>辽展地铁商城负二层中庭<br />
			<b>举办地址：</b>和平区彩塔街33号，辽宁工业展览馆前广场地下<br>
			<b>咨询电话：</b>31098566<br>
            <b>报名截止日期：</b>10月5日18：00点 <br /><br />
			<b>报名方式：</b>在下方填写您的联系电话、姓名及所选择参赛项目，参赛人员以短信电话通知为准<br /><br />
            <b>奖品设置：</b><br />
            一等奖各1名：ipad mini 1台<br />
            二等奖各2名：美嘉欢乐影城（万象店）提供价值100元观影票1张<br />
            三等奖各4名：万象城冰纷万象冰场提供价值75元冰票1张<br />
            参与奖：凡报名并参加比赛即可在比赛结束后领取10元Q币充值卡1张<br />
            <b>比赛规则：</b>请以沈阳辽宁工业展览馆地铁商城微信推送信息为准<br />

        </div>
        <div class="signup_inp_box">
            <div class="signup_inp_list">
                <div class="signup_inp_list_layer"><span class="glyphicon glyphicon-user"></span></div>
                <input type="text" name="name" onblur="if (this.value == '')
                            this.value = '姓名';" onfocus="if (this.value == '姓名')
                                        this.value = '';" name="" value="姓名" >
            </div>
            <div class="signup_inp_list">
                <div class="signup_inp_list_layer"><span class="glyphicon glyphicon-phone"></span></div>
                <input type="text" name="telephone" onblur="if (this.value == '')
                            this.value = '电话';" onfocus="if (this.value == '电话')
                                        this.value = '';" name="" value="电话">
            </div>
            <div class="signup_infor_list">
                <select name="kind">
                    <option value="飞机大战">飞机大战</option>
                    <option value="节奏大师">节奏大师</option>
                </select>
            </div>
            <div class="signup_inp_btn">
                <div class="signup_inp_btn_l">
                    <a href="###" id="tijiao">确 定</a>
                </div>
                <div class="signup_inp_btn_r">
                    <a href="###" id="restart">重 置</a>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function() {
                var signup = {
                    tijiao_btn: $('#tijiao'),
                    restart_btn: $('#restart'),
                    name_field: $("[name=name]"),
                    telephone_field: $("[name=telephone]"),
                    kind_field: $("[name=kind]"),
                    content_field: $('[name=content]'), //留言内容对象
                    ajax_status: 0, //Ajax请求状态
                    ajax_start: function() {
                        var _this = this;
                        var name = _this.name_field.val();
                        var telephone = _this.telephone_field.val();
                        var kind = _this.kind_field.val();
                        if (_this.check_fields(name, telephone)) {
                            _this.ajax_status = 1;
                            _this.tijiao_btn.html('报名信息上传中，请稍候...');
                            $.ajax({
                                type: "POST", //请求方式
                                url: app_url + "/sign_up/insert",
                                data: {name: name, telephone: telephone, kind: kind}, //数据
                                dataType: 'json', //返回数据类型
                                cache: false, //是否缓存
                                timeout: 20000, //超时时间
                                success: function(data) {
                                    _this.ajax_success_callback(data);
                                },
                                error: function() {
                                    _this.ajax_error();
                                }
                            });
                        }
                    },
                    ajax_success_callback: function(data) {
                        var _this = this;
                        if (data == 1) {
                            $('.signup_inp_box').html('您的报名信息已经成功提交！我们的工作人员会主动与您取得联系！');
                        } else {
                            _this.ajax_error();
                        }
                    },
                    ajax_error: function() {
                        alert("报名信息上传错误，请重新填写报名信息！");
                        location.reload();
                    },
                    check_fields: function(name, telephone) {
                        var _this = this;
                        if (name == '' || name == '姓名') {
                            _this.name_field.val('');
                            alert("请填写您的姓名！");
                            _this.name_field.focus();
                            return false;
                        }
                        if (telephone == '' || telephone == '电话') {
                            _this.telephone_field.val('');
                            alert("请填写您的联系电话！");
                            _this.telephone_field.focus();
                            return false;
                        }
                        return true;
                    },
                };

                signup.tijiao_btn.click(function() {
                    if (signup.ajax_status == 0) {
                        signup.ajax_start();  //开始进行Ajax请求
                    } else {
                        alert('报名信息上传中，请稍候...');
                    }
                });



            });
        </script>
		<script type="text/javascript" src="http://tajs.qq.com/stats?sId=27434495" charset="UTF-8"></script>
    </body>
</html>