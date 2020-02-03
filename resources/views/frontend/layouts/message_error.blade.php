@if (count($errors))
    @foreach($errors->get($name) as $message)
        <div class="error error_{{ $name }}" style="color: red">{{$message}}</div>
    @endforeach
@endif
