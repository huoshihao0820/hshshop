<?php
/**
 * Created by PhpStorm.
 * User: 霍世豪
 * Date: 2020/3/31
 * Time: 16:00
 */

namespace App\Tools;
function create_qrcode($qr_path,$filename,$page='',$expires_in=7200){
    if(empty($qr_path)) return array('status'=>0,'info'=>'缺少存储路径');
    if(empty($filename)) return array('status'=>0,'info'=>'请确定存储的图片名称');
//    if(empty($scene)) return array('status'=>0,'info'=>'缺少二维码场景值');
    if(!is_dir('.'.$qr_path)){                              //  ./Public/Qrcode/
        mkdir(iconv("GBK","UTF-8",'.'.$qr_path),0777,true);
    }
    $file = $qr_path.$filename;                             //   /Public/Qrcode/aaa.png
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $fileUrl = $protocol.$_SERVER['HTTP_HOST'].$file;       //   http://yourhost/Public/Qrcode/aaa.png
    $savePath = '.'.$file;                                  //   ./Public/Qrcode/aaa.png
    if(file_exists($savePath)){
        //当前时间-文件创建时间<过期时间
        if( (time()-filemtime($savePath)) < $expires_in ) return array('status'=>1,'info'=>$fileUrl);
    }
    $accessToken = 'xxxxxxxxxxxxxxxxxxxxxx';                // 获取到的 access_token
    $url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token='.$accessToken;
    $qrcode = array(
//        'scene'         => $scene,
        'width'         => 200,
        'page'          => $page,
        'auto_color'    => true
    );
    $result = request($url,true,'POST',json_encode($qrcode));
    $errcode = json_decode($result,true)['errcode'];
    $errmsg = json_decode($result,true)['errmsg'];
    if($errcode) return array('status'=>0,'info'=>$errmsg);
    $res = file_put_contents($savePath,$result);            //  将获取到的二维码图片流保存成图片文件


    if($res===false) return array('status'=>0,'info'=>'生成二维码失败');

    return array('status'=>1,'info'=>$fileUrl);           //返回本地图片地址

}