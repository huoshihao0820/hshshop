<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="/index/insert" method="post">
    @csrf
    <dl class="admin_login">
        <dt>
            <strong><h1 style="color: #0f0f0f">》》》》先关注测试号《《《《</h1>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="{{url('/ceshi.png')}}">
            </strong>
            <strong><h1 style="color: #0f0f0f">》》》》请扫码登录《《《《</h1>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="{{url('/2.png')}}">
            </strong>
        <h2 style="color: red"><a href="/login/login"><h1 style="color:darkred">点击去登录</h1></a></h2>
        </dt>

    </dl>
</form>
</body>
</html>