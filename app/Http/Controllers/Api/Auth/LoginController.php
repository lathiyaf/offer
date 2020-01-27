<?php

namespace App\Http\Controllers\Api\Offer;

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class LoginController extends Controller
{
    public function index(Request $request, $shopifyShop){
        $entity = Shop::where('shopify_domain',$shopifyShop)->firstOrFail()->toArray();
        return response([$entity],200);
    }
}
