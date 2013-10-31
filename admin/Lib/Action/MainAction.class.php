<?php

/**
 * 主体框架
 *
 * @author <zibin_5257@163.com>lanfengye
 */
class MainAction extends CommonAction {
    public function index(){
        import('ORG.Util.Auth'); //加载类库
        $auth = new Auth();
        $is_index_census=$auth->check('index_census', session('user_id'));
        $this->is_index_census=$is_index_census;
        if ($is_index_census) {
            $this->subscribe_count();
        }
        $this->display();
    }
    
    /**
     * 当日新关注人数和卸载人数统计
     */
    private function subscribe_count(){
        $this->subscribe_count=  subscribe_count();
        $this->unsubscribe_count=  subscribe_count(get_date(),'unsubscrib');
        $this->yesterday_subscribe_count=  subscribe_count(get_date(time()-86400));
        $this->yesterday_unsubscribe_count=  subscribe_count(get_date(time()-86400),'unsubscrib');
    }
}

?>
