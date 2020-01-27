<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Support\Facades\DB;


class SyncShopData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $shop, $what;
    public function __construct($shop,$what)
    {
        \Log::info('============ __construct ==================');
        $this->shop = $shop;
        $this->what = $what;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info('============ Handle ==================');
        if($this->what == 'products'){
            $this->products();
        }
    }

    public function products(){

        $not_found = \URL::to('/images/not_found.png');
        \Log::info('============ Products ==================');
        $shop = $this->shop;

        $domain = str_replace('.', '_', $shop->shopify_domain);
        $table = 'products_'.$domain;

        $rows = DB::table($table)->select('product_id')->get()->toArray();
        $rows = array_column($rows, 'product_id','product_id');

        $queryString=[];
        $queryString['fields'] = 'id,title,handle,image';
        $queryString['published_status'] = 'published';
        $queryString['limit'] = 250;
        $count = $shop->api()->rest('GET', '/admin/products/count.json');
        $totalPage = ceil($count->body->count / 250);
        $products = $data = [];

        for($i=1; $i<=$totalPage; $i++){
            $queryString['page'] = $i;
            $data250 = $shop->api()->rest('GET', '/admin/products.json',$queryString);
            foreach ($data250->body->products as $key => $value) {
                $products['title'] = $value->title;
                $products['product_image_url'] = (@$value->image->src)?@$value->image->src:$not_found;
                if(!in_array($value->id, $rows)){
                    $products['product_id'] = $value->id;
                    $products['product_handle'] = $value->handle;
                    $products['shop_id'] = $shop->id;
                    $data[] = $products;
                }else{
                    DB::table($table)
                        ->where('product_id', $value->id)
                        ->update($products);
                    unset($rows[$value->id]);
                }
                $products = [];
            }
        }
        if(!empty($rows))
            DB::table($table)->whereIn('product_id', $rows)->delete();

        if(!empty($data))
            DB::table($table)->insert($data);
    }
}
