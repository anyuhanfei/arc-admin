## 关于 arc_admin

通用后台管理系统。内置了例如：客户端设置、轮播图、公告、系统消息、会员管理、资金管理、文章管理等。

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

#### TODO
1. 公告、文章、轮播图的开关（发布、隐藏）
2. 分页数据处理的方法添加自定义
3. 提现审核无法提交