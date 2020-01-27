<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class RulesetProducts extends Model
{
    use Uuids;
    public $incrementing = false;

    public function ruleset(){
        return $this->belongsTo(Ruleset::class,'ruleset_id');
    }
}
