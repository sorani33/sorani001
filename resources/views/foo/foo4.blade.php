<link href="{{ mix('css/foo.css') }}" rel="stylesheet" type="text/css"></link>
<body class="hoge">
  <div class="threads">
    <h1>{{ $title }}</h1>
    <p>{{ $body }}</p>
    <p>href="{{ mix('css/foo.css') }}"</p>
    <p>src="{{ mix('js/foo.js') }}"</p>
  </div>

  <div id="app">
    <comp-child v-for="item in list"
      v-bind:key="item.id"
      v-bind:name="item.name"
      v-bind:hp="item.hp"
    >
    </comp-child>
    <comp-child2 v-on:childs-event="parentsMethods"></comp-child2>
  </div>
</body>

<script src="{{ mix('js/foo.js') }}"></script>
