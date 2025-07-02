<?php
namespace App\Api\Services;

use App\Admin\Controllers\Sys\SysBannersController;
use App\Admin\Controllers\Sys\SysNoticesController;
use App\Enums\StatusEnum;
use App\Repositories\AppVersions;
use Illuminate\Database\Eloquent\Collection;

use App\Repositories\Article\ArticleCategories;
use App\Repositories\Article\Articles;
use App\Repositories\Faqs\FaqTypes;
use App\Repositories\Feedback\Feedbacks;
use App\Repositories\Feedback\FeedbackTypes;
use App\Repositories\Sys\SysBanners;
use App\Repositories\Sys\SysNotices;
use App\Repositories\Sys\SysSettings;

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
        $admin_sys_banners = (new SysBannersController());
        $set_visible = ['id', 'full_image'];
        if($admin_sys_banners->field_link_enable){
            $set_visible[] = 'link';
            $set_visible[] = 'link_type';
        }
        return (new SysBanners())->get_datas_by_site($site)->setVisible($set_visible);
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
    public function get_notices_list(int $limit = 10):array{
        $notice_type = SysNotices::get_type();
        if($notice_type != '多条富文本' && $notice_type != '多条文字'){
            throwBusinessException('当前公告模式设置为单条，请直接使用 get_notice 接口');
        }
        $set_visible = ['id', 'title', 'created_at'];
        $admin_sys_notices = (new SysNoticesController());
        if($admin_sys_notices->field_image_enable){
            $set_visible[] = 'full_image';
        }
        $datas = format_paginated_datas((new SysNotices())->get_list($limit), $set_visible);
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
    public function get_notice_detail(int $user_id = 0, int $id = 0){
        switch(SysNotices::get_type()){
            case '单条文字':
                $data = (new SysNotices())->get_first_data();
                unset($data->content);
                break;
            case "多条文字":
                if($id == 0){
                    throwBusinessException('当前公告模式设置为多条，请使用 get_notice_list 接口或传递 id 参数!');
                }
                $data = (new SysNotices())->get_data_by_id($id);
                unset($data->content);
                break;
            case "单条富文本":
                $data = ((new SysNotices()))->get_first_data();
                break;
            case "多条富文本":
                if($id == 0){
                    throwBusinessException('当前公告模式设置为多条，请使用 get_notice_list 接口或传递 id 参数!');
                }
                $data = (new SysNotices())->get_data_by_id($id);
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
    public function get_article_categories_list(){
        return (new ArticleCategories())->get_datas();
    }

    /**
     * 获取文章列表
     *
     * @param integer $category_id
     * @param integer $page
     * @param integer $limit
     * @return array
     */
    public function get_articles_list(int $category_id, int $page = 1, int $limit = 10):array{
        if($category_id != 0){
            $datas = (new Articles())->get_list_by_category($category_id, $page, $limit);
        }else{
            $datas = (new Articles())->get_list($page, $limit);
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
        $data = (new Articles())->get_data_by_id($id);
        if(!$data || $data->status != 'normal'){
            throwBusinessException('文章未发布');
        }
        $data = $data->setVisible(['id', 'category_id', 'title', 'intro', 'image', 'author', 'keyword', 'content', 'created_at', 'category_name']);
        if(!$data){
            throwBusinessException('文章不存在');
        }
        $data->keyword = comma_str_to_array($data->keyword);
        $data->category_name = $data->category->name;
        return $data;
    }

    /**
     * 获取协议详情
     *
     * @param string $type
     * @return void
     */
    public function get_agreement_detail(string $type){
        return [
            'detail' => (new SysSettings())->get_value_by_key($type),
        ];
    }

    /**
     * 获取意见反馈类型列表
     *
     * @return void
     */
    public function get_feedback_types_list(){
        $names = (new FeedbackTypes())->get_names();
        return $names;
    }


    /**
     * 获取常见问题列表
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get_faqs_list(){
        // 获取所有展示状态的常见问题类型
        $types = (new FaqTypes())->get_datas_by_publish();
        // 处理数据
        $types = $types->map(function($item){
            // 只获取常见问题数据中状态为 normal 的数据并转换为数组
            $item->faqs = $item->faqs
                ->where('status', StatusEnum::NORMAL)
                ->map(function($faq) {
                    return $faq->only(['id', 'question', 'answer']);
                })->values();
            // 处理完成数据后返回整体
            return $item;
        })->map(function($item) {
            return $item->only(['id', 'name', 'faqs']);
        });
        return $types;
    }

    /**
     * 获取系统设置
     *  TODO::新项目中，需要前端展示/使用的系统配置可在此处返回
     *
     * @return void
     */
    public function get_sys_data(){
        $sys_setting_repository = new SysSettings();
        return [
            'withdraw_minimum_amount' => $sys_setting_repository->get_value_by_key("withdraw_minimum_amount"),
        ];
    }

    /**
     * 获取app版本更新信息
     *
     * @return void
     */
    public function get_app_version_check(string $side){
        $latestVersion = (new AppVersions())->get_latest_version_by_side($side);
        if(!$latestVersion){
            throwBusinessException("暂无版本信息", 'no_version');
        }
        $latestVersion->a_app_url = $latestVersion->a_app_url ? full_url($latestVersion->a_app_url) : null;
        $latestVersion->wgt_url = full_url($latestVersion->wgt_url);
        return [
            'isForce' => boolval($latestVersion->is_force),
            'wgtUrl' => $latestVersion->wgt_url,
            'iAppUrl' => $latestVersion->i_app_url,
            'aAppUrl' => $latestVersion->a_app_url,
            'isComplete' => boolval($latestVersion->is_complete),
            'version' => $latestVersion->version,
            'versionName' => $latestVersion->version_name,
            'size' => $latestVersion->size,
            'content' => $latestVersion->content
        ];
    }
}