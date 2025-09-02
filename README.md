## 关于 arc_admin

通用后台管理系统。内置了例如：客户端设置、轮播图、公告、系统消息、用户管理、资金管理、文章管理等。

框架为 `laravel 11.*`，后台模版为 `Dcat admin 2.*`。


#### 安装使用

1. 克隆项目到本地
```bash
git clone https://github.com/anyuhanfei/arc-admin.git
```
2. 进入项目根目录，安装依赖
```bash
composer install
```
3. 安装 Dcat admin 静态文件
```bash
php artisan admin:publish
```
4. 复制 `.env.example` 文件，重命名为 `.env`，并修改配置，此步骤一定要配置数据库
5. 运行以下命令完成数据库迁移
```bash
php artisan migrate
```
6. 按顺序运行以下命令生成基础数据
```bash
php artisan admin:install
php artisan db:seed
```
7. 初始超级管理员账号密码为：
```
账号：admin
密码：admin
```
8. 进入后台后，点击左侧菜单 `开发工具` -> `扩展`, 将两个扩展都启用。
9. 连接可视化数据库软件，打开 `admin_menu` 表的数据，将最后一行数据 `title` 为 `operation-logs` 的数据修改以下字段数据：
```bash
id: 27
title: 后台操作日志
icon: ''
```
10. 运行以下命令完成扩展工具 `dcat-media-selector` 的数据库迁移
```bash
php artisan migrate --path=vendor/dememory/dcat-media-selector/updates
```

#### TODO
1. 公告、文章、轮播图的开关（发布、隐藏）
2. 分页数据处理的方法添加自定义
3. 提现审核无法提交