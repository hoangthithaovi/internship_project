  <link href="{{asset('css/index/bootstrap.css')}}" rel="stylesheet" type="text/css" media="all" />
  <link href="{{asset('css/index/style7.css')}}" rel="stylesheet" type="text/css" media="all" />
  <link href="{{asset('css/index/style.css')}}" rel="stylesheet" type="text/css" media="all" />
  <!-- font-awesome-icons -->
  <link href="{{asset('css/index/font-awesome.css')}}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{asset('fonts/glyphicons-halflings-regular.woff')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('fonts/glyphicons-halflings-regular.woff2')}}">
  <!-- Bootstrap -->
  <link type="text/css" rel="stylesheet" href="{{asset('css/index/bootstrap.min.css')}}" />
  <!-- Owl Carousel -->
  <link type="text/css" rel="stylesheet" href="{{asset('css/index/owl.carousel.css')}}" />
  <link type="text/css" rel="stylesheet" href="{{asset('css/index/owl.theme.default.css')}}" />
  <!-- Font Awesome Icon -->
  <link rel="stylesheet" href="{{asset('css/index/font-awesome.min.css')}}">
  <!-- Custom stlylesheet -->
  <link type="text/css" rel="stylesheet" href="{{asset('css/index/header_style.css')}}" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">  
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> 
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <script src="js/index/jquery.min.js"></script>
  <script src="js/index/bootstrap.min.js"></script>
  <script src="js/index/main.js"></script>
  <script src="{{asset('js/index/responsiveslides.min.js')}}"></script>
  <script>
    $(function () {
        $("#slider4").responsiveSlides({
            auto: true,
            pager: true,
            nav: true,
            speed: 1000,
            namespace: "callbacks",
            before: function () {
                $('.events').append("<li>before event fired.</li>");
            },
            after: function () {
                $('.events').append("<li>after event fired.</li>");
            }
        });
    });
</script>