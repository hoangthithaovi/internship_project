<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserAction extends Model
{
    use Notifiable;

    protected $fillable = [
        'user_id','action_id',
    ];

    public function action() {
        return $this->belongsTo('App\Action', 'action_id', 'id');
    }

    public function user() {
        return $this->belongsTo('App\User','user_id','id');
    }
    //function dùng để kiểm tra xem user action có quyền hay không
    public function getRights_id_arr($user_id){
        $rightuser = $this->select('action_id')
                        ->where('user_id', '=', $user_id)->get();
                        $r = [];
        foreach ($rightuser as $key => $data) {
                
            $r[] = $data->action_id;


        }
        return $r;               

    }
}
