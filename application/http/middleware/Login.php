<?php
/**
 * 判断登录中间件
 */
namespace app\http\middleware;

use think\facade\Session;

class Login
{
    public function handle($request, \Closure $next)
    {
        if( is_null(Session::get('admin'))){
            return redirect(url('[user.login]'));
        }else{
            $request->url = url('[admin.index]');
        }
        return $next($request);
    }
}
