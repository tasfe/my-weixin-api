function delete_tr(id,action_name) {
    if (confirm('确实要删除该内容吗?')) {
        var data = {'id': id};
        action_name = action_name != undefined ? action_name : 'delete';
        alert(action_name);
        $.ajax({
            type: "POST",
            url: app_url + "/" + module_name + "/"+action_name,
            data: data,
            timeout: 5000,
            dataType: 'json',
            cache: false,
            success: function(data) {
                if (data.data == 1) {
                    $('#pop').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>删除成功！</div>')
                            .fadeIn("slow")
                            .fadeOut(5000);
                    $('#tr_' + id).hide();
                } else {
                    $('#pop').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>删除失败！</div>')
                            .fadeIn("slow")
                            .fadeOut(5000);
                }
            },
            error: function() {
                error();
            },
            beforeSend: function() {
                $('#pop').html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">×</button>数据请求中，请稍候...</div>')
                        .fadeIn("slow");
            }
        });
    }
}

function error() {
    $('#pop').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>删除失败！</div>')
            .fadeIn("slow")
            .fadeOut(5000);
}