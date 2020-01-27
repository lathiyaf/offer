<?php

namespace App\Observers;

use App\Models\DisplaySetting;
use App\Models\Shop;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use App\Jobs\SyncShopData;

class ShopObserver
{
    /**
     * Handle the shop "created" event.
     *
     * @param  \App\Shop  $shop
     * @return void
     */
    public function created(Shop $shop)
    {
        \Log::info('============ Shop Observer created==================');
        foreach (config('rocket') as $key => $val) {
            $entity = new DisplaySetting;
            $entity->shop_id = $shop->id;
            $entity->display_type = $key;
            $entity->type = json_decode($val['type']);
            $entity->text_settings = json_decode($val['text_settings']);
            $entity->style_settings = json_decode($val['style_settings']);
            $entity->button_settings = json_decode($val['button_settings']);
            $entity->updated_at = null;
            $entity->save(['timestamps' => false]);
        }
    }

    /**
     * Handle the shop "updated" event.
     *
     * @param  \App\Shop  $shop
     * @return void
     */
    public function saved(Shop $shop)
    {
    }

    public function updated(Shop $shop)
    {
        $shop_data = $shop->api()->rest('GET', '/admin/shop.json');
        if(@$shop_data->body->shop && $shop->currency == NULL){
            $shop_data = $shop_data->body->shop;
            $shop->currency = $shop_data->currency;
            $shop->money_format = currency($shop_data ->currency)->getSymbol();
            $shop->save();
        }

        if(@$shop_data->body->shop && $shop->timezone == NULL){
            $shop_data = $shop_data->body->shop;
            //$shop->timezone = $shop_data->iana_timezone;
            $shop->timezone = "UTC";
            $shop->save();
        }
    }

    /**
     * Handle the shop "deleted" event.
     *
     * @param  \App\Shop  $shop
     * @return void
     */
    public function deleted(Shop $shop)
    {
        //
    }

    /**
     * Handle the shop "restored" event.
     *
     * @param  \App\Shop  $shop
     * @return void
     */
    public function restored(Shop $shop)
    {
        //
    }

    /**
     * Handle the shop "force deleted" event.
     *
     * @param  \App\Shop  $shop
     * @return void
     */
    public function forceDeleted(Shop $shop)
    {
        //
    }
}
