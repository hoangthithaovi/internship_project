<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/events/choose_ticket.css')}}">
<!------ Include the above in your HEAD tag ---------->
@extends('layouts.app')
@section('content')
<section style="background:#efefe9;">
	<!-- Show tất cả loại vé của sự kiện đó lên để khách hàng có thể chọn mua nhiêu loại vé cùng một lúc -->
	<div class="container-fluid">
		<div class="row">
			<!-- Show tất loại vé -->
		    <div class=" board col-sm-6 col-md-6 col-lg-6">
		        <!-- <h2>Welcome to IGHALO!<sup>™</sup></h2>-->
		        <div class="row">
		        	<!-- Hiển thị thông tin của sự kiện muốn chọn vé -->
			    	<div class="panel panel-default">
	    	    		<div class="panel-body">
	    	    			<p class="name_event">{{$name_event->title_event}}</p>
	    	    			<p class="location1">{{$name_event->location}}</p>
	    	    			<p class="date1">{{date('d-m-Y',strtotime($name_event->date_start))}}
	    	    			&nbsp;&nbsp;{{date('H:i',strtotime($name_event->date_start))}}
	    	    			</p>
	    	    		</div>
			    	</div>    
			    		<!-- End -->
		         </div>
	        	 <div class="tab-content">
		          	<div class="tab-pane fade in active" id="home">
		              <h3 class="head text-center">Chọn loại vé<sup>™</sup> <span style="color:#f48260;">♥</span></h3>
			             <div class="panel panel-default">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
										<h5 >Tên vé</h5>
									</div>
									<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
										<h5>Giá vé</h5>
									</div>
									<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
										<h5 >Số lượng</h5>
									</div>
								</div>
							</div>
							<div class="panel-body">
								@foreach($type_event as $loai)
								<div class="row">
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
										<h5>{{$loai->name_type_ticket}}</h5>
									</div>
									<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
										<h5 class="ticket" id="ticket{{$loai['id']}}"></h5>
									</div>
									<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
										<h5>{{number_format($loai->price,2)}}</h5>
									</div>
									<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
										<div class="btn-group">
											<div class="qty-changer">
									            <button class="qty" id="button_{{$loai['id']}}" value="{{$loai['id']}}">-</button>

									            <input type="hidden" id="price{{$loai['id']}}" value="{{$loai['price']}}">
									             <div class="soluong" id="soluong{{$loai['id']}}">
				                                    0
				                                </div>
									            <button class="qty-change" value="{{$loai['id']}}">+</button>
									        </div>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						 </div>
		             	 <div class="text-center">
		             	 	<a href="{{route('getallevent')}}" class="btn btn-success btn-outline-rounded green" id="continuex" > Tiếp tục mua vé</a>
		             	 	<a href="{{route('shopping_cart')}}" class="btn btn-success btn-outline-rounded green" id="shopping_cart" >Đi đến giỏ hàng</a>
		             	 	<a href="{{route('checkout')}}" class="btn btn-success btn-outline-rounded green" id="payment" >Thanh toán</a>
		             	 </div>
		            </div>
				</div>
			</div>
			<!-- End show vé -->
			<!-- Show chỗ ngồi -->
			<div class="board col-sm-5 col-md-5 col-lg-5"> 	
				@foreach($mapEvent as $map)
				<img src="{{$map->folder.$map->attached_file}}" alt="" class="img-responsive">
				@endforeach
			</div>
			<!-- End show chỗ ngồi -->
		</div>
	</div>
	<!-- End -->
</section>
<script type="text/javascript">
// Tăng số lượng
  $(document).on('click', '.qty-change', function () {
    var product_id = $(this).val();
    var quantity = '#soluong' + $(this).val();
        quantity = parseInt($(quantity).text());
    var gia = '#price'+product_id;
    var price = $(gia).val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $.ajax({
        type: "get",
        url:  "{{URL::to('addtocart')}}/"+ product_id,
        dataType: "json",
        data: {id: product_id, price:price, quantity:quantity},
        success: function (data) { // What to do if we succeed
        	console.log(data);
        	var plus = '#soluong' + product_id;
	        var price = '#price_update' + product_id;
	        var price_chan = '#price_change'+product_id;
	        var ticket = '#ticket' + product_id; 
	        if(data.HetVe==0){
	        	$(ticket).html("Hết Vé!!!");
	        }
	        else if(data.quan==data.sl){
	        	$(ticket).html("Hết Vé!!!");
	        }
	        else{
	        }
        	$(plus).html(data.qty);
	        $(price).html(data.price);
	        $('.dem').html(data.quantyti);
	        $('.totalprice').html(data.totalprice);
	        $('.totaltong').html(data.totaltong);
	       $(price_chan).html(data.price_up);
            
        },
    })
});
//Giảm số lượng

 $(document).on('click', '.qty', function () {
    var gia = '#price'+product_id;
    var price = $(gia).val();
    var quantity = '#soluong' + $(this).val();
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
	            var plus = '#soluong' + product_id;
	            var price = '#price_update' + product_id;
	            var price_chan = '#price_change'+product_id;
	            $(plus).html(data.qty);
	            $(price).html(data.price);
	            $('.dem').html(data.quantyti);
	            $('.totalprice').html(data.totalprice);
	            $('.totaltong').html(data.totaltong);
	            $(price_chan).html(data.price_up);
            },
//
        })
    }
});


</script>
@endsection