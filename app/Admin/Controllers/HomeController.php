<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples;
use App\Http\Controllers\Controller;
use Dcat\Admin\Http\Controllers\Dashboard;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('仪表盘')
            ->description('数据最多延时60秒更新')
            ->body(function (Row $row) {
                $row->column(12, function (Column $column) {
                    $column->row(function (Row $row) {
                        $row->column(6, new Examples\新用户统计());
                        $row->column(2, new Examples\总用户数统计());
                        $row->column(2, new Examples\冻结用户数统计());
                    });
                    $column->row(function(Row $row){
                        $row->column(6, new Examples\资金流水统计());
                    });
                });

            });
    }
}
