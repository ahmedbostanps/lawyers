<div style='display: flex;'>
    @foreach ($getmulti as $key => $value)
     <div title="{{$value->first_name .  ' ' . $value->last_name}}" data-letters="{{ ucfirst(substr($value->first_name, 0, 1)) }}"> </div>
    @endforeach
</div>
