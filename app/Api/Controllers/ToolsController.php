<?php
namespace App\Api\Controllers;

use Illuminate\Http\Request;

use App\Api\Controllers\BaseController;

use App\Api\Services\SmsService;
use App\Api\Services\FileUploadService;

/**
 * 工具方法类
 */
class ToolsController extends BaseController{

    /**
     * 发送短信验证码
     *
     * @param int $phone
     * @return void
     */
    public function send_sms_code(Request $request){
        $phone = $request->input('phone', '') ?? '';
        (new SmsService())->send_sms_code_operation($phone, $this->user_id);
        return success('发送成功');
    }

    /**
     * 上传文件
     *
     * @param resource $file 文件资源句柄
     * @return void
     */
    public function upload(Request $request){
        if($request->hasFile('file')){
            $file = $request->file('file');
            $data = (new FileUploadService())->upload_file_operation($file);
            return success("上传成功", $data);
        }
       return error('上传文件不存在');
    }
}
