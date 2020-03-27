<?php
namespace App\Http\Controllers;
use App\Http\Controllers;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Log;
use Yansongda\Pay\Pay;
use Yansongda\Pay\Log;
use App\models\OrderModel;

class AlipayController extends Controller{
    protected $config = [
        'app_id' => '2016100100643043',//你创建应用的APPID
        'notify_url' => 'http://www.1904.com/index/index',//异步回调地址
        'return_url' => 'http://www.1904.com/index/index',//同步回调地址
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAkbOHGyo58nVFEB0MzEsaYj9aW15To8HGB0q0ENjSEhaZ7cTELbrBgmQtDJ6kksida4d6+zyDcTtsC612hbNfEAaSf/DAxUy+UOP4fLCQl0Jfhbip+yzaQZjRGdBMJb5sJB/4qXomGTd+MRauXusZNB9IUn/PyOTTqOqD78TqtoeUNAVwVyA4Ycz5q++RRUsKjgglDlBLpDL2ezg0umDBEfEteaekM/Dc8mwIymy5FhEnLk8i40kStkesfeCc3x2lanplWsLSIVneLDolXmsdsdsNnC25agF0XcJ1Whiu3s8EV/LOCxKBMoEGupnsB5PYhTmGX/NDmXauGNb8JRplfwIDAQAB',//是支付宝公钥，不是应用公钥,  公钥要写成一行,不要换行
        // 加密方式： **RSA2**
        //密钥,密钥要写成一行,不要换行
        'private_key' => 'MIIEpAIBAAKCAQEAu14ipA4AUhP1CObhHYn7dcn9ASOuEpO3xOfaeJWukjVRzN+wwIF+32Kmv8t4QznDr0YuzOxto6K/damqzfeKTI1QLyLrvUGAA2ZhnuiYICLJiOg6KYRQYIUUDCKmx3u4K8lnIUWXA+XkVOwcOjculT/q4+Swh0mkh6gcHCLmAfYU5wFbpDLTyzhX/J7d8cqKqI3LDORDRPFm7t/7RMARqPj6/l2Jd0WDFnqhHr3Ku4sS1zKyYyJvWwPQjGt2AmABWmuq6QwDTv31L2TUP2VLVafjpN79SvcKXckmhKiZqMrrWAyRG7GntMFDpBbH4r3C/UPmFWolxCWcXGS6KRSg3QIDAQABAoIBAGvv7NDJaBHggVZheunDZWMTu3Z+kXcONd1vG4I/6FM9+COn8XDUqLwTXrA6jMtdaYd9TNSslvSfeuBTn5wLsFYtSjX9TgS2yQIsZqxendRVdfgyn97u5EbWIxhileVxNkWzPoACUN7j/seVRSWcSG+eZLhoM/Gb0PZ9N8RVrl8N4TyOayiIdiXAO9R7Izrs+V0Ahw6ZcC4OPSeU7dnPrWXrsgLgO5GW9e4N9ZlRL7YbjdBe+OQRmHoIC1cYR/HRhSCZaUeIgM0k7aULAUlEHOxEvO8fi+41WcvADlSlojjTHIoiW680x0yMidhKmBm9wCI9ZJw+Yi2jIBPfv9TMiBkCgYEA60jZZLBW9IpiyiTvxBCD8Lt7BaXpspraYqu/kvM21jsEa1kWTv5dcvFX8JKP5cgGyZAc74nk1kMyFcfXLbN3GP8aqiveGkowPpPlfs/b8GMZkI4WmHL6saiZGsIiE9na+NP7j005Yj/vZ2UJ+zwBL2Agnj4ifPgmD8qtdXPGg3MCgYEAy91GCEqPWoaQkdabJ3RgMJgf/j6MdEUmJJ8BSaofccXoWzMTTGpTBpPMQ8Mm9RuVE2zxfTsAg3AZ1xcQDQ62oPtaDJlPilk2R89ybz3Il1WLISScu31YfykgMShb3a8BKUFPjccI9I2ZAglX9FfukKhQ0HYzO6B4eo2DVHaDVm8CgYB2YF+oDiShwmJzy+OqJJkNbHY34ELVLp4DmN+5Ao8rd+QAUoEr20SPCSgyjLrDZEEt9kjop9svhf1UAgicILgiJm93AL0tQvhE88o6ZEAHEQUSurpZlzfUXLwzP0s/65MFMDpX3gWqDfrYbXh5I7aA7H9cvmxBreQQe+uLtWVCSwKBgQCzXVrpnpgkILL/7V6TRxv+hUnYyrWO8uwNWmyqoGiMFIFMBFMdb4rfBZi5ofEbxInUDo0mDox0GGRTzzHLGz/pwVxIK3dFFRrh8Y4Qe76KD7Sak3jmqPD86HUvav/wurH91z2kUxL4/8A4f3oIPHlkgwKfdu+6rYRy5yE+ZgtGNwKBgQCkxwNZ2jLXLtFci/HrMNcJSuVggRJS9Vn3kDcCk7Y8SJhAeTJukv/tBM2KuJ0tXS7N6A006dVP322ICGSV8OsoRwVtXmwJzew1TqpTdE+20cM+dlW/WhaifDVAjliHkTNJrT4rQkBdf6owud2RiXBZQxInfpmv+V8y+NGYHFnqRg==',
        'log' => [ // optional
            'file' => './logs/alipay.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
    ];
    public function Alipay()
    {
//        $user = request()->session()->get('user');
        $total1=0;
        $user = request()->session()->get('user');
        $orderinfo=OrderModel::where('user_id','=',$user['id'])->get();
//        总价
        foreach ($orderinfo as $v){
            $total1+=$v['goods_price']*$v['number'];
            $dingdan=$v['dingdan'];
//        $res=OrderModel::where('user_id',$user['id'])->delete();
        }
        $order = [
            'out_trade_no' => $dingdan,
            'total_amount' => $total1,
            'subject' => '霍世豪- 测试',
        ];

        $alipay = Pay::alipay($this->config)->web($order);

        return $alipay;
    }

    public function AliPayReturn()
    {
        $data = Pay::alipay($this->config)->verify(); // 是的，验签就这么简单！

        // 订单号：$data->out_trade_no
        // 支付宝交易号：$data->trade_no
        // 订单总金额：$data->total_amount
    }

    public function AliPayNotify()
    {
        $alipay = Pay::alipay($this->config);

        try{
            $data = $alipay->verify(); // 是的，验签就这么简单！

            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况

            Log::debug('Alipay notify', $data->all());
        } catch (\Exception $e) {
            //$e->getMessage();
        }

        return $alipay->success();
    }
}
