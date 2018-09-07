@extends('layouts.app')
@section('content')
<!-- //for-mobile-apps -->
<link href="css/events/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/events/allevent.css" rel="stylesheet" type="text/css" media="all" />
<!-- js -->
<script src="js/jquery-1.11.1.min.js"></script>
<!-- banner -->
	<div class="banner">
		<div class="w3l_banner_nav_left">
			<nav class="navbar nav_bottom">
			 <!-- Brand and toggle get grouped for better mobile display -->
			  <div class="navbar-header nav_2">
				  <button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
			   </div> 
			   <!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
					<h4 style="line-height: 36px;">Công ty</h4>
					<ul class="nav navbar-nav nav_1">
						 @foreach($company as $data)
							<li><a href="{{route('events', $data->id)}}">{{$data->name_company}}</a></li>
						@endforeach
					</ul>
				 </div><!-- /.navbar-collapse -->
			</nav>
			<nav class="navbar nav_bottom">
			 <!-- Brand and toggle get grouped for better mobile display -->
			  <div class="navbar-header nav_2">
				  <button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
			   </div> 
			   <!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
					<h4 style="line-height: 36px;">Loại sự kiện</h4>
					<ul class="nav navbar-nav nav_1">
						  @foreach($type_event as $type_event)
			                <li><a href="{{route('loaisanpham',$type_event->id)}}">{{$type_event->name_type_event}}</a></li>
			               @endforeach
					</ul>
				 </div><!-- /.navbar-collapse -->
			</nav>
		</div>
		<div class="w3l_banner_nav_right">
<!-- events -->
			<div class="events">
				<h3>Sự kiện</h3>
				<div class="events-bottom">
					@foreach($event_company as $data)
						<div class="col-md-6 events_bottom_left">
							<div class="col-md-4 events_bottom_left1">
								<div class="events_bottom_left1_grid">
									<h4>{{date('d',strtotime($data->date_start))}}</h4>
									<p>{{date('F,Y',strtotime($data->date_start))}}</p>
								</div>
							</div>
							<div class="col-md-8 events_bottom_left2">	
							<a href="{{route('detailevents',$data->id)}}" title="{{$data->title_event}}"><img src="{{$data->folder.$data->attached_file}}" style="width: 100%;height: 250px;" alt=" " class="img-responsive" /></a>
								<h4>{{$data->title_event}}</h4>
								<ul>
									<li><i class="fa fa-clock-o" aria-hidden="true"></i>{{date('H:i:s',strtotime($data->date_start))}}</li>
									<li><i class="fa fa-user" aria-hidden="true"></i><a href="#">{{$data->location}}</a></li>
								</ul>
								<p>{{ str_limit($data->description, $limit = 106, $end = '...') }}<a href="{{route('detailevents',$data->id)}}" title="" class="link_watch">xem thêm</a></p>
							</div>
							<div class="clearfix"> </div>
						</div>
					@endforeach
					<div class="clearfix"> </div>
				</div>
				<div class="row" style="float: right;">
					{{$event_company->links()}}
				</div>
			</div>
		</div>
		<div class="image_dynamic">
			<img src="images/source.gif" class="img-responsive" width="200px" ">				
		</div>
		<div class="clearfix"></div>
	</div>
<!-- //banner -->
<!-- Bootstrap Core JavaScript -->
<script src="js/admin/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
    $(".dropdown").hover(            
        function() {
            $('.dropdown-menu', this).stop( true, true ).slideDown("fast");
            $(this).toggleClass('open');        
        },
        function() {
            $('.dropdown-menu', this).stop( true, true ).slideUp("fast");
            $(this).toggleClass('open');       
        }
    );
});
</script>
@endsection