@extends('layouts.admin.admin')
@section('content')
<h1 style="color: #0099CC; text-align: center; margin-top: 10px;">Quản lý nhóm phân quyền</h1>
@if (session('create_group'))
<div class="alert alert-success">
    {{ session('create_group') }}
</div>
@endif
@if (session('update_group'))
<div class="alert alert-success">
    {{ session('update_group') }}
</div>
@endif
@if (Session::has('deleted_group'))
<p class="bg-danger">{{session('deleted_group')}}</p>
@endif

<div class="content" style="width: 90%; margin: auto;">
    <div class="form-group">
        @if(count($groups) <= 0)
        <h4>Tài khoản hiện tại không thuộc bất cứ nhóm quản lý nào</h4>
        @else
        <table class="table"> 
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên nhóm</th>
                    <th>Các hành động của nhóm</th>
                    <th>Mô tả</th>
                    <th>Ngày tạo</th>
                    <th>Ngày cập nhật</th>
                    <th colspan="2">Hành động</th>
                </tr>
            </thead>

            <tbody>
                @foreach($groups as $group)
                <tr>
                    <td>{{$group->id}}</td>
                    <td>{{$group->name_group}}</a></td> 
                    <td><a href="{{url('/admin/groups/'.$group->id.'/action')}}">Xem hành động</a></td>     
                    <td>{{$group->description}}</td>
                    <td>{{$group->created_at}}</td>
                    <td>{{$group->updated_at}}</td>
                    <td>
                        <a class="btn btn-warning" href="{{ url('admin/groups/'.$group->id.'/edit') }}">Edit</a>
                    </td>
                    <td>
                        <form action="{{ route('admin.groups.destroy',$group->id) }}" method="POST" class="delete">
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
    </div>
</div>
<script>
    $(".delete").on("submit", function(){
        return confirm("Bạn chắc chắn muốn xóa nhóm này?");
    });
</script>
@stop