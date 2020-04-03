<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="/js/jquery-3.2.1.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>
<form action="">
    图书名称:<input type="text" name="s_name">
    <select name="key" id="key">
        <option value="0">--请选择--</option>
        <option value="is_show">是否展示</option>
    </select>
    <select name="keyval" id="keyval">
        <option value="">--请选择--</option>
        <option value="0">展示</option>
        <option value="1">不展示</option>
    </select>

    <input type="submit" value="搜索">
</form>
<script>
    $('#key').change(function () {
        var _this=$(this).val();
        console.log($(this));
        if(_this==s_type){
            $('#keyval').val()
        }
    })
</script>
<table border="1">
    <tr>
        <td><input type="checkbox" class="allbox"></td>
        <td>图书名称</td>
        <td>图书网址</td>
        <td>状态</td>
        <td>管理</td>
    </tr>
    @foreach($BrandInfo as $v)
        <tr s_id="{{ $v->s_id }}">
            <td><input type="checkbox" class="box">
                <span><?php if ($v->tp>5){ echo '高';}else{ echo '';}?></span>
            </td>
            <td>{{ $v->s_name }}</td>
            <td>{{ $v->s_wang }}</td>
            <td>@if($v->is_show==0)展示@else不展示@endif</td>
            <td>
                 <button class="mybut">投票</button>
            </td>
        </tr>
    @endforeach
</table>
{{ $BrandInfo->appends($query)->links() }}

</body>
</html>
<script>
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    $('.mybut').click(function () {
        var s_id=$(this).parents('tr').attr('s_id')
        $.ajax({
            method:"POST",
            url:"/brand/tp",
            data:{s_id:s_id},
        }).done(function (msg) {
            if (msg==1){
                location.reload()
                alert('投票成功')
            }else{
                alert('投票失败')
            }
        })
    });

</script>
