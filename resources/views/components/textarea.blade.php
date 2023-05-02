<div>
    <label for="" class="form-label fw-bold">{{$label}}</label>
    <textarea name="{{$name}}" id="{{$name}}" class="form-control" placeholder="{{$placeholder ?? ""}}">{{$value ?? old($name)}}</textarea>
</div>
