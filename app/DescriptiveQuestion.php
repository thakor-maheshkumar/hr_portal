<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DescriptiveQuestion extends Model
{
    //
    protected $table='descriptive_questions';

    protected $fillable = [
      'topic_id',
      'question',
      'marks',
      'question_img',
    ];

    public function topic(){
    	return $this->hasOne('App\Topic');
    }
    public function answer(){
      return $this->hasOne('App\Answer','question_id','id');
    }
}
