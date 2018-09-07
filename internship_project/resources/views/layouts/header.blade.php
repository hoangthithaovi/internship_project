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
