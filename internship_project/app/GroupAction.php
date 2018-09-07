<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class GroupAction extends Model
{
    use Notifiable;

    protected $fillable = [
        'group_id','action_id',
    ];

    public function action() {
        return $this->belongsTo('App\Action', 'action_id', 'id');
    }

    public function group() {
        return $this->belongsTo('App\Group','group_id','id');
    }
    //function dùng để kiểm tra xem group action có quyền hay không
    public function getRights_id_arr($group_id){
        $rightuser = $this->select('action_id')
                          ->where('group_id', '=', $group_id)->get();
        $r = [];
        foreach ($rightuser as $key => $data) {
                
            $r[] = $data->action_id;

    
        }
        return $r;               

    }
}
