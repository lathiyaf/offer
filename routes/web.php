<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['web', 'auth.shop']], function () {
    /* App Installation */
    Route::get('/','Dashboard\DashboardController@index')->name('home');

    Route::group(['prefix'=>'setup','as' => 'setup.'], function () {
        Route::get('/','Setup\SetupController@index')->name('index');
        Route::get('/steps','Setup\SetupController@steps')->name('steps');
        Route::get('uninstall/view','Setup\SetupController@unInstallView')->name('uninstall.view');
        Route::post('store','Setup\SetupController@store')->name('store');
        Route::post('uninstall','Setup\SetupController@unInstall')->name('uninstall');
    });

    Route::group(['prefix'=>'offers','as' => 'offers.'], function () {
        Route::get('/','Offer\OfferController@index')->name('index');
        Route::get('/getProducts','Offer\OfferController@getProducts')->name('getProducts');
        Route::get('create','Offer\OfferController@create')->name('create');
        Route::get('{ruleset}/edit','Offer\OfferController@edit')->name('edit');
        Route::post('{ruleset}/status','Offer\OfferController@status')->name('status');
        Route::post('/','Offer\OfferController@store')->name('store');
        Route::post('/check','Offer\OfferController@check')->name('check');
        Route::post('{ruleset}','Offer\OfferController@update')->name('update');
        Route::delete('{ruleset}/delete','Offer\OfferController@delete')->name('delete');
        Route::delete('delete-product','Offer\OfferController@deleteProduct')->name('deleteProduct');
    });

    Route::group(['prefix'=>'settings','as' => 'settings.'], function () {
        Route::get('/','Display\DisplaySettingsController@index')->name('index');
        Route::post('store','Display\DisplaySettingsController@store')->name('store');
        Route::post('restore','Display\DisplaySettingsController@restore')->name('restore');
    });
});

/**
 * Frontend
 */
Route::get('faq','Frontend\CommonController@faq')->name('faq');
Route::get('instruction','Frontend\CommonController@instruction')->name('instruction');

Route::get('flush', function(){
    request()->session()->flush();
});

/*Route::get('test', function(){
    foreach (config('rocket') as $key => $val){
        //dd(json_decode($val['text_settings'],1));
        $entity = new \App\Models\DisplaySetting;
        $entity->shop_id = null;
        $entity->display_type = $key;
        $entity->type = json_decode($val['type']);
        $entity->text_settings = json_decode($val['text_settings']);
        $entity->style_settings = json_decode($val['style_settings']);
        $entity->button_settings = json_decode($val['button_settings']);
        $entity->updated_at = null;
        $entity->save(['timestamps' => false]);

    }
});*/


Route::get('/webhooks/', 'WebHookController@get');
Route::get('/webhooks/delete', 'WebHookController@destroy');
