<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Ruleset extends Model
{
    use Uuids;
    public $incrementing = false;

    public function products(){
        return $this->hasMany(RulesetProducts::class,'ruleset_id','id');
    }

    public function settings(){
        return $this->hasMany(RulesetSetting::class,'ruleset_id','id');
    }
}
