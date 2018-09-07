@extends('layouts.admin.admin')
@section('content')

@if (session('create_event'))
<div class="alert alert-success">
    {{ session('create_event') }}
</div>
@endif
@if (session('update_event'))
<div class="alert alert-success">
    {{ session('update_event') }}
</div>
@endif
@if(Session::has('deleted_event'))
<p class="bg-danger">{{session('deleted_event')}}</p>
@endif
<div class="main-content-inner">
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{route('admin')}}">Trang chủ</a>
            </li>
            <li>
                <a href="{{route('admin.events.index')}}">Quản lý sự kiện</a>
            </li>
        </ul>
    </div>
</div>
<div class="content">
    <h1 style="color: #0099CC; text-align: center; margin:20px;">Quản lý sự kiện</h1>
    <div id="cd-search" class="cd-search">
        <form action="{{route('eventssearchadmin')}}" method="GET">
            <div class="input-group" style="width: 50%;margin-left: 25%;margin-bottom: 30px;">
                <input type="text" class="form-control"  name="search_textadmin" style="height: 42px;">
                <span class="input-group-btn">
                    <button class="btn btn-success" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
    </div>
    <table class="table"> 
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên sự kiện</th>
                <th>Địa điểm</th>
                <th>Số lượng vé</th>
                <th>Mô tả</th>
                <th>Ảnh sự kiện</th>
                <th>Tài liệu</th>
                <th>Ngày diễn ra</th>
                <th>Ngày kết thúc</th>
                <th>Tình trạng</th>
                <th>Xem vé</th>
                <th>Xem loại sự kiện</th>
                <th>Xem công ty tổ chức</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
                <th colspan="2">Hành động</th>
            </tr>
        </thead>

        <tbody>
            @if(count($events) <= 0)
                <h2>Không có kết quả</h2>
            @endif
            @if($events)
                @if(isset($is_search))
                    @foreach($events as $event)
                    <tr>
                        <td>{{$event->IDEvent}}</td>
                        <td>{{$event->title_event}}</td>  
                        <td>{{$event->location}}</td>
                        <td>{{$event->total_ticket}}</td>
                        <td>{{$event->description}}</td>     
                        <td>
                            <img width="75" height="60" src="{{$event->folder.$event->attached_file}}" alt="">
                        </td>
                        <td>
                            Tài liệu
                        </td>
                        <td>{{$event->date_start}}</td>
                        <td>{{$event->date_end}}</td>
                        <td>
                            @if(($event->status) == 0)
                            Đã diễn ra
                            @else
                            Chưa diễn ra
                            @endif
                        </td>
                        <td>
                            <a href="{{url('/admin/events/'.$event->IDEvent.'/tickets')}}">Xem các loại vé</a>
                        </td>
                        <td>
                            <a href="{{url('/admin/events/'.$event->IDEvent.'/type_event')}}">Xem loại sự kiện</a>
                        </td>
                        <td>
                            <a href="{{url('/admin/events/'.$event->IDEvent.'/companies')}}">Xem công ty tổ chức sự kiện</a>

                        </td>
                        <td>{{$event->created_at}}</td>
                        <td>{{$event->updated_at}}</td>
                        <td>
                            <button class="btn btn-warning"><a href="{{ url('admin/events/'.$event->IDEvent.'/edit') }}">Sửa</a></button>
                        </td>
                        <td>
                            <form action="{{ route('admin.events.destroy',$event->IDEvent) }}" method="POST" class="delete">
                               <input type="hidden" name="_method" value="DELETE">
                                    {{ csrf_field() }}
                                <input type="submit" class="btn btn-danger" value="Xóa">
                            </form> 
                        </td>
                    </tr>
                    @endforeach
                @else
                    @foreach($events as $event)
                    <tr>
                        <td>{{$event->id}}</td>
                        <td>{{$event->title_event}}</td>  
                        <td>{{$event->location}}</td>
                        <td>
                            @if($quantity)
                                @foreach($quantity as $quan)
                                    @if($event->id == $quan->id)
                                        {{$quan->quantity}}
                                    @endif
                                @endforeach
                            @endif
                        </td>
                        <td>{{$event->description}}</td>     
                        <td>
                            @if($images)
                                @foreach($images as $image)
                                    @if($image->object_id == $event->id)
                                        <img width="75" height="60" src="{{asset($image->folder.$image->attached_file)}}" alt="Ảnh không tồn tại" title="Ảnh sự kiện">
                                    @endif
                                @endforeach
                            @endif
                        </td>
                        <td>
                            @if($documents)
                                @foreach($documents as $document)
                                    @if($document->object_id == $event->id)
                                        <iframe width="100" height="80" src="{{asset($document->folder.$document->attached_file)}}" title="Tài liệu sự kiện"></iframe>
                                    @endif
                                @endforeach
                            @endif
                        </td>
                        <td>{{$event->date_start}}</td>
                        <td>{{$event->date_end}}</td>
                        <td>
                            @if(($event->status) == 0)
                            Đã diễn ra
                            @else
                            Chưa diễn ra
                            @endif
                        </td>
                        <td>
                            <a href="{{url('/admin/events/'.$event->id.'/tickets')}}">Xem các loại vé</a>
                        </td>
                        <td>
                            <a href="{{url('/admin/events/'.$event->id.'/type_event')}}">Xem loại sự kiện</a>
                        </td>
                        <td>
                            <a href="{{url('/admin/events/'.$event->id.'/companies')}}">Xem công ty tổ chức sự kiện</a>
                        </td>
                        <td>{{$event->created_at}}</td>
                        <td>{{$event->updated_at}}</td>
                        <td>
                            <a class="btn btn-warning" href="{{ url('admin/events/'.$event->id.'/edit') }}">Sửa</a>
                        </td>
                        <td>
                            <form action="{{ route('admin.events.destroy',$event->id) }}" method="POST" class="delete">
                               <input type="hidden" name="_method" value="DELETE">
                                    {{ csrf_field() }}
                                <input type="submit" class="btn btn-danger" value="Xóa">
                            </form> 
                        </td>
                    </tr>
                    @endforeach
                @endif
            @endif
        </tbody>
    </table>
</div>
<script>
    $(".delete").on("submit", function(){
        return confirm("Bạn chắc chắn muốn xóa sự kiện này?");
    });
</script>
@stop