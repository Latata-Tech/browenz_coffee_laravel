<div>
    <label for="" class="form-label">{{$label}}</label>
    <textarea name="{{$name}}" id="{{$name}}" class="form-control">{{$value ?? old($name)}}</textarea>
</div>
