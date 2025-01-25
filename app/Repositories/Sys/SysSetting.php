<?php

namespace App\Repositories\Sys;

use App\Models\Sys\SysSetting as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * 系统配置表数据仓库
 */
class SysSetting extends EloquentRepository{
    protected $eloquentClass = Model::class;

    /**
     * 此方法定义了项目中系统配置的结构与键数据
     * 格式可参考测试设置，其中，type、title 必填。type目前支持：text、number、onoff、select、radio、image、textarea、edit
     *
     * @return void
     */
    public function set_list():array{
        return [
            '测试设置'=> [
                'test_text'=> ['type'=> 'text', 'title'=> "测试文本"],
                'test_number'=> ['type'=> 'number', 'title'=> "测试数字", 'help'=> "只能填写数字"],
                'test_onoff'=> ['type'=> 'onoff', 'title'=> '测试开关'],
                'test_select'=> ['type'=> 'select', 'title'=> "测试选项", 'options'=> [
                    '选项1', '选项2', '选项3'
                ]],
                'test_radio'=> ['type'=> 'radio', 'title'=> "测试单选项", 'options'=> [
                    '选项1', '选项2', '选项3'
                ]],
                'test_image'=> ['type'=> "image", "title"=> "测试图片"],
                'test_textarea'=> ['type'=> "textarea", "title"=> "测试长文本"],
                'test_eidt'=> ['type'=> "edit", "title"=> "测试富文本"],
            ],
            '应用设置'=> [
                'withdraw_minimum_amount'=> ['type'=> 'number', 'title'=> "最低提现金额"],
            ],
        ];
    }

    /**
     * 创建数据
     *
     * @param string $key
     * @return EloquentModel
     */
    public function create_data(string $key):EloquentModel{
        return $this->eloquentClass::create([
            'key'=> $key,
            'value'=> '',
        ]);
    }

    /**
     * 获取指定key的数据
     *
     * @param string $key
     * @return EloquentModel|null
     */
    public function get_data_by_key(string $key):EloquentModel|null{
        return $this->eloquentClass::key($key)->first();
    }

    /**
     * 获取指定key的value的值
     *
     * @param string $key
     * @return string
     */
    public function get_value_by_key(string $key):string{
        return $this->eloquentClass::key($key)->value("value") ?? '';
    }

    /**
     * 修改指定key的value值
     *
     * @param string $key
     * @param string|integer|float $value
     * @return int
     */
    public function update_value_by_key(string $key, string|int|float $value):int{
        return $this->eloquentClass::key($key)->update([
            'value'=> $value,
        ]);
    }
}
