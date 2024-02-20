<?php

namespace App\Admin\Metrics\Examples;

use Dcat\Admin\Widgets\Metrics\Line;
use Illuminate\Http\Request;

use App\Repositories\Users\Users;


class 新会员统计 extends Line{

    protected function init(){
        parent::init();

        $this->title('新增会员统计');
        $this->dropdown([
            '7' => '本周',
            '8' => '前一周',
            // '30' => '本月',
            // '31' => '前一月',
        ]);
    }

    public function handle(Request $request){
        $本周数据 = (new Users())->获取本周新增会员数量();
        $前一周数据 = (new Users())->获取前一周新增会员数量();
        // $本月数据 = (new Users())->获取本月新增会员数量();
        // $前一月数据 = (new Users())->获取前一月新增会员数量();
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
            // case '30':
            //     $this->withChart(array_values($本月数据), "本月");
            //     break;
            // case '31':
            //     $this->withChart(array_values($前一月数据), "前一月");
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
}
