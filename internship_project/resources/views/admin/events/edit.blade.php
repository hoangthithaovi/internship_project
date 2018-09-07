@extends('layouts.admin.admin')

@section('content')
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
            <li class="active">Sửa thông tin</li>
        </ul>
    </div>
</div>
<div class="container">
    <div class="add-event">
        <div class="name_header">
            <h3>Cập nhật thông tin sự kiện</h3>
        </div>
        <form action="{{ route('admin.events.update', $event->id) }}" method="post" enctype='multipart/form-data'>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT"> 
            <input type="hidden" name="e_id" id="eve_id" value="{{$event->id}}">

            <div class="create-event">
                <div class="form-group">
                    <div class="col-md-6 {{ $errors->has('title_event') ? 'has-error' : '' }}">
                        <label>Tên sự kiện:</label>
                        <input type="text" id="title_event" name="title_event" class="form-control" placeholder="Nhập tên sự kiện..." value="{{$event->title_event}}" required>
                        <span class="text-danger">{{ $errors->first('title_event') }}</span>
                    </div> 
                    <div class="col-md-6 {{ $errors->has('location') ? 'has-error' : '' }}">
                        <label>Địa điểm tổ chức:</label>
                        <input type="text" id="location" name="location" class="form-control" placeholder="Nhập địa điểm..." value="{{$event->location}}">
                        <span class="text-danger">{{ $errors->first('location') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 {{$errors->has('date_start') ? 'has-error' : ''}}">
                        <label>Thời gian bắt đầu:</label>
                        <div class='input-group date'>
                            <input type="text" class="form-control" name="date_start" id="date_start" value="{{$event->date_start}}">
                            <span class="text-danger">{{ $errors->first('date_start') }}</span>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6 {{$errors->has('date_end') ? 'has-error' : ''}}">
                        <label>Thời gian kết thúc:</label>
                        <div class='input-group date'>
                            <input type="text" class="form-control" name="date_end" id="date_end" value="{{$event->date_end}}">
                            <span class="text-danger">{{ $errors->first('date_end') }}</span>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6">
                        <label>Loại sự kiện:</label>
                        <div class="{{$errors->has('type_event_id') ? 'has-error' : ''}}">
                            <select id="type_event1" class="form-control" name="type_event_id[]" multiple="multiple">
                                <optgroup label="Phổ biến">
                                @foreach ($type_events as $type_event)
                                    <option value="{{$type_event->id}}" @foreach($type_event_ds as $type) @if($type_event->id == $type->id) selected="selected" @endif @endforeach>
                                        {{$type_event->name_type_event}}
                                    </option>
                                @endforeach 
                                </optgroup>
                            </select>
                            <span class="text-danger">{{ $errors->first('type_event_id') }}</span>
                        </div>
                    </div>
  
                    <div class="col-md-6">
                        <label>Công ty tổ chức:</label>
                        <div class="{{$errors->has('company_id') ?'has-error' :''}}">
                            <select id="company_id" class="form-control" name="company_id[]" multiple="multiple">
                                <optgroup label="Đối tác">
                                @foreach ($companies as $company)     
                                    <option value="{{$company->id}}" 
                                    @foreach($company_event as $cp_et)
                                        @if($company->id == $cp_et->id)
                                        selected="selected"
                                        @endif
                                    @endforeach>
                                        {{$company->name_company}}
                                    </option>
                                @endforeach  
                                </optgroup>
                            </select>
                            <span class="text-danger">{{ $errors->first('company_id') }}</span>
                        </div> 
                    </div>
                </div>
        
                <div class="upload_image">
                    @if(count($event_images)>= 1)
                        <label>Ảnh sự kiện:</label>
                        @foreach($event_images as $event_image)
                        <div class="show_image_dele" id="show_image_dele{{$event_image->id}}">
                            <div class="col-md-3 show_image" >
                                <input type="hidden" id="image_id{{$event_image->id}}" value="{{$event_image->id}}">
                                <input type="hidden" id="event_id{{$event_image->id}}" value="{{$event->id}}">
                                <input type="hidden" id="attached_file_id{{$event_image->id}}" value="$event_image->folder.$event_image->attached_file">
                                <img src="{{asset($event_image->folder.$event_image->attached_file)}}" alt="" class="img-responsive img-rounded" id="name_image{{$event_image->id}}">
                                <button type="button" class="btn btn-warning image_delete" id="image_delete{{$event_image->id}}" value="{{$event_image->id}}">Xóa</button>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="ticket_add_more">
                        <p>Sự kiện chưa có ảnh</p>
                    </div>
                    @endif
                </div>

                <label class="zone_image">Thêm ảnh:</label>
                <div class="dropzone" id="mydropzone">
                </div>
                <div class="upload_image form-group">
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
                        <div class="form-group " style="width: 300px">
                            <img height="300" alt="Map" class="img-responsive img-rounded" id="attached">
                        </div>
                    </div>
                </div>
               
                <div class="form-group upload_image"> 
                    <div class="{{$errors->has('editor') ? 'has-error' : ''}}">
                        <label>Thông tin chi tiết sự kiện:</label> 
                        <textarea class="form-control description" rows="5" id="editor" name="editor" placeholder="Nhập chi tiết sự kiện..." value="{{$event->description}}">{{$event->description}}</textarea>
                        <span class="text-danger">{{ $errors->first('editor') }}</span>
                    </div>
                </div>
            </div>
            <div class="add-ticket">
                <div class="name_header">
                    <h3>Xem và chỉnh sửa thông tin vé</h3>
                </div>
        
                @if($tickets)
                    @foreach($tickets as $ticket)
                    <div class="row form-group show_ticket" id="show_ticket{{$ticket->id}}">
                        <div class="col-md-10">
                            <label>Tên loại vé:</label>
                            <input type="text" class="form-control font" value="{{$ticket->name_type_ticket}}" name="name_ticket_{{$ticket->id}}" readonly>
                        </div>
                        <div class="col-md-10">
                            <div class="row font">
                                <div class="col-md-6">
                                    <label>Giá vé:</label>
                                    <input type="number" name="price_{{$ticket->id}}" class="form-control" value="{{$ticket->price}}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>Số lượng vé:</label>
                                    <input type="number" name="quantity_{{$ticket->id}}" class="form-control" value="{{$ticket->quantity}}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 font">
                            <label>Thông tin chi tiết:</label>
                            <textarea name="description_{{$ticket->id}}" class="form-control" value="{{$ticket->description_ticket}}" readonly>{{$ticket->description_ticket}}</textarea>
                        </div>
                        <!-- Click để edit vé -->
                        <div class="ticket_add_more">
                            <p class="btn btn-success" data-toggle="modal" data-target="#edit_ticket_{{$ticket->id}}">Sửa vé</p>
                        </div>
                        <!-- Click để xóa vé -->
                        <div class="ticket_add_more">
                            <button type="button" class="btn btn-warning delete_ticket" value="{{$ticket->id}}">Xóa vé</button>
                        </div>
                    </div>

                    <div id="showTicket">
                        
                    </div>

                    <!-- Thẻ div show modal edit ticket -->
                    <div class="modal fade" id="edit_ticket_{{$ticket->id}}" role="dialog">
                        <div class="modal-content">
                            <div class="tickets form-group" id="add-ticket">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Chỉnh sửa thông tin vé</h4>
                                </div>
                                <div class="model-body">
                                    <div id="edit_tickets{{$ticket->id}}">
                                        <input type="hidden" id="event_id" value="{{$event->id}}">
                                        <div class="name_type_ticket {{ $errors->has('name_type_event') ? 'has-error' : '' }}">
                                            <label>Tên vé:</label>
                                            <input type="text" id="name_type_ticket_{{$ticket->id}}" placeholder="Nhập tên vé..." value="{{$ticket->name_type_ticket}}" class="form-control" required="Vui lòng nhập tên loại vé (:"> 
                                        </div>

                                        <div class="row number">
                                            <div class="col-md-6 {{ $errors->has('
                                                number') ? 'has-error' : '' }}">
                                                <label>Giá vé:</label>
                                                <input type="number" id="price_{{$ticket->id}}" placeholder="Nhập giá vé..." value="{{$ticket->price}}" class="form-control" required="Vui lòng nhập giá vé (:">  
                                            </div>
                                            <div class="col-md-6 {{ $errors->has('quantity') ? 'has-error' : '' }}">
                                                <label>Số lượng:</label>
                                                <input type="number" id="quantity_{{$ticket->id}}" placeholder="Nhập số lượng vé" value="{{$ticket->quantity}}" class="form-control" required="Vui lòng nhập số lượng vé (:"> 
                                            </div>
                                        </div>

                                        <div class="description">
                                            <textarea id="description_{{$ticket->id}}" rows="3" placeholder="Nhập chi tiết về loại vé..." value="{{$ticket->description_ticket}}" class="form-control" required="Vui lòng nhập chi tiết của loại vé (:">{{$ticket->description_ticket}}</textarea> 
                                        </div>
                                    </div>
                                </div>
                        
                                <div class="modal-footer">
                                    <button type="button" class="submitForm btn btn-success" value="{{$ticket->id}}">Lưu thông tin</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
                <div class="modal fade" id="c_ticket" role="dialog">
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
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="submitForm" class="btn btn-success" value="{{$event->id}}">+Tạo vé</button>
                                <button type="button" class="btn btn-danger cancle" data-dismiss="modal">Rời khỏi</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Click để tạo vé -->
                <div class="ticket_add_more">
                    <p data-toggle="modal" data-target="#c_ticket" class="btn btn-default">+ Tạo vé mới</p>
                </div>
            </div>

            <div class="form-group">
                <div class="row form-group" style="margin-top: 15px; margin-left:10px;">
                    <input type="submit" class="btn btn-success" value="Cập nhật thông tin" />
                </div>
            </div>
        </form>
    </div>
</div> 

<!-- Upload ảnh -->
<script type="text/javascript">
    var id = $('#eve_id').val();
    Dropzone.options.mydropzone= {
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
</script>

<!-- Xóa ảnh sự kiện -->
<script type="text/javascript">
    $(document).on('click', '.image_delete', function () {
        var image_id = $(this).val();
        var event_id = '#event_id'+image_id;
        var event = $(event_id).val();
        var answer = confirm('Bạn có muốn xóa hình ảnh này không?');
        if (answer) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $.ajax({
                type: "get",
                url: "{{URL::to('delete_image')}}/"+ image_id,
                dataType: "json",
                data: {id: image_id, event_id: event},
                success: function (data) { // What to do if we succeed
                    console.log(data.image_event);
                    var refresh = '#show_image_dele'+ image_id;
                    $(refresh).html(data.image_event);
                },
            })
        } else {

        }
    });
</script>

<script type="text/javascript">
    $(document).on('click', '.map_delete', function(){
        var map_id = $(this).val();
        var event_id = '#event_id'+ map_id;
        var event = $(event_id).val();
        var opinion = confirm('Bạn có muốn xóa sơ đồ chỗ ngồi này không?');
        if(opinion){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $.ajax({
                type: "get",
                url: "{{URL::to('delete_map')}}/"+ map_id,
                dataType: "json",
                data: {id: map_id, event_id: event},
                success: function (data) { // What to do if we succeed
                    console.log(data.image_event);
                    var refresh = '#show_map_dele'+ map_id;
                    $(refresh).html(data.image_event);
                },
            })
        }else{

        } 
    });
</script>

<script type="text/javascript">
    $(document).on('click', '.document_delete', function(){
        var document_id = $(this).val();
        var event_id = '#event_id'+ document_id;
        var event = $(event_id).val();
        var opinion = confirm('Bạn có muốn xóa tài liệu này không?');
        if(opinion){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $.ajax({
                type: "get",
                url: "{{URL::to('delete_document')}}/"+ document_id,
                dataType: "json",
                data: {id: document_id, event_id: event},
                success: function (data) { // What to do if we succeed
                    console.log(data.image_event);
                    var refresh = '#show_document_dele'+ document_id;
                    $(refresh).html(data.image_event);
                },
            })
        }else{

        } 
    });
</script>

<!-- Xóa vé -->
<script type="text/javascript">
    $(document).on('click', '.delete_ticket', function(){
        var ticket_id = $(this).val();
        var event_id =  $('#eve_id').val();
        var oppinion = confirm('Bạn có chắc chắn muốn xóa loại vé này không?');
        if(oppinion){
            $.ajaxSetup  ({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }) 
            $.ajax({
                type: "get",
                url: "{{URL::to('delete_ticket')}}/"+ ticket_id,
                dataType: "json",
                data: {
                    id: ticket_id,
                    event_id: event_id
                },
                success: function(data){
                    console.log(data.delete_t);
                    var show_delete = '#show_ticket' + ticket_id;
                    $(show_delete).remove();
                },
            }) 
        }
    });
</script>

<!-- Sửa thông tin vé -->
<script type="text/javascript">
    $(document).on('click', '.submitForm', function(){
        var ticket_id = $(this).val();
        var event_id = $('#event_id').val();
        var name_type_ticket = $('#name_type_ticket_' + ticket_id).val();
        var price = $('#price_' + ticket_id).val();
        var quantity = $('#quantity_' + ticket_id).val();
        var description = $('#description_' + ticket_id).val();

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
            url: "{{URL::to('update_ticket')}}/"+ ticket_id,
            dataType: "json",
            data:{id: ticket_id, 
                event_id: event_id, 
                name_ticket: name_type_ticket, 
                price: price, 
                quantity: quantity, 
                description: description
            },
            success: function (data) {
                console.log(data);
                var show = '#show_ticket' + ticket_id;
                var show_ticket  = 
                '<div class="row form-group show_ticket" id="show_ticket'+data.id+'">'
                    + '<div class="col-md-10">'
                        + '<label>Tên loại vé:</label>'
                        + ' <input type="text" class="form-control font" value="'+data.name_ticket+'" readonly>'
                    + '</div>'
                    + '<div class="col-md-10">'
                        + '<div class="row font">' 
                            + '<div class="col-md-6">'
                                + '<label>Giá vé:</label>' 
                                + '<input type="number" class="form-control" value="' +
                                data.price+'" class="form-control" readonly>'
                            + '</div>'
                            + '<div class="col-md-6">'
                                + '<label>Số lượng vé:</label>' 
                                + '<input type="number" class="form-control" value="' + data.quantity + '" readonly>' 
                            + '</div>' 
                        + '</div>'
                    + '</div>' 
                    + '<div class="col-md-10">' 
                        + '<label>Thông tin chi tiết:</label>'
                        + '<textarea type="text" name="description" value="'+data.description+'" class="form-control" readonly>'+ data.description + '</textarea>'
                    + '</div>'
                    + '<div class="ticket_add_more">'
                        + '<p class="btn btn-success" data-toggle="modal" data-target="#edit_ticket_'+data.id +'">Sửa vé</p>'
                    + '</div>'
                    + '<div class="ticket_add_more">'
                        + '<button type="button" class="btn btn-warning delete_ticket" value="' +data.id +'">Xóa vé</button>'
                    + '</div>'
                + '</div>';
                $(show).replaceWith(show_ticket);
                $('#edit_ticket_'+ticket_id).modal('hide');
            },
        })
    });
</script>

<!-- Thêm vé mới -->
<script type="text/javascript">
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
        data: {
            event_id:event_id,
            name_type_ticket: name_type_ticket, 
            quantity:quantity,price:price,
            description_ticket:description_ticket
        },
        success: function (data) { // What to do if we succeed
            console.log(data);
            var show  = 
            ' <div class="row form-group show_ticket" id="show_ticket'+data.id+'">'
                + '<div class="col-md-10">'
                    + '<label>Tên loại vé:</label>'
                    + '<input type="text" class="form-control font" value="'+data.name_type_ticket+'" readonly>'
                + '</div>'
                + '<div class="col-md-10">'
                    + '<div class="row font">' 
                        + '<div class="col-md-6">'
                            + '<label>Giá vé:</label>' 
                            + '<input type="number" class="form-control" value="' +
                            data.price+'" class="form-control" readonly>'
                        + '</div>'
                        + '<div class="col-md-6">'
                            + '<label>Số lượng vé:</label>' 
                            + '<input type="number" class="form-control" value="' + data.quantity + '" readonly>' 
                        + '</div>' 
                    + '</div>'
                + ' </div>' 
                + ' <div class="col-md-10">' 
                    + '<label>Thông tin chi tiết:</label>'
                    + '<textarea type="text" name="description" value="'+data.description+'" class="form-control" readonly>'+ data.description + '</textarea>'
                + '</div>'
                + '<div class="ticket_add_more">'
                    + '<p class="btn btn-success" data-toggle="modal" data-target="#edit_ticket_'+data.id +'">Sửa vé</p>'
                + '</div>'
                + '<div class="ticket_add_more">'
                    + '<button type="button" class="btn btn-warning delete_ticket" value="' +data.id +'">Xóa vé</button>'
                + '</div>'
            + '</div>';
            $('#showTicket').append(show);
            $('#c_ticket').modal('hide');
            $('#name_type_ticket').val('');
            $('#price').val('');
            $('#description').val('');
            $('#quantity').val('');
        },
    })
});
</script>

<script type="text/javascript">
    $(document).on('click', '.cancle', function () {
        return confirm('Bạn muốn rời khỏi trang khi chưa lưu thông tin?')
    });
</script>

<script>
    jQuery(document).ready(function () {

        jQuery('#date_start').datetimepicker();
    });
</script> 

<script>
    jQuery(document).ready(function () {

        jQuery('#date_end').datetimepicker();
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
@stop