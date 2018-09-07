@extends('layouts.admin.admin')
@section('content')

@if (session('update_order'))
<div class="alert alert-success">
    {{ session('update_order') }}
</div>
@endif
@if(Session::has('deleted_order'))
<p class="bg-danger">{{session('deleted_order')}}</p>
@endif

<div class="container">
    <h1 style="color: #0099CC; text-align: center; margin:20px;">Quản lý hóa đơn chưa thanh toán</h1>
</div>

<div class="content" style="width: 99%; margin: auto;">
    <table class="table"> 
        <thead>
            <tr>
                <th>ID hóa đơn</th>
                <th>ID tài khoản</th>
                <th>Tên khách hàng</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
                <th>Ngày đặt vé</th>
                <th>Hình thức thanh toán</th>
                <th>Ghi chú</th>
                <th>Tình trạng</th>
                <th>Xem chi tiết hóa đơn</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
                <th colspan="2">Hành động</th>
            </tr>
        </thead>

        <tbody>
            @if($orders)
            @foreach($orders as $order)
            <tr>
                <td>{{$order->id}}</td>
                <td>{{$order->user_id}}</td>
                <td>{{$order->fullname}}</td>
                <td>{{$order->email}}</td>
                <td>{{$order->phone_number}}</td>
                <td>{{$order->address}}</td>
                <td>{{$order->date_order}}</td>
                <td>
                    @if(($order->type_of_payment) == 0)
                    Thanh toán trực tiếp
                    @else
                    Thanh toán qua ngân hàng
                    @endif
                </td>
                <td>{{$order->notes}}</td>
                <td>
                    @if(($order->status) == 0)
                    Đã thanh toán
                    @else
                    Chưa thanh toán
                    @endif
                </td>
                <td><a href="{{url('/admin/orders/'.$order->id.'/order_detail')}}">Xem chi tiết</a></td>
                <td>{{$order->created_at}}</td>
                <td>{{$order->updated_at}}</td>
                <td>
                    <a href="{{ url('admin/orders/'.$order->id.'/edit') }}">Sửa</a>
                </td>
                <td>
                    <form action="{{ route('admin.orders.destroy',$order->id) }}" method="POST" class="delete">
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
<script>
    $(".delete").on("submit", function(){
        return confirm("Bạn chắc chắn muốn xóa hóa đơn này?");
    });
</script>
@stop