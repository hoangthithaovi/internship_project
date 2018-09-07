@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('css/bill/bill.css')}}">
<div class="container">
    <div class="row">
    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		    <div class="panel panel-success" style="margin-top: 30px;">
		    	<div class="panel-heading">
		    		<h3 class="panel-title" style="font-size: 1.5em;">THÔNG TIN HÓA ĐƠN CỦA BẠN</h3>
		    	</div>
		    	@if(count($getCusInfor)>0)
		    	<div class="row">
		    		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			    		<p class="name_customer">Tên khách hàng:<b>{{$getCusInfor[0]->fullname}}</b></p>
			    		<p class="address_customer">Địa chỉ:<b> {{$getCusInfor[0]->address}}</b></p>
		    		</div>
		    		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		    			<p>Số điện thoại: <b>{{$getCusInfor[0]->phone_number}}</b></p>
		    			<p>Email:<b>{{$getCusInfor[0]->email}}</b></p>
		    		</div>
		    	</div>
		    	@endif
		    	<div class="panel-body">
		    		<hr style="width: 100%;">
		    		<p>Cảm ơn bạn <strong>@if(Auth::check()){{Auth::user()->username}}@endif</strong> đã quan tâm đến các sự kiện của chúng tôi.</p>
		    		<p>Đây là thông tin vé của bạn.</p>
		    			<div class="row">
							@if (session('sucess'))
							    <div class="alert alert-danger noty" id="noty">
							        {{ session('sucess') }}
							    </div>
						    @endif
						</div>
		    		@if($showBill)
		    			<table class="table table-striped table-hover">
		    				<thead>
		    					<tr>
		    						<th>Thông tin đặt vé</th>
									<th>Hình thức thanh toán</th>
		    						<th>Ngày đặt vé</th>
		    						<th>Ngày sự kiện bắt đầu</th>
		    						<th>Status</th>
		    						<th>Action</th>
		    					</tr>
		    				</thead>
		    				<tbody>
									@foreach($showBill as $order)
		    					<tr class="cart-bill" id="cart-bill{{$order->ID_orderDetail}}">
									<td>Tên sự kiện:{{$order->title_event}}<br/>
										Số lượng: {{$order->quantity}}<br/>
										Giá vé:   @if($order->price==0)<b>FREE</b>@else {{$order->price}}@endif<br/></td>
									<td>@if($order->payment==1) Thanh toán trực tiếp @else Thanh toán qua thẻ ngân hàng @endif</td>
									<td>{{date('d-m-Y',strtotime($order->date_order))}}</td>
									<td>{{date('d-m-Y H:i',strtotime($order->date_start))}}</td>
									<td><h5 class="cancel" id="cancel{{$order->ID_orderDetail}}"></h5></td>
									
									<td>
										<input type="hidden" id="ticketed{{$order->ID_orderDetail}}" value="{{$order->IDticket}}">
										<input type="hidden" id="date_started{{$order->ID_orderDetail}}" value="{{$order->date_start}}">
										<input type="hidden" id="is_del{{$order->ID_orderDetail}}" value="{{$order->ID_Delete}}">
										<button class="btn btn-danger closeorder" value="{{$order->ID_orderDetail}}"><span class="glyphicon glyphicon-remove"></span>Xóa</button>
									</td>

		    					</tr>
		    						@endforeach
		    				</tbody>
		    			</table>
					@else
						<p class="bill_infor">Không có hóa đơn nào.</p>
					@endif
		    	</div>
		    	<p class="text-center">Chúc bạn sẽ có một buổi tham gia sự kiện thật vui vẻ và tuyệt vời cùng với Event Tommorrow</p>
		    	<p class="text-center">Vui lòng khi đi nhớ mang theo vé của bạn! Mọi thông tin về sự kiện chúng tôi sẽ gửi đến email &nbsp;<b>@if(Auth::check()){{Auth::user()->email}}@endif &nbsp;</b>của bạn. </p>
		    	<p class="text-center">Lưu ý: Bạn chỉ được hủy vé trước 48 giờ trước khi sự kiện diễn ra.</p>
   			 </div>
   			 <a href="{{url('/')}}" class="btn btn-lg btn-success">Quay về trang chủ</a>
    	</div>
    </div>
</div>
<script type="text/javascript">
	$(document).on('click', '.closeorder', function () {
	    var order_id = $(this).val();
	 	var ticket = '#ticketed'+order_id;
	    var ticketID = $(ticket).val();
	    var date = '#date_started' + order_id;
	    var date_started = $(date).val();
	    var del = '#is_del' + order_id;
	    var delete1 = $(del).val();
	    var answer = confirm('Bạn có muốn xóa hóa đơn này không');
	    if (answer) {
	        $.ajaxSetup({
	            headers: {
	                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            }
	        })
	        $.ajax({
	            type: "get",
	            url: "{{URL::to('removebill')}}/"+ order_id,
	            dataType: "json",
	            data: {id: order_id, ticket_id: ticketID, date_started:date_started},
	            success: function (data) { // What to do if we succeed
	            	console.log(data);
	                var bill = '#cart-bill'+ order_id;
	                $(bill).html(data.html);
	                var ticket = '#cancel' + order_id; 
	                if(data.is_delete==1){
	                	alert("Bạn đã hủy vé thành công?");
	                }
	                else 
	                {
	                	alert('Bạn không thể hủy vé!')
			        	$(ticket).html(data.thongbao);
	                }
	            },
	        })
	    } else {

	    }
});
</script>
@endsection