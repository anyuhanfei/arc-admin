<?php
namespace App\Api\Services;

use Illuminate\Database\Eloquent\Collection;

use App\Repositories\Article\Article;
use App\Repositories\Article\ArticleCategory;
use App\Repositories\Idx\IdxBanner;
use App\Repositories\Sys\SysNotice;

/**
 * 系统配置相关
 */
class SysService{

    /**
     * 获取轮播图列表
     *
     * @param string $site 位置
     * @return void
     */
    public function get_banner_list(string $site):Collection{
        return (new IdxBanner())->use_site_get_list($site);
    }

    /**
     * 获取公告列表
     *  只有多条文字货多条富文本才能访问；
     *  二者返回数据相同，富文本获取详情数据需要访问获取公告详情接口
     *
     * @param integer $page 页码
     * @param integer $limit 每页展示数据数量
     * @return void
     */
    public function get_notice_list(int $page = 1, int $limit = 10):Collection{
        $notice_type = SysNotice::get_type();
        if($notice_type != '多条富文本' && $notice_type != '多条文字'){
            throwBusinessException('当前公告模式设置为单条，请直接使用 get_notice 接口');
        }
        $data = (new SysNotice())->get_list($page, $limit);
        return $data;
    }

    /**
     * 获取公告
     * 根据系统设置返回指定公共
     *
     * @param integer $user_id
     * @param integer $id
     * @return void 单条的公告信息
     */
    public function get_notice(int $user_id = 0, int $id = 0){
        switch(SysNotice::get_type()){
            case '单条文字':
                $data = (new SysNotice())->get_first_data();
                unset($data->content);
                break;
            case "多条文字":
                if($id == 0){
                    throwBusinessException('当前公告模式设置为多条，请使用 get_notice_list 接口或传递 id 参数!');
                }
                $data = (new SysNotice())->use_id_get_data($id);
                unset($data->content);
                break;
            case "单条富文本":
                $data = ((new SysNotice()))->get_first_data();
                break;
            case "多条富文本":
                if($id == 0){
                    throwBusinessException('当前公告模式设置为多条，请使用 get_notice_list 接口或传递 id 参数!');
                }
                $data = (new SysNotice())->use_id_get_data($id);
                break;
            default:
                return [];
        }
        unset($data->updated_at, $data->deleted_at);
        return $data;
    }

    /**
     * 获取文章分类列表
     *
     */
    public function get_article_category_list(){
        return (new ArticleCategory())->get_all_data();
    }

    /**
     * 获取文章列表
     *
     * @param integer $category_id
     * @param integer $page
     * @param integer $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get_article_list(int $category_id, int $page = 1, int $limit = 10){
        if($category_id != 0){
            $data = (new Article())->use_category_get_list($category_id, $page, $limit);
        }else{
            $data = (new Article())->get_all_data($page, $limit);
        }
        foreach($data as &$v){
            $v->keyword = comma_str_to_array($v->keyword);
        }
        return $data;
    }

    /**
     * 获取文章详情
     *
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function get_article_detail(int $id){
        $data = (new Article())->use_id_get_data($id);
        if(!$data){
            throwBusinessException('文章不存在');
        }
        $data->keyword = comma_str_to_array($data->keyword);
        return $data;
    }
}