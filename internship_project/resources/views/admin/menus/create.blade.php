@extends('layouts.admin.admin')

@section('content')

<div class="container">
    <h1 style="color: #0099CC; text-align: center; margin-top: 10px;">Tạo mới menu</h1>
    <form action="{{route('admin.menus.store')}}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class=" form-group {{ $errors->has('name_menu') ? 'has-error' : '' }}">       
            <label>Tên Menu:</label>
            <input type="text" id="name_menu" name="name_menu" class="form-control" placeholder="Nhập tên menu..." value="{{ old('name_menu') }}">
            <span class="text-danger">{{ $errors->first('name_menu') }}</span><br>
        </div>
            
        <div class=" form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
            <label>Chọn menu cha:</label>
            <select class="form-control" id="parent_id" name="parent_id" >
                <option value="0">--Menu cha--</option>
                @foreach ($parent_menus as $parent_menu  )
                    <option value="{{$parent_menu->id}}">{{$parent_menu->name_menu}}</option>
                @endforeach   
            </select>                
            <span class="text-danger">{{ $errors->first('parent_id') }}</span>
        </div>

        <div class=" form-group {{ $errors->has('action_id') ? 'has-error' : '' }}">
            <label>Chọn hành động:</label>
            <select class="form-control" id="action_id" name="action_id">
                @foreach ($actions as $action)
                    <option value="{{$action->id}}">{{$action->name_action}}</option>
                @endforeach   
            </select>                
            <span class="text-danger">{{ $errors->first('action_id') }}</span>
        </div>

        <div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
            <label>URL:</label>
            <input type="text" id="url" name="url" class="form-control" placeholder="Nhập đường dẫn..." value="{{ old('url') }}">
            <span class="text-danger">{{ $errors->first('url') }}</span> 
        </div>

        <div class="form-group {{$errors->has('description') ? 'has-error' : ''}}">
            <label>Mô tả:</label>
            <textarea class="form-control" rows="5" id="description" name="description" placeholder="Nhập mô tả..." value="{{old('description')}}"></textarea>
            <span class="text-danger">{{ $errors->first('description') }}</span>
        </div>

        <div class="form-group" style="margin-top: 10px;">
            <input type="submit" class="btn btn-success" value="Tạo mới" />
        </div>
    </form>
</div>
@endsection