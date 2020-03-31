<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recognition extends Model
{
    protected $autoWriteTimestamp = false;
    //生成登录用的临时二维码
    public function getLoginQrcode(){
        $appid   = config('THINK_SDK_WEIXIN.APP_KEY');
        $appsecret = config('THINK_SDK_WEIXIN.APP_SECRET');
        if(empty($appid) || empty($appsecret)){
            return(array('error_code'=>true,'msg'=>'请联系管理员配置【AppId】【 AppSecret】'));
        }

        $database_login_qrcode = model('LoginQrcode');
        $database_login_qrcode->where(array('add_time'=>array('lt',($_SERVER['REQUEST_TIME']-604800))))->delete();

        $data_login_qrcode['add_time'] = $_SERVER['REQUEST_TIME'];
        $database_login_qrcode->save($data_login_qrcode);
        $qrcode_id = $database_login_qrcode->getLastInsID();
        if(empty($qrcode_id)){
            return(array('error_code'=>true,'msg'=>'获取二维码错误！无法写入数据到数据库。请重试。'));
        }

        import('Net.Http');
        $http = new \Http();

        //微信授权获得access_token
        $access_token_array = model('AccessTokenExpires')->getAccessToken();
        if ($access_token_array['errcode']) {
            return(array('error_code'=>true,'msg'=>'获取access_token发生错误：错误代码' . $access_token_array['errcode'] .',微信返回错误信息：' . $access_token_array['errmsg']));
        }
        $access_token = $access_token_array['access_token'];

        $qrcode_url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token;
        $post_data['expire_seconds'] = 604800;
        $post_data['action_name'] = 'QR_SCENE';
        $post_data['action_info']['scene']['scene_id'] = $qrcode_id;

        $json = $http->curlPost($qrcode_url,json_encode($post_data));
        if (!$json['errcode']){
            $condition_login_qrcode['id']=$qrcode_id;
            $data_login_qrcode['id'] = $qrcode_id;
            $data_login_qrcode['ticket'] = $json['ticket'];
            if($database_login_qrcode->isUpdate(true)->save($data_login_qrcode)){
                return(array('error_code'=>false,'id'=>$qrcode_id,'ticket'=>'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($json['ticket'])));
            }else{
                $database_login_qrcode->where($condition_login_qrcode)->delete();
                return(array('error_code'=>true,'msg'=>'获取二维码错误！保存二维码失败。请重试。'));
            }
        }else{
            $condition_login_qrcode['id'] = $qrcode_id;
            $database_login_qrcode->where($condition_login_qrcode)->delete();
            return(array('error_code'=>true,'msg'=>'发生错误：错误代码 '.$json['errcode'].'，微信返回错误信息：'.$json['errmsg']));
        }
    }

}
