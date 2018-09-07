@extends('layouts.admin.admin')

@section('content')
<h1 style="color: #0099CC; text-align: center; margin-top: 10px;">Xem các loại vé của sự kiện</h1>
@if(Session::has('deleted_ticket'))
<p class="bg-danger">{{session('deleted_ticket')}}</p>
@endif
<div class="container">
    <div class="row form-group" style="margin-left: 10px;">
        <table class="table"> 
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên loại vé</th>
                    <th>Giá tiền</th>
                    <th>Số lượng</th>
                    <th>Thông tin chi tiết</th>
                    <th>Ngày tạo</th>
                    <th>Ngày cập nhật</th>
                    <th>Hành động</th>
                </tr>
            </thead>

            <tbody>
                @if($tickets)
                @foreach($tickets as $ticket)
                <tr>
                    <td>{{$ticket->id}}</td>
                    <td>{{$ticket->name_type_ticket}}</td>  
                    <td>{{$ticket->price}}</td>
                    <td>{{$ticket->quantity}}</td>
                    <td>{{$ticket->description_ticket}}</td>
                    <td>{{$ticket->created_at}}</td>
                    <td>{{$ticket->updated_at}}</td>
                    <td>
                        <form action="{{ route('admin.tickets.destroy',$ticket->id) }}" method="POST" class="delete">
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
    </div>
</div>
<script>
    $(".delete").on("submit", function(){
        return confirm("Bạn chắc chắn muốn xóa?");
    });
</script>
@endsection