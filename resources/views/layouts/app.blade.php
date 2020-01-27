<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-url" content="{{ env('APP_API_URL') }}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,300i,400,400i,600,600i,700,700i,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.1.2/css/ionicons.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{--<link href="{{ asset('css/polaris.min.css') }}" rel="stylesheet">--}}
    <script>
        window.Laravel = @php echo json_encode([
            'csrfToken' => csrf_token()
        ]); @endphp

        window.timezone = "@php echo (\ShopifyApp::shop()->timezone)?\ShopifyApp::shop()->timezone:'UTC' ; @endphp"
        window.ShopifyApp.init({
            apiKey: "@php echo config('shopify-app.api_key') @endphp",
            shopOrigin: 'https://'+"@php echo \ShopifyApp::shop()->shopify_domain @endphp",
            forceRedirect: "@php echo config('shopify-app.esdk_enabled') @endphp",
        });
    </script>
</head>
<body class="body_{{ Request::path() }}">
<div class="" id="app">

        @include('layouts.nav')
        <div class="">
            @yield("content")
        </div>
</div>
<script src="{{ asset(mix('js/app.js')) }}" ></script>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const body = document.querySelector('body');
        if(window.innerWidth < 768) {
            var element = document.getElementById("oa-mobile-menu");
            const button = document.querySelector('#rocket_app_menu');
            button.addEventListener('click', event => {
                event.stopPropagation();
                element.classList.add("active");
            });

            body.addEventListener('click', event => {
                element.classList.remove("active");
            });

        }
        var menu_child = document.getElementById("menu_child");
        const li = document.querySelector('.ul_oa-menubar_li:last-child');
        li.addEventListener('click', event => {
            event.stopPropagation();
            menu_child.classList.add("visibility_class");
        });

        body.addEventListener('click', event => {
            menu_child.classList.remove("visibility_class");
        });


    })
</script>
</body>
</html>
