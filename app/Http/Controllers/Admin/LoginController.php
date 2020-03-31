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
        if ($request->password == $request->password1){
            unset($data['password1']);
        }else{
            echo "<script>alert('密码不一致');location='/login/register'</script>";
        }
//        dd($data);
        $data['password']=md5($data['password']);
        $res=RegisterModel::insert($data);
        if ($res){
            echo "<script>alert('注册成功');location='/login/login'</script>";
        }else{
            echo "<script>alert('注册失败');location='/login/register'</script>";

        }
    }
    public function wechat(){
            $code = $_GET['code'] ;
            $id = "wx67c8029efcf27af9";
            $secret = "94fc0954d8548a02bf0b7dc8e0b36453";
            $tokenurl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$id&secret=$secret&code=$code&grant_type=authorization_code";
            $res = file_get_contents ( $tokenurl);
            $token = json_decode( $res, true) ['access_token'];
            $openid = json_decode( $res, true) ['openid'];
            $userurl = "https://api.weixin.qq.com/sns/userinfo?access_token=$token&openid=$openid&Lang=zh_CN";
            $userinfo = file_get_contents($userurl);
            $user = json_decode ( $userinfo, true);
            print_r($user);
            echo "<img src=".$user['headimgurl']." /> ";


        $uid = $_GET['uid'];
        $id = "wx67 c8029efcf27af9" ;
        $url = urlencode("http://zhiboba.aulei521.com/login.php");

        header("location:$url");
    }
    public function wechatout(){
        $app_id = 'wx7c92fdcfe8f861ab';
        $app_secret = 'edee5f9219b0b3597977fc2adece249a';

            $url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$app_id.'&secret='.$app_secret.'&code='.$_GET['code'].'&grant_type=authorization_code';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_URL, $url);
            $json =  curl_exec($ch);
            curl_close($ch);
            $arr=json_decode($json,1);
            //用获取到的access_token调用接口

//拼接URL的参数也不需要赘述了
         $url='https://api.weixin.qq.com/sns/userinfo?access_token='.$arr['access_token'].'&openid='.$arr['openid'].'&lang=zh_CN';
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
         curl_setopt($ch, CURLOPT_URL, $url);
         $json =  curl_exec($ch);
         curl_close($ch);
         $userinfo=json_decode($json,1);
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
