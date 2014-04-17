<?php

/**
 * 主体框架
 *
 * @author <zibin_5257@163.com>lanfengye
 */
class MainAction extends CommonAction {
    public function index(){
        $is_index_census=  check_auth(MODULE_NAME.'/index_census');
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
    
    
    public function get_user_data() {
        if (S('main_user_data')) {
            $return_data = S('main_user_data');
        } else {
            for ($i = 29; $i >= 0; $i--) {
                $days[] = date("Y-m-d", strtotime(' -' . $i . 'day'));
            }
            foreach ($days as $key => $value) {
                $user_subscribe_counts[] = subscribe_count($value);
            }
            foreach ($days as $key => $value) {
                $user_unsubscribe_counts[] = subscribe_count($value, 'unsubscrib');
            }

            $return_data = array(
                'labels' => $days,
                'datasets' => array(
                    //新关注用户
                    array(
                        'fillColor' => 'rgba(151,187,205,0.3)',
                        'strokeColor' => 'rgba(151,187,205,1)',
                        'pointColor' => 'rgba(151,187,205,1)',
                        'pointStrokeColor' => "#fff",
                        'data' => $user_subscribe_counts
                    ),
                    //取消关注用户
                    array(
                        'fillColor' => 'rgba(220,220,220,0.3)',
                        'strokeColor' => 'rgba(220,220,220,1)',
                        'pointColor' => 'rgba(220,220,220,1)',
                        'pointStrokeColor' => "#fff",
                        'data' => $user_unsubscribe_counts
                    )
                )
            );
            S('main_user_data',$return_data,900);
        }

        echo json_encode($return_data,JSON_NUMERIC_CHECK);
    }

}

?>
