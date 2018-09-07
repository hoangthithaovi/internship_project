@extends('layouts.admin.admin')

@section('content')
<?php
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "event_project";
    $mysqli = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
    if (!$mysqli) {
        die('Không thể kết nối với Database: ' . mysqli_error());
    }
    $query = "select AUTO_INCREMENT
    FROM information_schema.tables
    WHERE table_name = 'companies'
    AND table_schema = DATABASE( ) ;";
    $qry_result = mysqli_query($mysqli,$query) or die(mysqli_error());
    while($row = mysqli_fetch_array($qry_result)){
        $next_company_id = $row['AUTO_INCREMENT'] + 0;
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
                <a href="{{route('admin.companies.index')}}">Quản lý công ty tổ chức</a>
            </li>
            <li class="active">Tạo mới công ty</li>
        </ul>
    </div>
</div>
<div class="container">
    <h1>Tạo mới công ty</h1>
    <form method="post" action="{{ route('admin.companies.store')}}" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="next_company_id" id="next_company_id" value="{{$next_company_id}}">
        <div class="row">
            <div class=" form-group {{ $errors->has('name_company') ? 'has-error' : '' }}">
                <label>Tên công ty:</label>
                <input type="text" id="name_company" name="name_company" class="form-control" placeholder="Nhập tên công ty..." value="{{ old('name_company') }}">
                <span class="text-danger">{{ $errors->first('name_company') }}</span>
            </div>  

            <div class=" form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label>Thư điện tử:</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Nhập địa chỉ thư điện tử..." value="{{ old('email') }}">
                <span class="text-danger">{{$errors->first('email')}}</span>
            </div>

            <div class=" form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                <label>Số điện thoại:</label>
                <input type="tel" id="phone" name="phone" class="form-control" placeholder="Nhập số điện thoại liên hệ..." value="{{ old('phone') }}">
                <span class="text-danger">{{ $errors->first('phone') }}</span>
            </div>

            <div class=" form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                <label>Địa chỉ:</label>
                <input type="text" name="address" id="address" class="form-control" placeholder="Nhập địa chỉ..." value="{{old('address')}}">
                <span class="text-danger">{{ $errors->first('address') }}</span>
            </div>
        </div>

        <div class=" form-group {{ $errors->has('attached_file') ? 'has-error' : '' }}">
            <label>Ảnh công ty:</label>
            <span class="text-danger">{{ $errors->first('attached_file') }}</span>
        </div>
        <div class="col-md-12">
            <div class="dropzone" id="my-dropzone" name="myDropzone">
            </div>
        </div>
        
        <div class="form-group">
            <input type="submit" class="btn btn-success" value="Lưu" />
        </div>
    </form>
</div>
<script type="text/javascript">
    var company_id = $('#next_company_id').val();
    Dropzone.options.myDropzone= {
        url: "{{URL::to('uploadImagesCompany')}}/" + company_id,
        headers: {
           'X-CSRF-TOKEN': '{!! csrf_token() !!}'
        },
        autoProcessQueue: true,
        uploadMultiple: true,
        parallelUploads: 5,
        maxFiles: 10,
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