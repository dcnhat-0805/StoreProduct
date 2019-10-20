@if (count($errors) > 0)
    <div class="flash-message">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                    onclick="this.parentElement.style.display='none';">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info', 'error'] as $msg)
        @if(Session::has('alert-' . $msg))
            <div class="alert alert-{{ $msg }}">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                        onclick="this.parentElement.style.display='none';">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul>
                    <li>
                        {!! Session::get('alert-' . $msg) !!}
                    </li>
                </ul>
            </div>
        @endif
    @endforeach
    @if(Session::has('alert-error-array'))
        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                    onclick="this.parentElement.style.display='none';">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul>
                @foreach(Session::get('alert-error-array') as $message)
                    <li>
                        {!! $message !!}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
