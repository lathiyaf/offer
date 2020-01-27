<p class="dropdown_headline">{{$ds->text->display_headline_text}}</p>
<table class="crawlapps_css_gridview" id="offerChange_gridview">
    <thead class="tbl_gd_thead">
        <td class="tbl_gd_td">{{$ds->text->headerText1}}</td>
        <td class="tbl_gd_td">{{$ds->text->headerText2}}</td>
        @if($ds->button->is_add_btn_enabled)
        <td class="tbl_gd_td">{{$ds->text->headerText3}}</td>
        @endif
    </thead>
    <tbody class="tbl_gd_tbody">
        @php $space = " "; @endphp
        @foreach ($reulset as $key => $val)
        <tr class="tbl_gd_tr read_offers_data"  data-buy="{{$val->buy}}" data-get="{{$val->get}}" data-offer="{{$val->offer_type}}" data-code="{{$val->code}}">
            <td class="tbl_gd_td">
                {{ $ds->text->before_qty.$space.$val->buy.$space }}
            </td>
            <td class="tbl_gd_td">
                @php
                    if($val->get == 0){
                        echo "<font>---</font>";
                    }else{
                        if($val->offer_type == "free"){
                            echo $ds->text->after_qty.
                                $space.
                                $val->get.
                                $space.
                                $ds->text->after_price.
                                $space.
                                $ds->type[$val->offer_type]['text'];
                        }
                        elseif($val->offer_type == "fixed"){
                            echo $ds->text->after_qty.
                                $space.
                                $ds->type[$val->offer_type]['symbol'].
                                $val->get.
                                $space.
                                $ds->text->after_price.
                                $space.
                                $ds->type[$val->offer_type]['text'];
                        }
                        else if($val->offer_type == "percentage"){
                            echo $ds->text->after_qty.
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
            </td>
            @if($ds->button->is_add_btn_enabled)
            <td class="tbl_gd_td">
                <button type="button" data-buy="{{$val->buy}}" data-get="{{$val->get}}" data-offer="{{$val->offer_type}}" value="{{$val->code}}" value="{{$val->code}}" class="tbl_gd_btn">{{$ds->button->text}}</button>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
<input type="hidden" name='properties[OfferType]'  value="" id="crawlapps_property_offer" />

<script>
    var el = document.getElementsByClassName('tbl_gd_btn');
    for (var i=0; i < el.length; i++) {
        el.item(i).onclick = clickerFn;
    }
    function clickerFn(button) {
        button = button.target;
        let input = document.getElementById('crawlapps_property_offer');
        input.setAttribute('value',button.value);
        let get = button.getAttribute('data-get')
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
        document.querySelector('[name="add"]' ).click();
    }
    @php echo $gs->advanced_js @endphp
</script>

@php

    $border_size_half = "0px";
    $border_radius = $ds->style->border_radius."px";
    if($ds->style->border_radius) {
        $border_radius = $ds->style->border_radius + 2;
        $border_radius = $border_radius."px";
    }
@endphp


<style>
    .crawlapps_css_gridview{
        width: auto;
        border-collapse: separate;
        text-shadow: none !important;
        border-radius: {{$border_radius}} !important;
        font-family:{{$ds->style->font_family}} !important;
        font-size:{{$ds->style->font_size}}px !important;
        margin-top:{{$ds->style->border_size}}px !important;
    }
    .crawlapps_css_gridview th,
    .crawlapps_css_gridview td{
        padding: {{$ds->style->td_padding}} !important;
        border: {!! $ds->style->border_size !!}px solid {!! $ds->style->border_color !!} !important;
    }
    .crawlapps_css_gridview thead td{
        background:{{$ds->style->header_bg_color}} !important;
        color:{{$ds->style->header_color}} !important;
    }
    .crawlapps_css_gridview tbody td{
        background:{{$ds->style->body_bg_color}} !important;
        color:{{$ds->style->text_color}} !important;
    }
    .crawlapps_css_gridview thead tr th:first-child,
    .crawlapps_css_gridview thead tr td:first-child{
        border-top-left-radius: {{$ds->style->border_radius}}px;
    }
    .crawlapps_css_gridview thead tr th:last-child,
    .crawlapps_css_gridview thead tr td:last-child{
        border-top-right-radius: {{$ds->style->border_radius}}px;
    }
    .crawlapps_css_gridview tbody tr:last-child td:first-of-type{
        border-bottom-left-radius: {{$ds->style->border_radius}}px;
    }
    .crawlapps_css_gridview tbody tr:last-child td:last-of-type {
        border-bottom-right-radius: {{$ds->style->border_radius}}px;
    }



    .crawlapps_css_gridview tbody tr td:not(:last-of-type){
        border-right: {!! $border_size_half !!} solid {!! $ds->style->border_color !!} !important;
    }

    .crawlapps_css_gridview thead tr td:not(:last-of-type){
        border-right: {!! $border_size_half !!} solid {!! $ds->style->border_color !!} !important;
    }

    .crawlapps_css_gridview tr:not(:last-of-type) td{
        border-bottom: {!! $border_size_half !!} solid {!! $ds->style->border_color !!} !important;
    }

    .crawlapps_css_gridview thead tr td{
        border-bottom: {!! $border_size_half !!} solid {!! $ds->style->border_color !!} !important;
    }



    .crawlapps_css_gridview tbody td .tbl_gd_btn:hover{
        border-color: {{$ds->button->border_color_on_hover}} !important;
    }
    .crawlapps_css_gridview tbody td .tbl_gd_btn:focus{
        outline: none !important;
        border-color: {{$ds->button->border_color_on_hover}} !important;
    }
    .crawlapps_css_gridview tbody td .tbl_gd_btn{
        font-family:{{$ds->button->font_family}} !important;
        font-size:{{$ds->button->font_size}}px !important;
        border-color:{{$ds->button->border_color}} !important;
        border-width:{{$ds->button->border_size}}px !important;
        background-color:{{$ds->button->bg_color}} !important;
        padding:{{$ds->button->padding}} !important;
        color:{{$ds->button->text_color}} !important;
        border-radius:{{$ds->button->border_radius}}px !important;
        border-style:solid !important;
    }


    .dropdown_headline {
        color: {{ $ds->style->color_display_headline_text  }};
        font-size: {{ $ds->style->font_size_display_headline_text  }}px;
        margin-bottom: 5px;
    }

    @media (max-width: 767px){
        .crawlapps_offers_gridview .dropdown_headline{
            text-align: center;
        }
        .crawlapps_css_gridview{
            margin-left: auto;
            margin-right: auto;
        }
    }

    @php echo $gs->advanced_css @endphp
</style>
<style>
    .crawlapps_body_venture .crawlapps_offers_gridview{
        width: 100%;
        padding: 0 5px;
    }
    .crawlapps_body_venture .crawlapps_offers_gridview table{
        margin-bottom: 10px;
    }
    .crawlapps_body_debut .crawlapps_offers_gridview{
        width: 100%;
        padding: 0 5px;
    }
    .crawlapps_body_debut .crawlapps_offers_gridview table{
        margin-bottom: 10px;
    }
    .crawlapps_body_minimal .crawlapps_offers_gridview table{
        margin-bottom: 17px;
    }
    .crawlapps_body_boundless .crawlapps_offers_gridview table{
        margin-bottom: 10px;
    }
</style>
