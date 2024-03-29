<div class="my-3">
    <label for="" class="fw-bold">{{$label}}</label>
    <select name="{{$name}}" id="{{$name}}" class="form-control" {{$onchange ?? ""}} {{$onclick ?? ""}} {{$disabled ?? ""}}>
        <option value="0">{{$placeholder ?? "-"}}</option>
        @foreach($datas as $data)
            @if(is_null($selected))
               <option value="{{$data->id}}">{{$data->name}}</option>
            @else
                <option value="{{$data->id}}" {{$selected === $data->id ? "selected" : ""}}>{{$data->name}}</option>
            @endif
        @endforeach
    </select>
</div>
