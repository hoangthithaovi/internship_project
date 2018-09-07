<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;

class TypeEvent extends Model
{
    protected $table = 'type_events';
    protected $fillable = ['name_type_event', 'description_typeEvent'];

    public function getEvent($id){
     $events = DB::select('select events.id, events.title_event, events.location, events.description, events.status,
   events.date_start, events.date_end, events.created_at, events.updated_at
   from type_events
   join type_event_events on type_event_events.type_event_id = type_events.id
   join events on events.id = type_event_events.event_id
   where type_event_events.is_delete = 0 and type_events.id = ?', [$id]);
     return $events;
    }

    public function getEventforType($event_id){
        $type = DB::select('select events.id, type_events.id from events 
            join type_event_events on type_event_events.event_id = events.id
            join type_events on type_events.id = type_event_events.type_event_id
            where type_event_events.is_delete = 0 and events.id = ?', [$event_id]);
        return $type;
    }
}