<link href="/sorani001/public/css/foo.css" rel="stylesheet" type="text/css"></link>
<body class="hoge">
  <div class="threads">
    <h1>{{ $title }}</h1>
    <p>{{ $body }}</p>
    <p>href="{{ mix('css/foo.css') }}"</p>
    <p>src="{{ mix('js/foo.js') }}"</p>
  </div>
</body>

<script src="/sorani001/public/js/foo.js"></script>
