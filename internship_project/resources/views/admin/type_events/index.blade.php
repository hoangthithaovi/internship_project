@extends('layouts.admin.admin')

@section('content')
@if (session('create_type_event'))
<div class="alert alert-success">
    {{ session('create_type_event') }}
</div>
@endif
@if (session('update_type_event'))
<div class="alert alert-success">
    {{ session('update_type_event') }}
</div>
@endif
@if(Session::has('deleted_type_event'))
<p class="bg-danger">{{session('deleted_type_event')}}</p>
@endif
<div class="content" style="width: 90%; margin: auto;">
    <h1 style="color: #0099CC; text-align: center; margin-top: 10px;">Quản lý loại sự kiện</h1>
    <div class="row form-group">
        <table class="table"> 
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Thể loại</th>
                    <th>Xem sự kiện cùng thể loại</th>
                    <th>Mô tả</th>
                    <th>Ngày tạo</th>
                    <th>Ngày cập nhật</th>
                    <th colspan="2">Hành động</th>
                </tr>
            </thead>

            <tbody>
                @foreach($type_events as $type_event)
                <tr>
                    <td>{{$type_event->id}}</td>
                    <td>{{$type_event->name_type_event}}</td>
                    <td><a href="{{url('admin/type_events/'.$type_event->id.'/events')}}">Xem sự kiện</a></td>  
                    <td>{{$type_event->description_typeEvent}}</td>
                    <td>{{$type_event->created_at}}</td>
                    <td>{{$type_event->updated_at}}</td>
                    <td>
                        <a href="{{ url('admin/type_events/'.$type_event->id.'/edit') }}">Sửa</a>
                    </td>
                    <td>
                        <form action="{{ route('admin.type_events.destroy',$type_event->id) }}" method="POST" class="delete">
                           <input type="hidden" name="_method" value="DELETE">
                                {{ csrf_field() }}
                            <input type="submit" class="btn btn-danger" value="Xóa">
                        </form> 
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    $(".delete").on("submit", function(){
        return confirm("Bạn chắc chắn muốn xóa?");
    });
</script>
@endsection