<?php

namespace App\Http\Controllers\Api\Offer;

use App\Models\DisplaySetting;
use App\Models\GeneralSetting;
use App\Models\Shop;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RulesetProducts;
use App\Models\RulesetSetting;
use Akaunting\Money\Currency;
use Akaunting\Money\Money;

class OfferController extends Controller
{
    public function index123(Request $request, $shopifyShop){
        $product = RulesetProducts::with('ruleset')->where('product_id',$request->product_id)
            ->whereHas('ruleset',function($query){
                $query->where('status',1);
            })
            ->select(['product_id','ruleset_id'])->first();
        if($product){
            $reulset = RulesetSetting::where('ruleset_id', $product->ruleset_id)->orderBy('buy')->get(['buy','get','offer_type','id','code']);

            $html = "<select class='' name='properties[OfferType]' id='offerChange_dropdown'> <option value=''>-- Select --</option>";

            foreach ($reulset as $key => $val){
                $html .= '<option data-buy="'.$val->buy.'" data-get="'.$val->get.'" data-offer="'.$val->offer_type.'" value="'.$val->code.'"> Buy: '.$val->buy.' - Get: '.$val->get.' - '.$val->offer_type.'</option>';
            }
            $html .= '</select>';
            return response()->json(['data' => $html]);
        }
    }

    public function index(Request $request, $shopifyShop){

        $shop = Shop::where('shopify_domain', $shopifyShop)->first();
        $product = RulesetProducts::with('ruleset')->where('product_id',$request->product_id)->where('shop_id',$shop->id)
            ->whereHas('ruleset',function($query){
                $query->where('status',1);
            })
            ->select(['product_id','ruleset_id','shop_id'])->first();
        if($product){
            $reulset = RulesetSetting::where('ruleset_id', $product->ruleset_id)->orderBy('buy')->get(['buy','get','offer_type','id','code']);
            $ds = DisplaySetting::where('shop_id', $product->shop_id)->where('display_type', $product->ruleset->display_type)->select('button_settings as button', 'display_type', 'style_final_string', 'style_settings as style','text_settings as text','type')->first();

            $gs = GeneralSetting::where('shop_id', $product->shop_id)->select(['advanced_css','advanced_js','display_customize_text'])->first();


            if($product->ruleset->display_type == 'dropdown'){
                return response()
                    ->view('api.dropdown',compact('reulset','product','ds','gs'), 200)->withHeaders([
                        'X_Discount_Type'=>'dropdown',
                        'Access-Control-Expose-Headers'=>'X_Discount_Type',
                        'Content-Type'=>'text/html',
                    ]);
            }else if($product->ruleset->display_type == 'gridview'){

                return response()
                    ->view('api.gridview',compact('reulset','product','ds','gs'), 200)->withHeaders([
                        'X_Discount_Type'=>'gridview',
                        'Access-Control-Expose-Headers'=>'X_Discount_Type',
                        'Content-Type'=>'text/html',
                    ]);
            }else if($product->ruleset->display_type == 'swatch'){
                return response()
                    ->view('api.swatch',compact('reulset','product','ds','gs'), 200)
                    ->withHeaders([
                        'X_Discount_Type'=>'swatch',
                        'Access-Control-Expose-Headers'=>'X_Discount_Type',
                        'Content-Type'=>'text/html',
                    ]);
            }
        }
    }

    public function testResponse($data){
        return response($data,200);
    }

    public function cart(Request $request, $shopifyShop){
        //return response($shopifyShop, 200);
        $shop = Shop::where('shopify_domain',$shopifyShop)->first();
        $newRequest = $request->all();
        $discount_code = $request->discount_code;
        $currency = $request->data['currency'];
        //$newRequest['data']['item_count'] = 0;
        $loop_key = $discounted_price_total = $item_count = 0;

        $original_total_price = 0;
        foreach ($newRequest['data']['items'] as $key => $val){
            $f = 0;
            $code = @$val['properties']['OfferType']?$val['properties']['OfferType']:'DISCOUNT';
            //$code = "DISCOUNT";
            if($code){
                if($code == "DISCOUNT"){
                    $product = RulesetProducts::where('shop_id',$shop->id)->where('product_id',$val['product_id'])->first();

                    if($product){
                        $entity = RulesetSetting::where('ruleset_id',$product->ruleset_id)->where('buy',$val['quantity'])->first();
                    }else{
                        $entity = false;
                    }
                }else{
                    $entity = RulesetSetting::where('code',$code)->first();
                }
                if($entity) {
                    $buy = $entity->buy;
                    $get = $entity->get;
                        $original_line_price = $val['original_line_price'];
                        $qty = $val['quantity'];
                        if($entity->offer_type == 'free'){
                            $newRequest['data']['cart']['items'][$loop_key] = $val;
                            if($code == "DISCOUNT" && $val['quantity'] != ($buy+$get)){
                                $qty = ($code == "DISCOUNT" && $val['quantity'] != ($buy+$get))?$buy+$get:$buy;
                                $final_price = $val['discounted_price'] * $buy;
                                $single_price = ($final_price / ($buy + $get));
                                $original_line_price = $val['discounted_price'] * $qty;
                            }else{
                                $final_price = $val['discounted_price'] * $buy;
                                $single_price = ($final_price / ($buy + $get));
                            }
                            $code ="DISCOUNTSINGLE";
                            //return response($original_line_price);
                        }else if($entity->offer_type == 'percentage' && $val['quantity'] == $buy){
                            $newRequest['data']['cart']['items'][$loop_key] = $val;
                            $final_price = ($val['original_line_price'] - ($val['original_line_price'] * $get / 100));
                            $single_price = ($val['original_price'] - ($val['original_price'] * $get / 100));
                        }else if($entity->offer_type == 'fixed' && $val['quantity'] == $buy){
                            $newRequest['data']['cart']['items'][$loop_key] = $val;
                            $get = $get*100;
                            $calc_line_price = $val['quantity'] * $get;
                            $final_price = $val['original_line_price'] - $get;
                            $single_price = $final_price / $buy;
                        }else{
                            $f=1;
                        }
                        if($f==0){
                            $newRequest['data']['cart']['items'][$loop_key]['__code'] = $code;
                            $newRequest['data']['cart']['items'][$loop_key]['__quantity'] = $qty;
                            $newRequest['data']['cart']['items'][$loop_key]['discounted_price'] = $single_price;

                            $newRequest['data']['cart']['items'][$loop_key]['discounted_price_format'] = Money::$currency($single_price)->format();

                            $newRequest['data']['cart']['items'][$loop_key]['original_price_format'] =  Money::$currency($val['original_price'])->format();

                            $newRequest['data']['cart']['items'][$loop_key]['discounted_line_price_format'] =  Money::$currency($final_price)->format();
                            $discounted_price_total += $final_price;

                            $newRequest['data']['cart']['items'][$loop_key]['original_line_price_format'] =  Money::$currency($original_line_price)->format();
                            $original_total_price += $original_line_price;
                            //return response($original_line_price);
                            $item_count = $newRequest['data']['cart']['items'][$loop_key++]['quantity'] = $val['quantity'];
                        }
                }else{
                    $f=1;
                    //$newRequest['data']['cart']['items'][$loop_key] = $val;
                    /*$newRequest['data']['items'][$loop_key]['properties']['OfferType'] = "EXPIRED";
                    $discounted_price_total += $val['discounted_price'];*/
                }
            }else{
                $f=1;
            }

            if($f==1){
                $newRequest['data']['cart']['items'][$loop_key] = $val;
                $newRequest['data']['cart']['items'][$loop_key]['__code'] = $code;
                $newRequest['data']['cart']['items'][$loop_key]['__quantity'] = $val['quantity'];
                $newRequest['data']['cart']['items'][$loop_key]['discounted_price'] = $val['discounted_price'];
                $newRequest['data']['cart']['items'][$loop_key]['discounted_price_format'] = Money::$currency($val['discounted_price'])->format();
                $newRequest['data']['cart']['items'][$loop_key]['original_price_format'] =  Money::$currency($val['original_price'])->format();

                $newRequest['data']['cart']['items'][$loop_key]['discounted_line_price_format'] =  Money::$currency($val['original_line_price'])->format();

                $newRequest['data']['cart']['items'][$loop_key]['original_line_price_format'] =  Money::$currency($val['original_line_price'])->format();
                $item_count = $newRequest['data']['cart']['items'][$loop_key++]['quantity'] = $val['quantity'];
                $original_total_price += $val['original_line_price'];
                $discounted_price_total += $val['final_line_price'];
            }
        }

        if($item_count > 0) {
            $tmp = $newRequest['data'];
            unset($newRequest['data']);
            $newRequest['data']['discounts'] = $tmp;
            $newRequest['data']['discounts']['cart_discount_msg_html'] = "";
            $newRequest['data']['discounts']['final_with_discounted_price'] = null;
            $newRequest['data']['discounts']['discount_code'] = "";
            $newRequest['data']['discounts']['discount_error'] = null;
            $newRequest['data']['discounts']['original_total_price'] = Money::$currency($original_total_price)->format();
            $newRequest['data']['discounts']['discounted_price_total'] = Money::$currency($discounted_price_total)->format();
        }

        return response()->json(['data' => $newRequest['data']]);
    }

    public function createDraftOrder(Request $request, $shopifyShop){
        $shop = \ShopifyApp::shop($shopifyShop);
        $cart = $request->data;
        $parameters = $order = [];
        $parameters['currency'] = $cart['currency'];
        $tags = ['offer-dynamic-discount'];
        foreach ($cart['cart']['items'] as $key => $val){
            $applied_discount = $line_items = [];
            $line_items['quantity'] = $val['quantity'];
            $line_items['variant_id'] = $val['variant_id'];
            $code = @$val['properties']['OfferType']?$val['properties']['OfferType']:'DISCOUNT';
            if($code) {
                if($code == "DISCOUNT"){
                    $product = RulesetProducts::where('shop_id',$shop->id)->where('product_id',$val['product_id'])->first();
                    if($product){
                        $entity = RulesetSetting::with('ruleset')->where('ruleset_id',$product->ruleset_id)->where('buy',$val['quantity'])->first();
                    }else{
                        $entity = false;
                    }
                }else{
                    $entity = RulesetSetting::with('ruleset')->where('code',$code)->first();
                }
                if ($entity) {
                    $buy = $entity->buy;
                    $get = $entity->get;
                    $discount = 0;
                    if ($entity->offer_type == 'free') {
                        if($code == "DISCOUNT"){
                            $qty = $buy+$get;
                            $line_items['quantity'] = $qty;
                            $price = $val['price'] * $qty;
                            $vv = ($price / 100) / $qty;
                            $discount = (int)(($vv*100))/100;
                            $amount = $discount * $qty;
                        }else{
                            $single_product_price = $val['price']/100;
                            $all_product_price = $single_product_price * $val['quantity'];
                            $discount_amount = $all_product_price - ($single_product_price * $get);
                            $amount = $all_product_price - $discount_amount;
                            $discount = $amount / $val['quantity'];
                        }
                        $type = 'fixed_amount';
                    } else if ($entity->offer_type == 'percentage') {
                        $discount = $get;
                        $type = 'percentage';
                        $vv = ($val['original_line_price'] * $get / 100) / 100;
                        $amount = (int)(($vv*100))/100;
                    } else if ($entity->offer_type == 'fixed') {
                        $discount = $get / $val['quantity'];
                        $amount =  $get;
                        $type = 'fixed_amount';
                    }
                    if($discount){
                        $code = $entity->code;
                        $tags[] = $entity->ruleset->code;
                        $applied_discount['description'] = $code;
                        $applied_discount['value'] = $discount;
                        $applied_discount['value_type'] = $type;
                        $applied_discount['amount'] = $amount;
                        $line_items['applied_discount'] = $applied_discount;
                    }
                }
            }
            $parameters['line_items'][] = $line_items;
        }
        $parameters['tags'] = implode(', ', $tags);
        $order['draft_order'] = $parameters;
        //return response($order);
        $order = $shop->api()->rest('POST', 'admin/draft_orders.json',$order);
        if(@$order->body->draft_order){
            $order = $order->body->draft_order;
            $invoice_url = $order->invoice_url;
            $code = 200;
        }else{
            $invoice_url = "";
            $code = 401;
        }
        return response()->json(['data' => ['url' => $invoice_url,'order' => $order]],$code);
    }

}
