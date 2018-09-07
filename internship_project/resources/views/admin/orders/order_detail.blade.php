@extends('layouts.admin.admin')
@section('content')

<div class="container">
    <h1 style="color: #0099CC; text-align: center; margin:20px;">Xem chi tiết hóa đơn</h1>
</div>

<div class="content" style="width: 90%; margin: auto;">
    <table class="table"> 
        <thead>
            <tr>
                <th>ID</th>
                <th>ID hóa đơn</th>
                <th>Tên loại vé</th>
                <th>Tên sự kiện</th>
                <th>Giá tiền</th>
                <th>Số lượng</th>
                <th>Tổng tiền</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
                <!-- <th colspan="2">Hành động</th> -->
            </tr>
        </thead>

        <tbody>
            @if($order_details)
            @foreach($order_details as $order)
            <tr>
                <td>{{$order->id}}</td>
                <td>{{$order->order_id}}</td>
                <td>{{$order->name_ticket}}</td>
                <td>{{$order->name_event}}</td>
                <td>{{$order->price}}</td>
                <td>{{$order->quantity}}</td>
                <td>{{$order->total}}</td>
                <td>{{$order->created_at}}</td>
                <td>{{$order->updated_at}}</td>
                <!-- <td>
                    <a href="{{ url('admin/orders/'.$order->id.'/edit') }}">Edit</a>
                </td>
                <td>
                    <form action="{{ route('admin.orders.destroy',$order->id) }}" method="POST">
                       <input type="hidden" name="_method" value="DELETE">
                            {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger" value="Delete">
                    </form> 
                </td> -->
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    <!-- <button class="btn btn-succes" value="Quay lại"></button> -->
</div>

@stop