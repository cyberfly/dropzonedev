<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    //subcategory belongs to category

    public function category(){
    	return $this->belongsTo('App\Category');
    }
}
