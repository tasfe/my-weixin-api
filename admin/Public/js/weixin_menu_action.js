$(function() {
    var delete_weixin_menu_btn = $('#delete_weixin_menu');  //删除微信自定义菜单按钮
    var put_weixin_server_btn = $('#put_weixin_server'); //将自定义菜单上传到微信服务器按钮

    //将自定义菜单上传到微信服务器按钮事件
    put_weixin_server_btn.click(function() {
        put_weixin_server_btn.attr("disabled", "disabled");
        put_weixin_server_btn.html('上传中，请等待..');
        $.ajax({
            type: "GET", //请求方式
            url: app_url + '/' + module_name + '/put_weixin_menu',
            dataType: 'json', //返回数据类型
            cache: false, //是否缓存
            timeout: 10000, //超时时间
            success: function(data) {
                put_weixin_server_success_callback(data);
                put_weixin_server_btn.removeAttr("disabled");
                put_weixin_server_btn.html('上传到微信服务器');
            },
            error: function() {
                error_callback();
            }
        });
    });

    //删除自定义菜单按钮事件
    delete_weixin_menu_btn.click(function() {
        delete_weixin_menu_btn.attr("disabled", "disabled");
        delete_weixin_menu_btn.html('删除中，请等待..');
        $.ajax({
            type: "GET", //请求方式
            url: app_url + '/' + module_name + '/delete_weixin_menu',
            dataType: 'json', //返回数据类型
            cache: false, //是否缓存
            timeout: 10000, //超时时间
            success: function(data) {
                delete_weixin_menu_success_callback(data);
                delete_weixin_menu_btn.removeAttr("disabled");
                delete_weixin_menu_btn.html('删除微信服务器菜单');
            },
            error: function() {
                error_callback();
            }
        });
    });

    //请求错误返回事件
    function error_callback() {
        alert("远程服务器请求错误，请刷新页面或者稍后重试！");
    }

    //删除微信自定义菜单成功返回事件
    function delete_weixin_menu_success_callback(data) {
        if (data.errcode > 0) {
            alert(data.errcode + '：' + data.errmsg);
        } else if (data.errcode < 0) {
            alert('系统繁忙，请稍候重试！');
        } else {
            alert('微信自定义菜单删除成功！因为腾讯微信服务器缓存，最长24小时生效！');
        }
    }

    //自定义菜单上传到微信服务器成功返回事件
    function put_weixin_server_success_callback(data) {
        if (data.errcode > 0) {
            alert(data.errcode + '：' + data.errmsg);
        } else if (data.errcode < 0) {
            alert('系统繁忙，请稍候重试！');
        } else {
            alert('微信自定义菜单上传成功！因为腾讯微信服务器缓存，最长24小时生效！如需查看效果请取消关注后重新关注即可立即生效！');
        }
    }
});