<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
class Ticket extends Model
{
    use Notifiable;
    protected $table = 'tickets';
    
    protected $fillable = [
        'name_type_ticket', 'price', 'quantity','description', 'event_id'
    ];
    //hiển thị tên sự kiện trong giỏ hàng
    public function events($id){
    	$a =  $this->belongsTo('App\Event','event_id','id')->get()->first();
        return $a;
    }

    public function event_tickets(){
        return $this->belongsTo('App\Event','event_id','id');
    }
//Hiển thị hình ảnh trong giỏ hàng
    public function getImage($id){
        $img = DB::table('tickets')
                ->select('tickets.id','tickets.name_type_ticket', 'events.title_event','attached_files.attached_file','attached_files.folder')
                ->join('events','events.id','=','tickets.event_id')
                ->join('attached_files', function ($join) {
                        $join->on('attached_files.object_id', '=', 'events.id')
                             ->where('attached_files.id',function ($q) {
                                $q->select(DB::raw('MAX(attached_files.id)'))
                                  ->from('attached_files')
                                  ->whereRaw('attached_files.object_id = events.id');
                        })  
                             ->where('attached_files.parent_object_id', '=', 2)
                             ->where('attached_files.type_file','=',0);
                })
                ->where('tickets.id','=',$id)->get()->first(); 
        return $img;
    }
}
