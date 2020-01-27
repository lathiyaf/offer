<?php 
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Shop;
use App\Models\Webhook;

class OrdersCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Shop's myshopify domain
     *
     * @var string
     */
    public $shopDomain;

    /**
     * The webhook data
     *
     * @var object
     */
    public $data;

    /**
     * Create a new job instance.
     *
     * @param string $shopDomain The shop's myshopify domain
     * @param object $data    The webhook data (JSON decoded)
     *
     * @return void
     */
    public function __construct($shopDomain, $data)
    {
        $this->shopDomain = $shopDomain;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::Info("=============== Order Create Webhook ==================");
        $shop = Shop::where('shopify_domain',$this->shopDomain)->first();
        $order = json_encode($this->data);
        $shopify_id = json_decode($order)->id;
        $tags =  explode(", ",json_decode($order)->tags);
        if(in_array('offer-dynamic-discount',$tags)){
            $entity = Webhook::updateOrCreate(
                ['shopify_id' => $shopify_id, 'topic' => 'orders/create', 'shop_id' => $shop->id],
                ['shopify_id' => $shopify_id, 'topic' => 'orders/create', 'tags' => $tags, 'shop_id' => $shop->id, 'data' => $order, 'is_executed' => 0]
            );
        }
    }
}
