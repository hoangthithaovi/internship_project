@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('css/bill/bill.css')}}">
<div class="container">
		@if (session('message'))
		    <div class="alert alert-success">
		        {{ session('message') }}
		    </div>
	    @endif
	    <div class="row">
	    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			    <div class="panel panel-success" style="margin-top: 30px;">
			    	<div class="panel-heading">
			    		<h3 class="panel-title" style="font-size: 1.5em;">THÔNG TIN HÓA ĐƠN CỦA BẠN</h3>
			    	</div>
			    	<br>
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
			    	<div class="panel-body">
			    		<hr style="width: 100%;">
			    		<h4>Cảm ơn bạn vì đã quan tâm đến trang web của chúng tôi.</h4>
			    		<h4>Đây là thông tin vé của bạn.</h4>
			    		<!-- <div class="row"> -->
			    			<table class="table table-striped table-hover">
			    				<thead>
			    					<tr>
			    						<th>Thông tin đặt vé</th>
										<th>Hình thức thanh toán</th>
			    						<th>Ngày đặt vé</th>
			    					</tr>
			    				</thead>
			    				<tbody>
										@foreach($getOrder as $order)
			    					<tr>
										<td>Tên sự kiện:{{$order->title_event}}<br/>
											Số lượng: {{$order->quantity}}<br/>
											Giá vé:   @if($order->price==0)<b>FREE</b>@else {{$order->price}}@endif<br/>
										<td>@if($order->payment==1) Thanh toán trực tiếp @else Thanh toán qua thẻ ngân hàng @endif</td>
										</td>
										<td>{{date('d-m-Y',strtotime($order->date_order))}}</td>
			    					</tr>
			    						@endforeach
			    				</tbody>
			    			</table>
			    			
			    		<!-- </div> -->
			    	</div>
			    	<p class="text-center">Chúc bạn sẽ có một buổi tham gia sự kiện thật vui vẻ và tuyệt vời cùng với Event Tommorrow</p>
			    	<p class="text-center">Vui lòng khi đi nhớ mang theo vé của bạn! Mọi thông tin về sự kiện chúng tôi sẽ gửi đến email &nbsp;<b>{{Auth::user()->email}}&nbsp;</b>của bạn. </p>
	   			 </div>
	   			 <a href="{{url('/')}}" class="btn btn-lg btn-success">Quay về trang chủ</a>
	    	</div>
	    </div>
</div>
@endsection