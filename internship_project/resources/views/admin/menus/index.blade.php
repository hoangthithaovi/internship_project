@extends('layouts.admin.admin')

@section('content')
@if (session('create_menu'))
<div class="alert alert-success">
    {{ session('create_menu') }}
</div>
@endif
@if (session('update_menu'))
<div class="alert alert-success">
    {{ session('update_menu') }}
</div>
@endif
@if (Session::has('deleted_menu'))
<p class="bg-danger">{{session('deleted_menu')}}</p>
@endif

<div class="content" style="width: 90%; margin: auto;">
    <h1 style="color: #0099CC; text-align: center; margin-top: 10px;">Quản lý menu cha</h1>
    <div class="row form-group">
        <table class="table"> 
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên menu cha</th>
                    <th>Tên action</th>
                    <th>Xem menu con</th>
                    <th>Đường dẫn URL</th>
                    <th>Mô tả</th>
                    <th>Ngày tạo</th>
                    <th>Ngày cập nhật</th>
                    <th colspan="2">Hành động</th>
                </tr>
            </thead>

            <tbody>
                @if($menus)
                @foreach($menus as $menu)
                <tr>
                    <td>{{$menu->id}}</td>
                    <td>{{$menu->name_menu}}</td>  
                    <td>{{$menu->action->name_action}}</td>
                    <td>
                        <a href="{{url('admin/menus/'.$menu->id.'/child')}}">Xem menu con</a>
                    </td>
                    <td>{{$menu->url}}</td>
                    <td>{{$menu->description}}</td>
                    <td>{{$menu->created_at}}</td>
                    <td>{{$menu->updated_at}}</td>
                    <td>
                        <a class="btn btn-warning" href="{{ url('admin/menus/'.$menu->id.'/edit') }}">Edit</a>
                    </td>
                    <td>
                        <form action="{{route('admin.menus.destroy',$menu->id)}}" method="POST" class="delete">
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
                {{ $menus->render() }}
            </div>
        </div>
    </div>
</div>
<script>
    $(".delete").on("submit", function(){
        return confirm("Bạn chắc chắn muốn xóa menu này?");
    });
</script>
@endsection