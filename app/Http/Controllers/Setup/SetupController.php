<?php

namespace App\Http\Controllers\Setup;

use App\Models\Webhook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SetupController extends Controller
{
    public $view = 'pages.setup.';

    public function steps(){
        $shop = \ShopifyApp::shop();
        $data = $this->index();
        $orders = Webhook::where('shop_id',$shop->id)->where('topic','orders/create')->count();

        return view($this->view.'steps',compact('data','orders'));
    }

    public function index(){
        $shop = \ShopifyApp::shop();
        $themes = $shop->api()->rest('GET', 'admin/themes.json', ['fields' => 'id,name']);
        $theme = $data = [];
        foreach($themes->body->themes as $val){
            $theme['label'] = $val->name;
            $theme['value'] = (string)$val->id;
            $data[] = $theme;
        }
        return $data;
        //return view($this->view.'index',compact('data'));
    }

    public function store(Request $request) {
        //dd($request->all());

        $shop = \ShopifyApp::shop();
        $asset = $shop->api()->rest('GET', 'admin/themes/'.$request->theme.'/assets.json',["asset[key]" => 'sections/cart-template.liquid']);
        if(@$asset->body->asset){
            $asset = $asset->body->asset->value;

            if(strpos($asset ,"uninstall-crawlappscartitemprice")){
                $asset = str_replace('uninstall-crawlappscartitemprice',"crawlapps-cart-item-price ",$asset);
            }
            elseif(!strpos($asset ,"<span class='crawlapps-cart-item-price'")){
                $asset = str_replace('{{ item.price | money }}',"<span class='crawlapps-cart-item-price ' data-key='{{item.key}}'>{{ item.price | money }}</span>",$asset);

                $asset = str_replace('{{ item.original_price | money }}',"<span class='crawlapps-cart-item-price ' data-key='{{item.key}}'>{{ item.original_price | money }}</span>",$asset);
            }

            if(strpos($asset ,"uninstall-crawlappscartitemlineprice")){
                $asset = str_replace('uninstall-crawlappscartitemlineprice',"crawlapps-cart-item-line-price ",$asset);
            }
            elseif(!strpos($asset ,"<span class='crawlapps-cart-item-line-price'")){
                $asset = str_replace('{{ item.line_price | money }}',"<span class='crawlapps-cart-item-line-price' data-key='{{item.key}}'>{{ item.line_price | money }}</span>",$asset);
                $asset= str_replace('{{ item.original_line_price | money }}',"<span class='crawlapps-cart-item-line-price' data-key='{{item.key}}'>{{ item.original_line_price | money }}</span>",$asset);
            }

            if(!strpos($asset ,"value=\"{{ item.quantity }}\" data-key='{{item.key}}'")){
                $asset = str_replace("value=\"{{ item.quantity }}\"","value=\"{{ item.quantity }}\" data-key='{{item.key}}'",$asset);
            }

            if(strpos($asset ,"uninstall-crawlappscartoriginaltotal")){
                $asset = str_replace('uninstall-crawlappscartoriginaltotal',"crawlapps-cart-original-total ",$asset);
            }
            elseif(!strpos($asset ,"<span class='crawlapps-cart-original-total'")){
                $asset = str_replace('{{ cart.total_price | money }}',"<span class='crawlapps-cart-original-total'>{{ cart.total_price | money }}</span>",$asset);
            }

            $parameter['asset']['key'] = 'sections/cart-template.liquid';
            $parameter['asset']['value'] = $asset;
            $asset = $shop->api()->rest('PUT', 'admin/themes/'.$request->theme.'/assets.json',$parameter);
            $this->snippet('add',$request);
            $this->updateThemeLiquid('add',$request);
            if(@$asset->body->asset)
            return \Response::json([
                'data' => 'Auto Install Completed',
            ], 200);
        }
    }

    public function updateThemeLiquid($type,$request){
        $shop = \ShopifyApp::shop();
        if($type == 'add'){

            $asset = $shop->api()->rest('GET', 'admin/themes/'.$request->theme.'/assets.json',["asset[key]" => 'layout/theme.liquid']);
            if(@$asset->body->asset){
                $asset = $asset->body->asset->value;
                if(!strpos($asset ,"{% include 'crawlapps-offers' %}</head>")){
                    $asset = str_replace('</head>',"{% include 'crawlapps-offers' %}</head> ",$asset);
                }

                $parameter['asset']['key'] = 'layout/theme.liquid';
                $parameter['asset']['value'] = $asset;
                $asset = $shop->api()->rest('PUT', 'admin/themes/'.$request->theme.'/assets.json',$parameter);
            }
        }
    }

    public function snippet($type,$request){

        $shop = \ShopifyApp::shop();
        if($type == 'add') {
            $value = <<<EOF
        <script id="crawlapps_offer_shop_data" type="application/json">
            {
                "shop": {
                    "domain": "{{ shop.domain }}",
                    "permanent_domain": "{{ shop.permanent_domain }}",
                    "url": "{{ shop.url }}",
                    "secure_url": "{{ shop.secure_url }}",
                    "money_format": {{ shop.money_format | json }},
                    "currency": {{ shop.currency | json }}
                },
                "customer": {
                    "id": {{ customer.id | json }},
                    "tags": {{ customer.tags | json }}
                },
                "cart": {{ cart | json }},
                "template": "{{ template | split: "." | first }}",
                "product": {{ product | json }},
                "collection": {{ collection.products | json }}
            }
        </script>
EOF;
        }
        $parameter['asset']['key'] = 'snippets/crawlapps-offers.liquid';
        $parameter['asset']['value'] = $value;
        $asset = $shop->api()->rest('PUT', 'admin/themes/'.$request->theme.'/assets.json',$parameter);
    }

    public function unInstallView(Request $request){
        $data = $this->index();
        return view($this->view.'uninstall',compact('data'));
    }

    public function unInstall(Request $request){
        $shop = \ShopifyApp::shop();
        $asset = $shop->api()->rest('GET', 'admin/themes/'.$request->theme.'/assets.json',["asset[key]" => 'sections/cart-template.liquid']);

        if(@$asset->body->asset){
            $asset = $asset->body->asset->value;
            if(strpos($asset ,"crawlapps-cart-item-price")){
                $asset = str_replace('crawlapps-cart-item-price',"uninstall-crawlappscartitemprice ",$asset);
            }
            if(strpos($asset ,"crawlapps-cart-item-line-price")){
                $asset = str_replace('crawlapps-cart-item-line-price',"uninstall-crawlappscartitemlineprice ",$asset);
            }
            if(strpos($asset ,"crawlapps-cart-original-total")){
                $asset = str_replace('crawlapps-cart-original-total',"uninstall-crawlappscartoriginaltotal ",$asset);
            }
            //dd($asset);
            $parameter['asset']['key'] = 'sections/cart-template.liquid';
            $parameter['asset']['value'] = $asset;
            $asset = $shop->api()->rest('PUT', 'admin/themes/'.$request->theme.'/assets.json',$parameter);
            if(@$asset->body->asset)
                return \Response::json([
                    'data' => 'Successfully Uninstalled',
                ], 200);
        }
    }
}
