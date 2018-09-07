@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('css/payment/shopping_cart.css')}}">
<div class="container">
    <!-- hiển thị thông báo nếu xóa thành công -->
    @if (session('sucess'))
        <div class="alert alert-success">
            {{ session('sucess') }}
        </div>
    @endif    
    <!-- End -->
    <!-- hiển thị thông tin của giỏ hàng -->
    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1">
            @if(Session::has('cart'))
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Vé sự kiện</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-center">Giá vé</th>
                            <th class="text-center">Tổng tiền</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($product_cart as $events)
                        <tr class="cart-header" id="cart-header{{$events['id']}}">
                            <td class="col-sm-5 col-md-5">
                                <div class="media">
                                    <a class="thumbnail pull-left"><img class="media-object" src="{{$events['folder'].$events['attached_file']}}"></a>
                                    <div class="media-body">
                                        <h4 class="media-heading" style="margin-left: 5px;">{{$events['title_event']}}</h4>
                                        <h5 class="media-heading" style="margin-left: 5px;">{{ $events['name_type_ticket']}}</h5>
                                    </div>
                                </div>
                            </td>
                            <td class="col-xs-3 col-sm-3 col-md-3 col-lg-3 displayQty">
                                <div class="list-inline">
                                    <div class="qty-changer">
                                        <button class="subtract" id="button_{{$events['id']}}" value="{{$events['id']}}">-</button>
                                        <input type="hidden" id="price{{$events['id']}}" value="{{$events['price']}}">
                                        <div class="quanti" id="quanti{{$events['id']}}">
                                            {{$events['qty']}}
                                        </div>
                                        <button class="them" value="{{$events['id']}}">+</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </td>
                            <td class="col-sm-1 col-md-1 text-center">
                                <span class="price_update" id="price_update{{$events['id']}}">{{$events['price']}}</span>VNĐ
                            </td>
                            <td class="col-sm-1 col-md-1 text-center">
                                <strong class="price_change" id="price_change{{$events['id']}}">{{number_format(($events['qty'] * $events['price']),3)}}</strong>
                            </td>
                            <td class="col-sm-1 col-md-1">
                                <button class="btn btn-danger closecart" value="{{$events['id']}}"><span class="glyphicon glyphicon-remove"></span>Xóa</button>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><h3 class="total">Tổng tiền</h3></td>
                            <td class="text-right"><h4><strong class="totaltong">{{number_format(Session::get('cart')->totalPrice,3)}} <span>&nbsp;VNĐ</span></strong></h4></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <a href="{{route('getallevent')}}" class="btn btn-default">
                                    <span class="glyphicon glyphicon-shopping-cart"></span> Tiếp tục mua vé
                                </a>
                            </td>
                            <td>
                                <a href="{{route('checkout')}}" class="btn btn-success">
                                    Thanh toán <span class="glyphicon glyphicon-play"></span>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @else
            <!-- hiển thị thông báo khi chưa có sự kiện được add vào giỏ -->
                <div class="inform">
                    <h3>Vui lòng thêm sự kiện vào giỏ. Giỏ của bạn hiện không có sự kiện nào.</h3>
                     <a href="{{route('getallevent')}}" class="btn btn-success" style="float: right;">
                        <span class="glyphicon glyphicon-shopping-cart" id="continuex"></span>Tiếp tục mua vé
                    </a>
                </div>
                <!-- End -->
            @endif
        </div>
    </div>
    <!-- End -->
</div>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script>
    //Tăng số lượng
   $(document).on('click', '.them', function () {
    var product_id = $(this).val();
    var gia = '#price'+product_id;
    var price = $(gia).val();
    var quantity = '#quanti' + $(this).val();
    quantity = parseInt($(quantity).text());
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $.ajax({
        type: "get",
        url:  "{{URL::to('addtocart')}}/"+ product_id,
        dataType: "json",
        data: {id: product_id, price:price,quantity:quantity},
        success: function (data) { // What to do if we succeed
            console.log(data);
            var plus = '#quanti' + product_id;
            var price = '#price_update' + product_id;
            var price_chan = '#price_change'+product_id;
            var tongQty = data.qty + data.quantity_order;
            if(data.HetVe==0){
                alert('Đã hết vé!');
            }
            else if(data.quan==data.sl){
                alert('Đã hết vé!');
            }
            else{
                
            }
            $(plus).html(data.qty);
            $(price).html(data.price);
            $('.dem').html(data.quantyti);
            $('.totalprice').html(data.totalprice);
            $('.totaltong').html(data.totaltong);
            $('.count_cart').html(data.quantyti);
            $(price_chan).html(data.price_up);
        },
    })
});
//End tăng số lượng
// Giảm số lượng
 $(document).on('click', '.subtract', function () {
    var gia = '#price'+product_id;
    var price = $(gia).val();
    var quantity = '#quanti' + $(this).val();
    quantity = parseInt($(quantity).text());
    if (quantity > 1) {
        var product_id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        $.ajax({
            type: "get",
            url:  "{{URL::to('deductbyone')}}/"+ product_id,
            dataType: "json",
            data: {id: product_id, price:price, quantity:quantity},
            success: function (data) { // What to do if we succeed
                console.log(data);
                var plus = '#quanti' + product_id;
                var price = '#price_update' + product_id;
                var price_chan = '#price_change'+product_id;
                $(plus).html(data.qty);
                $(price).html(data.price);
                $('.totalprice').html(data.totalprice);
                $('.totaltong').html(data.totaltong);
                $(price_chan).html(data.price_up);
                $('.dem').html(data.quantyti);
            },
//
        })
    }
});
//End giảm số lượng
//Xóa sự kiện khi vào giỏ cart
 $(document).on('click', '.closecart', function () {
    var product_id = $(this).val();
    var answer = confirm('Bạn có muốn xóa sự kiện này không?');
    if (answer) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        $.ajax({
            type: "get",
            url: "{{URL::to('removeticket')}}/"+ product_id,
            dataType: "json",
            data: {id: product_id},
            success: function (data) { // What to do if we succeed
                console.log(data);
                var temp = '#cart-header' + product_id;
                $(temp).html(data.html);
                var cart = '#cart-up' + product_id;
                $(cart).html(data.html);
                $('.dem').html(data.quantity);
                $('.count_cart').html(data.quantity);
                $('.totalprice').html(data.totalprice);
                $('.totaltong').html(data.totaltong);
            },
        })
    } else {

    }
});
 //End
</script>
@endsection