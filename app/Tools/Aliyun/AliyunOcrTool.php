<?php

namespace App\Tools\Aliyun;

use AlibabaCloud\SDK\Facebody\V20191230\Facebody;
use \Exception;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils;

use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\SDK\Facebody\V20191230\Models\GetFaceEntityRequest;
use AlibabaCloud\SDK\Facebody\V20191230\Models\AddFaceEntityRequest;
use AlibabaCloud\SDK\Facebody\V20191230\Models\AddFaceAdvanceRequest;
use AlibabaCloud\SDK\Facebody\V20191230\Models\SearchFaceAdvanceRequest;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use GuzzleHttp\Psr7\Stream;

# 阿里云人脸识别
# composer require alibabacloud/facebody-20191230

# 使用流程：
#   1. 为每一个用户创建一个样本
#   2. 将用户的照片上传到样本中
#   3. 使用时将本次的照片与样本中的照片比对，获取最匹配的样本后，再根据匹配度判断
class AliyunOcrTool{
    protected $accessKeyId;
    protected $accessKeySecret;
    protected $client;
    protected $db_name = 'default';

    public function __construct(){
        $this->accessKeyId = env('ALIYUN_AK');
        $this->accessKeySecret = env("ALIYUN_AS");
        $config = new Config([
            "accessKeyId" => $this->accessKeyId,
            "accessKeySecret" => $this->accessKeySecret
        ]);
        $config->endpoint = "facebody.cn-shanghai.aliyuncs.com";
        $this->client = new Facebody($config);
    }

    /**
     * 查询样本id是否存在
     *
     * @param integer $id
     * @return boolean 是否存在
     */
    public function select_id(int $id):bool{
        $getFaceEntityRequest = new GetFaceEntityRequest([
            "dbName" => $this->db_name,
            "entityId" => $id
        ]);
        $runtime = new RuntimeOptions([]);
        try{
            $res = $this->client->getFaceEntityWithOptions($getFaceEntityRequest, $runtime);
            $res = Utils::parseJSON(Utils::toJSONString($res));
        }catch(Exception $error){
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            throwBusinessException($error->message);
        }
        return !empty($res['body']['Data']);
    }

    /**
     * 创建一个样本，样本id为用户id
     *
     * @param integer $id
     * @return boolean 创建结果
     */
    public function add_id(int $id):bool{
        $addFaceEntityRequest = new AddFaceEntityRequest([
            "dbName" => $this->db_name,
            "entityId" => $id
        ]);
        $runtime = new RuntimeOptions([]);
        try{
            $res = $this->client->addFaceEntityWithOptions($addFaceEntityRequest, $runtime);
            $res = Utils::parseJSON(Utils::toJSONString($res));
        }catch(Exception $error){
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            throwBusinessException($error->message);
        }
        return $res['statusCode'] == 200;
    }

    /**
     * 将图片添加到样本中
     *
     * @param integer $user_id
     * @param string $face
     * @return boolean 添加结果
     */
    public function add_face(int $user_id, string $face):bool{
        $file = fopen($face, 'rb');
        $stream = new Stream($file);
        $addFaceRequest = new AddFaceAdvanceRequest([
            "dbName" => $this->db_name,
            "imageUrlObject" => $stream,
            "entityId" => $user_id
        ]);
        $runtime = new RuntimeOptions([]);
        try{
            $res = $this->client->addFaceAdvance($addFaceRequest, $runtime);
            $res = Utils::parseJSON(Utils::toJSONString($res));
        }catch(Exception $error){
            if(!($error instanceof TeaError)){
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            throwBusinessException($error->message);
        }
        return !empty($res['body']['Data']);
    }

    /**
     * 通过图片搜索匹配的图片，如果服务器中有样本，则必定返回一个样本，如果匹配度大于0.5则说明匹配成功
     *
     * @param string $face
     * @return integer 匹配到的样本id，未匹配成功返回-1
     */
    public function search_face(string $face):int{
        $file = fopen($face, 'rb');
        $stream = new Stream($file);
        $searchFaceRequest = new SearchFaceAdvanceRequest([
            "imageUrlObject" => $stream,
            "limit" => 1,
            "dbName" => $this->db_name
        ]);
        $runtime = new RuntimeOptions([]);
        try{
            $res = $this->client->searchFaceAdvance($searchFaceRequest, $runtime);
            $res = Utils::parseJSON(Utils::toJSONString($res));
        }catch(Exception $error){
            if(!($error instanceof TeaError)){
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            throwBusinessException($error->message);
        }
        if(count($res['body']['Data']['MatchList']) >= 1){
            if($res['body']['Data']['MatchList'][0]['FaceItems'][0]['Score'] >= 0.5){
                return intval($res['body']['Data']['MatchList'][0]['FaceItems'][0]['EntityId']);
            }
        }
        return -1;
    }
}