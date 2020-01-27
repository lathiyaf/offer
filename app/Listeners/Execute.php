<?php

namespace App\Listeners;

use App\Events\Webhook;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Webhook as WebhookModel;
class Execute
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  Webhook  $event
     * @return void
     */
    public function handle(Webhook $event)
    {
        /*\Log::Info("=============== Webhook Listner 1==================");
        $webhook = $event->webhook;
        \Log::Info($webhook);
        \Log::Info("---------------------");
        \Log::Info($webhook->is_executed);
        \Log::Info($webhook->topic);
        \Log::Info("---------rnd------------");
        if($webhook->is_executed == 0) {
            \Log::Info("===== 1 ===============");
            if ($webhook->topic == 'orders/create' || $webhook->topic == 'existing-order') {
                $this->createOrder($webhook);
            } else if ($webhook->topic == 'orders/updated') {
                \Log::Info("===== 2 ===============");
                $this->updateOrder($webhook);
            }
        }*/
    }

    public function createOrder($webhook) {

    }
    public function updateOrder($webhook) {

    }
}
