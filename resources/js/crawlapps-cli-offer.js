require('./bootstrap');
if(!window.jQuery)
{
    var script = document.createElement('script');
    script.type = "text/javascript";
    script.src = "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js";
    document.getElementsByTagName('head')[0].appendChild(script);
}
window.Vue = require('vue');
// import components

const host = process.env.MIX_APP_URL;
const apiEndPoint = host + '/api';
const apiUploadUrl = apiEndPoint + '/upload_image';

var shopifyDomain = Shopify.shop;
var shopifyTheme = convertToSlug(Shopify.theme.name);
var shopifyID = null;
var appSettings = null;



const app = new Vue({
    template: '<div></div>',
    delimiters: ['${', '}'],
    data: {
        shop_data:{},
        settings: null,
        addToCartIsBusy:false,
        offers: {
            offerVal:"",
            data: {},
            pagination: {},
        },
        totalReviews: null,
        avgRating: null,
        singleReview: {},
        modalReviewsData: {},
        rating: 0,
        reviewImage: {
            name: null,
            dataURL: null
        },
        dropzoneOptions: {
            headers: {
                'Access-Control-Allow-Headers': '*',
                'Access-Control-Allow-Headers': 'Content-Type, X-Auth-Token, Origin, X-Requested-With, Cache-Control, X-File-Name',
            },
            url: apiUploadUrl,
            acceptedFiles: 'image/jpg,image/jpeg,image/png',
            //autoProcessQueue: false,
            addRemoveLinks: true,
            uploadMultiple: false,
            maxFiles: 1,
            duplicateCheck: true,
            resizeWidth: 800,
            dictDefaultMessage: '<span class="fa fa-cloud-upload"></span><br><span style="font-size: 14px">Drop image or click here to upload<br>(The image must be of type jpg, jpeg or png and of size 10 MB)</span>'
        },
        googleData: []
    },
    methods: {
        init() {
            if(this.shop_data.template == 'product'){
                this.getOffers();
                this.addToCartButtonClick();
            }

            if(this.shop_data.template == 'cart') {
                this.cartPage();
            }
        },
        addShortcode(){
            let themes = ['crawlapps_body_narrative', 'crawlapps_body_minimal', 'crawlapps_body_boundless'];

            let addToCart = $('[name="add"]:first').parent();
            if($('.crawlapps_offers_swatch').length <= 0 ){
                if(themes.indexOf(addBodyClass) >= 0){
                    addToCart = $('[name="add"]:first');
                }
                addToCart.before('<div data-code="crawlapps_offers" class="crawlapps_offers crawlapps_offers_swatch"></div>');
            }
            if($('.crawlapps_offers_dropdown').length <= 0 ) {
                addToCart.before('<div data-code="crawlapps_offers" class="crawlapps_offers crawlapps_offers_dropdown"></div>');
            }

            if($('.crawlapps_offers_gridview').length <= 0 ) {
                addToCart.after('<div data-code="crawlapps_offers" class="crawlapps_offers crawlapps_offers_gridview" ></div>');
            }
        },
        getOffers() {
            var self = this;
            let aPIEndPoint = `${apiEndPoint}/${shopifyDomain}/offers?product_id=`+this.shop_data.product.id;
            axios.get(aPIEndPoint)
                .then(response => {
                    self.offers.data = response.data.data;

                    if(typeof response.headers.x_discount_type == "string"){

                        self.addShortcode();
                        /*$('html').append(this.addPopup());
                        $('.show_display_types').html('<div data-code="crawlapps_offers" class="crawlapps_offers crawlapps_offers_swatch"></div> <div data-code="crawlapps_offers" class="crawlapps_offers crawlapps_offers_dropdown"></div> <div data-code="crawlapps_offers" class="crawlapps_offers crawlapps_offers_gridview" ></div>');*/
                    }

                    if(response.headers.x_discount_type == "swatch") {
                        $(".crawlapps_offers_swatch").html(response.data);
                    }
                    else if(response.headers.x_discount_type == "dropdown"){
                        $(".crawlapps_offers_dropdown").html(response.data);
                    }
                    else{
                        $(".crawlapps_offers_gridview").html(response.data);
                    }
                })
                .catch(() => {
                    $('body').removeClass('loading');
                });
        },
        cartPage(){
            $('body').on('click', '.crawlapps_discount_button', function(e){
                e.preventDefault();
                var code = $('.crawlapps_discount_code').val();
                if(code == ''){
                    $('.crawlapps_discount_code').addClass('discount_error');
                }else{
                    localStorage.setItem('discount_code', code);
                    $('.crawlapps_discount_code').removeClass('discount_error');
                    //location.reload();
                }
            });

            var self = this;
            let aPIEndPoint = window.location.href+".json";
            axios.get(aPIEndPoint, {headers: {Accept: 'application/json'}})
                .then(response => {
                    let formdata = {
                        discount_code : localStorage.getItem('discount_code'),
                        data: response.data
                    };

                    let url = `${apiEndPoint}/${shopifyDomain}/offers/cart`;
                    axios.post(url, formdata)
                        .then(response => {
                            var data = response.data.data;
                            if (typeof data.discounts == "object" && typeof data.discounts.items == "object") {
                                self.crawlappsShowCartDiscounts(data.discounts);
                            }
                        })
                        .catch(() => {
                        });
                })
                .catch(() => {
                    $('body').removeClass('loading');
                });
        },
        crawlappsShowCartDiscounts(discounts){
            var self = this;
            var flag=0;
            $(".crawlapps_discount_hide").show();

            discounts.cart.items.forEach(function(item) {
                if (item.cart_discount_away_msg_html){
                    $(".crawlapps-reminder[data-key='" + item.key + "']").html(item.cart_discount_away_msg_html);
                }

                if (item.discounted_price < item.original_price) {
                    $(".cart__qty-input[data-key='" + item.key + "']").val( item.__quantity );
                    //$(".cart__qty-input[data-key='" + item.key + "']").attr( 'readonly', 'readonly' );
                    flag=1;

                    if(item.__code == "DISCOUNTSINGLE"){
                        $(".crawlapps-cart-item-price[data-key='" + item.key + "']").html("<span class='original_price'>" + item.original_price_format + "</span>");

                    }else{
                        //console.log('---------------1----------');
                        $(".crawlapps-cart-item-price[data-key='" + item.key + "']").html("<span class='original_price' style='text-decoration:line-through;'>" + item.original_price_format + "</span><br/>" + "<span class='discounted_price'>" + item.discounted_price_format + "</span>");
                    }
                    //console.log('---------------2----------');
                    $(".crawlapps-cart-item-line-price[data-key='" + item.key + "']").html("<span class='original_price' style='text-decoration:line-through;'>" + item.original_line_price_format + "</span><br/>" + "<span class='discounted_price'>" + item.discounted_line_price_format + "</span>")

                }else{
                    $(".crawlapps-cart-item-price[data-key='" + item.key + "']").html("<span class='original_price'>" + item.original_price_format + "</span>");
                    $(".crawlapps-cart-item-line-price[data-key='" + item.key + "']").html("<span class='original_price'>" + item.original_line_price_format + "</span>")
                }

            });
            if(flag==1){
                $(".crawlapps-cart-original-total").html(discounts.original_total_price).css("text-decoration", "line-through");
                if(discounts.final_with_discounted_price == null){
                    $("<span class='crawlapps-cart-total'>" + discounts.discounted_price_total + "</span>").insertAfter('.crawlapps-cart-original-total');
                }else{
                    $("<span class='crawlapps-cart-total'>" + discounts.final_with_discounted_price + "</span>").insertAfter('.crawlapps-cart-original-total');
                }
                if($(".crawlapps-discount-bar").length > 0){
                    $(".crawlapps-discount-bar").html(discounts.cart_discount_msg_html)
                }else {
                    $('form[action="/cart"]').prepend(discounts.cart_discount_msg_html)
                }
            }
            if (discounts.discount_code && discounts.discount_error == 1) {
                $(".crawlapps-cart-original-total").html(discounts.original_price_total);
                $(".crawlapps_discount_hide").after("<span class='crawlapps_summary'>Discount code does not match</span>");
                localStorage.removeItem('discount_code');
            } else if((discounts.discount_code && $('.discount_code_box').is(":visible"))){
                $(".crawlapps_discount_hide").after("<span class='crawlapps-summary-line-discount-code'><span class='discount-tag'>"+ discounts.discount_code +"<span class='close-tag'></span></span><span class='crawlapps_with_discount'>"+" -" + discounts.with_discount + "</span></span><span class='after_discount_price'><span class='final-total'>Total</span>"+discounts.final_with_discounted_price +"</span>");
                if(flag ==1){
                    $(".crawlapps-cart-original-total").html(discounts.discounted_price_total).css("text-decoration", "line-through");
                }else{
                    $(".crawlapps-cart-original-total").html(discounts.original_price_total).css("text-decoration", "line-through");
                }
                $(".crawlapps-cart-total").remove();
            }else{
                $(".crawlapps-cart-original-total").html(discounts.original_price_total);
            }
            window.crawlapps = {};
            window.crawlapps.cart = discounts;
            self.checkoutButtonClick();
        },
        checkoutButtonClick(){
            $(document).on('click', "input[name='checkout'], input[value='Checkout'], button[name='checkout'], [href$='checkout'], button[value='Checkout'], input[name='goto_pp'], button[name='goto_pp'], input[name='goto_gc'], button[name='goto_gc']", function(e){
                e.preventDefault();
                console.log("checkout clicked");
                let formdata = {
                    discount_code : localStorage.getItem('discount_code'),
                    data: window.crawlapps.cart,
                };

                let url = `${apiEndPoint}/${shopifyDomain}/offers/create-draft-order`;
                axios.post(url, formdata)
                    .then(response => {
                        let data = response.data
                        if(typeof data.data.url == "string" ){
                            console.log('IN');
                            window.location = data.data.url;
                        }else{
                            console.log('out');
                        }
                    })
                    .catch(() => {
                    });
            });
        },
        addToCartButtonClick(){
            let base = this;
            $(document).on('click', "input[name='add'], input[value='Add To Cart'], button[name='add'], [href$='add'], button[value='Add To Cart']", function(e){
                /*if(!base.addToCartIsBusy && $('[name="properties[OfferType]"]').val() == ""){
                    e.preventDefault();
                    let qty = $('[name="quantity"]').val();
                    let data = $('.read_offers_data').each(function(index,item){
                        if(item.dataset.buy == qty){
                            if(item.dataset.offer == 'free'){
                                let num = parseInt(item.dataset.buy) + parseInt(item.dataset.get)
                                $('[name="quantity"]').val(num);
                            }
                            $('[name="properties[OfferType]"]').val(item.dataset.code);
                            return true;
                        }
                    });
                    base.addToCartIsBusy = true;
                    $(this).trigger('click');
                }
                base.addToCartIsBusy = false;*/
            });
        },
        addPopup(){
            return` <button id="crawlapps_offer_popup_btn">View Offers</button>
                    <div id="crawlapps_offer_popup" class="crawlapps_offer_modal">

                  <!-- Modal content -->
                  <div class="crawlapps_offer_modal-content">
                    <div class="crawlapps_offer_modal-header">
                      <span class="crawlapps_offer_popup_close">&times;</span>
                      <h2>Offer</h2>
                    </div>
                    <div class="crawlapps_offer_modal-body">
                      <center class="show_display_types"></center>
                    </div>
                    <div class="crawlapps_offer_modal-footer">
                    <!--<div align="right"> <button type="button">Apply</button> </div>-->
                    </div>
                  </div>
                
                </div>
                
                
                <script>
                // Get the modal
                var modal = document.getElementById("crawlapps_offer_popup");
                
                // Get the button that opens the modal
                var btn = document.getElementById("crawlapps_offer_popup_btn");
                
                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("crawlapps_offer_popup_close")[0];
                
                // When the user clicks the button, open the modal 
                btn.onclick = function() {
                  modal.style.display = "block";
                }
                
                // When the user clicks on <span> (x), close the modal
                span.onclick = function() {
                  modal.style.display = "none";
                }
                
                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                  if (event.target == modal) {
                    modal.style.display = "none";
                  }
                }
                </script>
                
                
                <style>
                
                #crawlapps_offer_popup_btn{
                        position: fixed;
                        top: 50%;
                        right: 0px;
                        transform: translateY(-50%) rotate(90deg);
                        transform-origin: right 0;
                }
                
                /* The Modal (background) */
                .crawlapps_offer_modal {
                  display: block; /* Hidden by default */
                  position: fixed; /* Stay in place */
                  z-index: 999999; /* Sit on top */
                  padding-top: 100px; /* Location of the box */
                  left: 0;
                  top: 0;
                  width: 100%; /* Full width */
                  height: 100%; /* Full height */
                  overflow: auto; /* Enable scroll if needed */
                  background-color: rgb(0,0,0); /* Fallback color */
                  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
                }
                
                /* Modal Content */
                .crawlapps_offer_modal-content {
                  position: relative;
                  background-color: #fefefe;
                  margin: auto;
                  padding: 0;
                  border: 1px solid #888;
                  width: 30%;
                  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
                  -webkit-animation-name: animatetop;
                  -webkit-animation-duration: 0.4s;
                  animation-name: animatetop;
                  animation-duration: 0.4s;
                }
                
                /* Add Animation */
                @-webkit-keyframes animatetop {
                  from {top:-300px; opacity:0} 
                  to {top:0; opacity:1}
                }
                
                @keyframes animatetop {
                  from {top:-300px; opacity:0}
                  to {top:0; opacity:1}
                }
                
                /* The Close Button */
                .crawlapps_offer_popup_close {
                  color: white;
                  float: right;
                  font-size: 28px;
                  font-weight: bold;
                }
                
                .crawlapps_offer_popup_close:hover,
                .crawlapps_offer_popup_close:focus {
                  color: #000;
                  text-decoration: none;
                  cursor: pointer;
                }
                
                .crawlapps_offer_modal-header {
                  padding: 2px 16px;
                  background-color: #5cb85c;
                  color: white;
                }
                
                .crawlapps_offer_modal-body {padding: 2px 16px;}
                
                .crawlapps_offer_modal-footer {
                  padding: 2px 16px;
                  background-color: #5cb85c;
                  color: white;
                }
                </style>`;
        },
    },
    created() {
        this.shop_data = JSON.parse(document.getElementById('crawlapps_offer_shop_data').innerHTML);
        this.init();
    }
});
Window.crawlapps = {
    init:function(){
        app.$mount();
    },
    reloadCartPage:function(){
        document.location.reload();
    }
};
var addBodyClass = "";
$(document).ready(function () {
    Window.crawlapps.init();
    var body = document.body;
    console.log("Class Name: crawlapps_body_"+shopifyTheme);
    addBodyClass = "crawlapps_body_"+shopifyTheme;
    body.classList.add(addBodyClass);
});

function convertToSlug(Text)
{
    return Text
        .toLowerCase()
        .replace(/[^\w ]+/g,'')
        .replace(/ +/g,'-')
        ;
}

