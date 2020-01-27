<?php
namespace App\Models;

use OhMyBrew\ShopifyApp\Models\Shop as BaseShop;

class Shop extends BaseShop
{
    protected $table = 'shops';

    public function getShopSettings(){
        return $this->hasOne(ShopSettings::class,'shop_id','id');
    }

    public function get_rulesets(){
        return $this->hasmany(Ruleset::class,'shop_id','id');
    }
}
