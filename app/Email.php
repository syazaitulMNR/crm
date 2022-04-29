<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $table = 'mails';

    protected $fillable = [
        'id','title', 'content', 'date', 'name'
    ];
}
