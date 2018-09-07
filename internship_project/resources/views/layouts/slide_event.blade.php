<div class="mid_slider_w3lsagile">
  <div class="col-md-1"></div>
  <div class="col-md-2 mid_slider_text">
    <h5>Các đề xuất khác cho bạn</h5>
  </div>
  <div class="col-md-9 mid_slider_info">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1" class=""></li>
        <li data-target="#myCarousel" data-slide-to="2" class=""></li>
        <li data-target="#myCarousel" data-slide-to="3" class=""></li>
      </ol>

      <div class="carousel-inner" role="listbox" style="margin-top: 20px">
        @foreach($eventall as $key =>$event)
        <div class="item{{ $key == 0 ? ' active' : '' }}">
            
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="thumbnail">
                <img src="{{$event->folder.$event->attached_file}}" alt="Image" style="height: 220px">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <h5 style="color: white!important; font-family: Cambria;">{{$event->title_event}}</h5>
                <h5 style="color: white!important;font-family: Cambria;">{{$event->location}}</h5>
                <p style="color: white!important;font-family: Cambria;">{{$event->date_start}}</p>
                <div class="news-grid-info-bottom-text">
                            <p style="color: white!important;font-family: Cambria;">{{ str_limit($event->description, $limit = 100, $end = '...') }}<a href="{{route('detailevents',$event->id)}}" title="" class="link_watch">xem thêm</a></p>
                        </div>
                
              </div>
            </div>
          
        </div>
          @endforeach

      </div>

      
        <!-- The Modal -->
    </div>
  </div>
  <div class="clearfix"> </div>
</div>