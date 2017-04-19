<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class DetailUser extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
	 public $timestamps = false;
    protected $table = 'user_detail';

    //
}
