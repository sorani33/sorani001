<form action="{{action('ContactController@process')}}" method="post">
{{ csrf_field() }}
{{$contact->name}}
<br>
{{$contact->email}}
<br>
{{$contact->impression}}
<br>
{{$contact->message}}
<br>

<input type="submit" value="Submit">

@foreach($contact->getAttributes() as $key => $value)
<input type="hidden" name="{{$key}}" value="{{$value}}">
@endforeach
</form>
