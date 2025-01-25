<?php

namespace App\Admin\Metrics\Examples;

use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Donut;

use App\Repositories\Log\LogUsersFund;


class 资金流水统计 extends Donut{
    protected $labels = [];

    protected function init(){
        parent::init();

        $this->contentWidth(9, 3);
        $color = Admin::color();
        $this->colors = [
            $color->alpha('blue2', 0.8),$color->alpha('blue2', 0.4),
            $color->alpha('red', 0.8), $color->alpha('red', 0.4),
            $color->alpha('green', 0.8), $color->alpha('green', 0.4),
            $color->alpha('yellow', 0.8), $color->alpha('yellow', 0.4),
            $color->alpha('purple', 0.8), $color->alpha('purple', 0.4),
            $color->alpha('orange', 0.8), $color->alpha('orange', 0.4),
            $color->alpha('cyan', 0.8), $color->alpha('cyan', 0.4),
            $color->alpha('indigo', 0.8), $color->alpha('indigo', 0.4),
            $color->alpha('teal', 0.8), $color->alpha('teal', 0.4),
            $color->alpha('pink', 0.8), $color->alpha('pink', 0.4),
            $color->alpha('lime', 0.8), $color->alpha('lime', 0.4),
            $color->alpha('gray', 0.8), $color->alpha('gray', 0.4),
            $color->alpha('brown', 0.8), $color->alpha('brown', 0.4),
        ];

        $this->title('资金流水统计');
        $this->labels = LogUsersFund::fund_type_array();
        $this->chartLabels($this->labels);
        // 设置图表颜色
        $this->chartColors($this->colors);
        // $this->dropdown([
        //     '7' => '本周',
        //     '8' => '前一周',
        //     '30' => '本月',
        //     '31' => '前一月',
        //     'all'=> "全部",
        // ]);
    }

    public function render(){
        $this->fill();

        return parent::render();
    }

    public function fill(){
        $datas = [];
        foreach($this->labels as $label){
            $datas[] = (new LogUsersFund())->count_fund_type_sum($label);
        }
        $this->withContent($datas);

        // 图表数据
        $this->withChart(array_map(function($value){return abs($value);}, $datas));
    }

    public function withChart(array $data){
        return $this->chart([
            'series' => $data
        ]);
    }

    protected function withContent($datas){
        

        $style = 'float: left;';
        $labelWidth = 150;

        $html = "";
        foreach($this->labels as $key=> $label){
            $html .= <<<HTML
                <div class="d-flex pl-1 pr-1" style="{$style}">
                    <div style="width: {$labelWidth}px">
                        <i class="fa fa-circle" style="color: {$this->colors[$key]}"></i> {$label}
                    </div>
                    <div>{$datas[$key]}</div>
                </div>
            HTML;
        }

        return $this->content($html);
    }
}