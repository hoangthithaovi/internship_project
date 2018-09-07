@extends('layouts.admin.admin')

@section('content')

<div class="container">
    <h1 style="color: #0099CC; text-align: center; margin-top: 10px;">Tạo mới loại sự kiện</h1>
    <form action="{{route('admin.type_events.store')}}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row form-group {{ $errors->has('name_type_event') ? 'has-error' : '' }} ">           
            <label>Tên loại sự kiện:</label>
            <input type="text" id="name_type_event" name="name_type_event" class="form-control" placeholder="Nhập loại sự kiện..." value="{{ old('name_type_event') }}">
            <span class="text-danger">{{ $errors->first('name_type_event') }}</span><br>
               
            <label for="description_typeEvent" style="margin-top: 20px;">Mô tả:</label>
            <input type="text" id="description_typeEvent" name="description_typeEvent" class="form-control" placeholder="Nhập mô tả..." value="{{ old('description_typeEvent') }}">
            <span class="text-danger">{{ $errors->first('description_typeEvent') }}</span> 

            <div class="form-group" style="margin-top: 10px;">
                <input type="submit" class="btn btn-success" value="Tạo mới" />
            </div>
        </div>
    </form>
</div>
@endsection