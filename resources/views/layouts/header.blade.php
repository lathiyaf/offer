<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <title>{{ config('shopify-app.app_name')  }}</title>

    <link rel="stylesheet" href="https://sdks.shopifycdn.com/polaris/2.0.0-rc.3/polaris.min.css" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- External codes -->

</head>
<body>
    <div id="app" class="Polaris-Page">
            <div class="content-page">
            	@include('layouts.nav')
                <div class="content">
                    <div class="container">
                        <div class="">
                        @yield('content')
            @extends('layouts.footer')
