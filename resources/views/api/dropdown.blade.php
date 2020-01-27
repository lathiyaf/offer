@php
    $space = " ";
    $html = "<p class='dropdown_headline'>".$ds->text->display_headline_text."</p>";
        $html .= "<select class='crawlapps_css_dropdown read_offers_data' name='properties[OfferType]' id='offerChange_dropdown'>";
            if($ds->text->is_buy_1_enabled)
            $html .= "<option value='1'>".$ds->text->selectText."</option>";

            foreach ($reulset as $key => $val){
                $html .= '<option data-buy="'.$val->buy.'" data-get="'.$val->get.'" data-offer="'.$val->offer_type.'" data-code="'.$val->code.'" value="'.$val->code.'">';

                if($val->get == 0){
                    $html .=
                            $ds->text->before_qty.
                            $space.
                            $val->buy;
                }else{
                        if($val->offer_type == "free"){
                            $html .=
                                    $ds->text->before_qty.
                                    $space.
                                    $val->buy.
                                    $space.
                                    $ds->text->after_qty.
                                    $space.
                                    $ds->text->before_price.
                                    $space.
                                    $val->get.
                                    $space.
                                    $ds->text->after_price.
                                    $space.
                                    $ds->type['free']['text'];
                        }
                        elseif ($val->offer_type == "fixed"){
                            $html .=
                                    $ds->text->before_qty.
                                    $space.
                                    $val->buy.
                                    $space.
                                    $ds->text->after_qty.
                                    $space.
                                    $ds->text->before_price.
                                    $space.
                                    $ds->type['fixed']['symbol'].
                                    $val->get.
                                    $space.
                                    $ds->text->after_price.
                                    $space.
                                    $ds->type['fixed']['text'];
                        }
                        elseif ($val->offer_type == "percentage"){
                            $html .=
                                    $ds->text->before_qty.
                                    $space.
                                    $val->buy.
                                    $space.
                                    $ds->text->after_qty.
                                    $space.
                                    $ds->text->before_price.
                                    $space.
                                    $val->get.
                                    $ds->type['percentage']['symbol'].
                                    $space.
                                    $ds->text->after_price.
                                    $space.
                                    $ds->type['percentage']['text'];
                        }
                }
                $html .='</option>';
            }
            $html .= '</select>';
    echo $html;
@endphp

<style>
    .crawlapps_css_dropdown{
        background-color: {{ $ds->style->bg_color  }} !important;
        font-size: {{ $ds->style->font_size  }}px !important;
        color: {{ $ds->style->text_color  }} !important;
        border-width: {{ $ds->style->border_size  }}px !important;
        border-color: {{ $ds->style->border_color  }} !important;
        padding: {{ $ds->style->padding }} !important;
        border-radius: {{ $ds->style->border_radius }}px !important;
    }
    .crawlapps_css_dropdown:focus{
        outline: none !important;
    }
    .dropdown_headline{
        color: {{ $ds->style->color_display_headline_text  }} !important;
        font-size: {{ $ds->style->font_size_display_headline_text  }}px !important;
        margin-bottom: 5px;
    }
    @php echo $gs->advanced_css @endphp
</style>
<script>

    var el = document.getElementById('offerChange_dropdown');
    el.onchange = clickerFn;
    function clickerFn(button) {
        button = button.target;
        let get = button.selectedOptions[0].getAttribute('data-get')
        let buy = button.selectedOptions[0].getAttribute('data-buy') ? button.selectedOptions[0].getAttribute('data-buy'): 1;
        let offer = button.selectedOptions[0].getAttribute('data-offer');
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
    .crawlapps_body_venture .crawlapps_offers_dropdown{
        padding: 0 5px;
    }
    .crawlapps_body_venture .crawlapps_offers_dropdown .dropdown_headline{
        margin-bottom: 13px;
        text-transform: uppercase;
    }
    .crawlapps_body_venture .crawlapps_offers_dropdown .crawlapps_css_dropdown{
        width: 100%;
    }
    .crawlapps_body_venture .crawlapps_offers_dropdown .crawlapps_css_dropdown{
        border: solid !important;
    }
    .crawlapps_body_venture .crawlapps_offers_dropdown select{
        margin-bottom: 10px;
    }
    .crawlapps_body_debut .crawlapps_offers_dropdown{
        width: 100%;
        padding: 0 5px;
    }
    .crawlapps_body_debut .crawlapps_offers_dropdown select{
        margin-bottom: 10px;
    }
    .crawlapps_body_minimal .crawlapps_offers_dropdown select{
        margin-bottom: 17px;
    }
    .crawlapps_body_boundless .crawlapps_offers_dropdown select{
        margin-bottom: 10px;
    }
    .crawlapps_body_boundless .crawlapps_offers_dropdown .crawlapps_css_dropdown{
        border: solid !important;
    }
    .crawlapps_body_narrative .crawlapps_css_dropdown{
        width: auto;
    }
    @media (max-width: 749px){
        .crawlapps_body_debut .crawlapps_offers_dropdown select{
            margin-bottom: 0;
        }
    }
    @media (min-width: 769px){
        .crawlapps_body_minimal .crawlapps_css_dropdown{
            width: auto;
        }
    }
</style>
