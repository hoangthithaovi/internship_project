<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
class Like extends Model
{
    use Notifiable;

    protected $fillable = [
        'comment_id','user_id'
    ];

    public function comment(){
    	return $this->belongsTo('App\Comment');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
    //Đếm số like của tất cả các event
    public function LikeEvent($id_event){
        $count = DB::select('select count(likes.object_id) as CountLike from likes join events on events.id = likes.object_id where likes.object_id=? and likes.type_object = 1 group by likes.object_id',[$id_event]);
        return $count;
    }
    //Kiểm tra sự tồn tại của like(user đó đã like sự kiện hay chưa)
    public function LikeExist($id_event,$id_user){
        $exist = DB::select('select object_id,user_id from likes where object_id = ? and user_id = ? and is_delete = 0 and type_object = 1',[$id_event,$id_user]);
        return $exist;
    }
}
