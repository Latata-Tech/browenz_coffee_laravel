<div class="my-3">
    <label for="">{{$label}}</label>
    <select name="{{$name}}" id="{{$name}}" class="form-control">
        @foreach($datas as $data)
           <option value="{{$data->id}}">{{$data->name}}</option>
        @endforeach
    </select>
</div>
