<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Comment;

class AdminCommentManagement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::where([['is_delete', '=', '0'], ['parent_id', '=', '0']])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $comment = Comment::findOrFail($id);
        $comment['is_delete'] = 1;
        $comment->save();
        \Illuminate\Support\Facades\Session::flash('deleted_comment', 'Comment đã được xóa!');
        return redirect('/admin/comments');
    }

    public function getReplyComment($id) {
        $comments = Comment::where([['is_delete', '=', '0'], ['parent_id', '=', $id]])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.comments.index', compact('comments'));
    }
}
