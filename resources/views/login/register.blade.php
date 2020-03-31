<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 注册</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="favicon.ico"> <link href="/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/style.css?v=4.1.0" rel="stylesheet">
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>

</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen   animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">H+</h1>

        </div>
        <h3>欢迎注册 H+</h3>
        <p>创建一个H+新账户</p>
        <form class="m-t" role="form" method="post" action="/login/register_do">
            @csrf
            <div class="form-group">
                <input type="tel" id="tel" name="name" class="form-control" placeholder="请输入用户名" required="">
            </div>
            <div class="form-group">
                <input type="tel" id="tel_code" name="code" class="form-control" placeholder="验证码" required="">
                <a href="javascript:;" id="sendTelCode" class="btn">
                    <span id="span_tel" class="dyButton">获取</span>
                </a>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="请输入密码" required="">
            </div>
            <div class="form-group">
                <input type="password" name="password1" class="form-control" placeholder="请再次输入密码" required="">
            </div>
            <button type="submit" class=" btn-primary block full-width m-b">注 册</button>

            <p class="text-muted text-center"><small>已经有账户了？</small><a href="/login/login">点此登录</a>
            </p>

        </form>
    </div>
</div>

<!-- 全局js -->
<script src="/js/jquery.min.js?v=2.1.4"></script>
<script src="/js/bootstrap.min.js?v=3.3.6"></script>
<!-- iCheck -->
<script src="/js/plugins/iCheck/icheck.min.js"></script>
<script>
    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
    $(function () {
        var second = 60;// 设置倒计时秒数
        var _time;//设置全局变里放定时器(方便清除定时器)
        //给获取的获取绑定一个点击事件
        $('.btn').click(function () {
            var _this = $(this);
            //获取手机号或邮箱的值
            var _value = _this.parent('div').prev('div').find('input').val();
            if (_value == '') {
                alert('手机号或邮箱不能为空');
            }
                $.ajax({
                    type: "post",
                    url: "/login/send",
                    data: {value:_value,'_token':'{{csrf_token()}}'},
                    dataType:'json',
                    succcess: function (msg) {
                        if (msg.code == 1) {
                            //如果发送成功将获取改为60s
                            _this.find('span').text(second + 's');
                            _time = setInterval(secondTelTime, 1000);
                        }
                    },
                });

        });
        //手机号发送秒数倒计时
        function secondTelTime() {
            //获取span_tel
            var second = parseInt($('#span_tel').text());
            if (second == 0) {
                $('#span_tel').text('获取');
                clearInterval(_time);
                $('#span_te1').parent('a').css('pointer-events', 'auto');
            } else {
                second = second - 1;
                $('#span_tel').text(second + 's');
                $('#span_te1').parent('a').css('pointer-events', 'none');
            }
        }
    });


</script>




</body>

</html>































