@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1>Cập nhật thông tin hóa đơn</h1>
    <form action="{{ route('admin.orders.update', $order->id) }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="PUT">

        <div class=" form-group {{ $errors->has('fullname') ? 'has-error' : '' }}">
            <label>Tên khách hàng:</label>
            <input type="text" id="fullname" name="fullname" class="form-control" value="{{ $order->fullname }}" required readonly>
            <span class="text-danger">{{ $errors->first('fullname') }}</span>
        </div>  

        <div class=" form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <label>Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ $order->email}}" required>
            <span class="text-danger">{{ $errors->first('email') }}</span>
        </div> 

        <div class="  form-group {{ $errors->has('phone_number') ? 'has-error' : ''}}">
            <label>Số điện thoại:</label>
            <input type="number" id="phone_number" name="phone_number" class="form-control" value="{{$order->phone_number}}">
            <span class="text-danger">{{ $errors->first('phone_number') }}</span>
        </div>           

        <div class=" form-group {{ $errors->has('address') ? 'has-error' : '' }}">
            <label>Địa chỉ:</label>
            <input type="text" class="form-control" rows="5" id="address" name="address" value="{{ $order->address }}" required>
            <span class="text-danger">{{ $errors->first('address')}}</span>
        </div> 

        <div class=" form-group {{ $errors->has('date_order') ? 'has-error' : '' }}">
            <label>Ngày đặt vé:</label>
            <input type="text" class="form-control" rows="5" id="date_order" name="date_order" value="{{ $order->date_order }}" required readonly>
            <span class="text-danger">{{ $errors->first('date_order')}}</span>
        </div> 

        <div class=" form-group {{ $errors->has('type_of_payment') ? 'has-error' : '' }}">
            <label>Hình thức thanh toán:</label>
            <label class="radio-inline">
                <input type="radio" name="type_of_payment" value="0" @if($order->type_of_payment==0) checked @endif>Thanh toán trực tiếp
            </label>
            <label class="radio-inline">
                <input type="radio" name="type_of_payment" value="1" @if($order->type_of_payment==1) checked @endif>Thanh toán qua ngân hàng
            </label>
        </div>

        <div class=" form-group {{ $errors->has('notes') ? 'has-error' : '' }}">
            <label>Ghi chú:</label>
            <input type="text" class="form-control" rows="5" id="notes" name="notes" value="{{ $order->notes }}" required>
            <span class="text-danger">{{ $errors->first('notes')}}</span>
        </div> 

        <div class=" form-group {{ $errors->has('status') ? 'has-error' : '' }}">
            <label>Tình trang thanh toán:</label>
            <label class="radio-inline">
                <input type="radio" name="status" value="0" @if($order->status==0) checked @endif>Đã thanh toán
            </label>
            <label class="radio-inline">
                <input type="radio" name="status" value="1" @if($order->status==1) checked @endif>Chưa thanh toán
            </label>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-success" value="Cập nhật" />
        </div>
    </form>
</div>
@stop