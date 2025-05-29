<?php

namespace App\Admin\Metrics\Examples;

use Dcat\Admin\Widgets\Metrics\Line;
use Illuminate\Http\Request;

use App\Models\Users\Users;
use Illuminate\Support\Facades\Cache;

class 新会员统计 extends Line{

    protected function init(){
        parent::init();

        $this->title('新增会员统计');
        $this->dropdown([
            '7' => '本周',
            '8' => '前一周',
            '30' => '本月',
            '31' => '前一月',
        ]);
    }

    public function handle(Request $request){
        $本周数据 = $this->获取本周新增会员数量();
        $前一周数据 = $this->获取前一周新增会员数量();
        $本月数据 = $this->获取本月新增会员数量();
        $前一月数据 = $this->获取前一月新增会员数量();
        $今日 = date('l, Y-m-d', time());

        $this->withContent($本周数据[$今日]);
        switch($request->get('option')){
            case '7':
            default:
                $this->withChart(array_values($本周数据), "本周");
                break;
            case '8':
                $this->withChart(array_values($前一周数据), "前一周");
                break;
            case '30':
                $this->withChart(array_values($本月数据), "本月");
                break;
            case '31':
                $this->withChart(array_values($前一月数据), "前一月");
                break;
        }
    }

    /**
     * 设置图表数据.
     *
     * @param array $data
     *
     * @return $this
     */
    public function withChart(array $data, string $title){
        return $this->chart([
            'series' => [
                [
                    'name' => $title,
                    'data' => $data,
                ],
            ],
        ]);
    }

    /**
     * 设置卡片内容.
     *
     * @param string $content
     *
     * @return $this
     */
    public function withContent($content)
    {
        return $this->content(
            <<<HTML
<div class="d-flex justify-content-between align-items-center mt-1" style="margin-bottom: 2px">
    <h2 class="ml-1 font-lg-1">{$content}</h2>
    <span class="mb-0 mr-1 text-80">{$this->title}</span>
</div>
HTML
        );
    }

    public function withCategories(array $data){
        return $this->option('xaxis.categories', $data);
    }


    public function 获取本周新增会员数量(){
        $date = date('Y-m-d', strtotime('this week')); // 获取本周的第一天
        $today = date("Y-m-d", time()); // 今日
        $end_date = date('Y-m-d', strtotime('next week')); // 获取本周的最后一天

        $members = array(); // 用于存储每天的新增会员数量
        while ($date < $end_date) {
            if($date == $today){  // 是今天的数据，缓存时间设置为60s (正在进行中，数据更新频繁)
                $ttl = 60;
            }elseif($date < $today){  // 是过去的数据，缓存时间设置为14天（过去的时间，不会更新数据）
                $ttl = 86400 * 14;
            }else{
                $ttl = strtotime(date("Y-m-d", time() + 86400)) -  time(); // 到第二天0点过期
            }
            // 获取当天数据并存储到结果中
            $members[date('l, Y-m-d', strtotime($date))] = Cache::remember("count_day_users_number:{$date}", $ttl, function() use($date){
                return Users::whereDate("created_at", $date)->count();
            });
            // 下一天
            $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
        }
        return $members;
    }

    public function 获取前一周新增会员数量(){
        $date = date('Y-m-d', strtotime('last week')); // 获取前一周的第一天
        $end_date = date('Y-m-d', strtotime('this week')); // 获取本周的最后一天

        $ttl = 7 * 86400;  // 因为是过去的时间，所以不会改变了，直接缓存最大天数
        $members = array(); // 用于存储每天的新增会员数量
        while ($date < $end_date) {
            // 获取当天数据并存储到结果中
            $members[date('l, Y-m-d', strtotime($date))] = Cache::remember("count_day_users_number:{$date}", $ttl, function() use($date){
                return Users::whereDate("created_at", $date)->count();
            });
            // 下一天
            $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
        }
        return $members;
    }

    public function 获取本月新增会员数量(){
        $firstDay = strtotime(date('Y-m')); // 获取本月的第一天
        $today = date("Y-m-d", time()); // 今日
        $lastDay = strtotime(date('Y-m-01')) + (60*60*24*(date('t')-1)); // 获取本月的最后一天

        $members = array(); // 用于存储每天的新增会员数量
        $ttl = strtotime(date("Y-m-d", time() + 86400)) -  time(); // 到第二天0点过期
        for($i = $firstDay; $i <= $lastDay; $i = strtotime('+1 day', $i)){
            $date = date("Y-m-d", $i);
            if($date == $today){  // 是今天的数据，缓存时间设置为60s (正在进行中，数据更新频繁)
                $ttl = 60;
            }elseif($date < $today){  // 是过去的数据，缓存时间设置为60天（过去的时间，不会更新数据）
                $ttl = 86400 * 60;
            }else{
                $ttl = strtotime(date("Y-m-d", time() + 86400)) -  time(); // 到第二天0点过期
            }
            $members[date('l, Y-m-d', $i)] = Cache::remember("count_month_users_number:{$date}", $ttl, function() use($date){
                return Users::whereDate("created_at", $date)->count();
            });
        }
        return $members;
    }

    public function 获取前一月新增会员数量(){
        $date = date("Y-m-d", strtotime("last month"));
        $end_date = date("Y-m-t", strtotime("last month"));

        $members = array(); // 用于存储每天的新增会员数量
        $ttl = 30 * 86400;  // 因为是过去的时间，所以不会改变了，直接缓存最大天数
        while ($date <= $end_date) {
            // 获取当天数据并存储到结果中
            $members[date('l, Y-m-d', strtotime($date))] = Cache::remember("count_month_users_number:{$date}", $ttl, function() use($date){
                return Users::whereDate("created_at", $date)->count();
            });
            // 下一天
            $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
        }
        return $members;
    }
}
