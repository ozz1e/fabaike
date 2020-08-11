<?php
/**
 * 判断用户是否有权限进行后台操作
 */
namespace app\http\middleware;

require "../extend/Auth.php";
use think\facade\Session;
use AuthRule\Auth as Authority;

class Auth
{
    public function handle($request, \Closure $next)
    {
        //鉴权规则
        $rule = strtolower($request->module()).'/'.strtolower($request->controller()).'/'.strtolower($request->action());
        $user = Session::get('admin');
        $access = new Authority();
        if( !$access->check($rule,$user['id']) ){
            return redirect('[auth.lost]');
        }
        return $next($request);
    }
}
