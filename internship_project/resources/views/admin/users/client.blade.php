@extends('layouts.admin.admin')

@section('content')

@if(Session::has('create_user'))
<p class="alert alert-success">{{session('create_user')}}</p>
@endif

@if(Session::has('deleted_user'))
<p class="bg-danger">{{session('deleted_user') }}</p>
@endif

@if(Session::has('update_user'))
<p class="alert alert-success">{{session('update_user') }}</p>
@endif

<div class="container">
    <h1 style="color: #0099CC; text-align: center; margin:20px;">Quản lý tài khoản client</h1>
</div>
@if(count($users) <= 0)
Không có tài khoản client nào
@else
<div class="content">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ảnh đại diện</th>
                <th>Tên tài khoản</th>
                <th>Email</th>
                <th>Xem hóa đơn</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
                <th colspan="2">Hành động</th>
            </tr>
        </thead>

        <tbody>
            @if($users)
            @foreach ($users as $user) 
            <tr>
                <td>{{$user->id}}</td>
                <td><img height="50" width="50" src="{{$user->user_avata()? asset( $user->user_avata()->folder.$user->user_avata()->attached_file): 'http://placehold.it/400x400'}}" alt="image"></td>
                <td>{{$user->username}}</td>
                <td>{{$user->email}}</td>
                <td><a href="{{url('/admin/users/'.$user->id.'/orders')}}">Xem hóa đơn</a></td>
                <td>{{$user->created_at}}</td>
                <td>{{$user->updated_at}}</td>
                <td><a href="{{route('admin.users.edit',$user->id) }}" >Sửa</a></td>
                <td>
                    <form action="{{ route('admin.users.destroy',$user->id) }}" method="POST" class="delete">
                        <input type="hidden" name="_method" value="DELETE">
                            {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger" value="Xóa">
                    </form> 
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    <div class="row">
        <div class="col-lg-6 col-sm-offset-5">
            {{$users->render()}}
        </div>
    </div>
</div>
@endif
<script>
    $(".delete").on("submit", function(){
        return confirm("Bạn chắc chắn muốn xóa tài khoản này?");
    });
</script>
@stop


