<link href="{{ mix('css/foo.css') }}" rel="stylesheet" type="text/css"></link>
<body class="hoge">
  <div class="threads">
    <h1>{{ $title }}</h1>
    <p>{{ $body }}</p>
    <p>href="/sorani001/public/css/foo.css"</p>
    <p>src="/sorani001/public/js/foo.js"</p>
  </div>

  <div id="app">
    <my-component></my-component>
  </div>
</body>

<script src="{{ mix('js/foo.js') }}"></script>
