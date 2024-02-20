<?php
namespace App\Tools\Qiniu;

use Qiniu\Auth;
use Qiniu\Config;
use Qiniu\Storage\ArgusManager;
use Qiniu\Storage\UploadManager;

/**
 * 七牛云文件上传
 * composer require qiniu/php-sdk 本文件使用
 * composer require overtrue/laravel-filesystem-qiniu laravel后台使用
 */
class QiniuFileUploadTool{
    protected $accessKey;
    protected $secretKey;
    protected $doman;
    protected $bucket;

    public function __construct(){
        $this->accessKey = config('filesystems.disks.qiniu.access_key');
        $this->secretKey = config('filesystems.disks.qiniu.secret_key');
        $this->doman = config('filesystems.disks.qiniu.domain');
        $this->bucket = config("filesystems.disks.qiniu.bucket");
    }

    /**
     * 上传图片
     *
     * @param resource $file 文件资源对象
     * @return void
     */
    public function upload_file($file, string $file_name){
        $uploadMgr = new UploadManager();
        $auth = new Auth($this->accessKey, $this->secretKey);
        $token = $auth->uploadToken($this->bucket);
        list($ret, $error) = $uploadMgr->putFile($token, $file_name, $file->getRealPath());
        if($error != null){
            throwBusinessException("上传失败, 原因为:". $error);
        }
        return $this->doman . $ret['key'];
    }

    public function qiniu_图片鉴黄审核(string $image_url){
        $auth = new Auth($this->accessKey, $this->secretKey);
        $config = new Config();
        $argusManager = new ArgusManager($auth, $config);
        $body = '{
            "data":{
                "uri":"' . $image_url . '"
            },
            "params":{
                "scenes":[
                    "pulp"
                ]
            }
        }';
        list($ret, $err) = $argusManager->censorImage($body);
        if($err != null){
            throwBusinessException($err);
        }
        if($ret['code'] != 200){
            throwBusinessException($ret['message']);
        }
        if($ret['result']['suggestion'] != 'pass'){
            throwBusinessException('上传的图片未通过审核');
        }
        return true;
    }
}