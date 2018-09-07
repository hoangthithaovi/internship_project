<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;

class AttachedFile extends Model
{
	use Notifiable;
    protected $fillable = ['id', 
        'name_file', 'attached_file', 'describe', 'folder', 'type_file','parent_object_id','object_id',
    ];

    public function event_ticket($id){
    	$a = $this->belongsTo('App\Event','parent_object_id','id')->get()->first();
    	return $a;
    }
     //hiển thị ra những hình ảnh liên quan đến sự kiện của nó
    public function getImageEachEvent($event){
        $image = DB::select('select attached_files.attached_file, attached_files.folder, events.title_event from attached_files join events on attached_files.object_id =events.id where attached_files.parent_object_id = 2 and events.is_delete=0 and attached_files.object_id=?',[$event]);
        return $image;
    } 
    //hiển thị hình ảnh sơ đồ chỗ ngồi của sự kiện
    public function getMapEvent($event){
        $map = DB::select('select attached_files.attached_file, attached_files.folder,events.title_event,events.date_start, events.date_end,events.location,attached_files.name_file ,events.title_event from attached_files join events on events.id = attached_files.object_id where attached_files.name_file like "%Chỗ ngồi sân khấu%" and attached_files.parent_object_id = 4 and attached_files.object_id=?',[$event]);    
        return $map;

    }
    public function company(){
        return $this->belongsTo('App\Company');
    }

    public function event(){
        return $this->belongsTo('App\Event');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
