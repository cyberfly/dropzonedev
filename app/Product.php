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

    public function user()
    {
    	return $this->belongsTo('App\User','user_id','id');
    }
}
