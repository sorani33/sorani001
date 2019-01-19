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
        <h1><small>画像の確認</small></h1>
    </div>
    <p>入力画面 -> <span class="label label-danger">確認画面</span> -> 完了画面</p>
    <form action="/uploader/finish" method="post" class="form-horizontal">
        {{ csrf_field() }}
        <input type="hidden" name="username" value="{{ $username }}">
        <input type="hidden" name="thum" value="{{ $thum }}">
        <div class="form-group @if($errors->has('name')) has-error @endif">
            <label for="name" class="col-md-3 control-label">お名前</label>
            <div class="col-sm-9">
                {{$username}}
                @if($errors->has('name'))<span class="text-danger">{{ $errors->first('name') }}</span> @endif
            </div>
        </div>
        <div class="form-group ">
            <label class="col-sm-4 control-label" for="thum">サムネイル画像<br>（150×150）<br>PNG／JPG／GIF 可：</label>
            <div class="col-sm-8">
                <img src="{{ $thum }}" width="150">
            </div>
        </div>
        <div class="col-md-offset-3 text-center"><button class="btn btn-primary">確認</button></div>
    </form>

<!-- ここまで -->
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>
