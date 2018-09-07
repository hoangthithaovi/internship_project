@extends('layouts.app')
@section('content')
<link href="{{ asset('css/contact/contact.css')}}" rel="stylesheet">
<div class="ads-grid_shop">
    <div class="shop_inner_inf">
        <h3 class="head">Liên hệ với chúng tôi</h3>
        <p class="head_para">Thêm một vài mô tả</p>
        <div class="inner_section_w3ls">
            <div class="col-md-7 contact_grid_right">
                <h6>Vui lòng điền vào form này để tương tác, phản hồi với chúng tôi.</h6>
                @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <p>{{ \Session::get('success') }}</p>
                    </div><br />
                @endif
                <form method="post" action="{{URL::action('MailController@postMail')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="col-md-6 col-sm-6 contact_left_grid">                       
                        <input type="email" name="email" placeholder="Email..." required="" value="{!! old('email') !!}">
                    </div>
                    <div class="col-md-6 col-sm-6 contact_left_grid">                       
                        <input type="text" name="subject" placeholder="Nhập chủ đề..." required="" value="{!! old('subject') !!}">
                    </div>
                    <div class="clearfix"></div>
                    <textarea name="content" placeholder="Nhập nội dung..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Message...';}" required="" value="{!! old('content') !!}"></textarea>
                    <input type="submit" value="Gửi">
                    <input type="reset" value="Nhập lại">
                </form>
            </div>
            <div class="col-md-5 contact-left">
                <h6>Thông tin liên hệ</h6>
                <div class="visit">
                    <div class="col-md-2 col-sm-2 col-xs-2 contact-icon">
                        <span class="fa fa-home" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-10 col-sm-10 col-xs-10 contact-text">
                        <h4>Ghé thăm chúng tôi</h4>
                        <p>02 - Quang Trung - Hải Châu - Đà Nẵng</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="mail-us">
                    <div class="col-md-2 col-sm-2 col-xs-2 contact-icon">
                        <span class="fa fa-envelope" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-10 col-sm-10 col-xs-10 contact-text">
                        <h4>Mail của chúng tôi</h4>
                        <p><a href="mailto:info@example.com">PNInterns@example.com</a></p>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="call">
                    <div class="col-md-2 col-sm-2 col-xs-2 contact-icon">
                        <span class="fa fa-phone" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-10 col-sm-10 col-xs-10 contact-text">
                        <h4>Gọi chúng tôi</h4>
                        <p>+18044261149</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="visit">
                    <div class="col-md-2 col-sm-2 col-xs-2 contact-icon">
                        <span class="fa fa-fax" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-10 col-sm-10 col-xs-10 contact-text">
                        <h4>Fax</h4>
                        <p>+1804426349</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="contact-map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3833.805361061083!2d108.219902564224!3d16.07558699353893!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3142183a773870c3%3A0xe98d0134a02a7aa!2zU29mdGVjaCBUb3dlciBEYU5hbmcsIDAyIFF1YW5nIFRydW5nLCBI4bqjaSBDaMOidSwgxJDDoCBO4bq1bmcsIFZpZXRuYW0!5e0!3m2!1sen!2s!4v1530098732878" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>
</div>
@endsection