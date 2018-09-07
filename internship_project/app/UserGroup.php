<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\GroupAction;

class UserGroup extends Model
{
    use Notifiable;

    protected $table = 'users_groups';
    protected $fillable = [
        'user_id','group_id'
    ];

    public function group() {
        return $this->belongsTo('App\Group', 'group_id', 'id');
    }

    public function user() {
        return $this->belongsTo('App\User','user_id','id');
    }
    //function dùng để kiểm tra xem user group có quyền hay không
    public function getRights_id_arr($user_id){
        $groupaction = new GroupAction();
        $rightuser = $this->select('group_id')
                        ->where('user_id', '=', $user_id)->get();
        $r = [];
        foreach ($rightuser as $key => $data) {
                
            $temp =$groupaction->getRights_id_arr($data->group_id);
            $r = array_merge($r, $temp);

        }
        return $r;               

    }
}
