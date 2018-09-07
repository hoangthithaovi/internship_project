@extends('layouts.admin.admin')
@section('content')
@if (session('create_action'))
    <div class="alert alert-success">
        {{ session('create_action') }}
    </div>
    @endif
    @if (session('update_action'))
    <div class="alert alert-success">
        {{ session('update_action') }}
    </div>
    @endif
    @if(Session::has('deleted_action'))
    <p class="bg-danger">{{session('deleted_action')}}</p>
    @endif
    @if(count($actions) <= 0)
        <h4>Tài khoản hiện tại không có bất kỳ quyền quản lý nào</h4>
    @else
<div class="content" style="width: 90%; margin: auto;">
    <h1 style="color: #0099CC; text-align: center; margin:20px;">Quản lý bảng Actions</h1>
    <table class="table"> 
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên hành động</th>
                <th>Đường dẫn</th>
                <th>Quyền công khai</th>
                <th>Mô tả</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
                <th colspan="2">Hành động</th>
            </tr>
        </thead>

        <tbody>
            @foreach($actions as $action)
            <tr>
                <td>{{$action->id}}</td>
                <td>{{$action->name_action}}</td>        
                <td>{{$action->link_action}}</td>
                <td>
                    @if(($action->is_public) == 0)
                    Công khai
                    @else
                    Không công khai
                    @endif
                </td>
                <td>{{str_limit($action->description)}}</td>
                <td>{{$action->created_at}}</td>
                <td>{{$action->updated_at}}</td>
                <td>
                    <a class="btn btn-warning" href="{{ url('admin/actions/'.$action->id.'/edit') }}">Sửa</a>
                </td>
                <td>  
                    <form action="{{ route('admin.actions.destroy',$action->id) }}" method="POST" class="delete">
                        <input type="hidden" name="_method" value="DELETE">
                            {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger" value="Xóa">
                   </form>  
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    <script>
        $(".delete").on("submit", function(){
            return confirm("Bạn chắc chắn muốn xóa hành động này?");
        });
    </script>
</div>
@stop