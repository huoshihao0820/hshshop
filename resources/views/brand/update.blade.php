<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>修改</title>
    <script src="/css/bootstrap.min.css"></script>
    <script src="/js/jquery-3.2.1.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<form action="{{ url('brand/update_do/'.$data->s_id) }}" id="myform" method="post" enctype="multipart/form-data">
    @csrf
    <table>
        <tr>
            <td>图书名称</td>
            <td><input type="text" name="s_name" id="s_name" value="{{ $data->s_name }}"></td>
        </tr>
        <tr>
            <td>图书网址</td>
            <td><input type="text" name="s_wang" id="s_wang" value=" {{$data->s_wang }}"></td>
        </tr>
        <tr>
            <td>图书联系人</td>
            <td><input type="text" name="s_ren" id="s_ren" value="{{ $data->s_ren }}"></td>
        </tr>
        <tr>
            <td>图书介绍</td>
            <td><textarea name="s_text" id="" cols="30" rows="10">{{ $data->s_text }}</textarea></td>
        </tr>
        <tr>
            <td>是否显示</td>
            <td>
                @if($data->is_show==0)
                    <input type="radio" value="0" name="is_show" checked>是
                    <input type="radio" value="1" name="is_show">否
                @else
                    <input type="radio" value="0" name="is_show" >是
                    <input type="radio" value="1" name="is_show" checked>否
                @endif
            </td>
        </tr>
        <tr>
            <td></td>
            <td><input type="button" id="but" value="修改"></td>
        </tr>
    </table>
</form>
</body>
</html>
<script>
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    $('#s_name').blur(function () {
        forminfo($(this),/^[\u4e00-\u9fa5a-zA-Z0-9_]{2,12}$/,'格式不对请输入由中文字母下划线2至12位组成')

        var name=$(this).val();
        var obj=$(this);

        var id={{ $data->s_id }};
//        console.log(name);
        $.ajax({
            method:"POST",
            url:"/brand/checkname",
            data:{name:name,id:id},
            async:false
        }).done(function (msg) {
            if (msg>0){

                obj.after('<p style="color: red">名称已存在</p>')

            }
        })

    })
    $('#s_wang').blur(function () {
        forminfo($(this),/^http:\/\/+\w+\.+[0-9a-zA-Z]+\@+[0-9a-zA-Z]+\.(com|con|cn)$/,'邮箱格式不对请输入http://www.***@**.com|con|cn');
    })
    $('#s_ren').blur(function () {
        if ($(this)==''){
            $('#s_ren').after('<p style="color:red">不能为空</p>')
            return;
        }
        forminfo($(this),/^[\u4e00-\u9fa5]{0,}$/,'必须是中文')
    })

    $('#but').click(function () {
        event.preventDefault()
        var xxoo=true;
        var xo=1;
        var name=$('#s_name').val();
        var obj=$('#s_name');
        forminfo($('#s_name'),/^[\u4e00-\u9fa5a-zA-Z0-9_]{2,12}$/,'格式不对请输入由中文字母下划线2至12位组成')
//        console.log(name);
        var id={{ $data->s_id }};
        $.ajax({
            method:"POST",
            url:"/brand/checkname",
            data:{name:name,id:id},
            async:false
        }).done(function (msg) {
//            alert(msg);
            if (msg>0){
                obj.after('<p style="color: red">名称已存在</p>');
                xxoo=2;
            }else{
                xxoo=1;
            }

        })
//        alert(33);
        if(xxoo==2) {
            return false;
        }
//        alert(11);
        var xo=forminfo($('#s_wang'),/^http:\/\/+\w+\.+[0-9a-zA-Z]+\@+[0-9a-zA-Z]+\.(com|con|cn)$/,'邮箱格式不对请输入http://www.***@**.com|con|cn');
        if (xo=='no'){
//            alert(12);
            return false;
        }else{
            var xo=forminfo($('#s_ren'),/^[\u4e00-\u9fa5]{2,12}$/,'必须是中文');
            console.log(xo);
            if (xo=='no'){
//                alert(123);
                return false;
            }else{

            $('#myform').submit();
            }
        }




    })


    //封装
    function forminfo(obj,reg,content) {
        obj.nextAll().remove();
        var value=obj.val();
        if (!reg.test(value)){
            obj.after('<p style="color:red">'+content+'</p>')
            return 'no';
        }else {
            return 'ok';
        }
    }

    //提交封装
    function forminfoto(obj,reg,content) {
        obj.next().remove();
        var value=obj.val();
        if (!reg.test(value)){
            obj.after('<p style="color:red">'+content+'</p>')
            return 2;
        }
    }
</script>