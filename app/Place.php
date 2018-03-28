<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Carbon\Carbon;

class Place extends Eloquent
{
	 protected $dates = ['created_at'];

      public function getCreatedDateTimeLocalized()
    {
    	//dd($this->attributes['created_at']->toDateTime()->format('r'));
        setlocale(LC_TIME, 'id_ID.UTF-8');
        return Carbon::parse($this->attributes['created_at']->toDateTime()->format('Y-m-d H:i:s'))->formatLocalized('%d %B %Y');
    }
}
