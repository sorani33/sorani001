<form action="{{action('ContactController@confirm')}}" method="post">
{{ csrf_field() }}
名前：<input type="text" name="name">
<br>
email：<input type="text" name="email">
<br>印象はどうでしたか
<input name="impression" type="radio" value="良い">良い
<input name="impression" type="radio" value="普通">普通
<input name="impression" type="radio" value="悪い">悪い
<br>
その他：<textarea name="message"></textarea>
<br>
<input type="submit" value="送信">
</form>


作成参考元<br>
 https://www.webopixel.net/php/1316.html<br>
 https://liginc.co.jp/366540<br>
 https://www.ritolab.com/entry/38<br>
