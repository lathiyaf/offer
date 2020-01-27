<?php

namespace App\Http\Controllers\Display;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DisplaySetting;
use App\Models\GeneralSetting;

class DisplaySettingsController extends Controller
{
    public $view = 'pages.display.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->filled('api')){
            return $this->apiIndex();
        }
        return view($this->view.'index');
    }

    public function apiIndex()
    {
        $shop = \ShopifyApp::shop();
        $gs = GeneralSetting::where('shop_id', $shop->id)->select(['advanced_css','advanced_js','display_customize_text'])->first();
        $displaySettings = DisplaySetting::where('shop_id', $shop->id)->get(['button_settings as button', 'display_type', 'style_final_string', 'style_settings as style','text_settings as text','type','updated_at'])->toArray();
        $prepare = [];
        foreach ($displaySettings as $key => $val){
            $prepare[$val['display_type']]['style'] = $val['style'];
            $prepare[$val['display_type']]['button'] = $val['button'];
            $prepare[$val['display_type']]['text'] = $val['text'];
            $prepare[$val['display_type']]['type'] = $val['type'];
            $prepare[$val['display_type']]['style_final_string'] = $val['style_final_string'];
            $prepare[$val['display_type']]['updated_at'] = is_null($val['updated_at'])?0:1;
        }

        return response(['gsd' => $gs?$gs:false, 'displaySettings'=> $prepare?$prepare:false],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $shop = \ShopifyApp::shop();
        GeneralSetting::where('shop_id', $shop->id)->delete();
        DisplaySetting::where('shop_id', $shop->id)->delete();
        foreach ($request->all() as $key => $val){
            if($key == 'gs'){
                $entity = new GeneralSetting;
                $entity->shop_id = $shop->id;
                //$entity->display_customize_text = $val['display_customize_text'];
                $entity->advanced_css = $val['advanced_css'];
                $entity->advanced_js = $val['advanced_js'];
                $entity->save();
            }else{
                $entity = new DisplaySetting;
                $entity->shop_id = $shop->id;
                $entity->display_type = $key;
                $entity->style_final_string = $val['style_final_string'];
                $entity->type = $val['type'];
                $entity->text_settings = $val['text'];
                $entity->style_settings = $val['style'];
                $entity->button_settings = @$val['button'];
                $entity->save();
            }

        }
    }

    public function restore(Request $request)
    {
        $data = config('rocket')[$request->type];
        $shop = \ShopifyApp::shop();
        $entity = DisplaySetting::where('display_type',$request->type )->where('shop_id', $shop->id)->first();

        $entity->type = json_decode($data['type']);
        $entity->text_settings = json_decode($data['text_settings']);
        $entity->style_settings = json_decode($data['style_settings']);
        $entity->button_settings = json_decode($data['button_settings']);
        $entity->updated_at = null;
        $entity->save(['timestamps' => false]);

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
