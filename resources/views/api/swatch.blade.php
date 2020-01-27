<p class="dropdown_headline">{{$ds->text->display_headline_text}}</p>
@php $space = " "; @endphp
@if($ds->text->is_buy_1_enabled)
<div class="crawlapps_css_swatch">
    <label for="buy1_radio">
        <button type="button" class="swatch_gd_btn" value="1">{{ $ds->text->selectText  }}
        </button>
    </label>
    <input type="radio" id="buy1_radio" style="display:none;" />
</div>
@endif
<ul class="crawlapps_css_swatch_ul"  style="list-style: none;padding: 0;margin: 0;">
@foreach ($reulset as $key => $val)
<li class="crawlapps_css_swatch_li">
    <label for="{{ $val->offer_type }}.'_radio'">
        <button type="button" class="swatch_gd_btn read_offers_data" data-buy="{{$val->buy}}" data-get="{{$val->get}}" data-offer="{{$val->offer_type}}" data-code="{{$val->code}}" value="{{$val->code}}">
            @php
                if($val->get == 0){
                    echo $ds->text->before_qty.$space.$val->buy.$space;

                }else{
                    echo $ds->text->before_qty.$space.$val->buy.$space.$ds->text->after_qty;
                    if($val->offer_type == "free"){
                        echo $ds->text->before_price.
                            $space.
                            $val->get.
                            $space.
                            $ds->text->after_price.
                            $space.
                            $ds->type[$val->offer_type]['text'];
                    }
                    elseif($val->offer_type == "fixed"){
                        echo $ds->text->before_price.
                            $space.
                            $ds->type[$val->offer_type]['symbol'].
                            $val->get.
                            $space.
                            $ds->text->after_price.
                            $space.
                            $ds->type[$val->offer_type]['text'];
                    }
                    else if($val->offer_type == "percentage"){
                        echo $ds->text->before_price.
                            $space.
                            $val->get.
                            $ds->type[$val->offer_type]['symbol'].
                            $space.
                            $ds->text->after_price.
                            $space.
                            $ds->type[$val->offer_type]['text'];
                        }
                }

            @endphp
        </button>
    </label>
    <input type="radio" id="{{ $val->offer_type }}.'_radio'" style="display:none;" />
</li>
@endforeach
</ul>
<input type="hidden" name='properties[OfferType]'  value="" id="crawlapps_property_offer" />
<script>
    var el = document.getElementsByClassName('swatch_gd_btn');
    for (var i=0; i < el.length; i++) {
        el.item(i).onclick = clickerFn;
    }
    function clickerFn(button) {
        button = button.target;
        let input = document.getElementById('crawlapps_property_offer');
        input.setAttribute('value',button.value);

        let get = button.getAttribute('data-get');
        let buy = button.getAttribute('data-buy') ? button.getAttribute('data-buy'): 1;
        let offer = button.getAttribute('data-offer');
        var values = 0;
        let quantity = document.querySelector('[name="quantity"]');
        if(quantity == null){
            var div = document.querySelector('[name="add"]' );
            var newinput = document.createElement( 'input' );
            newinput.setAttribute('name','quantity');
            newinput.setAttribute('type','hidden');
            div.parentNode.insertBefore( newinput, div.nextSibling);
        }
        if(offer=="free"){

            values = parseInt(buy) + parseInt(get);
            document.querySelector('[name="quantity"]').setAttribute('value',values);
        }else{
            values = buy;
            document.querySelector('[name="quantity"]').setAttribute('value',values);
        }
    }

    @php echo $gs->advanced_js @endphp
</script>
<style>
    .crawlapps_css_swatch_li .swatch_gd_btn{
        font-family:{{$ds->style->font_family}} !important;
        font-size:{{$ds->style->font_size}}px !important;
        border-color:{{$ds->style->border_color}} !important;
        border-width:{{$ds->style->border_size}}px !important;
        background-color:{{$ds->style->bg_color}} !important;
        padding:{{$ds->style->padding}} !important;
        color:{{$ds->style->text_color}} !important;
        border-style:solid !important;
        border-radius:{{$ds->style->border_radius}}px !important;
    }

    .crawlapps_css_swatch_li .swatch_gd_btn:hover{
        border-color: {{$ds->style->border_color_on_hover}} !important;
    }

    .crawlapps_css_swatch_li .swatch_gd_btn:focus{
        outline: none;
        border-color: {{$ds->style->border_color_on_hover}} !important;
    }

    .crawlapps_css_swatch_li{
        display:{{$ds->style->display_type}} !important;
    }
    .dropdown_headline{
        color: {{ $ds->style->color_display_headline_text  }};
        font-size: {{ $ds->style->font_size_display_headline_text  }}px;
        margin-bottom: 5px;
    }
    @php echo $gs->advanced_css @endphp
</style>
<style>
    .crawlapps_body_venture .crawlapps_offers_swatch{
        width: 100%;
        padding: 0 5px;
    }
    .crawlapps_body_venture .crawlapps_offers_swatch ul{
        margin-bottom: 10px;
    }
    .crawlapps_body_debut .crawlapps_offers_swatch{
        width: 100%;
        padding: 0 5px;
    }
    .crawlapps_body_debut .crawlapps_offers_swatch ul{
        margin-bottom: 10px;
    }
    .crawlapps_body_minimal .crawlapps_offers_swatch ul{
        margin-bottom: 17px;
    }
    .crawlapps_body_boundless .crawlapps_css_swatch_li{
        margin-bottom: 8px;
        margin-right: 5px;
    }
    .crawlapps_body_venture ul{
        display: flex;
        flex-wrap: wrap;
    }
    .crawlapps_body_venture ul li{
        margin-bottom: 5px;
        margin-right: 5px;
    }
</style>
