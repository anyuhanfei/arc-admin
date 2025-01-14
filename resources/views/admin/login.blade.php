
<style>
	/* [v-cloak] {
        display: none !important;
    } */
    *{
        padding: 0;
        margin: 0;
    }
    div{
        box-sizing: border-box;
    }
    img{
        vertical-align: top;
    }

    #appp{
        display: flex;
        min-width: 1080px;
        min-height: 608rpx;
        background-color: white;
    }

    #appp .left-box{
        position: relative;
        flex-grow: 1;
        max-width: 1350px;
        /* width: 80%; */
        /* width: calc(100% - 401px); */
        height: 100vh;
        overflow: hidden;
        background-color: #6679FF;
        background-image: url("/static/admin_login/bg.png");
        background-position: center center;
        background-size: 769px auto;
        background-repeat: no-repeat;
    }

    #appp .left-box .bg-mask{
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.1);
    }

    /* #app .left-box .bg{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate( -50%, -50%);
        width: 100%;
        height: 100%;
        object-fit: contain;
    } */


    #appp .right-box{
        min-width: 534px;
        /* background-color: wheat; */
        flex-shrink: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    #appp .right-box .form-box{
        padding:10px 117px;
    }

    .form-box .form-tips{
        width: 184px;
        height: 29px;
    }
    .form-box .title{
        padding-top: 88px;
        padding-bottom: 34px;
        font-size: 22px;
    }
    .form-box .form-item{
        width: 340px;
        height: 45px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
    }
    .form-box .form-item .borderr{
        height: 100%;
        flex-grow: 1;
        border: 1px solid #E5E5E5;
        padding: 0 22px;
        display: flex;
        align-items: center;
    }
    .form-box .form-item input{
        flex-grow: 1;
        border: 0;
        outline: none;
    }

    .form-box .item-lable{
        display: flex;
        align-items: center;
    }
    .form-box .item-lable .icon{
        width: 18px;
        height: 18px;
        margin-right: 20px;
    }

    .form-box .form-item .code-img{
        width: 90px;
        flex-shrink: 0;
        margin-left: 10px;
        padding: 0;
        height: 45px
    }
    .form-box .form-item .code-img .img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* background-color: wheat; */
    }

    .form-box .submit-btn{
        width: 100%;
        height: 45px;
        font-size: 17px;
        background-color: #4861FF;
        color: white;
        border: 0;
        cursor: pointer;
    }

    #appp .right-box .page-name{
        position: absolute;
        bottom: 38px;
        left: 50%;
        transform: translateX(-50%);
        color: #BFBFBF;
    }
</style>
<link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">

    <div id="appp" v-cloak>
        <div class="left-box">
            <!-- <img class="bg" src="./image/bg.png" alt="" /> -->
            <div class="bg-mask"></div>
        </div>
        <div class="right-box">
            <form class="form-box" id="login-form1" method="POST" action="{{ admin_url('auth/login') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <img class="form-tips" src="/static/admin_login/form-tips.png" alt="" />
                <div class="title">
                    {{ $app_name }}
                </div>
                <div class="form-item ">
                    <div class="borderr">
                        <div class="item-lable">
                            <img class="icon" src="/static/admin_login/form-item-icon1.png" alt="">
                        </div>
                        <input name="username" type="text" placeholder="请输入用户名" value="{{ old('username') }}" required autofocus/>
                    </div>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-item ">
                    <div class="borderr">
                        <div class="item-lable">
                            <img class="icon" src="/static/admin_login/form-item-icon2.png" alt="">
                        </div>
                        <input type="password" placeholder="请输入密码" name="password" required autocomplete="current-password"/>
                    </div>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-item ">
                    <div class="borderr">
                        <div class="item-lable">
                            <img class="icon" src="/static/admin_login/form-item-icon3.png" alt="">
                        </div>
                        <input type="text" placeholder="请输入验证码" name="captcha" required/>
                    </div>
                    <div class="border code-img">
                        <img id="captcha-img" class="img" src="/admin/captcha/image?_token={{ csrf_token() }}" width="100" height="30" onclick="this.src = '/admin/captcha/image?_token={{ csrf_token() }}&r=' + Math.random();"/>
                    </div>
                </div>
                <div style="display: flex;align-items: center; margin-bottom: 60px;">
                    <input style="cursor: pointer;" id="remember" name="remember"  value="1" type="checkbox" {{ old('remember') ? 'checked' : '' }} placeholder="请输入密码">
                    <div style="padding-left: 10px;font-size: 14px;">保持登录</div>
                </div>

                @if($errors->has('username'))
                    <div>
                        <span class="text-danger">
                            @foreach($errors->get('username') as $message)
                                <span class="control-label" for="inputError"><i class="feather icon-x-circle"></i> {{$message}}</span><br>
                            @endforeach
                        </span>
                    </div>
                @endif
                @if($errors->has('password'))
                    <div>
                        <span class="text-danger">
                            @foreach($errors->get('password') as $message)
                                <span class="control-label" for="inputError"><i class="feather icon-x-circle"></i> {{$message}}</span><br>
                            @endforeach
                        </span>
                    </div>
                @endif

                <div id="error_text">
                    <!-- <span class=" text-danger">
                        <span class="control-label" for="inputError"><i class="feather icon-x-circle"></i> xxxxsx</span><br>
                    </span> -->
                </div>
                <button type="submit" class="submit-btn">{{ __('admin.login') }}</button>
            </form>

            <div class="page-name">
                后台管理系统
            </div>
        </div>
    </div>
<script src="https://unpkg.com/vue@2/dist/vue.js"></script>
<!-- 引入组件库 -->
<script src="https://unpkg.com/element-ui/lib/index.js"></script>
<script type="text/javascript">
    const app = new Vue({
        el: '#appp',
        data: function() {
            return {}
        }
    })

    Dcat.ready(function () {
        // ajax表单提交
        $('#login-form').form({
            validate: true,
        });

        $('#login-form1').form({
            validate: true,
            error:function(data){
                // console.log(data.responseJSON.errors)
                $("#error_text").html('');
                for(let key in data.responseJSON.errors){
                    $("#error_text").append('<span class=" text-danger"><span class="control-label" for="inputError"><i class="feather icon-x-circle"></i>' + data.responseJSON.errors[key] + '</span><br></span>')
                    // console.log(key + " -> " + data.responseJSON.errors[key]);
                }
                reloadCaptcha()
            }
        });
    });

</script>