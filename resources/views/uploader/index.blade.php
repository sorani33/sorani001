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
            <h1><small>画像の新規登録</small></h1>
        </div>
        <p><span class="label label-danger">入力画面</span> -> 確認画面 -> 完了画面</p>
        <form action="/uploader/confirm" method="post" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group @if($errors->has('name')) has-error @endif">
                <label for="name" class="col-md-3 control-label">お名前</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="username" name="username">
                    @if($errors->has('username'))<span class="text-danger">{{ $errors->first('username') }}</span> @endif
                </div>
            </div>
            <div class="form-group ">
                <label class="col-sm-4 control-label" for="thum">サムネイル画像<br>（150×150）<br>PNG／JPG／GIF 可：</label>
                <div class="col-sm-8">
                    <input type="file" id="thum" name="thum" size="50" />
                </div>
            </div>

            <div class="col-sm-offset-2 col-sm-10 text-center"><button class="btn btn-primary btn-wide">確認</button></div>
        </form>
        <br>




        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th><th>name</th><th>opration</th>
                </tr>
            </thead>
            <tbody>
                @foreach($uploaders as $uploader)
                <tr>
                    <td>{{$uploader->id}}</td>
                    <td>{{$uploader->username}}</td>
                    <td><img src="/img/{{$uploader->id}}/thum.jpeg" width="150"></td>
                </tr>
                @endforeach
            </tbody>
        </table>

<!-- ここまで -->
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>
