@extends('layouts.admin.admin')
@section('content')
<h1 style="color: #0099CC; text-align: center; margin:20px;">Create User</h1>
    
    <div class="container col-md-10" style="margin-left:100px; margin-top: 15px;">
        <form action="{{ route('admin.users.store') }}" method="post" enctype='multipart/form-data'>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class=" row form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                <label>Tên tài khoản:</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Nhập username..." value="{{ old('username') }}">
                <span class="text-danger">{{ $errors->first('username') }}</span>
            </div> 

            <div class=" row form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label>Email:</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Nhập email..." value="{{ old('email') }}">
                <span class="text-danger">{{ $errors->first('email') }}</span>
            </div> 

            <div class=" row form-group {{$errors->has('password') ? 'has-error' : '' }}">
                <label>Mật khẩu:</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Nhập password..." value="">
                <span class="text-danger">{{ $errors->first('password') }}</span>
            </div>

            <div class=" row form-group {{$errors->has('conf_pass') ? 'has-error' : ''}}">
                <label>Xác nhận mật khẩu:</label>
                <input type="password" id="conf_pass" name="conf_pass" class="form-control" placeholder="Nhập lại password..." value="">
                <span class="text-danger">{{ $errors->first('conf_pass') }}</span>
            </div>

            <div class="form-group " style="width: 300px">
                <img height="300" alt="Avata Image" class="img-responsive img-rounded" id="attached">
            </div><br>

            <div class="row form-group {{$errors->has('attached_file') ?'has-error' :''}}">
                <label>Ảnh đại diện:</label>
                <input type="file" id="attached_file" name="attached_file" class="form-control" value="{{old('attached_file')}}">
                <span class="text-danger">{{ $errors->first('attached_file') }}</span>
            </div> 

            <div class="row form-group {{$errors->has('action') ? 'has-error' : ''}}">
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
            <div class="row form-group {{$errors->has('group') ? 'has-error' : ''}}">
                <label>Nhóm:</label>
                <div class="row">
                    @if($groups)
                    @foreach ($groups as $group) 
                    <div class="col-md-4">
                        <label class="radio-inline">
                            <input type="checkbox" name="group[]" value="{{$group->id}}">{{$group->name_group}}<br>
                        </label>
                    </div>
                    @endforeach
                    @endif
                </div>
                <span class="text-danger">{{ $errors->first('group') }}</span>
            </div>

            <div class="row form-group">
                <input type="submit" class="btn btn-success" value="Tạo tài khoản" />
            </div>
        </form>
    </div>  
    <!-- Show file -->
    <script type="text/javascript">
        var file = document.getElementById('attached_file');
        var img = document.getElementById('attached');
        file.addEventListener("change", function() {
            if (this.value) {
                var file = this.files[0];
                img.onload = function () {
                    window.URL.revokeObjectURL(this.src);
                };
                img.src = window.URL.createObjectURL(file);
            }
        });
    </script>   
@stop