<?php

namespace App\Models;

use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Model;

class RulesetSetting extends Model
{
    use Uuids;
    public $incrementing = false;

    public function ruleset(){
        return $this->hasOne(Ruleset::class,'id','ruleset_id');
    }
}
