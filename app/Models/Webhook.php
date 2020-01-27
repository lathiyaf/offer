<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\Webhook as EventWebhook;

class Webhook extends Model
{
    /*protected $dispatchesEvents = [
        'created' => EventWebhook::class,
        'updated' => EventWebhook::class,
    ];*/
    protected $fillable = ["shopify_id", "topic", "shop_id", "data", "created_at", "updated_at","id", "is_executed",'tags'];

    protected $casts = [
        'tags' => 'array',
    ];
    public function shop(){
        return $this->belongsTo(Shop::class);
    }
}
