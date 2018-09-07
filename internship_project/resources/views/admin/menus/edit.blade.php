@extends('layouts.admin.admin')

@section('content')

<div class="container">
    <h1 style="color: #0099CC; text-align: center; margin-top: 10px;">Cập nhật thông tin menu</h1>
    <div class="row form-group {{ $errors->has('name_menu') ? 'has-error' : '' }} ">
        <form action="{{route('admin.menus.update', $menu->id)}}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT">
           
            <div class=" form-group {{ $errors->has('name_menu') ? 'has-error' : '' }}">       
                <label>Tên menu:</label>
                <input type="text" id="name_menu" name="name_menu" class="form-control" placeholder="Nhập tên menu..." value="{{$menu->name_menu}}" required>
                <span class="text-danger">{{ $errors->first('name_menu') }}</span><br>
            </div>

            <div class=" form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                <label>Chọn menu cha:</label>
                <select class="form-control" id="parent_id" name="parent_id" >
                    <option value="0" selected="true">--Parent Menu--</option>
                    @foreach ($parent_menus as $parent_menu  )
                        <option value="{{$parent_menu->id}}" @if($parent_menu->id === $menu->parent_id) selected="selected" @endif>{{$parent_menu->name_menu}}</option>
                    @endforeach   
                </select>                
                <span class="text-danger">{{ $errors->first('parent_id') }}</span>
            </div>

            <div class=" form-group {{ $errors->has('action_id') ? 'has-error' : '' }}">
                <label>Chọn Action:</label>
                <select class="form-control" id="action_id" name="action_id">
                    @foreach ($actions as $action)
                        <option value="{{$action->id}}" @if($action->id == $menu->action_id) selected="selected" @endif>{{$action->name_action}}</option>
                    @endforeach   
                </select>                
                <span class="text-danger">{{ $errors->first('action_id') }}</span>
            </div>

            <div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
                <label>URL:</label>
                <input type="text" id="url" name="url" class="form-control" placeholder="Nhập đường dẫn URl..." value="{{$menu->url}}" required>
                <span class="text-danger">{{ $errors->first('url')}}</span> 
            </div>

            <div class="form-group {{$errors->has('description') ? 'has-error' : ''}}">
                <label>Mô tả:</label>
                <textarea class="form-control" rows="5" id="description" name="description" placeholder="Nhập mô tả...">{{$menu->description}}</textarea>
            <span class="text-danger">{{ $errors->first('description') }}</span>
            </div>

            <div class="form-group" style="margin-top: 10px;">
                <input type="submit" class="btn btn-success" value="Cập nhật" />
            </div>
        </form>
    </div>
</div>
@endsection
