<?php
namespace App\Api\Services;

use App\Tools\Qiniu\QiniuFileUploadTool;

class FileUploadService{
    protected $allowed_ext;
    protected $directory;
    protected $disk;

    public function __construct(){
        $this->allowed_ext = ["png", "jpg", "gif", 'jpeg', 'mp4', 'mp3'];
        $this->directory = 'uploads/images/' . date('Y-m', time()) . '/';
        $this->disk = config('filesystems.default');
    }

    /**
     * 上传操作
     *
     * @param [type] $file
     * @return void
     */
    public function upload_file_operation($file):array{
        $file_data = $this->rename($file);
        switch($this->disk){
            case "qiniu":
                $file_data['full_path_file_name'] = (new QiniuFileUploadTool())->upload_file($file, $file_data['directory_file_name']);
                break;
            default:
                // 本地存储
                $this->upload2local($file, $file_data);
                break;
        }
        return $file_data;
    }

    /**
     * 将图片上传到本地
     *
     * @param array $file_data
     * @return void
     */
    private function upload2local($file, array $file_data):bool{
        try{
            $file->move($this->directory, $file_data['file_name']);
        }catch(\Exception $e){
            throwBusinessException("上传失败：原因为:" . $e->getMessage());
        }
        return true;
    }

    /**
     * 重命名文件并返回保存路径和本地完整访问路径
     *
     * @param resource $file
     * @return array
     */
    private function rename($file):array{
        if(!in_array($file->getClientOriginalExtension(), $this->allowed_ext)){
            throwBusinessException('不支持上传此类型文件');
        }
        $file_name = md5($file->getClientOriginalName().time().rand()).'.'.$file->getClientOriginalExtension();
        $directory_file_name = $this->directory . $file_name;
        $full_path_file_name = config('app.url') . '/' . $directory_file_name;
        return [
            'file_name'=> $file_name,  # 文件名
            'directory_file_name'=> $directory_file_name,  # 存储路径
            'full_path_file_name'=> $full_path_file_name   # 完整url链接
        ];
    }
}