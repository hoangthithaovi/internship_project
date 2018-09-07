@extends('layouts.app')
@section('content')
<div class="container">    
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                <div class="panel-heading">
                    <div class="panel-title">Đăng kí</div>
                </div>     

                <div style="padding-top:30px" class="panel-body" >

                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                        
                    <form id="loginform" class="form-horizontal" role="form" method="post" action="{{URL::action('EventController@postRegister')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}   
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="email" type="text" class="form-control" name="email" value="" placeholder="Email" value="{!! old('email') !!}">
                             @if($errors->has('email'))
                              <small class="text-danger">{{ $errors->first('email') }}</small>
                            @endif                                        
                        </div>
                            
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="login-password" type="password" class="form-control" name="password" placeholder="Mật khẩu" value="{!! old('password') !!}">
                             <p>@if($errors->has('password'))
                              <small class="text-danger">{{ $errors->first('password') }}</small>
                            @endif </p>
                        </div>
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="password" type="password" class="form-control" name="remember_token" placeholder="Xác nhận mật khẩu"value="{!! old('remember_token') !!}">
                            @if($errors->has('remember_token'))
                              <small class="text-danger">{{ $errors->first('remember_token') }}</small>
                            @endif 
                        </div>

                        <div style="margin-top:10px" class="form-group">
                            <!-- Button -->
                            <div class="col-sm-12 controls">
                                <button type="submit" class="btn btn-success">Đăng kí</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-facebook-square"></i>  FaceBook</button>

                                <button type="submit" class="btn btn-success"><i class="fa fa-google"></i>  Google</button>
                            </div>
                        </div> 

                    </form>     
                </div>                     
            </div>  
        </div>
</div>
@endsection
    