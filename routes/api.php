<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Api routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your Api!
|
*/

Route::group(['namespace' => 'Api'], function () {

    Route::get('version', function(Request $request) {

        $jsFilePath = public_path() . '/js/crawlapps-cli-offer.js';
        $jsVersion  = filemtime($jsFilePath);

        return response()->json(['data' => ['js' => $jsVersion]]);
    });

    Route::group(['prefix' => '{shopifyShop}'], function () {
        Route::get('/', 'Auth\LoginController@index');
        Route::get('offers', 'Offer\OfferController@index');
        Route::post('offers/cart', 'Offer\OfferController@cart');
        Route::post('offers/buy-now', 'Offer\OfferController@buyNow');
        Route::post('offers/create-draft-order', 'Offer\OfferController@createDraftOrder');
    });
});

