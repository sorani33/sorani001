<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/css/sticky-footer.css" rel="stylesheet" media="screen">
</head>

<body>
    <div class="container">
<!-- ここから -->
       <div class="page-header" style="margin-top:-30px;padding-bottom:0px;">
         <h1><small>受講生一覧</small></h1>
         <a href="new" class="btn btn-primary btn-sm">新規追加</a>
       </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th><th>name</th><th>email</th><th>tel</th><th>opration</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{$student->id}}</td>
                    <td>{{$student->name}}</td>
                    <td>{{$student->email}}</td>
                    <td>{{$student->tel}}</td>
                    <td>
                        <a href="edit/{{$student->id}}" class="btn btn-primary btn-sm">編集</a>
                    </td>
                    <td>
                        <form action="/student/delete/{{$student->id}}" method="POST">
                        {{ csrf_field() }}
                        <input type="submit" value="削除" class="btn btn-danger btn-sm btn-dell">
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
     <!-- page control -->
     {!! $students->render() !!}

     <!-- ここまで -->
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<script>
    $(function(){
    $(".btn-danger").click(function(){
        if(confirm("本当に削除しますか？")){
            //そのままsubmit（削除）
        }else{
            //cancel
            return false;
            }
        });
    });
</script>

</body>
</html>
