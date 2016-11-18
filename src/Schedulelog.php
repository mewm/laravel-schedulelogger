<?php

namespace PendoNL\LaravelScheduleLogger;

use Illuminate\Database\Eloquent\Model;

class Schedulelog extends Model
{

    protected $fillable = ['command_name','type','created_at'];

    public $timestamps = false;

    protected $dates = ['created_at'];

}
