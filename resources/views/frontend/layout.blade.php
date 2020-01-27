<!doctype html>
<html lang="en">
<head>
    <title>Offer List</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,600,600i,700,700i,900,900i&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.1.2/css/ionicons.min.css">
    <link href="{{ asset('css/frontend_style.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
<div class="navbar-main">
    <a href="/"><img src="https://cdn.shopify.com/s/files/1/1564/7647/files/logo_200x.png?v=1535545460" class="img-fluid" style="max-width: 250px;"></a>
</div>
<div class="page-banner text-center">
    <h3>Guide to Volume Tiered Discount</h3>
</div>
<div class="main-app">
    @yield('content')
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $('#myTab li a').click(function(){
            var id = $(this).attr('href');
            $(this).addClass('active');
            $(this).parents('#myTab li').siblings().find('a').removeClass('active');
            $(id).siblings().removeClass('show');
            $(id).addClass("show");
        });
        $('.panel-heading .setup-items').click(function(){
            $(this).parents('.panel-heading').siblings().find('.panel-collapse').slideUp();
            $(this).parents('.panel-heading').siblings().find('i').removeClass('ion-md-remove');
            $(this).parents('.panel-heading').find('.panel-collapse').slideToggle();
            $(this).find('i').toggleClass('ion-md-remove');
        });
    });
</script>
</body>
</html>
