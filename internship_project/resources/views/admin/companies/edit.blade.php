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
                <a href="{{route('admin.companies.index')}}">Quản lý công ty tổ chức</a>
            </li>
            <li class="active">Sửa thông tin</li>
        </ul>
    </div>
</div>
<div class="container">
    <h1>Sửa thông tin công ty</h1>
    <form action="{{ route('admin.companies.update', $company->id) }}" method="post" enctype='multipart/form-data'>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="company_id" id="company_id" value="{{$company->id}}">

        <div class="col-md-12">
            <div class=" form-group {{ $errors->has('name_company') ? 'has-error' : '' }}">
                <label>Tên công ty:</label>
                <input type="text" id="name_company" name="name_company" class="form-control" value="{{ $company->name_company }}" required>
                <span class="text-danger">{{ $errors->first('name_company') }}</span>
            </div>            

            <div class=" form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                <label>Số điện thoại:</label>
                <input type="tel" class="form-control" id="phone" name="phone" value="{{ $company->phone }}" required>
                <span class="text-danger">{{ $errors->first('phone')}}</span>
            </div>

            <div class=" form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label>Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $company->email }}" required>
                <span class="text-danger">{{ $errors->first('email')}}</span>
            </div>

            <div class=" form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                <label>Địa chỉ:</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ $company->address }}" required>
                <span class="text-danger">{{ $errors->first('address')}}</span>
            </div> 
        </div>
            
        <div class="upload_image">
            @if($company_images)
            <label>Ảnh công ty:</label>
                @foreach($company_images as $company_image)
                  <div class="show_image_dele" id="show_image_dele{{$company_image->id}}">
                    <div class="col-md-3" >
                        <input type="hidden" id="image_id{{$company_image->id}}" value="{{$company_image->id}}">
                        <input type="hidden" id="company_id{{$company_image->id}}" value="{{$company->id}}">
                        <input type="hidden" id="attached_file_id{{$company_image->id}}" value="$company_image->folder.$company_image->attached_file">
                        <img src="{{asset($company_image->folder.$company_image->attached_file)}}" alt="" class="img-responsive img-rounded" id="name_image{{$company_image->id}}">
                        <br>
                        <button type="button" class="btn btn-warning image_delete" id="image_delete{{$company_image->id}}" value="{{$company_image->id}}">Xóa</button>
                    </div>
                 </div>
                @endforeach
            @else
            <div class="ticket_add_more">
                <p>Công ty chưa có ảnh!</p>
            </div>
            @endif
        </div>
        
        <div class="drop_style">
            <div class="  form-group {{ $errors->has('attached_file') ? 'has-error' : ''}}">
                <label>Chọn file ảnh (có thể upload nhiều ảnh):</label>
                <span class="text-danger">{{ $errors->first('attached_file') }}</span>
            </div>
            
            <div class="dropzone" id="my-dropzone" name="myDropzone">
                <input type="hidden" name="company_id" id="company_id" value="{{$company->id}}">
            </div>
        </div> 

        <div class="form-group">
            <input type="submit" class="btn btn-success" value="Cập nhật" />
        </div>
    </form> 
</div>
<script type="text/javascript">
    $(document).on('click', '.image_delete', function () {
        var image_id = $(this).val();
        var company_id = '#company_id'+ image_id;
        var company = $(company_id).val();
        var answer = confirm('Bạn có muốn xóa hình ảnh này không?');
        if (answer) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $.ajax({
                type: "get",
                url: "{{URL::to('del_image')}}/"+ image_id,
                dataType: "json",
                data: {id: image_id, company_id: company},
                success: function (data) { // What to do if we succeed
                    console.log(data.images);
                    var refresh = '#show_image_dele'+ image_id;
                    $(refresh).html(data.images);
                },
            })
        } else {

        }
});
</script>

<script type="text/javascript">

    var company_id = $('#company_id').val();
    Dropzone.options.myDropzone= {
        url: "{{URL::to('uploadImagesCompany')}}/" + company_id,
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
@stop