@extends('layouts.admin.admin')

@section('content')
<h1 style="color: #0099CC; text-align: center; margin-top: 10px;">Phản hồi Management</h1>
@if(Session::has('deleted_contact'))
<p class="bg-danger">{{session('deleted_contact')}}</p>
@endif
<div class="container">
    <div class="row col-md-12 form-group" style="margin-left: 10px;">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Chủ đề</th>
                    <th>Nội dung</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
            </thead>
            <tbody>
                @foreach($contacts as $contact)
                <tr>
                    <td>{{$contact->id}}</td>
                    <td>{{$contact->email}}</td>
                    <td>{{$contact->subject}}</td>
                    <td>{{$contact->content}}</td>
                    <td>{{$contact->created_at}}</td>
                    <td>
                        <form action="{{route('admin.contacts.destroy',$contact->id) }}" method="POST" class="delete">
                            <input type="hidden" name="_method" value="DELETE">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-danger" value="Xóa">
                        </form>                     
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="col-lg-6 col-sm-offset-5">
                {{ $contacts->render() }}
            </div>
        </div>
    </div>
</div>
<script>
    $(".delete").on("submit", function(){
        return confirm("Bạn chắc chắn muốn xóa?");
    });
</script>
@endsection