<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Segmentation extends Model
{
    protected $table = 'segmentations';

    protected $fillable = [
         'name', 'description' , 'classification'
    ];
}
