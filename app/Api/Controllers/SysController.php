<?php
namespace App\Api\Controllers;

use Illuminate\Http\Request;

use App\Api\Controllers\BaseController;

use App\Api\Services\SysService;
use App\Enums\AppVersions\SideEnum;

/**
 * 配置相关
 */
class SysController extends BaseController{
    protected $service;

    public function __construct(Request $request, SysService $SysService){
        parent::__construct($request);
        $this->service = $SysService;
    }

    /**
     * 获取轮播图数据，可传入位置
     *
     * @return void
     */
    public function banners_list(\App\Api\Requests\Sys\BannerRequest $request){
        $site = $request->input("site", "首页") ?? '首页';
        return success('轮播图', $this->service->get_banners_list($site));
    }

    /**
     * 获取公告列表
     *
     * @param Request $request
     * @return void
     */
    public function notices_list(\App\Api\Requests\PageRequest $request){
        $page = $request->input("page", 1) ?? 1;
        $limit = $request->input("limit", 10) ?? 10;
        $data = $this->service->get_notices_list($limit);
        return success('公告列表', $data);
    }

    /**
     * 获取公告详情
     *
     * @param Request $request
     * @return void
     */
    public function notice_detail(Request $request){
        $id = $request->input('id', 0) ?? 0;
        return success('公告', $this->service->get_notice_detail($this->user_id, $id));
    }

    /**
     * 获取文章分类列表
     *
     * @param Request $request
     * @return void
     */
    public function article_categories_list(){
        $datas = $this->service->get_article_categories_list();
        return success("文章分类列表", $datas);
    }

    /**
     * 获取文章列表, 可根据文章分类筛选
     *
     * @param \App\Api\Requests\PageRequest $request
     * @return void
     */
    public function articles_list(\App\Api\Requests\PageRequest $request){
        $page = $request->input("page", 1) ?? 1;
        $limit = $request->input("limit", 10) ?? 10;
        $category_id = $request->input("category_id", 0) ?? 0;
        $datas = $this->service->get_articles_list($category_id, $page, $limit);
        return success("文章列表", $datas);
    }

    /**
     * 获取文章详情
     *
     * @param Request $request
     * @return void
     */
    public function article_detail(Request $request){
        $id = $request->input('id', 0) ?? 0;
        $data = $this->service->get_article_detail($id);
        return success("文章详情", $data);
    }

    /**
     * 获取协议详情
     *
     * @param Request $request
     * @return void
     */
    public function agreement_detail(Request $request){
        $type = $request->input('type');
        $data = $this->service->get_agreement_detail($type);
        return success("协议详情", $data);
    }

    /**
     * 获取意见反馈类型列表
     *
     * @return void
     */
    public function feedback_types_list(){
        $data = $this->service->get_feedback_types_list();
        return success("意见反馈类型列表", $data);
    }

    /**
     * 获取常见问题列表
     *
     * @return void
     */
    public function faqs_list(){
        $data = $this->service->get_faqs_list();
        return success("常见问题列表", $data);
    }

    /**
     * 获取系统设置
     *
     * @return void
     */
    public function sys_data(){
        $data = $this->service->get_sys_data();
        return success("系统设置", $data);
    }

    /**
     * 检查app版本
     *
     * @param Request $request
     * @return void
     */
    public function app_version_check(Request $request){
        $default_side = SideEnum::getKeys()[0];
        $side = $request->input('side', $default_side) ?? $default_side;
        $data = $this->service->get_app_version_check($side);
        return success("版本信息", $data);
    }
}
