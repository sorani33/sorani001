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
        <h1><small>確認画面</small></h1>
    </div>
    <form action="" method="post" class="form-horizontal">
        {{ csrf_field() }}
        <input type="hidden" name="name" value="{{$name}}">
        <input type="hidden" name="email" value="{{$email}}">
        <input type="hidden" name="tel" value="{{$tel}}">
        <div class="row">
            <label class="col-sm-4 control-label">お名前</label>
            <div class="col-sm-8">{{$name}}</div>
        </div>
        <div class="row">
            <label class="col-sm-4 control-label">メールアドレス</label>
            <div class="col-sm-8">{{$email}}</div>
        </div>
        <div class="row">
            <label class="col-sm-4 control-label">電話番号</label>
            <div class="col-sm-8">{{$tel}}</div>
        </div>
        <div class="row" style="margin-top: 30px;">
            <div class="col-sm-offset-4 col-sm-8">
            <input type="submit" name="button1" value="登録" class="btn btn-primary btn-wide" />
            </div>
        </div>
    </form>

<!-- ここまで -->
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>
