<?php
namespace App\Api\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * 验证类的基类
 *  修改了验证不通过后的提示方式，改为了api接口自定义的返回形式（为了验证的报错信息与接口逻辑代码执行时的报错信息格式统一）
 *
 * 使用验证类的整体思想逻辑：
 *  建议验证的类型：
 *      判断参数是否上传、
 *      参数的格式验证、
 *      参数是某行数据的标识，但是仅用于验证其他字段的合法性，在后续逻辑中没有使用（为了防止验证时查询了一次数据，进行业务逻辑处理时还要查询一遍数据）
 *  不建议验证的类型：
 *      参数是某行数据的标识，验证此行数据是否存在或是否归属于此用户这种需要数据查询的验证。（因为后续的业务逻辑也需要查询数据，重复查询增加了数据库的负载）
 *  总结：验证类只验证基本的验证规则，对于业务逻辑中的验证，还是交给后续的业务逻辑中验证
 *
 * Requests 目录的规则
 *  BaseRequest 和 PageRequest 作为基础类存放在目录下；
 *  其他验证类必须在 Controller 同名目录下，作为控制器方法的一对一验证。
 *  比如现在有 ToolsController 控制器，并且其内定义了 send_sms() 方法，那么我们需要在 Requests 目录下创建 Tools 目录，并在其目录下创建 SendSmsRequest 验证类并定义验证。
 *
 * Rule 目录的规则
 *  一个验证规则类中尽量只验证一种规则。
 *  验证规则类无需存放在子目录下，全部定义在 Rule 目录下。
 *  类名规则定义：
 *      如果判断某参数对应的数据是否存在, 当数据存在则不能通过验证时，那么文件名为 <参数名> + ExistVerify。如注册时要判断账号是否已存在
 *      如果判断某参数对应的数据是否存在，当数据不存在则不能通过验证时，<参数名> + NoExistVerify。如登录时要判断账号是否不存在
 *      如果判断某参数是否正确，当不正确时不能通过验证，<参数名> + EnterVerify。如果验证码、密码等
 *      如果判断某参数是否符合输入规则(一般是正则)，当不符合规则时不能通过验证，<参数名> + RuleVerify。如手机号规则等
 */
class BaseRequest extends FormRequest{
    /**
    * validate验证失败模板
    * @param Validator $validator
    */
    protected function failedValidation(Validator $validator){
        $message = "";
        foreach(json_decode(json_encode($validator->errors()), 1) as $error){
            $message = $error[0];
            break;
        }
        throw (new HttpResponseException(error($message)));
    }
}