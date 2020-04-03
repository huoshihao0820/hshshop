<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recognition;
use function App\Tools\create_qrcode;
use function App\Tools\sms\demo\sendSms;
use Illuminate\Http\Request;
use App\Models\LoginModel;
use App\Models\RegisterModel;
use phpqrcode;
use function Symfony\Component\Console\Tests\Command\createClosure;

class LoginController extends Controller
{
    public function login(){
        return view('/login/login');
    }
    public function login_do(Request $request){
        unset($request->_token);
        $password=md5($request->password);
//        dd($password);
        $where=['password'=>$password,'name'=>$request->name];
        $res=LoginModel::where($where)->first();
        if ($res) {
            $info = [
                'id' => $res['id'],
                'name' => $res['name'],
            ];
            request()->session()->put('info',$info);
            echo "<script>alert('登陆成功');location='/brand/show'</script>";
        }else{
            echo "<script>alert('账号或密码错误');location='/login/login'</script>";exit;
        }

    }
    public function register(){
        return view('login/register');
    }
    public function register_do(Request $request){
        $data = $request->all();
//        dd($data);
        unset($data['_token']);
        $where=['code'=>$request->code];
        $res=LoginModel::where($where)->first();
        if ($res) {

            if ($request->password == $request->password1) {
                unset($data['password1']);
            } else {
                echo "<script>alert('密码不一致');location='/login/register'</script>";
            }
//        dd($data);
            $data['password'] = md5($data['password']);
            $res = RegisterModel::insert($data);
            if ($res) {
                echo "<script>alert('注册成功');location='/login/login'</script>";
            } else {
                echo "<script>alert('注册失败');location='/login/register'</script>";

            }
        }else{
            echo "<script>alert('验证码不对');location='/login/register'</script>";die;
        }
    }
    public function wechat(){
        $uid = $_GET['uid'];
        session(['u_id' => $uid]);
        $appid = 'wx7c92fdcfe8f861ab';
        $uri = urlencode("http://hshshop.lqove.xyz/login/log");
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$uri&response_type=code&scope=snsapi_userinfo&state=$uid#wechat_redirect";
//        dd($url);
        return redirect($url);
//        $url = urlencode("http://zhiboba.aulei521.com/login.php");

    }
    public function wechatout(){
        $app_id = 'wx7c92fdcfe8f861ab';
        $app_secret = 'edee5f9219b0b3597977fc2adece249a';
        $url = public_path('phpqrcode.php');
        include($url);
        $obj = new phpqrcode\QRcode();
        $uid = uniqid();
//        echo $uid;die;
        $url = "http://hshshop.lqove.xyz/login/wechat?uid=".$uid;
//        dd($url);
        $obj->png($url,public_path('2.png'));

        return redirect('/login/img');

    }
    public function show(){
        echo $_GET['echostr'];
    }
    public function log(){
        $code = $_GET['code'];
//            dd($code);
        $id = "wx7c92fdcfe8f861ab";
        $u_id = session('u_id');
        $secret = "edee5f9219b0b3597977fc2adece249a";
        $tokenurl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$id&secret=$secret&code=$code&grant_type=authorization_code";
        $res = file_get_contents($tokenurl);
        $token = json_decode($res, true)['access_token'];
        $openid = json_decode($res, true)['openid'];
        session(['openid' => $openid]);
        $userurl = "https://api.weixin.qq.com/sns/userinfo?access_token=$token&openid=$openid&lang=zh_CN";
        $userinfo = file_get_contents($userurl);
        $user = json_decode($userinfo, true);
        echo '</br>';
        echo '微信昵称：' . $user['nickname'];
        echo '</br>';
        echo '微信头像：' . "<img src=" . $user['headimgurl'] . " />";
        echo '<hr>';
        $data=[
          'wname'=>$user['nickname']
        ];
        $where=['wname'=>$user['nickname']];
        $res=LoginModel::where($where)->first();
        if ($res){
            echo '<h2 style="color: red">您已经使我们的老客户了不需要绑定直接登录</h2>';
        }else{
            echo '你还没有绑定手机号<a href="/login/bd"><h2 style="color: red">点击去绑定</h2></a>';

        }

    }
    public function bd(){
        return view('login/bd');
    }
    public function img(){
        return view('/login/img');
    }
    public function send(Request $request){
        $str='8917489149162371694698782913';
        $value =$request->value;
//        dd($value);
        $sendCode=substr(str_shuffle($str),rand(0,15),6);
//        dd($sendCode);
        $res =sendSms($value,$sendCode);
        if ($res==1){
            $codeInfo=[
            'sendCode'=>$sendCode,
            'sendTime'=>time()
            ];
            session('codeInfo',$codeInfo);
            echo "<script>alert('发送成功');</script>";
        }else{
            echo "<script>alert('发送失败');</script>";

        }

    }

}
