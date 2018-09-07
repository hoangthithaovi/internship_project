
<link href="css/events/allevent.css" rel="stylesheet" type="text/css" media="all" />
<div class="banner_top innerpage" id="home">
  <div class="wrapper_top_w3layouts">
    <div class="header_agileits">
      <div class="logo">
        <h1><a class="navbar-brand" href="#"><span>Event</span></a></h1>
      </div>
 
        <!-- cart details -->
        <div class="top_nav_right">
        <div class="shoecart shoecart2 cart cart box_1">
          <form action="#" method="post" class="last">
            <input type="hidden" name="cmd" value="_cart">
            <input type="hidden" name="display" value="1">
            <a class="top_shoe_cart" href="{{route('shopping_cart')}}" name="submit" value=""  style="font-size: 40px;color: #fff;border: none;text-align: center;background: none;width: 50px;height: 50px;position: fixed;right:230px!important;top: 42px!important;"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i><span class="dem">@if (Session::has('cart')){{Session('cart')->totalQty}}
                @else 0 @endif</span></a>
          </form>
        </div>
      </div>
        <!-- //cart details -->
      <div class="clearfix"></div>
    </div>
    <!-- //search -->
  </div>
</div>
     <!-- search -->
 <div class="search_w3ls_agileinfo">
  <div class="cd-main-header">
    <ul class="cd-header-buttons" style="top: 50px !important">
      <li><a class="cd-search-trigger" href="#cd-search"> <span></span></a></li>
    </ul>
    <div id="cd-search" class="cd-search" style="top: 150px">
      <form action="{{route('eventssearch')}}" method="GET">
         <div class="input-group">
            <input type="text" class="form-control"  name="search_text" style="background-color: white !important;color: #0F0E0E;">
            <span class="input-group-btn">
                <button class="btn btn-lg btn-success" type="submit" style="height: 64px;">
                    <i class="fa fa-search"></i>
                </button>
            </span>
        </div>
      </form>
    </div>
  </div>   
</div>
        <!-- //search -->
<!-- products-breadcrumb -->
<div class="products-breadcrumb">
  <div class="container">
    <ul>
      <li>
          <i class="fa fa-home" aria-hidden="true"></i><a href="{{url('/')}}">Trang chủ</a><span>|</span></li>
          <li><a href="{{url('/getallevent')}}">Sự kiện</a><span>|</span></li>
          <li><a href="{{route('about')}}">Về chúng tôi</a><span>|</span></li>
          <li><a href="{{url('/addcontact')}}">Liên hệ</a><span>|</span></li>
          @if(Auth::check())
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
            <li><a href="{{ route('register') }}">Đăng kí</a><span>|</span></li>
            <li><a href="{{ route('login') }}">Đăng nhập</a></li>
          @endif
    </ul>
  </div>
</div>
<!-- //products-breadcrumb -->