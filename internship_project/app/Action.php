<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Action extends Model
{
	use Notifiable;

    protected $fillable = [
        'name_action', 'link_action', 'is_public', 'description', 'is_delete'
    ];
}
