<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{	
    protected $table = 'application';
    public $timestamps = true;

    protected $fillable = [
        'date', 'name', 'dob','emailid','positionapplied','currentcompany','designation','expectedctc','expectednegotiable','noticeperiod','noticenegotiable','reasonforjobchange','employmentdesired','nightshift','appliedposition','jobopportunity','reference','other','currency','others','resume',
    ];
}
