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
        <h1><small>新規登録</small></h1>
    </div>
    <form action="" method="post" class="form-horizontal">
        {{ csrf_field() }}
        {{ method_field('patch') }}
        <div class="form-group @if($errors->has('name')) has-error @endif">
            <label for="name" class="col-md-3 control-label">お名前</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="name" name="name">
                @if($errors->has('name'))<span class="text-danger">{{ $errors->first('name') }}</span> @endif
            </div>
        </div>
        <div class="form-group @if($errors->has('email')) has-error @endif">
            <label for="email" class="col-md-3 control-label">メールアドレス</label>
            <div class="col-sm-9">
            <input type="email" class="form-control" id="email" name="email">
            @if($errors->has('email'))<span class="text-danger">{{ $errors->first('email') }}</span> @endif
            </div>
        </div>
        <div class="form-group @if($errors->has('tel')) has-error @endif">
            <label for="tel" class="col-md-3 control-label">電話番号</label>
            <div class="col-md-9">
            <input type="tel" class="form-control" id="tel" name="tel">
            @if($errors->has('tel'))<span class="text-danger">{{ $errors->first('tel') }}</span> @endif
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
