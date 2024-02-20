<?php
namespace App\Api\Requests;


/**
 * 分页验证类
 */
class PageRequest extends BaseRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'page' => ['required', 'min:1'],
            'limit' => ['required', 'min:1', 'max:100'],
        ];
    }

    public function messages(){
        return [
            'page.required'=> '请指定页码',
            'page.min'=> '页码必须大于等于1',
            'limit.required'=> '请指定每页数据数量',
            'limit.min'=> '每页数据数量必须大于等于1',
            'limit.max'=> '每页数据数量必须小于100',
        ];
    }
}