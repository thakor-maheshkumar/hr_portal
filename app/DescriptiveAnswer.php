<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DescriptiveAnswer extends Model
{
    //
    protected $table='descriptive_answers';

    protected $fillable='topic_id', 'user_id', 'question_id', 'user_answer', 'answer';

    
}
