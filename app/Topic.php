<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Topic extends Model
{
    protected $fillable = [
      'title', 'per_q_mark','passing_marks','description', 'timer','show_ans','amount','test_type',
    ];

    public function question(){
      return $this->hasOne('App\Question');
    }

    public function answer(){
      return $this->hasOne('App\Answer');
    }
    
    public function descriptive_questions(){
      return $this->hasMany('App\DescriptiveQuestion');
    }
    public function user() {
      return $this->belongsToMany('App\User','topic_user')
         ->withPivot('amount','transaction_id', 'status')
        ->withTimestamps();
    }
    public function scopeQuestionCount($query){
      return $query->withCount(['descriptive_questions as que_count' => function ($query) {
          $query->select(DB::raw("SUM(marks) as total_marks"));
      }]);
    }
        
    
}
