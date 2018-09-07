<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CompanyEvent extends Model
{
    use Notifiable;

    protected $table = 'companies_events';
    protected $fillable = ['company_id','event_id', 'is_delete'];

    public function company() {
        return $this->belongsTo('App\Company', 'company_id', 'id');
    }

    public function event() {
        return $this->belongsTo('App\Event','event_id','id');
    }
}
