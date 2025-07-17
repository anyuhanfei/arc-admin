<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminMenuTableSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            [
                'id' => 1,
                'parent_id' => 0,
                'order' => 1,
                'title' => '主页',
                'icon' => 'feather icon-bar-chart-2',
                'uri' => '/',
                'extension' => '',
                'show' => 1,
                'created_at' => '2023-10-30 08:41:34',
                'updated_at' => '2023-11-17 15:20:59'
            ],
            [
                'id' => 2,
                'parent_id' => 0,
                'order' => 2,
                'title' => '后台系统管理',
                'icon' => 'feather icon-settings',
                'uri' => NULL,
                'extension' => '',
                'show' => 1,
                'created_at' => '2023-10-30 08:41:34',
                'updated_at' => '2023-11-17 15:21:10'
            ],
            [
                'id' => 3,
                'parent_id' => 2,
                'order' => 3,
                'title' => '管理员管理',
                'icon' => NULL,
                'uri' => 'auth/users',
                'extension' => '',
                'show' => 1,
                'created_at' => '2023-10-30 08:41:34',
                'updated_at' => '2023-11-17 15:21:21'
            ],
            [
                'id' => 4,
                'parent_id' => 2,
                'order' => 4,
                'title' => '角色管理',
                'icon' => NULL,
                'uri' => 'auth/roles',
                'extension' => '',
                'show' => 1,
                'created_at' => '2023-10-30 08:41:34',
                'updated_at' => '2023-11-17 15:21:28'
            ],
            [
                'id' => 5,
                'parent_id' => 2,
                'order' => 5,
                'title' => '权限管理',
                'icon' => NULL,
                'uri' => 'auth/permissions',
                'extension' => '',
                'show' => 1,
                'created_at' => '2023-10-30 08:41:34',
                'updated_at' => '2023-11-17 15:21:34'
            ],
            [
                'id' => 6,
                'parent_id' => 2,
                'order' => 6,
                'title' => '目录管理',
                'icon' => NULL,
                'uri' => 'auth/menu',
                'extension' => '',
                'show' => 1,
                'created_at' => '2023-10-30 08:41:34',
                'updated_at' => '2023-11-17 15:21:40'
            ],
            [
                'id' => 8,
                'parent_id' => 0,
                'order' => 8,
                'title' => '客户端管理',
                'icon' => 'fa-connectdevelop',
                'uri' => NULL,
                'extension' => '',
                'show' => 1,
                'created_at' => '2023-10-31 09:58:11',
                'updated_at' => '2025-02-08 16:11:02'
            ],
            [
                'id' => 9,
                'parent_id' => 8,
                'order' => 9,
                'title' => '轮播图管理',
                'icon' => NULL,
                'uri' => 'sys/banners',
                'extension' => '',
                'show' => 1,
                'created_at' => '2023-10-31 10:01:18',
                'updated_at' => '2025-02-08 11:35:30'
            ],
            [
                'id' => 10,
                'parent_id' => 8,
                'order' => 10,
                'title' => '系统设置管理',
                'icon' => NULL,
                'uri' => 'sys/settings/set',
                'extension' => '',
                'show' => 1,
                'created_at' => '2023-10-31 10:59:34',
                'updated_at' => '2025-02-08 14:19:57'
            ],
            [
                'id' => 11,
                'parent_id' => 8,
                'order' => 11,
                'title' => '系统公告管理',
                'icon' => NULL,
                'uri' => 'sys/notices',
                'extension' => '',
                'show' => 1,
                'created_at' => '2023-10-31 13:24:18',
                'updated_at' => '2025-02-08 14:31:30'
            ],
            [
                'id' => 12,
                'parent_id' => 0,
                'order' => 12,
                'title' => '会员管理',
                'icon' => 'fa-address-book',
                'uri' => NULL,
                'extension' => '',
                'show' => 1,
                'created_at' => '2023-10-31 15:11:58',
                'updated_at' => '2025-02-10 09:47:23'
            ],
            [
                'id' => 13,
                'parent_id' => 12,
                'order' => 13,
                'title' => '会员管理',
                'icon' => NULL,
                'uri' => 'users/users',
                'extension' => '',
                'show' => 1,
                'created_at' => '2023-10-31 15:12:21',
                'updated_at' => '2025-02-10 09:47:28'
            ],
            [
                'id' => 14,
                'parent_id' => 0,
                'order' => 14,
                'title' => '内容管理',
                'icon' => 'fa-book',
                'uri' => NULL,
                'extension' => '',
                'show' => 1,
                'created_at' => '2023-11-01 09:24:19',
                'updated_at' => '2023-11-01 09:24:19'
            ],
            [
                'id' => 15,
                'parent_id' => 14,
                'order' => 16,
                'title' => '文章管理',
                'icon' => NULL,
                'uri' => 'article/articles',
                'extension' => '',
                'show' => 1,
                'created_at' => '2023-11-01 09:24:37',
                'updated_at' => '2025-02-08 15:47:57'
            ],
            [
                'id' => 16,
                'parent_id' => 14,
                'order' => 15,
                'title' => '文章分类管理',
                'icon' => NULL,
                'uri' => 'article/categories',
                'extension' => '',
                'show' => 1,
                'created_at' => '2023-11-01 09:24:55',
                'updated_at' => '2025-02-08 16:00:30'
            ],
            [
                'id' => 17,
                'parent_id' => 0,
                'order' => 17,
                'title' => '财务管理',
                'icon' => 'fa-dollar',
                'uri' => NULL,
                'extension' => '',
                'show' => 1,
                'created_at' => '2023-11-01 11:28:13',
                'updated_at' => '2023-11-01 11:28:13'
            ],
            [
                'id' => 18,
                'parent_id' => 17,
                'order' => 18,
                'title' => '会员资金记录',
                'icon' => NULL,
                'uri' => 'log/balances',
                'extension' => '',
                'show' => 1,
                'created_at' => '2023-11-01 11:28:35',
                'updated_at' => '2025-02-08 15:16:25'
            ],
            [
                'id' => 19,
                'parent_id' => 8,
                'order' => 19,
                'title' => '系统消息管理',
                'icon' => NULL,
                'uri' => 'sys/messages',
                'extension' => '',
                'show' => 1,
                'created_at' => '2023-11-03 10:29:08',
                'updated_at' => '2025-02-08 16:08:17'
            ],
            [
                'id' => 20,
                'parent_id' => 17,
                'order' => 20,
                'title' => '会员提现管理',
                'icon' => NULL,
                'uri' => 'log/withdraws',
                'extension' => '',
                'show' => 1,
                'created_at' => '2023-11-04 14:21:32',
                'updated_at' => '2025-02-08 15:27:09'
            ],
            [
                'id' => 21,
                'parent_id' => 14,
                'order' => 21,
                'title' => '意见反馈类型管理',
                'icon' => NULL,
                'uri' => 'feedback/types',
                'extension' => '',
                'show' => 1,
                'created_at' => '2025-02-08 16:21:22',
                'updated_at' => '2025-02-08 16:30:50'
            ],
            [
                'id' => 22,
                'parent_id' => 14,
                'order' => 22,
                'title' => '意见反馈管理',
                'icon' => NULL,
                'uri' => 'feedback/feedbacks',
                'extension' => '',
                'show' => 1,
                'created_at' => '2025-02-08 16:36:45',
                'updated_at' => '2025-02-08 16:36:45'
            ],
            [
                'id' => 23,
                'parent_id' => 14,
                'order' => 23,
                'title' => '常见问题类型管理',
                'icon' => NULL,
                'uri' => 'faqs/types',
                'extension' => '',
                'show' => 1,
                'created_at' => '2025-02-08 16:36:45',
                'updated_at' => '2025-02-08 16:36:45'
            ],
            [
                'id' => 24,
                'parent_id' => 14,
                'order' => 24,
                'title' => '常见问题管理',
                'icon' => NULL,
                'uri' => 'faqs/faqs',
                'extension' => '',
                'show' => 1,
                'created_at' => '2025-02-08 16:36:45',
                'updated_at' => '2025-02-08 16:36:45'
            ],
            [
                'id' => 25,
                'parent_id' => 28,
                'order' => 25,
                'title' => 'APP版本管理',
                'icon' => "",
                'uri' => 'app/versions',
                'extension' => '',
                'show' => 1,
                'created_at' => '2025-02-08 16:36:45',
                'updated_at' => '2025-02-08 16:36:45'
            ],
            [
                'id' => 27,
                'parent_id' => 28,
                'order' => 27,
                'title' => '后台操作日志',
                'icon' => "",
                'uri' => 'auth/operation-logs',
                'extension' => 'dcat-admin.operation-log',
                'show' => 1,
                'created_at' => '2025-02-08 16:36:45',
                'updated_at' => '2025-02-08 16:36:45'
            ],
            [
                'id' => 28,
                'parent_id' => 0,
                'order' => 24,
                'title' => '开发者',
                'icon' => "fa-user-secret",
                'uri' => '',
                'extension' => '',
                'show' => 1,
                'created_at' => '2025-02-08 16:36:45',
                'updated_at' => '2025-02-08 16:36:45'
            ],
            [
                'id' => 29,
                'parent_id' => 0,
                'order' => 27,
                'title' => 'Media Manager',
                'icon' => "fa-folder-open",
                'uri' => 'media',
                'extension' => 'jatdung.media-manager',
                'show' => 1,
                'created_at' => '2025-02-08 16:36:45',
                'updated_at' => '2025-02-08 16:36:45'
            ],
        ];

        DB::table('admin_menu')->truncate();  // 清空表
        DB::table('admin_menu')->insert($menus);
    }
}