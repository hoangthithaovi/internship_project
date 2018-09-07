<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <base href="{{asset('')}}">
  <meta name="_token" content="{{ csrf_token() }}" /> 
  @include('layouts.link')
</head>
<body>
  
<body>
  <div class="top_nav_right" style="top: 48px !important">
        <div class="shoecart shoecart2 cart cart box_1">
          <form action="#" method="post" class="last">
            <input type="hidden" name="cmd" value="_cart">
            <input type="hidden" name="display" value="1">
            <a class="top_shoe_cart" href="{{route('shopping_cart')}}" name="submit" value=""><i class="fa fa-cart-arrow-down" aria-hidden="true"></i><span class="dem">@if (Session::has('cart')){{Session('cart')->totalQty}}
                @else 0 @endif</span></a>
          </form>
        </div>
  </div>
  <header id="header" class="transparent-navbar">
    <!-- container -->
    <div class="container">
      <!-- navbar header -->
      <div class="navbar-header">
        <!-- Logo -->
        <div class="navbar-brand">
          <a class="logo" href="index.html">
            <img class="logo-img" src="./img/logo.png" alt="logo">
            <img class="logo-alt-img" src="./img/logo-alt.png" alt="logo">
          </a>
        </div>
        <!-- /Logo -->

        <!-- Mobile toggle -->
        <button class="navbar-toggle">
            <i class="fa fa-bars"></i>
          </button>
        <!-- /Mobile toggle -->
      </div>
      <!-- /navbar header -->

      <!-- Navigation -->
      <nav id="nav">
        <ul class="main-nav nav navbar-nav navbar-right">
           @if(Auth::check())
            @if(Auth::user()->role==0)
            <li><a href="">Chào bạn &nbsp;{{Auth::user()->username}}</a></li>
            @endif
          @endif
          <li><a href="{{url('/')}}">Trang chủ</a></li>
          <li><a href="{{url('/getallevent')}}">Sự kiện</a></li>
          <li><a href="{{route('about')}}">Về chúng tôi</a></li>
          <li><a href="{{url('/addcontact')}}">Liên hệ</a></li>
           @if(Auth::check())
          <li><a href="{{route('showbill',Auth::user()->id)}}" title="">Xem hóa đơn</a></li>
          <li>
              <a href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                  Đăng xuất
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
          </li>
          @else
            <li><a href="{{ route('register') }}">Đăng kí</a></li>
            <li><a href="{{ route('login') }}">Đăng nhập</a></li>
          @endif
        </ul>
      </nav>
      <!-- /Navigation -->
    </div>
    <!-- /container -->
  </header>
   <!-- Home -->
  <div id="homes">
    <!-- background image -->
    <div class="section-bg" style="background-image:url(./img/background01.jpg)" data-stellar-background-ratio="0.5"></div>
    <!-- /background image -->

    <!-- home wrapper -->
    <div class="home-wrapper">
      <!-- container -->
      <div class="container">
        <!-- row -->
        <div class="row">
          <!-- home content -->
          <div class="col-md-8 col-md-offset-2">
            <div class="home-content">
              <h1>CUỐI TUẦN SÔI ĐỘNG CÙNG CÁC LỄ HỘI ĐƯỜNG PHỐ</h1>
              <h4 class="lead">LỄ HỘI ĐỒNG HÀNH CÙNG DIFF 2018<br/>
                                COLOR YOUR WEEKEND WITH THE STREET FESTIVAL</h4>
              <a href="#" class="main-btn">Buy Ticket</a>
            </div>
          </div>
          <!-- /home content -->
        </div>
        <!-- /row -->
      </div>
      <!-- /container -->
    </div>
    <!-- /home wrapper -->
  </div>
  <!-- /Home -->
     <!-- search -->
   <div class="search_w3ls_agileinfo">
    <div class="cd-main-header">
      <ul class="cd-header-buttons" style="top: 93px !important">
        <li><a class="cd-search-trigger" href="#cd-search"> <span></span></a></li>
      </ul>
      <div id="cd-search" class="cd-search" style="top: 150px">
        <form action="{{route('eventssearch')}}" method="GET">
           <div class="input-group">
              <input type="text" class="form-control"  name="search_text" style="background-color: white !important; color: #0F0E0E;">
              <span class="input-group-btn">
                  <button class="btn btn-lg btn-success" type="submit" style="height: 56px;">
                      <span class="glyphicon glyphicon-search"></span>
                  </button>
              </span>
          </div>
        </form>
      </div>
    </div>   
  </div>
        <!-- //search -->
</body>

  <ul class="top_icons">
    <li><a href="#"><span class="fab fa-facebook-f" aria-hidden="true"></span></a></li>
    <li><a href="#"><span class="fab fa-twitter" aria-hidden="true"></span></a></li>
    <li><a href="#"><span class="fab fa-linkedin-in" aria-hidden="true"></span></a></li>
    <li><a href="#"><span class="fab fa-google-plus-g" aria-hidden="true"></span></a></li>
  </ul>

<!-- Feature events -->
<div class="wrapper_top_w3layouts">
  <div class="container-fluid">
    <div class="news" id="news">
      <div class="container">
        <div class="w3-welcome-heading">
          <h3>Sự kiện <span class="feature"> mới</span></h3>
        </div>
        <div class="row">
           @if($eventall)
          <div class="agile-news-grid">
              @foreach($eventall as $data =>$query1)
              <div class="col-md-6 agile-news-left">
                <div class="col-md-6 ">
                  <div class="news-left-img" style="background: url({{$query1->folder.$query1->attached_file}}) no-repeat 0px 0px; background-size: 250px 154px;">
                    <div class="news-left-text">
                      <a href="{{route('detailevents',$query1->id)}}" class="title_event"><h5>{{$query1->title_event}}</h5></a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 news-grid-info-bottom">
                  <div class="news-left-top-text">
                    <a href="#" data-toggle="modal" data-target="#myModal" class="location">{{$query1->location}}</a>
                  </div>
                  <div class="date-grid">
                    <div class="time">
                      <p><i class="fa fa-calendar" aria-hidden="true"></i> {{date('d-m-Y H::i',strtotime($query1->date_start))}}</p>
                    </div>
                    <div class="clearfix"> </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-5 like" id="like">
                      <button class="btn Home_Like" id="Home_Like{{$query1->id}}" value="{{$query1->id}}"><i class="fas fa-thumbs-up" style="font-size: 10px;"></i></button>
                      <input type="hidden" id="id_user_Home{{$query1->id}}" value="@if(Auth::check()){{Auth::user()->id}}@endif">
                      <input type="hidden" id="id_Event_Home{{$query1->id}}" class="id_Event_Home" value="{{$query1->id}}">
                      <span class="id_like_Home" id="id_like_Home{{$query1->id}}"></span>
                    </div>
                    <div class="col-sm-7 comment">
                        <button class="btn Home_Comment" id="Home_Comment{{$query1->id}}" value="{{$query1->id}}"><i class="fas fa-comment" style="font-size: 10px;"></i></button>
                        <input type="hidden" id="id_Event_Comment{{$query1->id}}" class="id_Event_Comment" value="{{$query1->id}}">
                        <span class="id_comment" id="id_comment_Home{{$query1->id}}"></span>
                    </div>
                  </div>
                  <div class="news-grid-info-bottom-text">
                    <p class="description">{{ str_limit($query1->description, $limit = 100, $end = '...') }}<a href="{{route('detailevents',$query1->id)}}" title="" class="link_watch">xem thêm</a></p>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              @endforeach
          </div>
           @endif
        </div>
      </div>
    </div>
  </div> 
</div>
<div class="clearfix"></div>    
<!-- End show feature events -->
<!-- Start show new events -->
<div class="wrapper_top_w3layouts">
  <div class="container-fluid">
    <div class="news jarallax" id="news">
      <div class="container">
        <div class="w3-welcome-heading">
          <h3><span class="feature">Sự kiện </span> nổi bật</h3>
        </div>   
        @if($start_event)     
          @if(count($start_event)> 0)
            @foreach($start_event as $new_event)
            <div class="news-grids">
              <div class=" col-md-4 section-grid-wthree one">
                <div class="services-info-w3-agileits">
                  <h5 class="sub-title"><a href="#">{{$new_event->title_event}}</a></h5>
                   <h6 class="location">{{$new_event->location}}</h6>
                  <h6><i class="fa fa-calendar" aria-hidden="true">&nbsp;&nbsp;</i>{{date('d-m-Y H::i',strtotime($new_event->date_start))}}</h6>
                  <p class="para-w3">{{ str_limit($new_event->description, $limit = 100, $end = '...') }}<a href="{{route('detailevents',$new_event->id)}}" title="" class="link_watch">xem thêm</a></p>
                </div>
                <div class="services-img-agileits-w3layouts">
                  <a href="{{route('detailevents',$new_event->id)}}"><img src="{{$new_event->folder.$new_event->attached_file}}" alt="service-img"></a>
                </div>
              </div>  
            </div>
            @endforeach
            <!--  <div class="clearfix"></div> -->
          @else
            @foreach($newevent as $new_event)
            <div class="news-grids">
              <div class=" col-md-4 section-grid-wthree">
                <div class="services-info-w3-agileits">
                  <h5 class="sub-title"><a href="#">{{$new_event->title_event}}</a></h5>
                  <h6  class="location">{{$new_event->location}}</h6>
                  <h6><i class="fa fa-calendar" aria-hidden="true">&nbsp;&nbsp;</i>{{date('d-m-Y H::i',strtotime($new_event->date_start))}}&nbsp;</h6>
                  <p class="para-w3">{{ str_limit($new_event->description, $limit = 100, $end = '...') }}<a href="{{route('detailevents',$new_event->id)}}" title="" class="link_watch">xem thêm</a></p>
                </div>
                <div class="services-img-agileits-w3layouts">
                  <a href="{{route('detailevents',$new_event->id)}}"><img src="{{$new_event->folder.$new_event->attached_file}}" alt="service-img"></a>
                </div>
              </div> 
            </div>
            @endforeach
          @endif
        @endif
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End show new events -->
<!-- Start slide -->
<div class="clearfix" style="margin-top: 20px;"></div>
@include('layouts.slide_event')
<!-- End slide -->
<!-- Include Footer -->
@include('layouts.footer')
<script>
  $(document).on('click', '.Home_Like', function () {
    var event_id = $(this).val();
    var id_user  = '#id_user_Home'+ event_id;
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
              // console.log(data.dem);
              if(data.dem==0){
                  var like = '<i class="fas fa-thumbs-up" style="font-size: 10px;color: #dd0a37;"></i>';
                  $('#Home_Like'+ data.event_id).html(like);
                  $('#id_like_Home'+ data.event_id).html(data.Amountdemlike);

                }
                else
                {
                  var like = '<i class="fa fa-thumbs-down" style="font-size: 10px;"></i>';
                    $('#Home_Like'+ data.event_id).html(like);
                    $('#id_like_Home'+ data.event_id).html(data.Amountdemlike);
                }

          },
      })
  }
  else {
    alert("Bạn cần đăng nhập trước khi like.Cảm ơn");
  }
});
  //Đếm số lượt like của từng sự kiện
  //Cách để lấy được id của sự kiện
$(document).ready(function () {
  $('.id_Event_Home').each(function(index, value){
    var event_id = $(this).val();
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      })
     $.ajax({
          type: "get",
          url:  "{{URL::to('likeEventCount')}}",
          dataType: "json",
          data: {event_id: event_id},
          success: function (data) { // What to do if we succeed
            var dataCount = data.count;
            var luotlike = '#id_like_Home' + event_id;
            $(luotlike).html(dataCount);
          },
      })

})

});
//Đếm số lượng comment của từng sự kiện ở trang chủ
$(document).ready(function () {
  $('.id_Event_Comment').each(function(index, value){
    var event_id = $(this).val();
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      })
     $.ajax({
          type: "get",
          url:  "{{URL::to('CommentEventCount')}}",
          dataType: "json",
          data: {event_id: event_id},
          success: function (data) { // What to do if we succeed
           console.log(data);
           var luotComment = '#id_comment_Home' + event_id;
           $(luotComment).html(data.countComment);
          },
      })

})

});
//End
//check user đã like hay chưa 
$(document).ready(function () {
  $('.id_Event_Home').each(function(index, value){
    var event_id = $(this).val();
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      })
     $.ajax({
          type: "get",
          url:  "{{URL::to('LikeOrNotYet')}}",
          dataType: "json",
          data: {event_id: event_id},
          success: function (data) { // What to do if we succeed
            console.log(data.check);
            if(data.check!=0){
              var like = '<i class="fas fa-thumbs-up" style="font-size: 10px;color: #dd0a37;"></i>';
              $('#Home_Like'+ data.event_id).html(like);
            }
            else {
              var like = '<i class="fas fa-thumbs-up" style="font-size: 10px;"></i>';
              $('#Home_Like'+ data.event_id).html(like);
            }
          },
      })

})

});
</script>

</body>
</html>