<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $table = 'actions';

    public function category()
    {
    	return $this->hasOne('App\Category','id','category_id');
    }
}
