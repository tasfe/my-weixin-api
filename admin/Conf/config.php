<?php
$base_config=  require("../Conf/config.php");
$config=array(
    'admin_secret_key'=>'lWsoP7hNlPApcqXGItvHax0OiOC6IqIW'  //后台管理员加密密钥,建议16位以上
);
return array_merge($base_config,$config);
?>