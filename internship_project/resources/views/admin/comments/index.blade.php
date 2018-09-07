@extends('layouts.admin.admin')

@section('content')
<h1 style="color: #0099CC; text-align: center; margin-top: 10px;">Quản lý Comments</h1>
@if(Session::has('deleted_comment'))
<p class="bg-danger">{{session('deleted_comment')}}</p>
@endif
<div class="container">
    <div class="row col-md-12 form-group" style="margin-left: 10px;">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sự kiện</th>
                    <th>Tên User</th>
                    <th>Parent Comment</th>
                    <th>Nội dung</th>
                    <th>Xem Reply</th>
                    <th>Ngày Comment</th>
                    <th>Hành động</th>
            </thead>
            <tbody>
                @foreach($comments as $comment)
                <tr>
                    <td>{{$comment->id}}</td>
                    <td>{{$comment->event->title_event}}</td>
                    <td>{{$comment->user->email}}</td>
                    <td>@if (($comment->parent_id) === 0)
                        Comment
                        @else
                        Reply
                        @endif
                    </td>
                    <td>{{$comment->content}}</td>
                    <td>
                        <a class="btn btn-warning" href="{{ url('/admin/comments/'.$comment->id.'/reply') }}">Xem</a></td>
                    <td>{{$comment->created_at}}</td>
                    <td>
                        <form action="{{ route('admin.comments.destroy',$comment->id) }}" method="POST" class="delete">
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
                {{ $comments->render() }}
            </div>
        </div>
    </div>
</div>
<script>
    $(".delete").on("submit", function(){
        return confirm("Bạn chắc chắn muốn xóa bình luận này?");
    });
</script>
@endsection