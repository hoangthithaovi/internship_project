<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
class Comment extends Model
{
    use Notifiable;
    protected $table = 'comments';

    protected $fillable = [
        'user_id', 'event_id', 'parent_id', 'content', 'is_delete'
    ];

    public function user() {
        $a = $this->belongsTo('App\User', 'user_id', 'id');
        return $a;
    }
    public function user_comment(){
        $user1 = DB::select('select users.id, users.username from comments join users on users.id = comments.user_id');
        return $user1;
        }

    public function event() {
        return $this->belongsTo('App\Event','event_id', 'id');
    }

    public function children() {
        return $this->hasMany('App\Comment', 'parent_id', 'id', ['is_delete', '=', '0']);
    }
    public function getFullComment(&$comment,$parent_id,$event_id){
        $menu_tree = $this->select('comments.id','comments.event_id','comments.user_id','comments.content','comments.parent_id','events.id as ID_event','users.username','comments.created_at')
                            ->join('events', 'events.id', '=', 'comments.event_id')
                            ->join('users','users.id','=','comments.user_id')
                            ->where('comments.parent_id', $parent_id)
                            ->where('comments.event_id',$event_id)
                            ->get();
            foreach ($menu_tree as $key => $data){        
            $comment[] = ['id'=>$data->id,'parent_id'=> $data->parent_id, 'content'=>$data->content, 'ID_event'=>$data->ID_event, 'username'=>$data->username,'user_id'=>$data->user_id,'created_at'=>$data->created_at,'childs'=>[]];
            $this->getFullComment($comment[count($comment) -1]['childs'],$data->id,$data->ID_event);
        }
    }
    public function countComment($id_event){
         $countComment = DB::select('select count(comments.event_id) as CountComment from comments join events on events.id = comments.event_id where comments.event_id=? group by comments.event_id',[$id_event]);
        return $countComment;
    }
}
