<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 登录</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> 
    <link href="/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/css/font-awesome.css?v=4.4.0" rel="stylesheet">

    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/style.css?v=4.1.0" rel="stylesheet">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>
</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">h</h1>

        </div>
        <h3>欢迎使用 hAdmin</h3>

        <form class="m-t" method="post" role="form" action="/login/login_do">
            @csrf
            <div class="form-group">
                <input type="name" name="name" class="form-control" placeholder="用户名" required="">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="密码" required="">
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>


            <p class="text-muted text-center">
                <a href="login.html#"><small>忘记密码了？</small></a> | <a href="/login/register">注册一个新账号</a> | <a
                        href="/login/wechatout" class="noname-login">微信登录</a>
            </p>

        </form>
    </div>
</div>

<!-- 全局js -->
<script src="/js/jquery.min.js?v=2.1.4"></script>
<script src="/js/bootstrap.min.js?v=3.3.6"></script>
<script src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>
<script>
        $(document).on("click", ".noname-login", function () {//登录按钮触发事件
        $(".layer").removeClass("hide");
        var data = {};
        var html = template('login-box', data);
        var url = '{!!env("APP_URL")!!}logincallback/'+merchant.hash;
        var callbackUrl = encodeURIComponent(url);
        document.getElementById('layer-box').innerHTML = html;
        var timestamp = (new Date()).valueOf();
        var state = timestamp+Math.floor(Math.random()*100);
        var obj = new WxLogin({//之前的代码是点击按钮之后弹出登录弹框 然后实例化这个类 id表示放这个二维码的div的id
            id: "ewimg",
            appid: "{{env('WXOPEN_APP_ID')}}",
            scope: "snsapi_login",//扫码登录用这个参数 参数固定
            redirect_uri: callbackUrl,//扫码之后成功的回调
            state: state,//随机数
            style: "",
            href: ""
        });
    });
</script>




</body>

</html>
