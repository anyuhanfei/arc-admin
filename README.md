## 关于 aner_admin7

通用后台管理系统。内置了例如：网站设置、轮播图、公告、系统消息、会员管理、资金管理、文章管理等。

框架为 `laravel 10.*`，后台模版为 `Dcat admin 2.*`。


#### 安装使用

1. 克隆项目到本地
```bash
git clone https://github.com/aner/aner_admin7.git
```
2. 进入项目根目录，安装依赖
```bash
composer install
```
3. 安装 Dcat admin 静态文件
```bash
php artisan admin:publish
```
4. 复制 `.env.example` 文件，重命名为 `.env`，并修改配置


#### 未完成功能
- 提现的驳回说明
- 文章的草稿功能