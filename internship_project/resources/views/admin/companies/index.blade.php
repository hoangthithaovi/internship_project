@extends('layouts.admin.admin')
@section('content')
@if (session('create_company'))
<div class="alert alert-success">
    {{ session('create_company') }}
</div>
@endif
@if (session('update_company'))
<div class="alert alert-success">
    {{ session('update_company') }}
</div>
@endif
@if(Session::has('deleted_company'))
<p class="bg-danger">{{session('delete_company')}}</p>
@endif
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
        </ul>
    </div>
</div>
<div class="content">
    <h1 style="color: #0099CC; text-align: center; margin:20px;">Quản lý công ty</h1>
    <table class="table"> 
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên công ty</th>
                <th>File ảnh</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Xem sự kiện của công ty</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
                <th colspan="2">Hành động</th>
            </tr>
        </thead>

        <tbody>
            @foreach($companies as $company)
            <tr>
                <td>{{$company->id}}</td>
                <td>{{$company->name_company}}</td>        
                <td>
                    @if($images)
                        @foreach($images as $image)
                            @if($image->object_id == $company->id)
                                <img width="75" height="60" src="{{asset($image->folder.$image->attached_file)}}" alt="Ảnh không tồn tại" title="Ảnh công ty">
                            @endif
                        @endforeach
                    @endif
                </td>
                <td>{{$company->phone}}</td>
                <td>{{$company->email}}</td>
                <td>{{$company->address}}</td>
                <td><a href="{{url('/admin/companies/'.$company->id.'/events')}}">Xem sự kiện</a></td>
                <td>{{$company->created_at}}</td>
                <td>{{$company->updated_at}}</td>
                <td>
                    <a class="btn btn-warning" href="{{ url('admin/companies/'.$company->id.'/edit') }}">Chỉnh sửa</a>
                </td>
                <td>
                    <form action="{{ route('admin.companies.destroy',$company->id)}}" method="POST" class="delete">
                       <input type="hidden" name="_method" value="DELETE">
                            {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger" value="Xóa">
                    </form> 
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    $(".delete").on("submit", function(){
        return confirm("Bạn chắc chắn muốn xóa công ty này?");
    });
</script>
@stop