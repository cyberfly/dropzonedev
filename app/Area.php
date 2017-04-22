<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public function state()
    {
    	return $this->belongsTo('App\State');
    }
}
