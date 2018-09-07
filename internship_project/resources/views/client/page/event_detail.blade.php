
@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('css/events/slide_company.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/events/form_like.css')}}">
<link href="css/events/allevent.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
<!-- Show hình ảnh, tên sự kiện, ngày bắt đầu sự kiện, địa điểm diễn ra sự kiện 
tại đây có một nút button để mua vé (chuyển đến trang mua vé) -->
@if($event_details)
<div class="inner-header">
	<div class="container-fluid">
		
		<div class="row">
			<div class="col-xs-1 col-sm-1 col-md-2 col-lg-1">
				<img src="{{asset('assets/images/overtime.png')}}" alt="" class="img-responsive" style="margin-top: 20px">
			</div>
			<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
				<h3 class="title_e">{{$event_details->title_event}}</h2>
				<h4 class="calendar"><i class="fa fa-calendar" aria-hidden="true">&nbsp;&nbsp;</i><span>{{date('H:i',strtotime($event_details->date_start))}}</span> {{date('d-m-Y',strtotime($event_details->date_start))}}</h3>
				<h4 class="location"><i class="material-icons">&#xe55e;</i>&nbsp;{{$event_details->location}}</h3>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<a href="{{route('chooseticket',$event_details->id)}}" class="btn btn-lg buy_ticket" >Mua vé ngay</a>
			</div>
		</div>
	</div>
	<br/>
	<div class="panel panel-default">
	  <div class="panel-body">
	   <div class="container">
	      <div class='row'>
	        <div class='col-md-12'>
	           <div class="carousel slide media-carousel" id="quyen">
	             <div class="carousel-inner">
	                <div class="item  active">
	                  <div class="row">
	                   @foreach($all_image_event as $imageall)
	                    <div class="col-md-3">
	                        <a class="thumbnail" href="#"><img alt="" src="{{$imageall->folder.$imageall->attached_file}}"></a>
	                    </div>
	                     @endforeach          
	                  </div>
	                </div>
	                 <div class="item">
	                  <div class="row">
	                   @foreach($companies as $companie)
						    <div class="col-md-3">
		                  		<a class="thumbnail" href="#"><img src="{{$companie->folder.$companie->attached_file}}" alt="" class="img-responsive" ></a>
		              		</div>   
							@endforeach       
	                  </div>
	                </div>
	            </div>                        
	         </div>
	       </div>
	    </div>
	   </div>
	  </div>
	 </div>
</div>
<!-- End -->
<!-- Có 2 phần: 1.Show chi tiết về sự kiện: mô tả sự kiện, ngày bắt đầu ngày kết thúc, số điện thoại, Fanpage của sự kiện hoặc công ty tổ chức sự kiện, 2. Show những sự kiện nổi bật -->
<div class="container-fluid">
	<div class="row">
		<!-- Show chi tiết sự kiện -->
		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="text-center intro">Giới thiệu</h2>
				</div>
				<div class="show_info">
					<p class="text_des">{{$event_details->description}}</p>
					<p class="text_des"><b>Địa chỉ:</b> <span>{{$event_details->location}}</span></p>
					<p class="text_des"><b>Ngày bắt đầu </b> vào lúc:&nbsp;<b>{{date('H:i',strtotime($event_details->date_start))}}&nbsp;</b> ngày<b>&nbsp;{{date('d-m-Y',strtotime($event_details->date_start))}}</b></p>
					<p class="text_des"><b>Ngày kết thúc:</b> {{$event_details->date_end}}</p>
					<p class="text_des"><b>Trang chủ:</b> contact@devday.org</p>
					<p class="text_des"><b>Vui lòng liên hệ đến số điện thoại:</b>(84) 236 7109 123 | (84) 935 102 044</p>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<img src="{{$event_details->folder.$event_details->attached_file}}" alt="" style="width: 100%; height: 450px; padding-top: 20px; padding-bottom: 20px;" class="img-responsive">
						</div>
					</div>

					<div class="social-cont">
					    <div class="col-md-4">
					    		<div class="like" id="like">
								@if(Auth::check())
									@if(count($existLike)>0)
									<button class="btn Event_like" id="Event_like{{$event_details->id}}" value="{{$event_details->id}}"><i class="fas fa-thumbs-up" style="font-size: 16px;color: #dd0a37"></i></button>
									<input type="hidden" id="id_user{{$event_details->id}}" value="@if(Auth::check()){{Auth::user()->id}}@endif">
									<span class="id_like" id="id_like{{$event_details->id}}">@if($count){{$count[0]->CountLike}} @else 0 @endif</span>
									@else
									<button class="btn Event_like" id="Event_like{{$event_details->id}}" value="{{$event_details->id}}"><i class="fas fa-thumbs-up" style="font-size: 16px;"></i></button>
									<input type="hidden" id="id_user{{$event_details->id}}" value="@if(Auth::check()){{Auth::user()->id}}@endif">
									<span class="id_like" id="id_like{{$event_details->id}}">@if($count){{$count[0]->CountLike}} @else 0 @endif</span>
									@endif
								@else
									<button class="btn Event_like" id="Event_like{{$event_details->id}}" value="{{$event_details->id}}"><i class="fas fa-thumbs-up" style="font-size: 16px; "></i></button>
									<input type="hidden" id="id_user{{$event_details->id}}" value="@if(Auth::check()){{Auth::user()->id}}@endif">
									<span class="id_like" id="id_like{{$event_details->id}}">@if($count){{$count[0]->CountLike}} @else 0 @endif</span>
								@endif
								</div>
					    </div>
				     	<div class="col-md-8">
				      		<div class="social">
					  			<span class="text-right"><p>Share on Social</p></span>
								 <a class="social-icon facebook" target="blank" data-tooltip="Facebook" href="http://www.facebook.com/SOJITRAHIREN">
								    <i class="fa fa-facebook"></i>
								 </a>

								<a class="social-icon twitter" target="blank" data-tooltip="Twitter" href="https://www.twitter.com/Sojitra_Hiren">
								    <i class="fa fa-twitter"></i>
								</a>

								<a class="social-icon linkedin" target="blank" data-tooltip="LinkedIn" href="https://www.linkedin.com/in/hirensojitraamreli">
								    <i class="fa fa-linkedin"></i>
								</a>

								<a class="social-icon google-plus" target="blank" data-tooltip="Google +" href="https://plus.google.com/+HirenSojitraa">
								    <i class="fa fa-google-plus"></i>
								</a>

								<a class="social-icon email" target="blank" data-tooltip="Contact e-Mail" href="mailto:hirensojitra007@gmail.com">
								    <i class="fa fa-envelope-o"></i>
								</a>

							</div>
				        </div>
				        <div class="clearfix"></div>
				    </div>
				</div>
			</div>
		</div>
		<!-- End show chi tiết sự kiện -->
		<!-- Show những sự kiện nổi bật -->
		<div class="col-sm-3 aside">
			<div class="widget">
				<h3 class="text-center" style="margin-bottom: 20px;"><b class="feature_event">Sự kiện nổi bật</b></h3>
				<div class="widget-body">
					<div class="beta-sales beta-lists">
						@foreach($eventall as $query1)
							<div class="media beta-sales-item">
								<a class="pull-left" href="{{route('detailevents',$query1->id)}}"><img src="{{$query1->folder.$query1->attached_file}}" alt="" class="img-responsive" style="position: relative;"></a>
								<div class="media-body">
									<p class="name_event">{{$query1->title_event}}<p>
								</div>
							</div>
						@endforeach

					</div>
				</div>
			</div>
		</div>
		<!-- End những sự kiện nổi bật -->

		<div class="clearfix">
		</div>
</div>	
<!-- End mô tả chi tiết sự kiện-->
<!-- Show hình ảnh công ty liên quan đến sự kiện -->
<!-- Phần comment và reply của khách hàng -->
	<div class="container-fluid">
		<div class="tab-content">
	        <div class="arrivals">                  
		        @if(Auth::check())
		        <div class="well">
		            <h4>Bình luận về sản phẩm:</h4>
		            <form method="POST" id="comment_form" enctype='multipart/form-data'>
		                <input type="hidden" id="_token1" name="_token" value="{{ csrf_token() }}"/>
		                <input type="hidden" id="event_id" name="event_id" value="{{$event_details->id}}">
		                <input type="hidden" id="user_id" value="{{Auth::check() ? Auth::user()->id : 0}}"/>
		                <input type="hidden" id="username" value="{{Auth::check()?Auth::user()->username :""}}"/>

		                <div class="form-group">
		                    <label>Content:</label>
		                    <div class=" row {{ $errors->has('content') ? 'has-error' : '' }}">
		                        <textarea name="content" class="form-control" rows="5" id="content" placeholder="Enter Content"></textarea>
		                        <span class="text-danger">{{ $errors->first('content') }}</span>
		                    </div> 
		                </div>

		                <div class="form-group">
		                    <button type="button" id="comment-btn{{$event_details->id}}" value="{{$event_details->id}}" class="btn btn-primary comment" >Comment</button>
		                </div>
		            </form>                                                                      
		          
		        </div>  
		        @endif                    
	        </div>
	        <div id="show_comment">
	        	<h3 style="font-family: Cambria;">Comments</h3>
	        @if($array_comment)
	            @foreach($array_comment as $comment)
	            <div class="well" >
	                <!-- <div class="media"> -->
	                    <div class="row">
	                        <div class="col-md-2">                           
		                        {{$comment['username']}}<br>
	                        </div>
	                        <div class="col-md-7">
	                            {{str_limit($comment['content'], 300)}} <br>
	                        </div>                                           
	                        <div class="col-md-3">
	                            <p><span class="glyphicon glyphicon-time"></span>Posted: {{date('d/m/y H:i',strtotime($comment['created_at']))}}</p>
	                        </div>
	                       
	                    </div>
	                    <div id="show_reply_{{$comment['id']}}" style="margin-top: 35px;"></div>
	                <!-- </div>   -->
	                 @if(count($comment['childs']))
	                        <button type="button" class="showMorePro btn btn-link" data-toggle="collapse" data-target="#showMoreReply_{{$comment['id']}}">
	                            <span class="glyphicon glyphicon-collapse-down"></span>View More Reply
	                        </button>
	                   @endif  
                   <div id="showMoreReply_{{$comment['id']}}" class="collapse">
                    @if($comment['childs'])
                    @foreach($comment['childs'] as $replyComment)
                        <!-- <div class="media"> -->
                            <div class="row">
                                <div class="col-md-3">
                                @if($replyComment['username'])                           
                                    {{$replyComment['username']}}<br>
                                @endif
                                </div>
                                <div class="col-md-6">
                                {{str_limit($replyComment['content'], 300)}} 
                                </div>
                                <div class="col-md-3">
                                	<p><span class="glyphicon glyphicon-time"></span> Posted: {{$replyComment['created_at']}}</p>
                                </div>  
                            </div>
                        <!-- </div> -->
                    @endforeach 
                    @endif
                    </div>                                
	                @if(Auth::check())
	                <div class="button">
		                <button type="button" class="replyPro btn btn-primary" data-toggle="collapse" data-target="#replyForProduct_{{$comment['id']}}">
		                    <span class="glyphicon glyphicon-collapse-down"></span>Write Reply
		                </button>
		            </div>
		            <div class="well collapse" id="replyForProduct_{{$comment['id']}}">
		                <form id="replyComment_{{$comment['id']}}" name="comment" method="POST" enctype='multipart/form-data'>
		                    <input type="hidden" id="token_reply" name="_token" value="{{ csrf_token() }}"/>
		                    <input type="hidden" id="pro_id_{{$comment['id']}}" name="event_id" value="{{$event_details->id}}">
		                    <input type="hidden" id="parent_id_{{$comment['id']}}" name="parent_id" value="{{$comment['id']}}">
		                    <input type="hidden" id="user_id" value="{{Auth::check() ? Auth::user()->id : 0}}"/>
		                    <input type="hidden" id="username" value="{{Auth::check()?Auth::user()->username :""}}"/>

		                    <div class="form-group">
		                        <label for="content">Content:</label>
		                        <div class=" row {{ $errors->has('content') ? 'has-error' : '' }}">
		                            <textarea id="reply_content_{{$comment['id']}}" name="content" class="form-control" rows="4" placeholder="Enter Content..." required></textarea>
		                           	<span class="text-danger">{{ $errors->first('content') }}</span>
		                        </div>                                           
		                    </div>
		                    <div class="form-group">
		                        <button class="btn btn-primary reply" type="button" id="reply{{$comment['id']}}" value="{{$comment['id']}}">Reply</button>
		                    </div>
		                </form>  
		            </div> 
		        </div>
		        @endif
		        <script>
		            var comment_id = document.getElementById("parent_id_{{$comment['id']}}");
		            $('#replyForProduct' + comment_id).on("hide.bs.collapse", function(){
		            $(".replyPro").html('<span class="glyphicon glyphicon-collapse-down"></span> Write Reply');
		            });
		            $('#replyForProduct' + comment_id).on("show.bs.collapse", function(){
		            $(".replyPro").html('<span class="glyphicon glyphicon-collapse-up"></span> Close Reply');
		            });
		        </script>

		        <script>
		            var comment_id = document.getElementById("parent_id_{{$comment['id']}}");
		            $('#showMoreReply_' + comment_id).on("hide.bs.collapse", function(){
		            $(".showMorePro").html('<span class="glyphicon glyphicon-collapse-down"></span>View More Reply');
		            });
		            $('#showMoreReply_' + comment_id).on("show.bs.collapse", function(){
		            $(".showMorePro").html('<span class="glyphicon glyphicon-collapse-up"></span>Hide Reply');
		            });
		        </script>
		        @endforeach                          
	        @endif
	    	</div>
	   	</div>                      
  	</div>  
</div>

		<div class="clearfix">
		</div>
</div>	
@endif
<!-- <div class="container-fluid">
	<div class='row'>
		<div class=" col-md-12 panel panel-default">
			<div class="panel-heading">
				<h3 class="text-center"><b>Các công ty liên quan</b></h3>
				</div>
			  	<div class="carousel media-carousel" id="media">
			        <div class="carousel-inner">
			          <div class="item active">
			            <div class="row">
			            	@foreach($companies as $companie)
							    <div class="col-md-4">
			                  		<a class="thumbnail" href="#"><img src="{{$companie->folder.$companie->attached_file}}" alt="" class="img-responsive" ></a>
			              		</div>   
							@endforeach
			                    
			            </div>
			          </div>
			  		</div>
				</div>
		</div>                          
	</div>
</div> -->

<script>
	$(document).on('click', '.Event_like', function () {
    var event_id = $(this).val();
    var id_user  = '#id_user'+ event_id;
    var user     = $(id_user).val();
  	if(user){
	    $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	    })

	    $.ajax({
	        type: "get",
	        url:  "{{URL::to('likeEvent')}}/"+ event_id,
	        dataType: "json",
	        data: {event_id: event_id, id_user:user},
	        success: function (data) { // What to do if we succeed
	            console.log(data.Amountdemlike);
	            if(data.dem==0){
	            	var like = '<i class="fas fa-thumbs-up" style="font-size: 16px; color:#dd0a37;"></i>';
						$('#Event_like'+ data.event_id).html(like);
						$('#id_like'+ data.event_id).html(data.Amountdemlike);

	            }
	            else
	            {
	            	var like = '<i class="fa fa-thumbs-down" style="font-size: 16px;"></i>';
						$('#Event_like'+ data.event_id).html(like);
						$('#id_like'+ data.event_id).html(data.Amountdemlike);
	            }

	        },
	    })
	}
	else {
		alert("Bạn cần đăng nhập trước khi like.Cảm ơn");
	}
});
//Commetn
$(document).ready(function(){
 	$(document).on('click', '.comment', function () {
	    var event_id = $(this).val();
	    var content  = $('#content').val();
		    $.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        }
		    })

		    $.ajax({
		        type: "POST",
		        url:  "{{URL::to('comment_event')}}",
		        dataType: "json",
		        data: {event_id: event_id, content:content},
		        success: function (data) { // What to do if we succeed
		            console.log(data);
		           var comment = '<div class="well">'
                    + '<div class="row">'
                    + '<div class="col-md-2">'
                    + $('#username').attr("value") + '<br>'
                    + '</div>' + '<div class="col-md-7">'+ data.content + '<br>' + '</div>' + '<div class="col-md-3">' + '<p>' + '<span class="glyphicon glyphicon-time">' + '</span>' + 'Posted:'
                    + data.created_at + '</p>' + '</div>' + '</div>' + '<div id="show_reply_' + data.id + '" style="margin-top: 35px;"></div>' + '</div>'
                    + '<div class="button">' + '<button type="button" class="replyPro btn btn-primary" data-toggle="collapse" data-target="#replyForProduct_'
                    + data.id + '">' + '<span class="glyphicon glyphicon-collapse-down"></span>' + 'Write Reply' + '</button>' + '</div>'
                    + '<div class="well collapse" id="replyForProduct_' + data.id + '">'
                    + '<form id="replyComment_' + data.id + '" name="comment" method="POST" enctype="multipart/form-data">'
                    + '<input type="hidden" id="token_reply" name="_token" value="' + $('input[name="_token"]').val() + '"/>'
                    + '<input type="hidden" id="pro_id_' + data.id + '" name="event_id" value="' + data.event_id + '">'
                    + '<input type="hidden" id="parent_id_' + data.id + '" name="parent_id" value="' + data.id + '">'
                    + '<input type="hidden" id="user_id" value="' + data.user_id + '"/>'

                    + '<div class="form-group">'
                    + '<label for="content">Content:</label>'

                    + '<textarea id="reply_content_' + data.id + '" name="content" class="form-control" rows="5" placeholder="Enter Content" required></textarea>'
                    + '<span class="text-danger"></span>'
                    + '</div>'

                    + '<div class="form-group">'
                    + '<button class="btn btn-primary reply" data-id="' + data.id + '" value="' + data.id + '">Reply</button>'
                    + '</div>'
                    + '</form>'
                    + '</div>';
            		$('#show_comment').append(comment);
            		$('#content').val('');
		        },
		        error: function (data) {
            	console.log('Error:', data);
        	}
		    })
	});
});

//Reply của comment
$(document).ready(function(){
	$(document).on('click', '.reply', function () {
	    var comment_id = $(this).val();
	   	var content    = $('#reply_content_' + comment_id).val();
	   	var product_id = $('#pro_id_' + comment_id).val();
	   	var parent_id  = $('#parent_id_' + comment_id).val();
	    $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('#token_reply').val()
	        }
	    });
	    $.ajax({
	        type: "get",
	        url: "{{URL::to('reply_event')}}",
	        data: {comment_id:comment_id,content:content,product_id:product_id,parent_id:parent_id},
	        dataType: 'json',
	        success: function (data) {
	            console.log(data['reply']['content']);
	            var reply = '<div class="well" >'
				                    + '<div class="row">'
					                    + '<div class="col-md-3">'
					                    	+ $('#username').attr("value") + '<br>'
					                	+ '</div>' 
				                		+ '<div class="col-md-6">'+ data['reply']['content'] + '<br>' + '</div>' 
					                	+ '<div class="col-md-3">' + '<p>' + '<span class="glyphicon glyphicon-time">' + '</span>' + 'Posted:'
					                    + data['reply']['created_at'] + '</p>' 
					                    + '</div>' 
				                    + '</div>' 
			                    	+ '<div id="show_reply_' + data.id + '" style="margin-top: 35px;"></div>'
                    		+ '</div>';
            		$('#show_reply_' + comment_id).append(reply);
            		$('#reply_content_' + comment_id).val('');
	        },
	        error: function (data) {
	            console.log('Error:', data);
	        }
	    });
	});
});

</script>
@endsection
