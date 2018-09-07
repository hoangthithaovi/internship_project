<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Contact extends Model
{
	use Notifiable;
    protected $table = 'contacts';
    protected $fillable = ['email','subject', 'content', 'is_delete'];
}
