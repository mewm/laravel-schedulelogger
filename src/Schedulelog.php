<?php

namespace PendoNL\LaravelScheduleLogger;

use Illuminate\Database\Eloquent\Model;

class Schedulelog extends Model
{
    protected $fillable = ['command_name', 'start', 'end'];

    public $timestamps = true;

    /**
     * Set start attribute. Multiply by 1000 to get milliseconds as integer.
     *
     * @param $value
     *
     * @return string
     */
    public function setStartAttribute($value)
    {
        $this->attributes['start'] = number_format($value * 1000, 0, '', '');
    }

    /**
     * Set end attribute. Multiply by 1000 to get milliseconds as integer.
     *
     * @param $value
     *
     * @return string
     */
    public function setEndAttribute($value)
    {
        $this->attributes['end'] = number_format($value * 1000, 0, '', '');
    }
}
