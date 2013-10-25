<?php

/**
 * 
 * @Created on : 2013-8-1, 11:50:48
 * @author <zibin_5257@163.com>lanfengye
 */
class TAction extends CommonAction {

    /**
     * 抽奖返回大转盘弧度
     */
    public function index() {
//        $id = intval($_GET['id']);
        $id = mt_rand(1, 5);
        $angle = 24; //返回弧度
        $prize = 100;  //中奖奖项 100为谢谢惠顾
        switch ($id) {
            case 1: //判断奖项
                $data = array(1, 2);
                $rand_keys = array_rand($data, 1);
                $prize = 11;
                if ($data[$rand_keys] == 1) { //判断正弧度
                    $angle = mt_rand(0, 20);
                } else {
                    $angle = mt_rand(342, 360);
                }
                break;
            case 2:
                $prize = 12;
                $angle = mt_rand(70, 110);
                break;
            case 3:
                $prize = 13;
                $angle = mt_rand(160, 200);
                break;
            case 4:
                $prize = 14;
                $angle = mt_rand(250, 290);
                break;
            case 5:
                $rand_num = mt_rand(1, 4);
                $prize = 100;
                switch ($rand_num) {
                    case 1:
                        $angle = mt_rand(25, 65);
                        break;
                    case 2:
                        $angle = mt_rand(115, 155);
                        break;
                    case 3:
                        $angle = mt_rand(205, 245);
                        break;
                    case 4:
                        $angle = mt_rand(300, 335);
                        break;
                }
                break;
        }
        $this->ajaxReturn(array('data' => $angle, 'prize' => $prize));
    }

    public function menu() {
        $data = array(
            'button' => array(
                0 => array(
                    "type" => "click",
                    "name" => "今日歌曲",
                    "key" => "V1001_TODAY_MUSIC"
                ),
                1 => array(
                    "type" => "click",
                    "name" => "歌手简介",
                    "key" => "V1001_TODAY_MUSIC"
                ),
                2 => array(
                    'name' => '企业简介',
                    'sub_button' => array(
                        0 => array(
                            "type" => "click",
                            "name" => "企业简介",
                            "key" => "V1001_TODAY_MUSIC"
                        ),
                        1 => array(
                            "type" => "click",
                            "name" => "联系方式",
                            "key" => "V1001_TODAY_MUSIC"
                        ),
                    )
                )
            )
        );
        $json_data = json_encode($data);
        list($return_code, $return_content) = $this->http_post_data('https://api.weixin.qq.com/cgi-bin/menu/create?access_token=ACCESS_TOKEN', $json_data);
//        dump($return_content);
        $return_json_data=  json_decode($return_content, true);
        dump($return_json_data);
        /**
         * 返回信息
         * $return_code==200
         * 
         * $return_json_data['errcode']==0 菜单提交成功
         * if $return_json_data['errcode']>0 菜单提交失败 返回$return_json_data['errmsg']字符串用于显示错误
         * {"errcode":0,"errmsg":"ok"}
         * 
         */
    }

    /**
     * 
     * @param String $url 链接地址
     * @param String $data_string 需要提交到远程的JSON字符串
     * @return array list($return_code, $return_content) 返回码，返回内容
     */
    public function http_post_data($url, $data_string, $timeout = 10) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($data_string))
        );
        ob_start();
        curl_exec($ch);
        $return_content = ob_get_contents();
        ob_end_clean();

        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return array($return_code, $return_content);
    }
    
    
    public function get_menu(){
        $data='{"menu":{"button":[{"type":"click","name":"今日歌曲","key":"V1001_TODAY_MUSIC","sub_button":[]},{"type":"click","name":"歌手简介","key":"V1001_TODAY_SINGER","sub_button":[]},{"name":"菜单","sub_button":[{"type":"click","name":"hello word","key":"V1001_HELLO_WORLD","sub_button":[]},{"type":"click","name":"赞一下我们","key":"V1001_GOOD","sub_button":[]}]}]}}';
        dump(json_decode($data,true));
    }

}

?>
