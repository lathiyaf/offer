<?php

namespace App\Http\Controllers\Offer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\OfferRequest;
use App\Models\Ruleset;
use App\Models\RulesetProducts;
use App\Models\RulesetSetting;
use Illuminate\Support\Facades\DB;
use OhMyBrew\ShopifyApp\ShopifyApp;

class OfferController extends Controller
{
    public $view = 'pages.offers.';

    public function index(Request $request){
        if($request->filled('page')){
            return $this->apiIndex($request);
        }
        $counter = Ruleset::where('shop_id', \ShopifyApp::shop()->id)->count();

        return view($this->view.'index',compact('counter'));
    }

    private function apiIndex(Request $request)
    {
        $shop = \ShopifyApp::shop();
        $per_page = $request->per_page;

        $entities = Ruleset::withCount('products');

        if ($request->has('sort') && !empty($request->get('sort'))) {
            $short_array = explode('|', $request->get('sort'));
            $entities    = $entities->orderBy($short_array[0], $short_array[1]);
        } else {
            $entities = $entities->orderBy('created_at', 'desc');
        }

        if($request->filled('search')){
            $search = $request->search;
            $entities = $entities->orWhere('ruleset_name','like','%'.$search.'%');
        }
        $entities = $entities->where('shop_id', $shop->id)->orderBy('created_at','desc');
        if($request->filled('api')){
            $paginator = $entities->select(['ruleset_name','code','id'])->get();
        }else{
            $paginator = $entities->paginate($per_page);
        }

        return response()->json($paginator,200);
    }

    public function create(Request $request){
        $data = [];
        return view($this->view.'createEdit', compact('data'));
    }

    public function store(OfferRequest $request){
        $shop = \ShopifyApp::shop();
        $entity = new Ruleset;
        $entity->shop_id = $shop->id;
        $entity->ruleset_name = $request->ruleset_name;
        $entity->status = @$request->status?1:0;
        $entity->code = 'offer-dynamic-'.uniqid();
        $entity->display_type = $request->display_type;
        $entity->save();
        $this->commonDB($request, $entity);
        return response()->json([
            'data' => 'Ruleset Successfully Created.',
        ],200);
    }

    public function edit(Ruleset $ruleset, Request $request){
        $data['entity'] = Ruleset::with(['products' => function($query){
            return $query->select('product_title as title','ruleset_id','id', 'product_img_src as image', 'product_id');
        },'settings' => function($query){
            return $query->select('id','ruleset_id','get','buy','offer_type')->orderBy('buy');
        }])->find($ruleset->id);
        return view($this->view.'createEdit',compact('data'));
    }

    public function update(Ruleset $ruleset, OfferRequest $request){
        $entity = $ruleset;
        $entity->ruleset_name = $request->ruleset_name;
        $entity->status = @$request->status?1:0;
        $entity->display_type = $request->display_type;
        $entity->save();
        $this->commonDB($request, $entity);
        return response()->json([
            'data' => 'Ruleset Successfully Saved.',
        ],200);
    }

    public function commonDB($request, $entity){
        if(@count($request->tier_pricing)) {
            RulesetSetting::where('ruleset_id',$entity->id)->delete();
            foreach ($request->tier_pricing as $item) {
                $setting = new RulesetSetting;
                $setting->ruleset_id = $entity->id;
                $setting->buy = $item['buy'];
                $setting->get = $item['get'];
                $setting->offer_type = $item['offer_type'];
                $code = "BUY".$item['buy']."GET".$item['get'].strtoupper($item['offer_type']);
                $setting->code = $code;
                $setting->save();
            }
        }

        if(@count($request->selectedDesign['data'])){
            RulesetProducts::where('ruleset_id',$entity->id)->delete();
            foreach ($request->selectedDesign['data'] as $item) {
                $RulesetProducts = new RulesetProducts;
                $RulesetProducts->shop_id = $entity->shop_id;
                $RulesetProducts->ruleset_id = $entity->id;
                $RulesetProducts->product_id = @$item['product_id']?$item['product_id']:$item['id'];
                $RulesetProducts->product_img_src = @$item['image'];
                $RulesetProducts->product_title = $item['title'];
                $RulesetProducts->save();
            }
        }
    }

    public function delete(Ruleset $ruleset, Request $request)
    {
        $ruleset->products()->delete();
        $ruleset->settings()->delete();
        $ruleset->delete();
        return $this->apiIndex($request);
    }

    public function deleteProduct( Request $request){
        $ruleset_product = RulesetProducts::find($request->id);
        $ruleset_id = $ruleset_product->ruleset_id;
        $ruleset_product->delete();
       return RulesetProducts::where('ruleset_id',$ruleset_id)->select('product_title as title','ruleset_id','id', 'product_img_src as image', 'product_id')->get()->toJson();
    }

    public function getProducts(Request $request){
        $shop = \ShopifyApp::shop();
        $domain = str_replace('.', '_', $shop->shopify_domain);
        $table = 'products_'.$domain;
        return $rows = DB::table($table)->select('product_id', 'product_image_url', 'title')->paginate(20)->toJson();
    }

    public function check(Request $request){
        $shop = \ShopifyApp::shop();
        $entity = RulesetProducts::where('shop_id',$shop->id)->get()->toArray();
        $entity = array_column($entity,'product_id');;
        $prepareArray = [];
        $c = 0;
        $notfound_image = asset('images/not_found.png');

        foreach($request['data'] as $key => $val){
            if(!in_array($val['id'],$entity)){
                $prepareArray[$c]['id'] = $val['id'];
                $prepareArray[$c]['title'] = $val['title'];
                $prepareArray[$c++]['image'] = @($val['image']['src'])?$val['image']['src']:$notfound_image;
            }
        }

        return \Response::json([
            'data' => $prepareArray,
            'total_selected' => count($request['data']),
            'total_added' => $c,
        ], 200);
    }

    public function status(Ruleset $ruleset){
        $ruleset->status = @$ruleset->status?0:1;
        $ruleset->save();
        $msg = $ruleset->status?"Activated.":"Deactivated.";
        return response()->json([
            'data' => 'Ruleset Successfully '.$msg,
        ],200);
    }
}
