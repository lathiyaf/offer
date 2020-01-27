<template>
<div>
    <div class="oa-box">
        <div class="oa-accodian">
            <div class="oa-box-header" @click="toggalAccordian('text-setting')">
                <div class="d-flex align-items-center justify-content-between">
                    <h2 class="text-primary">Text Settings :</h2>
                    <i class="h1 mb-0 text-black-700 ion" v-bind:class="{ 'ion-ios-arrow-down': toggle.text, 'ion-ios-arrow-up': !toggle.text }"></i>
                </div>
            </div>
            <div class="oa-box-body" style="padding-bottom: 0;" v-bind:class="{ 'show': toggle.text, '': !toggle.text }">
                <div class="oa-row">
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Display Headline Text :</p>
                        <input type="text" v-model="text.display_headline_text" placeholder="Enter Headline Text" class="form-control form-control-sm fancy-input">
                    </div>
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Text Before Qty :</p>
                        <input type="text" placeholder="Enter Before Qty Text" class="form-control form-control-sm fancy-input" v-model="text.before_qty">
                    </div>
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Text After Qty :</p>
                        <input type="text" placeholder="Enter After Qty Text" class="form-control form-control-sm fancy-input" v-model="text.after_qty">
                    </div>
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Text For Free :</p>
                        <input type="text" placeholder="Enter For Free Text" class="form-control form-control-sm fancy-input" v-model="type.free.text">
                    </div>
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Text For Percentage :</p>
                        <input type="text" placeholder="Enter For Percentage Text" class="form-control form-control-sm fancy-input" v-model="type.percentage.text">
                    </div>
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Text For Fixed :</p>
                        <input type="text" placeholder="Enter For Fixed Text" class="form-control form-control-sm fancy-input" v-model="type.fixed.text">
                    </div>
                    <div class="w-50 mb-4">
                        <p class="text-black-700 mb-2">Display Type :</p>
                        <input type="radio" id="Horizontal" name="Type" value="inline-block" v-model="style.display_type">
                        <label for="Horizontal" class="mr-2"><span></span>Horizontal</label>
                        <input type="radio" id="Vertical" name="Type" value="list-item" v-model="style.display_type">
                        <label for="Vertical"><span></span>Vertical</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="oa-accodian">
            <div class="oa-box-header" @click="toggalAccordian('style-setting')">
                <div class="d-flex align-items-center justify-content-between">
                    <h2 class="text-primary">Style Settings :</h2>
                    <i class="ion h1 mb-0 text-black-700" v-bind:class="{ 'ion-ios-arrow-down': toggle.style, 'ion-ios-arrow-up': !toggle.style }"></i>
                </div>
            </div>
            <div class="oa-box-body" style="padding-bottom: 0;" v-bind:class="{ 'show': toggle.style, '': !toggle.style }">
                <div class="oa-row">
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Padding Top :</p>
                        <vue-slider v-model="style.padding_area.top"  :min="0" :max="25"/>
                        <div class="d-flex justify-content-end">
                            <span class="px-tag">{{style.padding_area.top || 0 }}px</span>
                        </div>
                    </div>
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Padding Right :</p>
                        <vue-slider v-model="style.padding_area.right"  :min="0" :max="25"/>
                        <div class="d-flex justify-content-end">
                            <span class="px-tag">{{style.padding_area.right || 0 }}px</span>
                        </div>
                    </div>
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Padding Bottom :</p>
                        <vue-slider v-model="style.padding_area.bottom"  :min="0" :max="25"/>
                        <div class="d-flex justify-content-end">
                            <span class="px-tag">{{style.padding_area.bottom || 0 }}px</span>
                        </div>
                    </div>
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Padding Left :</p>
                        <vue-slider v-model="style.padding_area.left"  :min="0" :max="25"/>
                        <div class="d-flex justify-content-end">
                            <span class="px-tag">{{style.padding_area.left || 0 }}px</span>
                        </div>
                    </div>
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Headline Text Font Size :</p>
                        <vue-slider v-model="style.font_size_display_headline_text"  :min="0" :max="25"/>
                        <div class="d-flex justify-content-end">
                            <span class="px-tag">{{style.font_size_display_headline_text || 0 }}px</span>
                        </div>
                    </div>

                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Font Size :</p>
                        <vue-slider v-model="values.style.font_size"  :min="0" :max="25"/>
                        <div class="d-flex justify-content-end">
                            <span class="px-tag">{{style.font_size || 0 }}px</span>
                        </div>
                    </div>
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Border Size :</p>
                        <vue-slider v-model="values.style.border_size"  :min="0" :max="25"/>
                        <div class="d-flex justify-content-end">
                            <span class="px-tag">{{style.border_size || 0 }}px</span>
                        </div>
                    </div>

                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Border Radius :</p>
                        <vue-slider v-model="values.style.border_radius"  :min="0" :max="25"/>
                        <div class="d-flex justify-content-end">
                            <span class="px-tag">{{style.border_radius || 0 }}px</span>
                        </div>
                    </div>

                    <ColorPicker class="text-black-700" label="Headline Text Color:" :color="style.color_display_headline_text"
                                 v-model="style.color_display_headline_text"/>
                    <ColorPicker class="text-black-700" slot="btn_border_color1" label="Text Color:" :color="values.style.text_color" v-model="values.style.text_color" />
                    <ColorPicker class="text-black-700" slot="btn_border_color2" label="Border Color:" :color="values.style.border_color" v-model="values.style.border_color" />
                    <ColorPicker class="text-black-700" slot="btn_border_color2" label="Border Color On Hover:" :color="values.style.border_color_on_hover" v-model="values.style.border_color_on_hover" />
                    <ColorPicker class="text-black-700" slot="btn_border_color3" label="Background Color:" :color="values.style.bg_color" v-model="values.style.bg_color" />
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Font Family :</p>
                        <input type="text" v-model="values.style.font_family" placeholder="Font Family" class="form-control form-control-sm fancy-input">
                    </div>
                </div>
            </div>
        </div>

        <div class="">
            <div class="oa-box-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h2 class="text-primary">Swatch Preview :</h2>
                    <button type="button" align="right" @click="restorDefault" class="btn btn-sm">Restore Defaults</button>
                </div>
            </div>
            <div class="oa-box-body">
                <div class="text-center mb-20">
                    <p class="display_headline_text" :style="'font-size:'+style.font_size_display_headline_text+'px;color:'+style.color_display_headline_text"> {{ text.display_headline_text }}</p>
                    <div class="custom_swatch_css" v-if="text.is_buy_1_enabled">
                        <label for="buy1_radio">
                            <button type="button" :style="'font-family:'+values.style.font_family+
                                                ';font-size:'+values.style.font_size+'px'+
                                                ';border-color:'+values.style.border_color+
                                                ';border-width:'+values.style.border_size+'px'+
                                                ';background-color:'+values.style.bg_color+
                                                ';padding:'+values.style.padding+
                                                ';color:'+values.style.text_color
                                            ">
                                {{ text.selectText }}
                            </button>
                        </label>
                        <input type="radio" name="discount_btn" id="buy1_radio" style="display:none;" />
                    </div>
                    <ul style="list-style: none">
                        <li v-for="item in demoContents" class="crawlapps_css_swatch_li mr-2 mb-2" :style="'display:'+values.style.display_type">
                            <label for="item.type+'_radio'">
                                <button class="width-130px" type="button" :style="'--font-family:'+values.style.font_family+
                                                    ';--font-size:'+values.style.font_size+'px'+
                                                    ';--border-color:'+values.style.border_color+
                                                    ';--border-color-hover:'+values.style.border_color_on_hover+
                                                    ';--border-width:'+values.style.border_size+'px'+
                                                    ';--border-radius:'+values.style.border_radius+'px'+
                                                    ';--background-color:'+values.style.bg_color+
                                                    ';--padding:'+values.style.padding+
                                                    ';--color:'+values.style.text_color"
                                >
                                    {{ text.before_qty + space + item.qty + space +  text.after_qty }}
                                    {{ makePrice(text.before_price, item.get, text.after_price, item.type)  }}
                                    <font v-if="item.type.type == 'free'"> {{ type.free.text }}</font>
                                    <font v-if="item.type.type == 'fixed'"> {{ type.fixed.text }}</font>
                                    <font v-if="item.type.type == 'percentage'"> {{ type.percentage.text }}</font>
                                </button>
                            </label>
                            <input type="radio" name="discount_btn" id="item.type+'_radio'" style="display:none;" />
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>

    import ColorPicker from "./ColorPicker";
    import VueSlider from 'vue-slider-component';
    import 'vue-slider-component/theme/antd.css';
    export default {
        props:['values','demoContents'],
        components:{
            ColorPicker,
            VueSlider,
        },
        data(){
            return{
                style:{},
                text:{},
                type:{},
                button:{},
                space: ' ',
                toggle: {
                    text: true,
                    style: false,
                }
            }
        },
        created() {
            this.init();
        },
        watch: {
            'values.text.selectText_before'(newValue, oldValue){
                this.text.selectText = newValue+' 1 '+this.text.selectText_after;
            },
            'values.text.selectText_after'(newValue, oldValue){
                this.text.selectText = this.text.selectText_before+' 1 '+newValue;
            },
            /*Style Td padding*/
            'values.style.padding_area.top'(newValue, oldValue){
                let padding = this.style.padding_area;
                this.style.padding = newValue+'px '+padding.right+'px '+padding.bottom+'px '+padding.left+'px';
            },
            'values.style.padding_area.right'(newValue, oldValue){
                let padding = this.style.padding_area;
                this.style.padding = padding.top+'px '+newValue+'px '+padding.bottom+'px '+padding.left+'px';
            },
            'values.style.padding_area.bottom'(newValue, oldValue){
                let padding = this.style.padding_area;
                this.style.padding = padding.top+'px '+padding.right+'px '+newValue+'px '+padding.left+'px';
            },
            'values.style.padding_area.left'(newValue, oldValue){
                let padding = this.style.padding_area;
                this.style.padding = padding.top+'px '+padding.right+'px '+padding.bottom+'px '+newValue+'px';
            },
        },
        methods:{
            restorDefault(){
                this.$emit('restorDefault','swatch');
            },
            toggalAccordian(id) {

                if(id == 'text-setting'){
                    this.toggle.text = !this.toggle.text;
                }
                else if(id == 'style-setting'){
                    this.toggle.style = !this.toggle.style;
                }
            },
            init(){
                this.style = this.values.style;
                this.text = this.values.text;
                this.type = this.values.type;
            },

            makePrice(text_before_price, price, text_after_price, type){
                let string = '',  space = this.space;
                if(type.type == 'free'){
                    string =
                        space +
                        text_before_price +
                        space +
                        price +
                        space +
                        text_after_price +
                        space;
                }else if(type.type == 'fixed'){
                    string =
                        space +
                        text_before_price +
                        space +
                        type.symbol +
                        price +
                        space +
                        text_after_price +
                        space;
                }else if(type.type == 'percentage') {
                    string =
                        space +
                        text_before_price +
                        space +
                        price +
                        type.symbol +
                        space +
                        text_after_price +
                        space;
                }
                return string;
            },
        }
    };
</script>
<style>
    .crawlapps_css_swatch_li button {
        font-family: var(--font-family);
        font-size: var(--font-size);
        border-color: var(--border-color);
        border-width: var(--border-width);
        border-radius: var(--border-radius);
        background-color: var(--background-color);
        padding: var(--padding);
        color: var(--color);
        border-style: solid;
    }
    .crawlapps_css_swatch_li button:hover{
        border-color: var(--border-color-hover);
    }
    .crawlapps_css_swatch_li button:focus{
        outline: none;
        border-color: var(--border-color-hover);
    }
</style>
