<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/css/sticky-footer.css" rel="stylesheet" media="screen">
</head>

@if(Session::has('flashmessage'))
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
<script>
  $(window).load(function() {
  $('#modal_box').modal('show');
  });
</script>
<!-- モーダルウィンドウの中身 -->
<div class="modal fade" id="modal_box" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">受講生 APP</h4>
            </div>
            <div class="modal-body">
                {{ session('flashmessage') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
            </div>
        </div>
    </div>
</div>
@endif


<body>
    <div class="container">
<!-- ここから -->
       <div class="page-header" style="margin-top:-30px;padding-bottom:0px;">
         <h1><small>受講生一覧</small></h1>
         <div class="row" style="margin-bottom: 30px;">
          <div class="col-sm-10" style="margin-bottom: 10px;">
              <form method="get" action="" class="form-inline">
              <div class="form-group">
                 <input type="text" name="keyword" class="form-control" value="{{$keyword}}" placeholder="検索キーワード">
              </div>
              <input type="submit" value="検索" class="btn btn-info">
              </form>
          </div>
          <div class="col-sm-2">
              <a href="/student/new" class="btn btn-warning"><i class="glyphicon glyphicon-plus"></i> 新規登録</a>
          </div>
         </div>

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
     {!! $students->appends(['keyword'=>$keyword])->render()!!}
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
