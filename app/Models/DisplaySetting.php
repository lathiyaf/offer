<?php

namespace App\Models;

use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Model;

class DisplaySetting extends Model
{
    use Uuids;
    public $incrementing = false;
    protected $casts = [
      'type'   => 'array',
      'text_settings'   => 'array',
      'style_settings'  => 'array',
      'button_settings'  => 'array',
    ];

    public function getStyleAttribute($value)
    {
        $value = str_replace('null','""',$value);
        return json_decode($value);
    }

    public function getButtonAttribute($value)
    {
        $value = str_replace('null','""',$value);
        return json_decode($value);
    }

    public function getTextAttribute($value)
    {
        $value = str_replace('null','""',$value);
        return json_decode($value);
    }
}
