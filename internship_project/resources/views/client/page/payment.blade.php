@extends('layouts.app')
@section('content')
<link href="{{asset('css/payment/payment.css')}}" rel="stylesheet">
<link href="{{asset('css/index/easy-responsive-tabs.css')}}" rel="stylesheet">
<div class="header_agileits info">
</div>
<div class="ads-grid_shop">
    <div class="shop_inner_inf">
        <div class="privacy about">
        <h3>Thanh<span>&nbsp;toán</span></h3>
        <div class="checkout-left">
            <div class="col-md-8 address_form">
                <h4 class="pay-border">Thông tin người nhận vé</h4>
                <form action="{{route('checkout')}}" method="post" class="creditly-card-form agileinfo_form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <section class="creditly-wrapper wrapper">
                        <div class="information-wrapper">
                            <div class="first-row form-group">
                                <div class="row card_number_grids">
                                    <div class="card_number_grid_left col-md-6">
                                        <div class="controls">
                                            <label class="control-label">Họ và tên: </label>
                                            <input class="billing-address-name form-control" type="text" name="name" placeholder="Họ và tên" value="{{ old('name') }}">
                                             @if($errors->has('name'))
                                                <strong class="text-danger">{{$errors->first('name')}}</strong>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card_number_grid_right col-md-6">
                                        <div class="controls">
                                            <label class="control-label">Địa chỉ:</label>
                                            <input class="billing-address-name form-control" type="text" name="address" placeholder="Địa chỉ" value="{{ old('address') }}">
                                            @if($errors->has('address'))
                                                <strong class="text-danger">{{$errors->first('address')}}</strong>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row card_number_grids">
                                    <div class="card_number_grid_left col-md-6">
                                        <div class="controls">
                                            <label class="control-label">Số điện thoại:</label>
                                            <input class="form-control" name="phone" type="text" placeholder="Số điện thoại" value="{{ old('phone') }}">
                                             @if($errors->has('phone'))
                                                <strong class="text-danger">{{$errors->first('phone')}}</strong>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card_number_grid_right col-md-6">
                                        <div class="controls">
                                            <label class="control-label">Email: </label>
                                            <input class="form-control" name="email" type="text" placeholder="Email" value="@if(Auth::check()){{ Auth::user()->email }} @else @endif">
                                             @if($errors->has('email'))
                                                <strong class="text-danger">{{$errors->first('email')}}</strong>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="clear"> </div>
                                </div>
                            </div>
                            <div class="information-wrapper">
                                <h4 class="pay-border">Hình thức thanh toán</h4>
                                <div class="responsive_tabs">
                                    <div id="horizontalTab">
                                        <ul class="resp-tabs-list">
                                              <label class="radio-inline">
                                              <input type="radio" type="radio" class="input-radio" name="payment_method" value="0" checked="checked" style="margin-left: -90px;">Thanh toán trực tiếp
                                            </label>
                                            <label class="radio-inline">
                                              <input id="payment_method_cheque" type="radio" class="input-radio" name="payment_method" value="1" style="margin-left: -111px;">Chuyển khoản ngân hàng
                                            </label>
                                        </ul>
                                        <div class="resp-tabs-container">
                                            <!--/tab_one-->
                                            <div class="tab1">
                                                <div class="pay_info">
                                                    <div class="vertical_post check_box_agile">
                                                        <h5>Nhận vé tại:</h5>
                                                        <p>Văn phòng EventTomorrow ĐN: Tầng 7 - tòa nhà ABC, 02 Quang Trung, Hải Châu, Đà Nẵng</p>
                                                        <p>Giờ làm việc: Thứ 2 - thứ 7 (8h - 17h)</p>
                                                        <p class="dashed-line"></p>
                                                    </div>
                                                    <form class="cc-form">
                                                        <div class="clearfix">
                                                            <div class="form-group form-group-cc-number">
                                                                <input type="hidden" name="type_of_payment" value="0">
                                                                <textarea class="form-control" rows="3" name="notes" placeholder="Ghi chú..."  value="{{ old('notes') }}"></textarea>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="tab2">
                                                <div class="pay_info">
                                                    <h5 class="bank-title">Dang sách các ngân hàng hỗ trợ thanh toán:</h5>
                                                    <img src="images/banks.jpg" class="pp-img" alt="Banks" title="Banks">
                                                    <p>Vé của bạn sẽ được gửi qua email ngay sau khi thanh toán.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>     
                            </div>
                            <button class="submit check_out" type="submit">Finish</button>
                        </div>
                    </section>
                </form>
            </div>
            <div class="col-md-4 checkout-left-basket">
                <h4>Thông tin thanh toán</h4>
                 @if(Session::has('cart'))
                    @foreach($product_cart as $event)
                        <div class="media">
                            <img width="25%" src="{{$event['folder'].$event['attached_file']}}" alt="" class="pull-left">
                            <div class="media-body">
                                <p class="font-large">Tên sự kiện:&nbsp; {{$event['title_event']}}</p>
                                <span class="color-gray">Số lượng:&nbsp;<b class="qty">{{$event['qty']}}</b>&nbsp;{{$event['name_type_ticket']}}</span><br/>
                                <span class="color-gray your-order-info">Giá vé: &nbsp;@if($event['price']==0) <span class="free">FREE  @else <b class="price_style">{{$event['price']}}</b> @endif</span><br/>
                            </div>
                        </div>
                    <!-- end one item -->
                    @endforeach
                @endif
                <div class="clearfix"> </div>
                <div class="box-style1">
                    <div class="total2 clearfix">
                        <span class="text-label">Tổng cộng:</span>
                        <div class="amount1">
                            <p><strong class="total_strong2">{{number_format(Session('cart')->totalPrice,3)}} &nbsp; VNĐ</strong></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"> </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
@endsection