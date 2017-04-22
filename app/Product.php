<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //

    public function brand()
    {
    	return $this->belongsTo('App\Brand');
    }

    public function subcategory()
    {
    	return $this->belongsTo('App\Subcategory');
    }

    public function area()
    {
    	return $this->belongsTo('App\Area');
    }
}
