<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;

class Group extends Model
{
    use Notifiable;

    protected $fillable = [
        'name_group', 'user_id', 'description', 'is_delete'
    ];

    public function getAction($id){
    	$getactions = DB::select('select actions.id, actions.name_action, actions.link_action, actions.is_public, actions.description,
			actions.created_at, actions.updated_at
			from groups
			join group_actions on group_actions.group_id = groups.id
			join actions on actions.id = group_actions.action_id
			where groups.id = ?', [$id]);
    	return $getactions;
    }

    public function group_action($id){
        $group_action = DB::select('select groups.id, group_actions.group_id, group_actions.action_id from groups
            join group_actions on groups.id = group_actions.group_id
            join actions on group_actions.action_id = actions.id
            where groups.id = ?',[$id]);
        return $group_action;
    }
}
