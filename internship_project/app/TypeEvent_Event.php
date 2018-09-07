<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TypeEvent_Event extends Model
{
    use Notifiable;

    protected $table = 'type_event_events';
    protected $fillable = ['type_event_id','event_id',];

    public function typeEvent() {
        return $this->belongsTo('App\TypeEvent', 'type_event_id', 'id');
    }

    public function event() {
        return $this->belongsTo('App\Event','event_id','id');
    }
}
