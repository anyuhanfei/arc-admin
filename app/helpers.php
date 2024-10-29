<?php

# 自定义返回代码
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
function success(string $msg, null|array|Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model $data = []){
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
function return_data(int $code, string $msg, null|array|Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model $data, string $error = ''){
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
 * 将数组转换为以英文逗号隔开的字符串
 *
 * @param array $array
 * @return string
 */
function array_to_comma_str(array $array):string {
    return implode(',', $array);
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
 * 二维码生成
 *
 * @param string $url 链接
 * @param string $identity 标识(文件名)
 * @return void
 */
function qrcode($url, $identity){
    include_once '../extend/phpqrcode/qrlib.php'; //放在extend中
     //vendor('phpqrcode.phpqrcode'); //放在vender中
     $errorCorrectionLevel = 'H'; //容错级别
     $matrixPointSize = 5; //图片大小慢慢自己调整，只要是int就行
     $path = './qrcode/';
     $QR = $QRB = $path . $identity . ".png";
     QRcode::png($url, $QR, $errorCorrectionLevel, $matrixPointSize, 2);
     if(file_exists($path . $identity . ".png")){
         return config("app.url") . "/qrcode/" . $identity . ".png";
     }else{
         return false;
     }
 }

/**
 * 后台会员展示优化
*
* @param [type] $user_data
* @return void
*/
function admin_show_user_data($user_data, $default = '已注销'){
    try {
        $avatar = $user_data->avatar == '' ? config("app.url") . "/static/avatar.jpeg" : $user_data->avatar;
        $str = '<img data-action="preview-img" src="' . $avatar . '" style="margin-top: 1px;margin-right: 1px;max-height:60px;cursor:pointer;float:left;" class="img img-thumbnail">';
        $str .= 'ID:&nbsp;<span class="label" style="padding:0em 0.3em 0em;background:#586cb1">' . $user_data->id . '</span>';
        $str .= "<br/>";
        $str .= '<span style="padding-top:2px;"><i class="feather icon-user"></i>:&nbsp;' . $user_data->nickname . '&nbsp;';
        $str .= "<br/>";
        $str .= '<span style="padding-top:22px;"><i class="feather icon-smartphone"></i>:&nbsp;' . $user_data->phone . '</span>';
        return $str;
    } catch (\Exception $e) {
        return $default;
    }
}

/**
 * 后台图片上传
 *
 * @param [type] $image_obj
 * @return void
 */
function admin_image_field($image_obj){
    return $image_obj->autoUpload()->uniqueName()->saveFullUrl()->removable(false)->retainable();
}

/**
 * 删除指定目录下指定小时前的文件
 *
 * @param string $directory 目录路径
 * @param int $hours 指定小时
 * @return array [结果, 错误信息]
 */
function delete_files_older_than_hours(string $directory, int $hours):array{
    // 检查目录是否存在
    if(!is_dir($directory)){
        return [false, "指定的目录不存在: $directory"];
    }
    // 获取当前时间
    $currentTime = time();
    // 打开目录
    $dirHandle = opendir($directory);
    if($dirHandle === false){
        return [false, "无法打开目录: $directory"];
    }
    // 遍历目录中的文件
    while(($file = readdir($dirHandle)) !== false){
        // 跳过 . 和 .. 目录
        if($file == '.' || $file == '..' || $file == '.gitignore'){
            continue;
        }
        // 构建文件完整路径
        $filePath = $directory . DIRECTORY_SEPARATOR . $file;
        // 检查是否为文件
        if(is_file($filePath)){
            // 获取文件的创建时间
            $fileCreationTime = filectime($filePath);
            // 计算文件创建时间和当前时间的差值（秒）
            $timeDifference = $currentTime - $fileCreationTime;
            // 判断文件是否超过指定小时
            if($timeDifference > ($hours * 3600)){
                // 删除文件
                unlink($filePath);
            }
        }
    }
    // 关闭目录
    closedir($dirHandle);
    return [true, ''];
}

/**
 * 创建验证码图片并保存到 uploads/captcha 目录下(该目录需要自行创建)
 *
 * @param integer $image_width 验证码图片宽度
 * @param integer $image_height 验证码图片高度
 * @param string $captcha 验证码字符串
 * @param integer $font_size 字体大小
 * @param integer $x X轴偏移量
 * @param integer $y Y轴偏移量
 * @return string 验证码图片路径
 */
function generate_captcha_image(int $image_width, int $image_height, string $captcha, int $font_size = 5, int $x = 10, int $y = 5):string{
    // 创建图像资源
    $image = imagecreate($image_width, $image_height);
    // 设置颜色
    $background_color = imagecolorallocate($image, 255, 255, 255); // 白色背景
    $text_color = imagecolorallocate($image, 0, 0, 0); // 黑色文字
    // 填充背景
    imagefilledrectangle($image, 0, 0, $image_width, $image_height, $background_color);
    // 绘制验证码
    imagestring($image, $font_size, $x, $y, $captcha, $text_color);
    // 保存图像
    imagepng($image, "uploads/captcha/{$captcha}.png");
    // 销毁图像资源
    imagedestroy($image);
    return "/uploads/captcha/{$captcha}.png";
}