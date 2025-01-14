<?php
namespace App\Tools;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CaptchaImageTool{
    /**
     * 生成验证码并保存到redis以供验证
     *
     * @param [type] $request
     * @return void
     */
    public static function generate_captcha(?string $_token){
        $captcha = create_captcha(4, 'lowercase+uppercase+figure');
        $image_file_path = self::generate_captcha_image(58, 23, $captcha, 5, 10, 5);
        // 存储验证码，供后续验证
        Redis::setex("{$_token}_captcha", 360, $captcha);
        return $image_file_path;
    }

    /**
     * 验证验证码
     *
     * @param string|null $_token
     * @param string $captcha_code
     * @return void
     */
    public static function check_captcha(?string $_token, string $captcha_code){
        $stored_captcha = Redis::get("{$_token}_captcha");
        return hash_equals(strtolower($captcha_code), strtolower($stored_captcha));
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
    public static function generate_captcha_image(int $image_width, int $image_height, string $captcha, int $font_size = 5, int $x = 10, int $y = 5){
        // 创建图像资源
        $image = imagecreate($image_width, $image_height);
        // 设置颜色
        $background_color = imagecolorallocate($image, 255, 255, 255); // 白色背景
        $text_color = imagecolorallocate($image, 0, 0, 0); // 黑色文字
        // 填充背景
        imagefilledrectangle($image, 0, 0, $image_width, $image_height, $background_color);
        // 绘制验证码
        imagestring($image, $font_size, $x, $y, $captcha, $text_color);
        // 发送图像
        header('Content-Type: image/png');
        imagepng($image);
    }
}