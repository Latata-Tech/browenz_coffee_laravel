@if(session()->has('failed'))
    <div class="alert alert-danger">
        {{session()->get('failed')}}
    </div>
@endif
