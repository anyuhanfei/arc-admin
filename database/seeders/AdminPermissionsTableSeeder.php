<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminPermissionsTableSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            [
                'id' => 1,
                'name' => '后台系统设置',
                'slug' => '后台系统设置',
                'http_method' => '',
                'http_path' => '',
                'order' => 1,
                'parent_id' => 0,
                'created_at' => '2023-10-30 08:41:34',
                'updated_at' => '2023-11-17 15:19:28'
            ],
            [
                'id' => 2,
                'name' => '管理员管理',
                'slug' => '管理员管理',
                'http_method' => '',
                'http_path' => '/auth/users*',
                'order' => 2,
                'parent_id' => 1,
                'created_at' => '2023-10-30 08:41:34',
                'updated_at' => '2023-11-17 15:19:40'
            ],
            [
                'id' => 3,
                'name' => '角色管理',
                'slug' => '角色管理',
                'http_method' => '',
                'http_path' => '/auth/roles*',
                'order' => 3,
                'parent_id' => 1,
                'created_at' => '2023-10-30 08:41:34',
                'updated_at' => '2023-11-17 15:19:54'
            ],
            [
                'id' => 4,
                'name' => '权限管理',
                'slug' => '权限管理',
                'http_method' => '',
                'http_path' => '/auth/permissions*',
                'order' => 4,
                'parent_id' => 1,
                'created_at' => '2023-10-30 08:41:34',
                'updated_at' => '2023-11-17 15:20:05'
            ],
            [
                'id' => 5,
                'name' => '菜单管理',
                'slug' => '菜单管理',
                'http_method' => '',
                'http_path' => '/auth/menu*',
                'order' => 5,
                'parent_id' => 1,
                'created_at' => '2023-10-30 08:41:34',
                'updated_at' => '2023-11-17 15:20:24'
            ],
            [
                'id' => 6,
                'name' => '扩展管理',
                'slug' => '扩展管理',
                'http_method' => '',
                'http_path' => '/auth/extensions*',
                'order' => 6,
                'parent_id' => 1,
                'created_at' => '2023-10-30 08:41:34',
                'updated_at' => '2023-11-17 15:20:35'
            ],
            [
                'id' => 7,
                'name' => '网站设置',
                'slug' => '网站设置',
                'http_method' => '',
                'http_path' => '',
                'order' => 7,
                'parent_id' => 0,
                'created_at' => '2023-10-31 10:02:25',
                'updated_at' => '2023-10-31 10:02:25'
            ],
            [
                'id' => 8,
                'name' => '轮播图管理',
                'slug' => '轮播图管理',
                'http_method' => '',
                'http_path' => '',
                'order' => 8,
                'parent_id' => 7,
                'created_at' => '2023-10-31 10:03:05',
                'updated_at' => '2025-02-10 09:19:54'
            ],
            [
                'id' => 9,
                'name' => '系统设置管理',
                'slug' => '系统设置管理',
                'http_method' => '',
                'http_path' => '',
                'order' => 13,
                'parent_id' => 7,
                'created_at' => '2023-11-17 15:13:33',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 10,
                'name' => '系统公告管理',
                'slug' => '系统公告管理',
                'http_method' => '',
                'http_path' => '',
                'order' => 15,
                'parent_id' => 7,
                'created_at' => '2023-11-17 15:14:01',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 11,
                'name' => '系统消息管理',
                'slug' => '系统消息管理',
                'http_method' => '',
                'http_path' => '',
                'order' => 20,
                'parent_id' => 7,
                'created_at' => '2023-11-17 15:14:32',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 12,
                'name' => '会员管理',
                'slug' => '会员管理',
                'http_method' => '',
                'http_path' => '',
                'order' => 25,
                'parent_id' => 0,
                'created_at' => '2023-11-17 15:14:58',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 13,
                'name' => '会员管理',
                'slug' => '会员列表',
                'http_method' => '',
                'http_path' => '',
                'order' => 26,
                'parent_id' => 12,
                'created_at' => '2023-11-17 15:15:39',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 14,
                'name' => '内容管理',
                'slug' => '内容管理',
                'http_method' => '',
                'http_path' => '',
                'order' => 31,
                'parent_id' => 0,
                'created_at' => '2023-11-17 15:15:59',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 15,
                'name' => '文章管理',
                'slug' => '文章管理',
                'http_method' => '',
                'http_path' => '',
                'order' => 37,
                'parent_id' => 14,
                'created_at' => '2023-11-17 15:16:27',
                'updated_at' => '2025-02-10 09:56:54'
            ],
            [
                'id' => 16,
                'name' => '文章分类管理',
                'slug' => '文章分类管理',
                'http_method' => '',
                'http_path' => '/article/category*,/article/category/*',
                'order' => 32,
                'parent_id' => 14,
                'created_at' => '2023-11-17 15:17:05',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 17,
                'name' => '财务管理',
                'slug' => '财务管理',
                'http_method' => '',
                'http_path' => '',
                'order' => 38,
                'parent_id' => 0,
                'created_at' => '2023-11-17 15:17:28',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 18,
                'name' => '会员资金记录',
                'slug' => '会员资金记录',
                'http_method' => '',
                'http_path' => '',
                'order' => 39,
                'parent_id' => 17,
                'created_at' => '2023-11-17 15:18:08',
                'updated_at' => '2025-02-10 11:44:53'
            ],
            [
                'id' => 19,
                'name' => '会员提现管理',
                'slug' => '会员提现管理',
                'http_method' => '',
                'http_path' => '',
                'order' => 40,
                'parent_id' => 17,
                'created_at' => '2023-11-17 15:18:37',
                'updated_at' => '2025-02-10 11:44:47'
            ],
            [
                'id' => 20,
                'name' => '列表',
                'slug' => 'banners_list',
                'http_method' => '',
                'http_path' => '/sys/banners',
                'order' => 9,
                'parent_id' => 8,
                'created_at' => '2025-02-08 17:40:28',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 21,
                'name' => '新增',
                'slug' => 'banners_add',
                'http_method' => '',
                'http_path' => '/sys/banners/create*',
                'order' => 10,
                'parent_id' => 8,
                'created_at' => '2025-02-08 17:41:09',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 22,
                'name' => '编辑',
                'slug' => 'banners_edit',
                'http_method' => 'GET,PUT',
                'http_path' => '/sys/banners/*,/sys/banners/*/edit',
                'order' => 11,
                'parent_id' => 8,
                'created_at' => '2025-02-08 17:41:59',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 23,
                'name' => '删除',
                'slug' => 'banners_del',
                'http_method' => 'DELETE',
                'http_path' => '/sys/banners/*',
                'order' => 12,
                'parent_id' => 8,
                'created_at' => '2025-02-08 17:42:45',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 24,
                'name' => '保存设置',
                'slug' => 'setting_edit',
                'http_method' => 'GET,POST',
                'http_path' => '/sys/settings/set,/sys/settings',
                'order' => 14,
                'parent_id' => 9,
                'created_at' => '2025-02-08 17:48:03',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 25,
                'name' => '列表',
                'slug' => 'notices_list',
                'http_method' => '',
                'http_path' => '/sys/notices',
                'order' => 16,
                'parent_id' => 10,
                'created_at' => '2025-02-08 17:49:07',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 26,
                'name' => '新增',
                'slug' => 'notices_add',
                'http_method' => '',
                'http_path' => '/sys/notices/create*',
                'order' => 17,
                'parent_id' => 10,
                'created_at' => '2025-02-08 17:49:50',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 27,
                'name' => '编辑(包含显示)',
                'slug' => 'notices_edit',
                'http_method' => 'GET,PUT',
                'http_path' => '/sys/notices/*,/sys/notices/*/edit',
                'order' => 18,
                'parent_id' => 10,
                'created_at' => '2025-02-08 17:51:03',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 28,
                'name' => '删除',
                'slug' => 'notices_del',
                'http_method' => 'DELETE',
                'http_path' => '/sys/notices/*',
                'order' => 19,
                'parent_id' => 10,
                'created_at' => '2025-02-10 08:58:54',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 30,
                'name' => '列表',
                'slug' => 'messages_list',
                'http_method' => '',
                'http_path' => '/sys/messages',
                'order' => 21,
                'parent_id' => 11,
                'created_at' => '2025-02-10 09:38:20',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 31,
                'name' => '新增',
                'slug' => 'messages_add',
                'http_method' => '',
                'http_path' => '/sys/messages/create*',
                'order' => 22,
                'parent_id' => 11,
                'created_at' => '2025-02-10 09:38:53',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 32,
                'name' => '编辑(包含显示)',
                'slug' => 'messages_edit',
                'http_method' => 'GET,PUT',
                'http_path' => '/sys/messages/*,/sys/messages/*/edit',
                'order' => 23,
                'parent_id' => 11,
                'created_at' => '2025-02-10 09:39:38',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 33,
                'name' => '删除',
                'slug' => 'messages_del',
                'http_method' => 'DELETE',
                'http_path' => '/sys/messages/*',
                'order' => 24,
                'parent_id' => 11,
                'created_at' => '2025-02-10 09:40:14',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 34,
                'name' => '列表',
                'slug' => 'users_list',
                'http_method' => '',
                'http_path' => '/users/users',
                'order' => 27,
                'parent_id' => 13,
                'created_at' => '2025-02-10 09:48:15',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 35,
                'name' => '新增',
                'slug' => 'users_add',
                'http_method' => '',
                'http_path' => '/users/users/create*',
                'order' => 28,
                'parent_id' => 13,
                'created_at' => '2025-02-10 09:48:54',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 36,
                'name' => '编辑(包含显示)',
                'slug' => 'users_edit',
                'http_method' => 'GET,PUT',
                'http_path' => '/users/users/*,/users/users/*/edit',
                'order' => 29,
                'parent_id' => 13,
                'created_at' => '2025-02-10 09:49:40',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 37,
                'name' => '删除',
                'slug' => 'users_del',
                'http_method' => 'DELETE',
                'http_path' => '/users/users/*',
                'order' => 30,
                'parent_id' => 13,
                'created_at' => '2025-02-10 09:50:15',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 38,
                'name' => '列表',
                'slug' => 'article_categories_list',
                'http_method' => '',
                'http_path' => '/article/categories',
                'order' => 33,
                'parent_id' => 16,
                'created_at' => '2025-02-10 09:51:47',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 39,
                'name' => '新增',
                'slug' => 'article_categories_add',
                'http_method' => '',
                'http_path' => '/article/categories/create*',
                'order' => 34,
                'parent_id' => 16,
                'created_at' => '2025-02-10 09:52:19',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 40,
                'name' => '编辑',
                'slug' => 'article_categories_edit',
                'http_method' => 'GET,PUT',
                'http_path' => '/article/categories/*,/article/categories/*/edit',
                'order' => 35,
                'parent_id' => 16,
                'created_at' => '2025-02-10 09:52:59',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 41,
                'name' => '删除',
                'slug' => 'article_categories_del',
                'http_method' => 'DELETE',
                'http_path' => '/article/categories/*',
                'order' => 36,
                'parent_id' => 16,
                'created_at' => '2025-02-10 09:53:30',
                'updated_at' => '2025-02-10 09:53:40'
            ],
            [
                'id' => 42,
                'name' => '列表',
                'slug' => 'articles_list',
                'http_method' => '',
                'http_path' => '/article/articles',
                'order' => 41,
                'parent_id' => 15,
                'created_at' => '2025-02-10 09:54:49',
                'updated_at' => '2025-02-10 09:54:49'
            ],
            [
                'id' => 43,
                'name' => '新增',
                'slug' => 'articles_add',
                'http_method' => '',
                'http_path' => '/article/articles/create*',
                'order' => 42,
                'parent_id' => 15,
                'created_at' => '2025-02-10 09:55:21',
                'updated_at' => '2025-02-10 09:55:21'
            ],
            [
                'id' => 44,
                'name' => '编辑(包含显示)',
                'slug' => 'articles_edit',
                'http_method' => 'GET,PUT',
                'http_path' => '/article/articles/*,/article/articles/*/edit',
                'order' => 43,
                'parent_id' => 15,
                'created_at' => '2025-02-10 09:56:03',
                'updated_at' => '2025-02-10 09:56:03'
            ],
            [
                'id' => 45,
                'name' => '删除',
                'slug' => 'articles_del',
                'http_method' => 'DELETE',
                'http_path' => '/article/articles/*',
                'order' => 44,
                'parent_id' => 15,
                'created_at' => '2025-02-10 09:56:35',
                'updated_at' => '2025-02-10 09:56:35'
            ],
            [
                'id' => 46,
                'name' => '意见反馈类型管理',
                'slug' => '意见反馈类型管理',
                'http_method' => '',
                'http_path' => '',
                'order' => 45,
                'parent_id' => 14,
                'created_at' => '2025-02-10 09:58:06',
                'updated_at' => '2025-02-10 09:58:06'
            ],
            [
                'id' => 47,
                'name' => '列表',
                'slug' => 'feedback_types_list',
                'http_method' => '',
                'http_path' => '/feedback/types',
                'order' => 46,
                'parent_id' => 46,
                'created_at' => '2025-02-10 09:58:45',
                'updated_at' => '2025-02-10 09:58:45'
            ],
            [
                'id' => 48,
                'name' => '新增',
                'slug' => 'feedback_types_add',
                'http_method' => '',
                'http_path' => '/feedback/types/create*',
                'order' => 47,
                'parent_id' => 46,
                'created_at' => '2025-02-10 09:59:08',
                'updated_at' => '2025-02-10 09:59:08'
            ],
            [
                'id' => 49,
                'name' => '编辑',
                'slug' => 'feedback_types_edit',
                'http_method' => 'GET,PUT',
                'http_path' => '/feedback/types/*,/feedback/types/*/edit',
                'order' => 48,
                'parent_id' => 46,
                'created_at' => '2025-02-10 10:03:01',
                'updated_at' => '2025-02-10 10:03:01'
            ],
            [
                'id' => 50,
                'name' => '删除',
                'slug' => 'feedback_types_del',
                'http_method' => 'DELETE',
                'http_path' => '/feedback/types/*',
                'order' => 49,
                'parent_id' => 46,
                'created_at' => '2025-02-10 10:03:50',
                'updated_at' => '2025-02-10 10:03:50'
            ],
            [
                'id' => 51,
                'name' => '意见反馈管理',
                'slug' => '意见反馈管理',
                'http_method' => '',
                'http_path' => '',
                'order' => 50,
                'parent_id' => 14,
                'created_at' => '2025-02-10 10:04:22',
                'updated_at' => '2025-02-10 10:04:22'
            ],
            [
                'id' => 52,
                'name' => '列表',
                'slug' => 'feedbacks_list',
                'http_method' => '',
                'http_path' => '/feedback/feedbacks',
                'order' => 51,
                'parent_id' => 51,
                'created_at' => '2025-02-10 10:05:01',
                'updated_at' => '2025-02-10 10:05:01'
            ],
            [
                'id' => 53,
                'name' => '新增',
                'slug' => 'feedbacks_add',
                'http_method' => '',
                'http_path' => '/feedback/feedbacks/create*',
                'order' => 52,
                'parent_id' => 51,
                'created_at' => '2025-02-10 10:05:35',
                'updated_at' => '2025-02-10 10:05:35'
            ],
            [
                'id' => 54,
                'name' => '编辑(包含显示)',
                'slug' => 'feedbacks_edit',
                'http_method' => 'GET,PUT',
                'http_path' => '/feedback/feedbacks/*,/feedback/feedbacks/*/edit',
                'order' => 53,
                'parent_id' => 51,
                'created_at' => '2025-02-10 11:41:39',
                'updated_at' => '2025-02-10 11:41:39'
            ],
            [
                'id' => 55,
                'name' => '删除',
                'slug' => 'feedbacks_del',
                'http_method' => 'DELETE',
                'http_path' => '/feedback/feedbacks/*',
                'order' => 54,
                'parent_id' => 51,
                'created_at' => '2025-02-10 11:42:14',
                'updated_at' => '2025-02-10 11:42:14'
            ],
            [
                'id' => 56,
                'name' => '列表',
                'slug' => 'balances_list',
                'http_method' => '',
                'http_path' => '/log/balances',
                'order' => 55,
                'parent_id' => 18,
                'created_at' => '2025-02-10 11:43:10',
                'updated_at' => '2025-02-10 11:43:10'
            ],
            [
                'id' => 57,
                'name' => '显示',
                'slug' => 'balances_view',
                'http_method' => 'GET',
                'http_path' => '/log/balances/*',
                'order' => 56,
                'parent_id' => 18,
                'created_at' => '2025-02-10 11:43:42',
                'updated_at' => '2025-02-10 11:43:42'
            ],
            [
                'id' => 58,
                'name' => '列表',
                'slug' => 'withdraws_list',
                'http_method' => '',
                'http_path' => '/log/withdraws',
                'order' => 57,
                'parent_id' => 19,
                'created_at' => '2025-02-10 11:44:04',
                'updated_at' => '2025-02-10 11:44:04'
            ],
            [
                'id' => 59,
                'name' => '编辑',
                'slug' => 'withdraws_edit',
                'http_method' => 'GET,PUT',
                'http_path' => '/log/withdraws/*,/log/withdraws/*/edit',
                'order' => 58,
                'parent_id' => 19,
                'created_at' => '2025-02-10 11:44:39',
                'updated_at' => '2025-02-10 11:44:39'
            ],
            // 常见问题类型管理
            [
                'id' => 60,
                'name' => '常见问题类型管理',
                'slug' => '常见问题类型管理',
                'http_method' => '',
                'http_path' => '',
                'order' => 59,
                'parent_id' => 14,
                'created_at' => '2025-06-23 17:34:43',
                'updated_at' => '2025-06-23 17:34:43'
            ],
            [
                'id' => 61,
                'name' => '列表',
                'slug' => 'faqs_types_list',
                'http_method' => '',
                'http_path' => '/faqs/types',
                'order' => 60,
                'parent_id' => 60,
                'created_at' => '2025-06-23 17:35:34',
                'updated_at' => '2025-06-23 17:35:34'
            ],
            [
                'id' => 62,
                'name' => '新增',
                'slug' => 'faqs_types_add',
                'http_method' => '',
                'http_path' => '/faqs/types/create*',
                'order' => 61,
                'parent_id' => 60,
                'created_at' => '2025-06-23 17:36:20',
                'updated_at' => '2025-06-23 17:36:20'
            ],
            [
                'id' => 63,
                'name' => '编辑',
                'slug' => 'faqs_types_edit',
                'http_method' => 'GET,PUT',
                'http_path' => '/faqs/types/*,/faqs/types/*/edit',
                'order' => 62,
                'parent_id' => 60,
                'created_at' => '2025-06-23 17:36:57',
                'updated_at' => '2025-06-23 17:36:57'
            ],
            [
                'id' => 64,
                'name' => '删除',
                'slug' => 'faqs_types_del',
                'http_method' => 'DELETE',
                'http_path' => '/faqs/types/*',
                'order' => 63,
                'parent_id' => 60,
                'created_at' => '2025-06-23 17:38:01',
                'updated_at' => '2025-06-23 17:38:01'
            ],
            // 常见问题管理
            [
                'id' => 65,
                'name' => '常见问题管理',
                'slug' => '常见问题管理',
                'http_method' => '',
                'http_path' => '',
                'order' => 64,
                'parent_id' => 14,
                'created_at' => '2025-06-23 17:38:53',
                'updated_at' => '2025-06-23 17:38:53'
            ],
            [
                'id' => 66,
                'name' => '列表',
                'slug' => 'faqs_faqs_list',
                'http_method' => '',
                'http_path' => '/faqs/faqs',
                'order' => 65,
                'parent_id' => 65,
                'created_at' => '2025-06-23 17:39:49',
                'updated_at' => '2025-06-23 17:39:49'
            ],
            [
                'id' => 67,
                'name' => '新增',
                'slug' => 'faqs_faqs_add',
                'http_method' => '',
                'http_path' => '/faqs/faqs/create*',
                'order' => 66,
                'parent_id' => 65,
                'created_at' => '2025-06-23 17:40:37',
                'updated_at' => '2025-06-23 17:40:37'
            ],
            [
                'id' => 68,
                'name' => '编辑',
                'slug' => 'faqs_faqs_edit',
                'http_method' => 'GET,PUT',
                'http_path' => '/faqs/faqs/*,/faqs/faqs/*/edit',
                'order' => 67,
                'parent_id' => 65,
                'created_at' => '2025-06-23 17:41:07',
                'updated_at' => '2025-06-23 17:41:07'
            ],
            [
                'id' => 69,
                'name' => '删除',
                'slug' => 'faqs_faqs_del',
                'http_method' => 'DELETE',
                'http_path' => '/faqs/faqs/*',
                'order' => 68,
                'parent_id' => 65,
                'created_at' => '2025-06-23 17:43:08',
                'updated_at' => '2025-06-23 17:43:08'
            ],
            // APP版本管理
            [
                'id' => 70,
                'name' => 'APP版本管理',
                'slug' => 'APP版本管理',
                'http_method' => '',
                'http_path' => '',
                'order' => 70,
                'parent_id' => 75,
                'created_at' => '2025-06-23 17:46:57',
                'updated_at' => '2025-06-23 17:46:57'
            ],
            [
                'id' => 71,
                'name' => '列表',
                'slug' => 'app_versions_list',
                'http_method' => '',
                'http_path' => '/app/versions',
                'order' => 71,
                'parent_id' => 70,
                'created_at' => '2025-06-23 17:48:12',
                'updated_at' => '2025-06-23 17:48:12'
            ],
            [
                'id' => 72,
                'name' => '新增',
                'slug' => 'app_versions_add',
                'http_method' => '',
                'http_path' => '/app/versions/create*',
                'order' => 72,
                'parent_id' => 70,
                'created_at' => '2025-06-23 17:48:43',
                'updated_at' => '2025-06-23 17:48:43'
            ],
            [
                'id' => 73,
                'name' => '编辑',
                'slug' => 'app_versions_edit',
                'http_method' => 'GET,PUT',
                'http_path' => '/app/versions/*,/app/versions/*/edit',
                'order' => 73,
                'parent_id' => 70,
                'created_at' => '2025-06-23 17:49:10',
                'updated_at' => '2025-06-23 17:49:10'
            ],
            [
                'id' => 74,
                'name' => '删除',
                'slug' => 'app_versions_del',
                'http_method' => 'DELETE',
                'http_path' => '/app/versions/*',
                'order' => 74,
                'parent_id' => 70,
                'created_at' => '2025-06-23 17:49:48',
                'updated_at' => '2025-06-23 17:49:48'
            ],
            // 开发者
            [
                'id' => 75,
                'name' => '开发者',
                'slug' => '开发者',
                'http_method' => '',
                'http_path' => '',
                'order' => 69,
                'parent_id' => 0,
                'created_at' => '2025-06-23 17:48:12',
                'updated_at' => '2025-06-23 17:48:12'
            ],
            // 后台操作日志
            [
                'id' => 76,
                'name' => '后台操作日志',
                'slug' => '后台操作日志',
                'http_method' => '',
                'http_path' => '',
                'order' => 75,
                'parent_id' => 75,
                'created_at' => '2025-06-23 17:48:12',
                'updated_at' => '2025-06-23 17:48:12'
            ],
            [
                'id' => 77,
                'name' => '列表',
                'slug' => 'operation-logs_list',
                'http_method' => '',
                'http_path' => '/auth/operation-logs',
                'order' => 76,
                'parent_id' => 76,
                'created_at' => '2025-06-23 17:48:12',
                'updated_at' => '2025-06-23 17:48:12'
            ],
            [
                'id' => 78,
                'name' => '删除',
                'slug' => 'operation-logs_del',
                'http_method' => 'DELETE',
                'http_path' => '/auth/operation-logs/*',
                'order' => 77,
                'parent_id' => 76,
                'created_at' => '2025-06-23 17:48:12',
                'updated_at' => '2025-06-23 17:48:12'
            ],

        ];

        DB::table('admin_permissions')->truncate();  // 清空表
        DB::table('admin_permissions')->insert($permissions);
    }
}