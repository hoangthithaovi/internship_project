@extends('layouts.admin.admin')
@section('content')
<?php
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "event_project";
    $mysqli = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
    if (!$mysqli) {
        die('Could not connect: ' . mysqli_error());
    }
    $query = "select AUTO_INCREMENT
    FROM information_schema.tables
    WHERE table_name = 'events'
    AND table_schema = DATABASE( ) ;";
    $qry_result = mysqli_query($mysqli, $query) or die(mysqli_error());
    while($row = mysqli_fetch_array($qry_result)){
        $next_event_id = $row['AUTO_INCREMENT'] + 0;
    }
?>
<div class="main-content-inner">
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{route('admin')}}">Trang chủ</a>
            </li>
            <li>
                <a href="{{route('admin.events.index')}}">Quản lý sự kiện</a>
            </li>
            <li class="active">Tạo sự kiện</li>
        </ul>
    </div>
</div>
<div class="container">
    <div class="add-event">
        <div class="name_header">
            <h3>Nhập thông tin sự kiện</h3>
        </div>
        <form action="{{route('admin.events.store') }}" method="post" enctype='multipart/form-data'>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="next_id" value="{{$next_event_id}}">

        <div class="create-event">
            <div class="form-group">
                <div class="col-md-6 {{ $errors->has('title_event') ? 'has-error' : '' }}">
                    <label>Tên sự kiện:</label>
                    <input type="text" name="title_event" class="form-control" placeholder="Nhập tên sự kiện..." value="{{old('title_event')}}" required>
                    <span class="text-danger">{{ $errors->first('title_event') }}</span>
                </div> 
                <div class="col-md-6 {{ $errors->has('location') ? 'has-error' : '' }}">
                    <label>Địa điểm tổ chức:</label>
                    <input type="text" name="location" class="form-control" placeholder="Nhập địa điểm..." value="{{old('location')}}">
                    <span class="text-danger">{{ $errors->first('location') }}</span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6  {{$errors->has('date_start') ? 'has-error' : ''}}">
                    <label>Thời gian bắt đầu:</label>
                    <div class='input-group date'>
                        <input type="text" class="form-control" name="date_start" id="date_start" value="{{old('date_start')}}">
                        <span class="text-danger">{{ $errors->first('date_start') }}</span>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="col-md-6 {{$errors->has('date_end') ? 'has-error' : ''}}">
                    <label>Thời gian kết thúc:</label>
                    <div class='input-group date'>
                        <input type="text" class="form-control" name="date_end" id="date_end" value="{{old('date_end')}}">
                        <span class="text-danger">{{ $errors->first('date_end') }}</span>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6"> 
                    <div class="{{$errors->has('type_event_id') ? 'has-error' : ''}}">
                        <label>Loại sự kiện:</label>
                        <select id="type_event1" name="type_event_id[]" multiple="multiple">
                            <optgroup label="Phổ biến">
                            @foreach ($type_events as $type_event)
                                <option value="{{$type_event->id}}">
                                    {{$type_event->name_type_event}}
                                </option>
                            @endforeach 
                            </optgroup>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="{{$errors->has('company_id') ?'has-error' :''}}">
                        <label>Công ty tổ chức:</label>
                        <select id="company_id" name="company_id[]" multiple="multiple">
                            <optgroup label="Đối tác">
                            @foreach ($companies as $company)     
                                <option value="{{$company->id}}">
                                    {{$company->name_company}}
                                </option>
                            @endforeach  
                            </optgroup>
                        </select>
                        <span class="text-danger">{{ $errors->first('company_id') }}</span>
                    </div>
                </div> 
            </div>
                    
            <label class="zone_image">Ảnh sự kiện:</label>
            <div class="dropzone" id="eventDropzone">
            </div>

            <div class="form-group"> 
                <div class="col-md-6">
                    <div class="{{ $errors->has('file_document') ? ' has-error' : ''}}">
                        <label>Tài liệu:</label>
                        <input type="file" name="file_document" class="form-control">
                        <span class="text-danger">{{ $errors->first('file_document') }}</span>
                    </div>
                    <div class="show-document" id="documentEvent">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="{{$errors->has('file_image') ? 'has-error' : ''}}">
                        <label>Sơ đồ chỗ ngồi:</label><br>
                        <input type="file" id="file_image" name="file_image" class="form-control">
                        <span class="text-danger">{{ $errors->first('file_image') }}</span>
                    </div><br>
                    <div class="form-group " style="width: 200px">
                        <img height="100" alt="Map" class="img-responsive img-rounded" id="attached">
                    </div>
                </div>
            </div>

            <div class="form-group upload_image">
                <div class="{{$errors->has('editor') ? 'has-error' : ''}}">
                    <label>Thông tin chi tiết:</label><br> 
                    <textarea class="form-control description" rows="5" id="editor" name="editor" placeholder="Nhập chi tiết/ mô tả về sự kiện..."></textarea>
                    <span class="text-danger">{{ $errors->first('editor') }}</span>
                </div>
            </div>

            <div class="add-ticket">
                <div class="name_header">
                    <h3>Tạo vé sự kiện</h3>
                </div>
                <div id="showTicket">
                
                </div>
                <!-- Thẻ div show modal add ticket -->
                <div class="modal fade" id="create_ticket" role="dialog">
                    <div class="modal-content">
                        <div class="tickets form-group" id="add-ticket">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Tạo vé sự kiện</h4>
                            </div>
                            <div class="model-body">
                                <div id="add_more_tickets">
                                    <div class="name_type_ticket {{ $errors->has('name_type_event') ? 'has-error' : '' }}">
                                        <label>Tên vé:</label>
                                        <input type="text" name="name_type_ticket" placeholder="Nhập tên vé..." value="{{old('name_type_ticket')}}" class="form-control" id="name_type_ticket">
                                        <span class="text-danger">{{ $errors->first('name_type_ticket') }}</span>
                                    </div>

                                    <div class="row number">
                                        <div class="col-md-6 {{ $errors->has('
                                            number') ? 'has-error' : '' }}">
                                            <label>Giá vé:</label>
                                            <input type="number" name="price" placeholder="Nhập giá vé..." value="{{old('price')}}" class="form-control" id="price">
                                            <span class="text-danger">{{ $errors->first('price') }}</span>
                                        </div>

                                        <div class="col-md-6 {{ $errors->has('quantity') ? 'has-error' : '' }}">
                                            <label>Số lượng:</label>
                                            <input type="number" name="quantity" placeholder="Nhập số lượng vé" value="{{old('quantity')}}" class="form-control" id="quantity">
                                            <span class="text-danger">{{ $errors->first('quantity') }}</span>
                                        </div>
                                    </div>

                                    <div class="description">
                                        <label>Thông tin chi tiết:</label>
                                        <textarea name="description" rows="3" placeholder="Nhập chi tiết về loại vé..." value="{{old('description')}}" class="form-control" id="description"></textarea>
                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="submitForm" class="btn btn-success" value="{{$next_event_id}}">Lưu</button>
                                    <button type="button" class="btn btn-danger cancle" data-dismiss="modal">Rời khỏi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Click để tạo vé -->
        <div class="ticket_add_more">
            <p data-toggle="modal" data-target="#create_ticket" class="btn btn-warning">+ Tạo vé</p>
        </div>
        <div class="form-group">
            <div class="row form-group" style="margin-top: 15px; margin-left:10px;">
                <input type="submit" class="btn btn-success" value="Tạo sự kiện" />
            </div>
        </div>
        </form>
    </div>
</div> 
<script>
    jQuery(document).ready(function () {
        jQuery('#date_start').datetimepicker();
    });
</script> 

<script>
    jQuery(document).ready(function () {
        jQuery('#date_end').datetimepicker({
            startDate: new Date()
        });
    });
</script>  

<script>
    $(document).ready(
        function() {
            $('#type_event1').multiselect({
                enableFiltering:true
        });
    });
</script> 

<script>
    $(document).ready(
        function() {
            $('#company_id').multiselect({
                enableFiltering:true
        });
    });
</script>

<script type="text/javascript">
    var file = document.getElementById('file_image');
    var img = document.getElementById('attached');
    file.addEventListener("change", function() {
        if (this.value) {
            var file = this.files[0];
            img.onload = function () {
                window.URL.revokeObjectURL(this.src);
            };
            img.src = window.URL.createObjectURL(file);
        }
    });
</script>   

<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

<script> 
    CKEDITOR.replace( 'editor', {
    filebrowserBrowseUrl: '{{ asset('ckfinder/ckfinder.html') }}',
    filebrowserImageBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Images') }}',
    filebrowserFlashBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Flash') }}',
    filebrowserUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}',
    filebrowserImageUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}',
    filebrowserFlashUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}'
    } ); 
</script>

<script type="text/javascript">
    var id = $('#next_id').val();
    Dropzone.options.eventDropzone= {
        url: "{{URL::to('uploadImagesEvents')}}/" + id,
        headers: {
           'X-CSRF-TOKEN': '{!! csrf_token() !!}'
        },
        autoProcessQueue: true,
        uploadMultiple: true,
        maxFiles: 4,
        maxFilesize: 6,
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        dictFileTooBig: 'Dung lượng file phải nhỏ hơn 6MB',
        addRemoveLinks: true,
        removedfile: function(file) {
        var name = file.name;    
        name =name.replace(/\s+/g, '-').toLowerCase();    /*only spaces*/
        $.ajax({
            type: 'POST',
            url: "{{URL::to('deleteImage')}}",
            headers: {
                 'X-CSRF-TOKEN': '{!! csrf_token() !!}'
             },
            data: "id="+name,
            dataType: 'html',
            success: function(data) {
                $("#msg").html(data);
            }
        });
        var _ref;
        if (file.previewElement) {
            if ((_ref = file.previewElement) != null) {
              _ref.parentNode.removeChild(file.previewElement);
            }
        }
        return this._updateMaxFilesReachedClass();
    },
    previewsContainer: null,
    hiddenInputContainer: "body",
   }

$(document).on('click', '#submitForm', function () {
    var event_id = $(this).val();
    var name_type_ticket  = $('#name_type_ticket').val();
    var quantity = $('#quantity').val();
    var price = $('#price').val();
    var description_ticket = $('#description').val();

    if(name_type_ticket == ''){
        alert('Bạn phải nhập tên loại vé!');
    }
    if((price == '') || (price == 'e')){
        alert('Bạn phải nhập giá vé, giá vé chỉ được nhập số!');
    }
    if((quantity == '') || (quantity == 0)){
        alert('Bạn phải nhập số lượng vé, số lượng bắt buộc phải lớn hơn 0!');
    }
    if(description == ''){
        alert('Bạn phải nhập mô tả cho vé!');
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $.ajax({
        type: "get",
        url:  "{{URL::to('addTicket')}}",
        dataType: "json",
        data: {event_id:event_id,name_type_ticket: name_type_ticket, quantity:quantity,price:price,description_ticket:description_ticket},
        success: function (data) { // What to do if we succeed
            console.log(data);
            var show  = 
            '<div class="row form-group show_ticket">'
                + ' <div class="col-md-10">'
                    +'<label>Tên loại vé:</label>'
                    + ' <input type="text" class="form-control font" value="'+data.name_type_ticket+'" readonly>'
                + '</div>'
                + '<div class="col-md-10">'
                    + '<div class="row font">' 
                        + '<div class="col-md-6">'
                            +'<label>Giá vé:</label>' 
                            + '<input type="number" class="form-control" value="' +
                            data.price+'" class="form-control" readonly>'
                        +'</div>'
                        +'<div class="col-md-6">'
                            + '<label>Số lượng vé:</label>' 
                            +'<input type="number" class="form-control" value="' + data.quantity + '" readonly>' 
                        +'</div>' 
                    + '</div>'
                + '</div>' 
                + ' <div class="col-md-10">' 
                    + '<label>Thông tin chi tiết:</label>'
                    + '<textarea type="text" name="description" value="'+data.description+'" class="form-control" readonly>'+ data.description + '</textarea>'
                    +'</div>'
                + '</div>';
            $('#showTicket').append(show);
            $('.fade').modal('hide');
            $('#name_type_ticket').val('');
            $('#price').val('');
            $('#description').val('');
            $('#quantity').val('');
            },
        })
    });
</script>
@stop