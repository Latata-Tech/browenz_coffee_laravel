<div class="my-3">
    <label for="" class="form-label fw-bold">{{$label}}</label>
    <input
            type="{{$type}}"
            name="{{$name}}"
            id="{{$name}}"
            class="form-control"
            value="{{$value ?? old($name)}}",
            placeholder="{{$placeholder ?? ""}}"
    >
</div>
