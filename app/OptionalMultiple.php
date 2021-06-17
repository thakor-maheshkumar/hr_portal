<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionalMultiple extends Model
{
    protected $table='optional_multiple';

    protected $fillable=[
    	'topic_id',
      	'question',
      	'a',
      	'b',
      	'c',
      	'd',
      	'a_marks',
      	'b_marks',
      	'c_marks',
      	'd_marks',
    ];
}
