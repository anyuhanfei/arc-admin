<?php

namespace App\Admin\Metrics\Examples;

use App\Models\Users\Users;
use Dcat\Admin\Widgets\Metrics\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class 冻结会员数统计 extends Card{
    protected $footer;

    protected function init(){
        parent::init();

        $this->title('冻结会员数统计');
        $this->dropdown([]);
    }

    public function handle(Request $request){
        $user_number = $this->count_nologin_users_number();
        $this->content($user_number);
    }

    public function footer($footer){
        $this->footer = $footer;

        return $this;
    }


    public function renderContent(){
        $content = parent::renderContent();

        return <<<HTML
<div class="d-flex justify-content-between align-items-center mt-1" style="margin-bottom: 2px">
    <h2 class="ml-1 font-lg-1">{$content}</h2>
</div>
HTML;
    }

    /**
     * 渲染卡片底部内容.
     *
     * @return string
     */
    public function renderFooter(){
        return $this->toString($this->footer);
    }

    public function count_nologin_users_number():int{
        return Cache::remember("count_nologin_users_number", 60, function(){
            return Users::loginStatus(0)->count();
        });
    }
}
