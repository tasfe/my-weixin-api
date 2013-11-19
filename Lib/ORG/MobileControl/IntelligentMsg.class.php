<?php

/**
 * 智能回复消息扩展类
 * @Created on:2013-11-19 11:17:13
 * @author 蓝枫叶{zibin_5257@163.com}
 * @uses class TextMsg::return_text() 微信文本回复扩展类::回复纯文本
 * @uses class Hailiang 海量分词扩展类
 */
class IntelligentMsg {

    private $content = ''; //用户回复的语句
    private $no_keys_return = '该话题没有找到，咱们换个话题吧！';   //智能回复库中不存在的提示语句
    private $get_keys_num = 1000;  //最大获取的数据记录数量 最大统计关键词密度记录数量
    private $msg_info = array(); //微信信息

    function __construct($msg_info) {
        $this->msg_info = $msg_info;
        $this->content = trim($this->msg_info->Content);
        $this->no_keys_return = MC('no_keys_return');
    }

    /**
     * 调用方法,分词->获取数据并调整词频顺序
     * @return array 返回的回复数组
     */
    public function get_intelligent_msg() {
        //判断是否进行分词并分词
        $keyword = $this->utf8_strlen($this->content) > 2 ? $this->get_keys($this->content) : $this->content;
        $data = $this->get_data($keyword);  //根据词语模糊查询数据库获取数据
        //统计词频并调整排序
        $return_array = $this->get_keys_count($data, $keyword);
        //判断返回数组是否为空
        if (empty($return_array) && !empty($this->no_keys_return)) {
            import("@.ORG.TextMsg");
            $TextMsg = new TextMsg($this->msg_info);
            $TextMsg->return_text($this->no_keys_return);
        }
        return $return_array;
    }

    /**
     * 获取关键词数组的词频
     * 如果需要查找的关键词是一个数组，则对数据数组增加str_num列，str_num列记录关键词得分
     */
    private function get_keys_count($data, $keywords) {
        if (is_array($keywords)) {
            foreach ($data as $key => $value) {
                $str_num = 0;  //关键词得分
                foreach ($keywords as $key_key => $key_value) {
                    if (strpos($value['keywords'], $key_value) !== false or strpos($value['title'], $key_value) !== false) {
                        $str_num++;  //如果关键词中存在该关键词，则得分+1
                    }
                }
                $data[$key]['str_num'] = $str_num;
            }
            $data = $this->keys_num_order($data);
        }
        return $data;
    }

    /**
     * 针对数据数组按照关键词得分进行排序
     * @return array 针对关键词得分，输出类型，排序顺序，id进行依次排序后的数组
     * */
    private function keys_num_order($data) {
        foreach ($data as $key => $value) {
            $str_num[$key] = $value['str_num']; //1 按照关键词得分进行排序
            $type[$key] = $value['msg_type'];  //2 按照输出类型进行排序
            $sort[$key] = $value['sort'];  //3 按照排序顺序进行排序
            $id[$key] = $value['id'];  //4 最后按照id进行排序
        }
//对数组进行排序
//按照如下顺序依次排序
//1-关键词得分 数值递减,2-输出类型 数值递增,3-排序顺序 数值递增,4-ID 数值递减
        array_multisort($str_num, SORT_DESC, SORT_NUMERIC, $type, SORT_ASC, SORT_NUMERIC, $sort, SORT_ASC, SORT_NUMERIC, $id, SORT_DESC, SORT_NUMERIC, $data);
        $str_num = null;
        $type = null;
        $sort = null;
        $id = null;
        unset($str_num);
        unset($type);
        unset($sort);
        unset($id);
        return $data;
    }

    /**
     * 根据关键词进行获取信息
     * @param array $keys_array 关键词数组
     */
    private function get_data($keys_array) {
        $M = M('ReplyDatabase');
        $where = '(';
        if (is_array($keys_array)) {
            foreach ($keys_array as $key => $value) {
                if ($key > 0)
                    $where.='or ';
                $where.="keywords like '%{$value}%' or title like '%{$value}%' ";
            }
        }else {
            $where.="keywords like '%{$keys_array}%' or title like '%{$keys_array}%' ";
        }
        $where.=") and status=1 ";
        $list = $M->where("{$where}")->order('msg_type,sort,id desc')->limit($this->get_keys_num)->select();
        return $list;
    }

    /**
     * 对用户输入的信息进行分词
     * @param String $keywords 用户输入的信息
     * @return array 分词数组
     */
    private function get_keys($keywords) {
        define('appkey', '5839506671989993634'); //海量分词密钥
        define('secret', 'd142f86976af111c6b858cc75b2023a9b13341fc'); //海量分词私钥
        define('api_url', 'http://freeapi.hylanda.com/rest/se/segment/realtime');  //海量分词接口地址
        $return_array = array();

        import('@.ORG.Hailiang');
        $api = new Hailiang(secret);
        $params['appkey'] = appkey;
        $params['v'] = '1.0';
        $params['time'] = time(); //1305690837;//time();
        $params['xmlparam'] = $api->get_xml_data($keywords);


        $ret = $api->execute(api_url, $params);
        if ($ret === false)
            exit;
        else {
            $postObj = simplexml_load_string($ret, 'SimpleXMLElement', LIBXML_NOCDATA);
            if ($postObj->ret != 0) {
                exit;
            }
            $templist = (array) $postObj->Result->Resource->AnalyzeResult->Annotations;
            foreach ($templist['Item'] as $key => $value) {
//                if ($this->utf8_strlen($value['Text']) >= $this->key_count) {
                $tempStr = (array) $value['Text'];
                $return_array[] = $tempStr[0];
//                }
            }
            return $return_array;
        }
    }

    /**
     * 计算中文字串的长度
     * @param String $string 需要计算长度的文字
     * @return integer 长度
     */
    private function utf8_strlen($string = null) {
        // 将字符串分解为单元
        preg_match_all("/./us", $string, $match);
        // 返回单元个数
        return count($match[0]);
    }

}
