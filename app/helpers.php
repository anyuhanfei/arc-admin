<?php

# 自定义返回代码

use Illuminate\Pagination\LengthAwarePaginator;
use Dcat\Admin\Widgets\Metrics\Card;

const SUCCESS_CODE = 200;
const ERROR_CODE = 500;

# 自定义特殊报错码
const NO_LOGIN = "no_login";
const NO_BIND_WX = "no_bind_wx";
const NO_BIND_ALIPAY = "no_bind_alipay";
const NO_BIND_PHONE = "no_bind_phone";

/**
 * 返回异常回调信息
 *
 * @param string $msg 返回信息
 * @param string $error 特殊错误码
 * @return void
 */
function error(string $msg, string $error = ''){
    return return_data(ERROR_CODE, $msg, [], $error);
}

/**
 * 返回成功回调信息
 *
 * @param string $msg 返回信息
 * @param array $data 返回数据
 * @return void
 */
function success(string $msg, null|array|Illuminate\Support\Collection|Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|LengthAwarePaginator $data = []){
    return return_data(SUCCESS_CODE, $msg, $data);
}

/**
 * 手动抛出异常，用于中断程序
 *
 * @param string $msg 返回信息
 * @return void
 */
function throwBusinessException(string $msg, string $error = ''){
    throw new \App\Exceptions\BusinessException($msg . "[" . $error . "]");
}

/**
 * 接口返回json格式的数据
 *
 * @param integer $code 项目自定义错误码
 * @param string $msg 返回信息
 * @param array $data 返回数据
 * @param string $error 特殊错误码
 * @return void
 */
function return_data(int $code, string $msg, null|array|Illuminate\Support\Collection|Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|LengthAwarePaginator $data, string $error = ''){
    return response()->json(['code'=> $code, 'msg'=> $msg, 'data'=> $data, 'error'=> $error], 200); # 此 200 为真正的 http 状态码
}

/**
 * 生成随机码
 *
 * @param int $number 随机码位数
 * @param string $type 随机码内容类型
 * @return string
 */
function create_captcha(int $number, string $type = 'figure'):string{
    $array_figure = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0];
    $array_lowercase = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
    $array_uppercase = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
    switch($type){
        case 'lowercase':
            $res_array = $array_lowercase;
            break;
        case 'uppercase':
            $res_array = $array_uppercase;
            break;
        case 'lowercase+figure':
            $res_array = array_merge($array_lowercase, $array_figure);
            break;
        case 'uppercase+figure':
            $res_array = array_merge($array_uppercase, $array_figure);
            break;
        case 'lowercase+uppercase':
            $res_array = array_merge($array_lowercase, $array_uppercase);
            break;
        case 'lowercase+uppercase+figure':
            $res_array = array_merge(array_merge($array_lowercase, $array_uppercase), $array_figure);
            break;
        default:
            $res_array = $array_figure;
            break;
    }
    $resstr = '';
    shuffle($res_array);
    foreach(array_rand($res_array, $number) as $v){
        $resstr .= $res_array[$v];
    }
    return $resstr;
}

/**
 * 将包含英文逗号的字符串(以英文逗号隔开的字符串参数)转换成数组
 *
 * @param string $str 以英文逗号隔开的字符串
 * @return Array
 */
function comma_str_to_array(string $str):Array {
    return array_filter(explode(',', $str));
}


/**
 * 从一个数据列表中获取指定字段
 *
 * @param \Illuminate\Database\Eloquent\Collection $data_list
 * @param string $field
 * @return void
 */
function get_collection_field(\Illuminate\Database\Eloquent\Collection $data_list, string $field){
    $data = [];
    foreach($data_list as $value){
        $data[] = $value->$field;
    }
    return $data;
}

/**
 * 后台会员展示优化
 *  使用方式：在 grid() 方法中的字段列表对象中使用 display() 方法，然后使用此方法
*
* @param [type] $user_data
* @return void
*/
function admin_grid_user_field($user_data, $default = '已注销'){
    try {
        $avatar = $user_data->avatar == '' ? config("app.url") . "/static/avatar.jpeg" : full_url($user_data->avatar);
        $str = '<div style="width:200px">';
        $str .= '<img data-action="preview-img" src="' . $avatar . '" style="margin-top: 1px;margin-right: 1px;width:60px;height:60px;cursor:pointer;float:left;" class="img img-thumbnail">';
        $str .= 'ID:&nbsp;<span class="label" style="padding:0em 0.3em 0em;background:#586cb1">' . $user_data->id . '</span>';
        $str .= "<br/>";
        $str .= '<span style="padding-top:2px;"><i class="feather icon-user"></i>:&nbsp;' . $user_data->nickname . '&nbsp;';
        $str .= "<br/>";
        $str .= '<span style="padding-top:22px;"><i class="feather icon-smartphone"></i>:&nbsp;' . $user_data->phone . '</span>';
        $str .= '</div>';
        return $str;
    } catch (\Exception $e) {
        return $default;
    }
}

/**
 * 后台富文本展示
 *  使用方法，将 grid() 中的富文本字段列表对象传入此方法
 *
 * @param [type] $content_obj
 * @return void
 */
function admin_grid_content($content_obj){
    return $content_obj->width('15%')->display('')->modal(function ($modal) {
        $modal->title($this->title);
        $this->content == null ? $modal->icon('feather ') : $modal->icon('feather icon-eye');
        $card = (new Card(null, ''))->header($this->content);
        return "<div style='padding:10px 10px 0'>$card</div>";
    });
}

/**
 * 后台图片表单上传处理
 *  使用方法，将 form() 中的图片表单对象传入此方法
 *
 * @param [type] $image_obj
 * @return void
 */
function admin_form_image_field($image_obj){
    return $image_obj->autoUpload()->uniqueName()->removable(false)->retainable();
}

/**
 * 后台媒体选择表单上传处理
 *  使用方法，将 form() 中的媒体选择表单对象传入此方法
 *
 * @param [type] $media_selector_obj
 * @param int $limit
 * @param array $types image-图片选择,video-视频选择,audio-音频选择,powerpoint-文稿选择,code-代码文件选择,zip-压缩包选择,text-文本选择,other-其他选择
 * @return void
 */
function admin_form_media_selector_field($media_selector_obj, int $limit = 1, array $types = ['image']){
    return $media_selector_obj->options([
        'area'     => ['60%', '98%'], // 弹框大小
        'limit'    => $limit, // 媒体数量
        'types'    => $types, // 媒体选择类型
        'sortable' => true, // 排序
        'move'     => json_encode(['dir' => 'media', 'fileNameIsEncrypt' => true]),// 第一个参数，媒体上传路径。默认media。第二个参数，媒体名称是否加密。默认true
    ]);
}

/**
 * 后台数字表单输入限制
 *  使用方法，将 form() 中的数字表单对象传入此方法
 *
 * @param [type] $number_obj
 * @param string $step
 * @return void
 */
function admin_form_number_field($number_obj, $step = '0.01'){
    return $number_obj->attribute('type', 'number')->attribute('step', $step);
}

/**
 * 整合分页的统计数据
 *
 * @param LengthAwarePaginator $datas
 * @return void
 */
function format_paginated_datas(LengthAwarePaginator $datas, array $visible = ['*'], ?callable $func = null){
    $data = null;
    if($func){
        $data = $datas->map(function($item) use ($func){
            return $func($item);
        });
    }
    if(count($visible) > 0 && $visible[0] != '*'){
        $data = $datas->setVisible($visible);
    }
    return [
        'total'=> $datas->total(),  // 总条数
        'count'=> $datas->count(),  // 当页总数
        'perPage'=> $datas->perPage(),  // 每页应展示数量
        'currentPage'=> $datas->currentPage(),  // 当前页码
        'lastPage'=> $datas->lastPage(),  // 最后一页页码
        'firstItem'=> $datas->firstItem(),  // 当页第一条数据的编号(id)
        'lastItem'=> $datas->lastItem(),  // 当页最后一条数据的编号(id)
        'datas'=> $data ?? $datas->setVisible($visible),
    ];
}

/**
* 获取文件的完整路径
*  一般情况下，查询出来的图片、文件数据直接通过模型中的访问器修改为了完整路径。
*  但可能有一些特殊情况不是由模型获取到的数据，需要手动拼接完整路径。
*
* @param string $file_path 文件路径
* @param string $catelogue 文件目录
* @return void
*/
function full_url($file_path, $catelogue = '/uploads/'){
    if($file_path == '' || $file_path == null){
        return '';
    }
    if(strpos($file_path, 'http') !== false){
        return $file_path;
    }
    if(strpos($file_path, 'https') !== false){
        return $file_path;
    }
    if(strpos($file_path, 'data:') !== false){
        return $file_path;
    }
    return url($catelogue . $file_path);
}
