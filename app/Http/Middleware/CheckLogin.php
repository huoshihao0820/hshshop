<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $session = request()->session()->get('info');
        // dd($session);
        if (empty($session)) {
            echo "<script>alert('请登录');location='/login/login'</script>";
        }
        return $next($request);
    }
}
