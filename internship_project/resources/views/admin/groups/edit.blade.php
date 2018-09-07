@extends('layouts.admin.admin')
@section('content')

<div class="container col-md-11" style="margin-left:100px; margin-top: 15px;">
    <h1>Cập nhật thông tin</h1>
    <form action="{{ route('admin.groups.update', $group->id) }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="PUT">
        <div class="row">
            <div class="col-md-7">
                <div class=" form-group {{ $errors->has('name_group') ? 'has-error' : '' }}">
                    <label>Tên nhóm:</label>
                    <input type="text" id="name_group" name="name_group" class="form-control" value="{{$group->name_group}}" required>
                    <span class="text-danger">{{ $errors->first('name_group') }}</span>
                </div>  

                <div class=" form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                    <label>Mô tả:</label>
                    <textarea class="form-control" rows="5" id="description" name="description" value="{{$group->description}}" required>{{$group->description}}</textarea>
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                </div>
            </div>
            
            <div class="col-md-5">
                <div class="row form-group {{$errors->has('action') ? 'has-error' : ''}}">
                    <label>Chức năng:</label>
                    <div class="row">
                        @if($actions)
                        @foreach($actions as $action)
                        <div class="col-md-5">
                            <label class="radio-inline">
                                <input type="checkbox" name="action[]" value="{{$action->id}}"
                                @if($group_actions)
                                    @foreach($group_actions as $group_action)
                                        @if($action->id === $group_action->action_id) checked
                                        @endif
                                    @endforeach
                                @endif>
                                {{$action->name_action}}<br>
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
            <input type="submit" class="btn btn-success" value="Cập nhật" />
        </div>
    </form>
</div>     
@stop