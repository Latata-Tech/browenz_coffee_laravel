<div class="my-3">
    <label for="">{{$label}}</label>
    <select name="{{$name}}" id="{{$name}}" class="form-control">
        <option>-</option>
        @foreach($datas as $data)
            @if(is_null($selected))
               <option value="{{$data->id}}">{{$data->name}}</option>
            @else
                <option value="{{$data->id}}" {{$selected === $data->id ? "selected" : ""}}>{{$data->name}}</option>
            @endif
        @endforeach
    </select>
</div>
