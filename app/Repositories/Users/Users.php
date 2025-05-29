<?php

namespace App\Repositories\Users;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as EloquentModel;

use App\Models\Users\Users as Model;
use Dcat\Admin\Repositories\EloquentRepository;

/**
 * 会员表数据仓库
 */
class Users extends EloquentRepository{
    protected $eloquentClass = Model::class;

    /**
     * 后台接单：获取会员列表
     *
     * @return Collection
     */
    public function admin_get_datas_by_account(string|null $account = ''):Collection{
        return $this->eloquentClass::where('account', 'like', "%{$account}%")->get(['id', DB::raw("account as text")]);exit;
    }

    /**
     * 创建会员
     *
     * @param [type] $params
     * @return EloquentModel
     */
    public function create_data(array $params):EloquentModel{
        $password = $this->set_user_password($params['password'] ?? '');
        DB::beginTransaction();
        try{
            $user_data = $this->eloquentClass::create([
                'avatar'=> $params['avatar'] ?? '',
                'nickname'=> $params['nickname'] ?? ($params['account'] ?? ($params['phone'] ?? '')),
                'account'=> $params['account'] ?? '',
                'phone'=> $params['phone'] ?? '',
                'email'=> $params['email'] ?? '',
                'password'=> $password,
                'parent_user_id'=> $params['parent_user_id'] ?? 0,
                'unionid'=> $params['unionid'] ?? '',
                'openid'=> $params['openid'] ?? '',
                'login_status'=> $params['login_status'] ?? 1,
            ]);
            (new UserBalances())->create_data($user_data->id);
            (new UserDetails())->create_data($user_data->id);
            DB::commit();
        }catch(\Exception $e) {
            DB::rollBack();
            throwBusinessException("注册失败");
        }
        return $user_data;
    }

    /**
     * 通过账号查询一条数据
     *
     * @param string $account
     * @return EloquentModel
     */
    public function get_data_by_account(string $account):EloquentModel{
        return $this->eloquentClass::account($account)->first();
    }

    /**
     * 通过手机号查询一条数据
     *
     * @param string $phone
     * @return EloquentModel
     */
    public function get_data_by_phone(string $phone):?EloquentModel{
        return $this->eloquentClass::phone($phone)->first();
    }

    /**
     * 通过openid查询一条数据
     *
     * @param string $openid
     * @return EloquentModel
     */
    public function get_data_by_openid(string $openid):EloquentModel{
        return $this->eloquentClass::openid($openid)->first();
    }

    /**
     * 通过id查询一条数据
     *
     * @param integer $id
     * @return EloquentModel
     */
    public function get_data_by_id(int $id):EloquentModel{
        return $this->eloquentClass::id($id)->first();
    }

    /**
     * 获取指定id的openid
     *
     * @param integer $id
     * @return string
     */
    public function get_openid_by_id(int $id):string{
        return $this->eloquentClass::id($id)->value("openid");
    }

    /**
     * 获取指定id的会员集
     *
     * @param array $ids
     * @return Collection
     */
    public function get_datas_by_ids(array $ids):Collection{
        return $this->eloquentClass::id($ids)->select("id", "nickname", "account", "phone")->get();
    }

    /**
     * 获取全部会员的id
     *
     * @return Collection
     */
    public function get_ids():Collection{
        return $this->eloquentClass::pluck("id");
    }

    /**
     * 修改会员中指定的数据
     *
     * @param integer $user_id
     * @param array $params
     * @return void
     */
    public function update_datas_by_user(int $user_id, array $params):int{
        return $this->eloquentClass::where("id", $user_id)->update($params);
    }

    public function verify_status_by_user(Model $user_data){
        if(!$user_data || $user_data->login_status == 0){
            throwBusinessException("会员不存在或已冻结", NO_LOGIN);
        }
    }



    /****************************start password***************************** */
    /**
     * 生成密码
     *
     * @param string $password 密码原码
     * @return string 加密密码
     */
    public function set_user_password($password):string{
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * 验证密码
     *
     * @param Eloquent $encryption_password 加密后的密文
     * @param string $password 密码原码
     * @return bool
     */
    public function verify_user_password($encryption_password, $password):bool{
        return password_verify($password, $encryption_password);
    }
    /**************************************end password***************************************** */

    /**************************************start token***************************************** */
    /**
     * 设置会员的token
     *
     * @param int $user_id 会员id
     * @return string
     */
    public function set_token(int $user_id):string{
        $SSO_STATUS = true; // 此项目是否是单点登录 TODO::暂时放在这里
        if($SSO_STATUS){
            do{
                $token = Redis::spop("ut:{$user_id}");
                Redis::delete("ut:{$token}");
            }while($token);
        }
        $user_token = md5(Hash::make(time()));
        Redis::set("ut:{$user_token}", $user_id);
        Redis::sadd("ut:{$user_id}", $user_token);  // 向 token集合 中添加一个 token
        return $user_token;
    }

    /**
     * 删除会员的token信息
     *  一般用于退出登录操作（无论是否设置为单点登录, 都仅删除当前登录的token）
     *
     * @param int $user_id 会员id
     * @return bool
     */
    public function delete_token(int $user_id, string $token):bool{
        Redis::srem("ut:{$user_id}", $token);
        Redis::delete("ut:{$token}");
        return true;
    }

    /**
     * 通过token获取会员的id
     *
     * @param string $token token
     * @return int
     */
    public function use_token_get_id(string $token):int{
        $user_id = Redis::get("ut:{$token}");
        return $user_id ?? 0;
    }
    /**************************************end token***************************************** */

    /**************************************start count*************************************** */
    public function 获取本周新增会员数量(){
        $date = date('Y-m-d', strtotime('this week')); // 获取本周的第一天
        $today = date("Y-m-d", time()); // 今日
        $end_date = date('Y-m-d', strtotime('next week')); // 获取本周的最后一天

        $members = array(); // 用于存储每天的新增会员数量
        while ($date < $end_date) {
            if($date == $today){  // 是今天的数据，缓存时间设置为60s (正在进行中，数据更新频繁)
                $ttl = 60;
            }elseif($date < $today){  // 是过去的数据，缓存时间设置为14天（过去的时间，不会更新数据）
                $ttl = 86400 * 14;
            }else{
                $ttl = strtotime(date("Y-m-d", time() + 86400)) -  time(); // 到第二天0点过期
            }
            // 获取当天数据并存储到结果中
            $members[date('l, Y-m-d', strtotime($date))] = Cache::remember("count_day_users_number:{$date}", $ttl, function() use($date){
                return $this->eloquentClass::whereDate("created_at", $date)->count();
            });
            // 下一天
            $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
        }
        return $members;
    }

    public function 获取前一周新增会员数量(){
        $date = date('Y-m-d', strtotime('last week')); // 获取前一周的第一天
        $end_date = date('Y-m-d', strtotime('this week')); // 获取本周的最后一天

        $ttl = 7 * 86400;  // 因为是过去的时间，所以不会改变了，直接缓存最大天数
        $members = array(); // 用于存储每天的新增会员数量
        while ($date < $end_date) {
            // 获取当天数据并存储到结果中
            $members[date('l, Y-m-d', strtotime($date))] = Cache::remember("count_day_users_number:{$date}", $ttl, function() use($date){
                return $this->eloquentClass::whereDate("created_at", $date)->count();
            });
            // 下一天
            $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
        }
        return $members;
    }

    public function 获取本月新增会员数量(){
        $firstDay = strtotime(date('Y-m')); // 获取本月的第一天
        $today = date("Y-m-d", time()); // 今日
        $lastDay = strtotime(date('Y-m-01')) + (60*60*24*(date('t')-1)); // 获取本月的最后一天

        $members = array(); // 用于存储每天的新增会员数量
        $ttl = strtotime(date("Y-m-d", time() + 86400)) -  time(); // 到第二天0点过期
        for($i = $firstDay; $i <= $lastDay; $i = strtotime('+1 day', $i)){
            $date = date("Y-m-d", $i);
            if($date == $today){  // 是今天的数据，缓存时间设置为60s (正在进行中，数据更新频繁)
                $ttl = 60;
            }elseif($date < $today){  // 是过去的数据，缓存时间设置为60天（过去的时间，不会更新数据）
                $ttl = 86400 * 60;
            }else{
                $ttl = strtotime(date("Y-m-d", time() + 86400)) -  time(); // 到第二天0点过期
            }
            $members[date('l, Y-m-d', $i)] = Cache::remember("count_month_users_number:{$date}", $ttl, function() use($date){
                return $this->eloquentClass::whereDate("created_at", $date)->count();
            });
        }
        return $members;
    }

    public function 获取前一月新增会员数量(){
        $date = date("Y-m-d", strtotime("last month"));
        $end_date = date("Y-m-t", strtotime("last month"));

        $members = array(); // 用于存储每天的新增会员数量
        $ttl = 30 * 86400;  // 因为是过去的时间，所以不会改变了，直接缓存最大天数
        while ($date <= $end_date) {
            // 获取当天数据并存储到结果中
            $members[date('l, Y-m-d', strtotime($date))] = Cache::remember("count_month_users_number:{$date}", $ttl, function() use($date){
                return $this->eloquentClass::whereDate("created_at", $date)->count();
            });
            // 下一天
            $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
        }
        return $members;
    }

    /**
     * 统计会员总数
     *
     * @return integer
     */
    public function count_users_number():int{
        return Cache::remember("count_users_number", 60, function(){
            return $this->eloquentClass::count();
        });
    }

    public function count_nologin_users_number():int{
        return Cache::remember("count_nologin_users_number", 60, function(){
            return $this->eloquentClass::loginStatus(0)->count();
        });
    }
    /**************************************end count***************************************** */

}