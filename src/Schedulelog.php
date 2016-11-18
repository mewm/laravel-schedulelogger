<?php

namespace PendoNL\LaravelScheduleLogger;

use Illuminate\Database\Eloquent\Model;

class Schedulelog extends Model
{

    protected $fillable = ['command_name','start','end'];

    public $timestamps = false;

    protected $dates = ['start','end'];

}
