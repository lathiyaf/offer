<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebHookController extends Controller
{
    public function get(Request $request)
    {

        $shop = \ShopifyApp::shop();
        $data = $shop->api()->rest('GET', '/admin/webhooks.json');
        dd($data);
    }

    public function destroy(Request $request)
    {
        $shop = \ShopifyApp::shop();
        $data = $shop->api()->rest("DELETE", '/admin/webhooks/'.$request->id.'.json');
        dd($data);
    }
}
