<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMSBulkModel extends Model
{
    protected $table = 'smsbulk';
	
	protected $fillable = [
        'type', 'phone', 'template_id', 'schedule_id', 'group_id', 'user_id', 'title', 'message'
    ];
	
	public function template()
    {
        return $this->belongsTo(SMSTemplateModel::class);
    }

    public function schedule(){
        return $this->belongsTo('App\SMSSchedule','schedule_id','id');
    }
}
