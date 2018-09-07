@extends('layouts.app')

@section('content')
<div class="checkout">	 
    <div class="container">	
        <ol class="breadcrumb">
            <li><a href="index.html">Trang chủ</a></li>
            <li class="active">Thanh toán</li>
        </ol>
        @if(Session::has('cart'))
        <h3>Your Shopping Cart in here (<span class="count_cart">{{ Session::has('cart') ? Session::get('cart')->totalQty : '' }}</span>)</h3>
        <div class="col-md-9 event-price1">
            <div class="check-out">			
                <div class=" cart-items">

                    <div>
                        <div class="row title_cart">
                            <div class="col-sm-2 col-md-2 col-lg-2 col-xs-2">
                                <span>Ảnh</span>
                            </div>
                            <div class="col-sm-3 col-md-3 col-lg-3 col-xs-2">
                                <span>Tên sản phẩm</span>
                            </div>
                            <div class="col-sm-2 col-md-2 col-lg-2 col-xs-2">
                                <span>Giá</span>
                            </div>
                            <div class="col-sm-3 col-md-3 col-lg-3 col-xs-3">
                                <span>Số lượng</span>
                            </div>  
                            <div class="col-sm-2 col-md-2 col-lg-2 col-xs-2">
                                <span>Tổng</span>
                            </div>
                        </div>
                        @if(Session::has('cart'))
                        <div class="result_delete">
                           @foreach($product_cart as $event)
                            <ul class="cart-header" id="cart-header{{$event['id']}}">
                                <li class="ring-in"><a href="#" ><img src="{{$event['folder'].$event['attached_file']}}" class="img-responsive" style="height: 130px; width: 120px;" alt=""></a></li>
                                <li><span> {{$event['title_event']}}</span></li>
                                <li><span style="display: inline-block">{{ number_format($event['price'], 3, ',', '.')}}VNĐ</span></li>
                                <li><div id="convert">
                                        <button class="subtract" id="button_{{$event['id']}}" value="{{$event['id']}}">-</button>
                                        <input type="hidden" id="price{{$event['id']}}" value="{{$event['price']}}">
                                        <div class="quantity" id="quantity{{$event['id']}}">
                                            {{$event['qty']}}
                                        </div>
                                        <button class="plus" value="{{$event['id']}}">+</button>
                                        <div class="clearfix"></div>
                                    </div></li>
                                <li>
                                    <span class="price_update" id="price_update{{$event['id']}}" style="display: inline-block;font-weight: bold">{{ number_format($event['price'], 3, ',', '.')}}</span>VNĐ
                                    <button class="closecart" value="{{$event['id']}}"></button>
                                </li>
                                <div class="clearfix"> </div>
                            </ul>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <!--                    <div class="clearfix"></div>-->
                </div>					  
            </div>
        </div>
        <div class="col-md-3 cart-total">
            <div class="box-style2">
                <div class="information_order">Thông tin đơn hàng</div>                
            </div>
            <div class="box-style">
                <span>Tạm tính (<span class="count_cart">{{ Session::has('cart') ? Session::get('cart')->totalQty : '' }}</span> sản phẩm)</span>
                <strong class="total_strong"><span class="totalprice">{{ Session::has('cart') ? number_format(Session::get('cart')->totalPrice, 3, ',', '.') : '' }}</span> VNĐ</strong>
            </div>
            <div class="box-style3">
                <span>Vận chuyển:</span>
                <strong class="total_strong"><span>Miễn phí</span></strong>
            </div>
            <div class="box-style1">
                <div class="total2 clearfix">
                    <span class="text-label">Tổng cộng:</span>
                    <div class="amount1">
                        <p><strong class="total_strong2"><span class="totaltong">{{ Session::has('cart') ? number_format(Session::get('cart')->totalPrice, 3, ',', '.') : '' }}</span> VNĐ</strong></p>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-large btn-block btn-danger btn-checkout payment_button">
                <a href="{{route('checkout')}}" class="payment_button_a">Tiến hành đặt hàng</a>
            </button>
            <button type="button" class="btn btn-large btn-block btn-yellow btn-checkout" id="btn-send-gift" >
                <a href="{{url('event')}}" class="continue_button_a">Tiếp tục mua vé</a>
            </button>
            <div class="clearfix"></div>
        </div>
        @else
        <div class="cart-empty-text">Không có sản phẩm nào trong giỏ hàng</div>
        <div class="cart_empty_button"><button type="button" class="next-btn next-btn-secondary next-btn-large cart-empty-button"><a href="{{url('event')}}">TIẾP TỤC MUA VÉ</a></button></div>
        @endif
    </div>
</div>		
<div class="clearfix"></div>
@endsection

