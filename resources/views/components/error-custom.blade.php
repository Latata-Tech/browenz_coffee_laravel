@if(session()->has($errorName))
    <div class="alert alert-danger" role="alert">
        {{session()->get($errorName)}}
    </div>
@endif
