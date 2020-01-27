<?php

namespace App\Models;

use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use Uuids;
    public $incrementing = false;
}
