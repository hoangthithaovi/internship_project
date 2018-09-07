@extends('layouts.admin.admin')
@section('content')

<div class="container col-md-10" style="margin-left:100px; margin-top: 15px;">
    <h1>Tạo nhóm quản lý</h1>
    <form action="{{ route('admin.groups.store')}}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-md-7">
                <div class=" form-group {{$errors->has('name_group') ? 'has-error' : ''}}">
                    <label>Tên nhóm:</label>
                    <input type="text" id="name_group" name="name_group" class="form-control" placeholder="Nhập tên nhóm..." value="{{ old('name_group')}}">
                    <span class="text-danger">{{ $errors->first('name_group') }}</span>
                </div>          

                <div class=" form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                    <label>Mô tả:</label>
                    <textarea class="form-control" rows="5" id="description" name="description" placeholder="Nhập mô tả..." value="{{old('description')}}"></textarea>
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                </div>
            </div>
            
            <div class="col-md-5">
                <div class="form-group {{$errors->has('action') ? 'has-error' : ''}}">
                    <label>Chức năng:</label>
                    <div class="row">
                        @if($actions)
                            @foreach($actions as $action)
                            <div class="col-md-4">
                                <label class="radio-inline">
                                    <input type="checkbox" name="action[]" value="{{$action->id}}">{{$action->name_action}}<br>
                                </label>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    <span class="text-danger">{{ $errors->first('action') }}</span>
                </div>    
            </div>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-success" value="Tạo mới" />
        </div>
    </form>
</div>     
@stop