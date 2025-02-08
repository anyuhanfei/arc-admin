<?php
namespace App\Api\Services;

use Illuminate\Database\Eloquent\Collection;

use App\Repositories\Article\Article;
use App\Repositories\Article\ArticleCategory;
use App\Repositories\Sys\SysBanners;
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
    public function get_banners_list(string $site):Collection{
        return (new SysBanners())->get_datas_by_site($site)->setVisible(['id', 'image', 'link_type', 'link']);
    }

    /**
     * 获取公告列表
     *  只有多条文字货多条富文本才能访问；
     *  二者返回数据相同，富文本获取详情数据需要访问获取公告详情接口
     *
     * @param integer $page 页码
     * @param integer $limit 每页展示数据数量
     * @return array
     */
    public function get_notice_list(int $limit = 10):array{
        $notice_type = SysNotice::get_type();
        if($notice_type != '多条富文本' && $notice_type != '多条文字'){
            throwBusinessException('当前公告模式设置为单条，请直接使用 get_notice 接口');
        }
        $datas = format_paginated_datas((new SysNotice())->get_list($limit), ['id', 'title', 'image', 'created_at']);
        return $datas;
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
                $data = (new SysNotice())->get_data_by_id($id);
                unset($data->content);
                break;
            case "单条富文本":
                $data = ((new SysNotice()))->get_first_data();
                break;
            case "多条富文本":
                if($id == 0){
                    throwBusinessException('当前公告模式设置为多条，请使用 get_notice_list 接口或传递 id 参数!');
                }
                $data = (new SysNotice())->get_data_by_id($id);
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
        return (new ArticleCategory())->get_datas();
    }

    /**
     * 获取文章列表
     *
     * @param integer $category_id
     * @param integer $page
     * @param integer $limit
     * @return array
     */
    public function get_article_list(int $category_id, int $limit = 10):array{
        if($category_id != 0){
            $datas = (new Article())->get_list_by_category($category_id, $limit);
        }else{
            $datas = (new Article())->get_list($limit);
        }
        $datas->load(['category']);
        foreach($datas as &$item){
            $item->keyword = comma_str_to_array($item->keyword);
            $item->category_name = $item->category->name;
        }
        $datas = format_paginated_datas($datas, ['id', 'category_id', 'title', 'intro', 'image', 'author', 'keyword', 'created_at', 'category_name']);
        return $datas;
    }

    /**
     * 获取文章详情
     *
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function get_article_detail(int $id){
        $data = (new Article())->get_data_by_id($id)->setVisible(['id', 'category_id', 'title', 'intro', 'image', 'author', 'keyword', 'content', 'created_at', 'category_name']);
        if(!$data){
            throwBusinessException('文章不存在');
        }
        $data->keyword = comma_str_to_array($data->keyword);
        $data->category_name = $data->category->name;
        return $data;
    }
}