<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    use Notifiable;
    protected $fillable = ['username', 'email', 'password', 'remember_token', 'role'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token',];
    protected $table = 'users';

    public function attached_files() {
        return $this->hasMany('App\AttachedFile','object_id','id');
    }

    public function user_avata() {
        return $this->attached_files()->where([['parent_object_id', 3], ['type_file',0], ['is_delete', 0]])->get()->last();
    }

    public function orders(){
        return $this->hasMany('App\Order','user_id','id');
    }

    public function user_action($id) {

        $user_action = DB::select('select users.id, users.username, user_actions.user_id, user_actions.action_id, actions.name_action, actions.link_action, actions.is_public, actions.description, actions.created_at, actions.updated_at from users
            join user_actions on users.id = user_actions.user_id
            join actions on user_actions.action_id = actions.id
            where user_actions.is_delete = 0 and users.id = ?',[$id]);
        return $user_action;
    }

    public function user_group($id) {

        $user_group = DB::select('select users.id, users.username, users_groups.user_id, users_groups.group_id, groups.name_group,groups.description, groups.created_at, groups.updated_at from users
            join users_groups on users.id = users_groups.user_id
            join groups on users_groups.group_id = groups.id
            where users_groups.is_delete = 0 and users.id = ?',[$id]);
        return $user_group;
    }

    public function user_order($id) {
        $user_order = DB::select('select orders.id, orders.user_id, orders.fullname, orders.email, orders.phone_number, orders.address, orders. date_order, orders.type_of_payment, orders.notes, orders.status, orders.created_at, orders.updated_at 
            from users
            join orders on orders.user_id = users.id
            where orders.is_delete = 0 and users.id = ?', [$id]);
        return $user_order;
    }

    public function is_Admin(){
        if($this->role ==0){
            return true;
        }
        else return false;
    }
}
