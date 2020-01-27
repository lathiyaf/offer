<template>
<div>
    <div class="oa-box">
        <div class="oa-accodian">
            <div class="oa-box-header" @click="toggalAccordianMain('text-setting')">
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
                        <p class="text-black-700 mb-1">Grid Header Column 1:</p>
                        <input type="text" v-model="text.headerText1" placeholder="Enter Headline Text" class="form-control form-control-sm fancy-input">
                    </div>
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Grid Header Column 2:</p>
                        <input type="text" v-model="text.headerText2" placeholder="Enter Headline Text" class="form-control form-control-sm fancy-input">
                    </div>
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Grid Header Column 3:</p>
                        <input type="text" v-model="text.headerText3" placeholder="Enter Headline Text" class="form-control form-control-sm fancy-input">
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

                </div>
            </div>
        </div>

        <div class="oa-accodian">
            <div class="oa-box-header" @click="toggalAccordianMain('style-setting')">
                <div class="d-flex align-items-center justify-content-between">
                    <h2 class="text-primary">Style Settings :</h2>
                    <i class="ion h1 mb-0 text-black-700" v-bind:class="{ 'ion-ios-arrow-down': toggle.style, 'ion-ios-arrow-up': !toggle.style }"></i>
                </div>
            </div>
            <div class="oa-box-body" style="padding-bottom: 0;" v-bind:class="{ 'show': toggle.style, '': !toggle.style }">
                <div class="oa-row">
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Padding Top :</p>
                        <vue-slider v-model="style.td_padding_area.top"  :min="0" :max="25"/>
                        <div class="d-flex justify-content-end">
                            <span class="px-tag">{{style.td_padding_area.top || 0 }}px</span>
                        </div>
                    </div>
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Padding Right :</p>
                        <vue-slider v-model="style.td_padding_area.right"  :min="0" :max="25"/>
                        <div class="d-flex justify-content-end">
                            <span class="px-tag">{{style.td_padding_area.right || 0 }}px</span>
                        </div>
                    </div>
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Padding Bottom :</p>
                        <vue-slider v-model="style.td_padding_area.bottom"  :min="0" :max="25"/>
                        <div class="d-flex justify-content-end">
                            <span class="px-tag">{{style.td_padding_area.bottom || 0 }}px</span>
                        </div>
                    </div>
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Padding Left :</p>
                        <vue-slider v-model="style.td_padding_area.left"  :min="0" :max="25"/>
                        <div class="d-flex justify-content-end">
                            <span class="px-tag">{{style.td_padding_area.left || 0 }}px</span>
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
                        <vue-slider v-model="style.font_size"  :min="0" :max="25"/>
                        <div class="d-flex justify-content-end">
                            <span class="px-tag">{{style.font_size || 0 }}px</span>
                        </div>
                    </div>
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Border Size :</p>
                        <vue-slider v-model="style.border_size" :min="0" :max="25"/>
                        <div class="d-flex justify-content-end">
                            <span class="px-tag">{{style.border_size || 0 }}px</span>
                        </div>
                    </div>

                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Border Radius :</p>
                        <vue-slider v-model="style.border_radius"  :min="0" :max="25"/>
                        <div class="d-flex justify-content-end">
                            <span class="px-tag">{{style.border_radius || 0 }}px</span>
                        </div>
                    </div>

                    <ColorPicker class="wd-3 text-black-700" label="Headline Text Color:" :color="style.color_display_headline_text" v-model="style.color_display_headline_text" />

                    <ColorPicker class="wd-3 text-black-700" slot="border_color" label="Border Color:" :color="values.style.border_color" v-model="values.style.border_color" />

                    <ColorPicker class="wd-3 text-black-700" slot="header_color" label="Header Text Color:" :color="values.style.header_color" v-model="values.style.header_color" />
                    <ColorPicker class="wd-3 text-black-700" slot="header_bg_color" label="Header Background:" :color="values.style.header_bg_color" v-model="values.style.header_bg_color" />
                    <ColorPicker class="wd-3 text-black-700" slot="text_color" label="Text Color:" :color="values.style.text_color" v-model="values.style.text_color" />
                    <ColorPicker class="wd-3 text-black-700" slot="body_bg_color" label="Background Color:" :color="values.style.body_bg_color" v-model="values.style.body_bg_color" />

                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Font Family :</p>
                        <input type="text" v-model="style.font_family" placeholder="Font Family" class="form-control form-control-sm fancy-input">
                    </div>
                </div>
            </div>
        </div>

        <div class="oa-accodian">
            <div class="oa-box-header" @click="toggalAccordianMain('button-setting')">
                <div class="d-flex align-items-center justify-content-between">
                    <h2 class="text-primary">Button Settings :</h2>
                    <i class="ion h1 mb-0 text-black-700" v-bind:class="{ 'ion-ios-arrow-down': toggle.button, 'ion-ios-arrow-up': !toggle.button }"></i>
                </div>
            </div>
            <div class="oa-box-body" style="padding-bottom: 0;" v-bind:class="{ 'show': toggle.button, '': !toggle.button }">
                <div class="oa-row">
                    <div class="oa-row" v-if="button.is_add_btn_enabled">
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Padding Top :</p>
                        <vue-slider v-model="button.padding_area.top"  :min="0" :max="25"/>
                        <div class="d-flex justify-content-end">
                            <span class="px-tag">{{button.padding_area.top || 0 }}px</span>
                        </div>
                    </div>
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Padding Right :</p>
                        <vue-slider v-model="button.padding_area.right"  :min="0" :max="25"/>
                        <div class="d-flex justify-content-end">
                            <span class="px-tag">{{button.padding_area.right || 0 }}px</span>
                        </div>
                    </div>
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Padding Bottom :</p>
                        <vue-slider v-model="button.padding_area.bottom"  :min="0" :max="25"/>
                        <div class="d-flex justify-content-end">
                            <span class="px-tag">{{button.padding_area.bottom || 0 }}px</span>
                        </div>
                    </div>
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Padding Left :</p>
                        <vue-slider v-model="button.padding_area.left"  :min="0" :max="25"/>
                        <div class="d-flex justify-content-end">
                            <span class="px-tag">{{button.padding_area.left || 0 }}px</span>
                        </div>
                    </div>
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Font Size :</p>
                        <vue-slider v-model="button.font_size"  :min="0" :max="25"/>
                        <div class="d-flex justify-content-end">
                            <span class="px-tag">{{button.font_size || 0 }}px</span>
                        </div>
                    </div>
                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Border Size :</p>
                        <vue-slider v-model="button.border_size"  :min="0" :max="25"/>
                        <div class="d-flex justify-content-end">
                            <span class="px-tag">{{button.border_size || 0 }}px</span>
                        </div>
                    </div>

                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Border Radius :</p>
                        <vue-slider v-model="button.border_radius"  :min="0" :max="25"/>
                        <div class="d-flex justify-content-end">
                            <span class="px-tag">{{button.border_radius || 0 }}px</span>
                        </div>
                    </div>

                    <ColorPicker class="wd-3 text-black-700" slot="btn_text_color" label="Text Color:" :color="values.button.text_color" v-model="values.button.text_color" />
                    <ColorPicker class="wd-3 text-black-700" slot="btn_border_color" label="Border Color:" :color="values.button.border_color" v-model="values.button.border_color" />
                    <ColorPicker class="wd-3 text-black-700" slot="btn_bg_color" label="Background Color:" :color="values.button.bg_color" v-model="values.button.bg_color" />
                    <ColorPicker class="text-black-700" slot="btn_border_color2" label="Border Color On Hover:" :color="values.style.border_color_on_hover" v-model="values.button.border_color_on_hover" />


                    <div class="w-25 mb-4">
                        <p class="text-black-700 mb-1">Font Family :</p>
                        <input type="text" v-model="button.font_family" placeholder="Font Family" class="form-control form-control-sm fancy-input">
                    </div>
                    </div>
                    <div class="from-group-item mb-2">
                        <label class="text-black-700">Button Text:</label>
                        <div class="from-input-group">
                            <input class="form-contorl" placeholder="Button Text" type="text" v-model="button.text">
                            <div class="input-group-addon">
                                <label class="switch">
                                    <input type="checkbox" v-model="button.is_add_btn_enabled">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="">
            <div class="oa-box-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h2 class="text-primary">GridView Preview :</h2>
                    <button type="button" align="right" @click="restorDefault" class="btn btn-sm">Restore Defaults</button>
                </div>
            </div>
            <div class="oa-box-body">
                <div class="text-center mb-20 preview_box">
                    <p class="display_headline_text" :style="'font-size:'+style.font_size_display_headline_text+'px;color:'+style.color_display_headline_text"> {{ text.display_headline_text }}</p>
                    <table class="crawlapps_css_gridview"
                           :style="'--font-family:'+values.style.font_family+
                            ';--font-size:'+values.style.font_size+'px'+
                             ';--border-radius:'+style.border_radius+'px'+
                            ';--margin-top:'+style.border_size+'px'
                            "
                    >
                        <thead :style="
                                        '--head-background-color:'+values.style.header_bg_color+
                                        ';--head-color:'+values.style.header_color

                                ">
                        <tr>
                            <td :style="
                                    '--padding:'+values.style.td_padding+
                                    ';--thtd-border:'+style.border_size+'px solid '+values.style.border_color+
                                    ';--thtdhalf-border:'+td_border_size_half+'px solid '+values.style.border_color+
                                    ';--border-radius:'+style.border_radius+'px'
                                ">{{text.headerText1}}</td>
                            <td :style="
                                    '--padding:'+values.style.td_padding+
                                    ';--thtd-border:'+style.border_size+'px solid '+values.style.border_color+
                                    ';--thtdhalf-border:'+td_border_size_half+'px solid '+values.style.border_color+
                                    ';--border-radius:'+style.border_radius+'px'
                                ">{{text.headerText2}}</td>
                            <td v-if="button.is_add_btn_enabled" :style="
                                    '--padding:'+values.style.td_padding+
                                    ';--thtd-border:'+style.border_size+'px solid '+values.style.border_color+
                                    ';--thtdhalf-border:'+td_border_size_half+'px solid '+values.style.border_color+
                                    ';--border-radius:'+style.border_radius+'px'
                                ">{{text.headerText3}}</td>
                        </tr>
                        </thead>
                        <tbody :style="
                                    '--tbody-background-color:'+values.style.body_bg_color+
                                    ';--tbody-color:'+values.style.text_color
                                ">
                        <tr  v-for="item in demoContents">
                            <td :style="
                                    '--padding:'+values.style.td_padding+
                                    ';--thtd-border:'+style.border_size+'px solid '+values.style.border_color+
                                    ';--thtdhalf-border:'+td_border_size_half+'px solid '+values.style.border_color+
                                    ';--border-radius:'+style.border_radius+'px'
                                ">{{ text.before_qty + space + item.qty +  space }}</td>
                            <td :style="
                                    '--padding:'+values.style.td_padding+
                                     ';--thtd-border:'+style.border_size+'px solid '+values.style.border_color+
                                     ';--thtdhalf-border:'+td_border_size_half+'px solid '+values.style.border_color+
                                     ';--border-radius:'+style.border_radius+'px'
                                ">
                                {{ makePrice(text.after_qty, item.get, '', item.type)  }}
                                <font v-if="item.type.type == 'free'"> {{ type.free.text }}</font>
                                <font v-if="item.type.type == 'fixed'"> {{ type.fixed.text }}</font>
                                <font v-if="item.type.type == 'percentage'"> {{ type.percentage.text }}</font>
                            </td>
                            <td v-if="button.is_add_btn_enabled" :style="
                                    '--padding:'+values.style.td_padding+
                                     ';--thtd-border:'+style.border_size+'px solid '+values.style.border_color+
                                     ';--thtdhalf-border:'+td_border_size_half+'px solid '+values.style.border_color+
                                     ';--border-radius:'+style.border_radius+'px'
                                ">
                                <button class="tbl_gd_btn" type="button"
                                        :style="'--btn-font-family:'+values.button.font_family+
                                                ';--btn-font-size:'+values.button.font_size+'px'+
                                                ';--btn-border-color:'+values.button.border_color+
                                                ';--btn-border-color-hover:'+button.border_color_on_hover+
                                                ';--btn-border-width:'+values.button.border_size+'px'+
                                                ';--btn-border-radius:'+values.button.border_radius+'px'+
                                                ';--btn-background-color:'+values.button.bg_color+
                                                ';--btn-padding:'+values.button.padding+
                                                ';--btn-color:'+values.button.text_color
                                            "
                                >{{button.text}}</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
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
                button:{},
                type:{},
                style_final_string:'',
                watchInitFlag:0,
                space: ' ',
                icon:{
                    style:false,
                    button:false,
                },
                toggle: {
                    text: true,
                    style: false,
                    button: false,
                },
                td_border_size_half:0,
            }
        },
        mounted() {
            this.init();
        },
        watch: {
            /*Button padding*/
            'values.button.padding_area.top'(newValue, oldValue){
                let padding = this.button.padding_area;
                this.button.padding = newValue+'px '+padding.right+'px '+padding.bottom+'px '+padding.left+'px';
            },
            'values.button.padding_area.right'(newValue, oldValue){
                let padding = this.button.padding_area;
                this.button.padding = padding.top+'px '+newValue+'px '+padding.bottom+'px '+padding.left+'px';
            },
            'values.button.padding_area.bottom'(newValue, oldValue){
                let padding = this.button.padding_area;
                this.button.padding = padding.top+'px '+padding.right+'px '+newValue+'px '+padding.left+'px';
            },
            'values.button.padding_area.left'(newValue, oldValue){
                let padding = this.button.padding_area;
                this.button.padding = padding.top+'px '+padding.right+'px '+padding.bottom+'px '+newValue+'px';
            },

            /*Style th padding*/
            'values.style.th_padding_area.top'(newValue, oldValue){
                let padding = this.style.th_padding_area;
                this.style.th_padding = newValue+'px '+padding.right+'px '+padding.bottom+'px '+padding.left+'px';
            },
            'values.style.th_padding_area.right'(newValue, oldValue){
                let padding = this.style.th_padding_area;
                this.style.th_padding = padding.top+'px '+newValue+'px '+padding.bottom+'px '+padding.left+'px';
            },
            'values.style.th_padding_area.bottom'(newValue, oldValue){
                let padding = this.style.th_padding_area;
                this.style.th_padding = padding.top+'px '+padding.right+'px '+newValue+'px '+padding.left+'px';
            },
            'values.style.th_padding_area.left'(newValue, oldValue){
                let padding = this.style.th_padding_area;
                this.style.th_padding = padding.top+'px '+padding.right+'px '+padding.bottom+'px '+newValue+'px';
            },

            /*Style Td padding*/
            'values.style.td_padding_area.top'(newValue, oldValue){
                let padding = this.style.td_padding_area;
                this.style.td_padding = newValue+'px '+padding.right+'px '+padding.bottom+'px '+padding.left+'px';
            },
            'values.style.td_padding_area.right'(newValue, oldValue){
                let padding = this.style.td_padding_area;
                this.style.td_padding = padding.top+'px '+newValue+'px '+padding.bottom+'px '+padding.left+'px';
            },
            'values.style.td_padding_area.bottom'(newValue, oldValue){
                let padding = this.style.td_padding_area;
                this.style.td_padding = padding.top+'px '+padding.right+'px '+newValue+'px '+padding.left+'px';
            },
            'values.style.td_padding_area.left'(newValue, oldValue){
                let padding = this.style.td_padding_area;
                this.style.td_padding = padding.top+'px '+padding.right+'px '+padding.bottom+'px '+newValue+'px';
            },
        },
        methods:{
            restorDefault(){
                this.$emit('restorDefault','gridview');
            },
            toggalAccordianMain(id){

                if(id == 'text-setting'){
                    this.toggle.text = !this.toggle.text;
                }
                else if(id == 'style-setting'){
                    this.toggle.style = !this.toggle.style;
                }else if(id == 'button-setting'){
                    this.toggle.button = !this.toggle.button;
                }
            },
            toggalAccordian(id){
                if(id == 'accoridan-style'){
                    this.icon.style = !this.icon.style;
                }else if(id == 'accoridan-button'){
                    this.icon.button = !this.icon.button;
                }
            },
            makePrice(text_before_price, price, text_after_price, type){
                let string = '', space = this.space;
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
                }else if(type.type == 'percentage'){
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
            async init(){
                this.style = this.values.style;
                this.text = this.values.text;
                this.button = this.values.button;
                this.type = this.values.type;
            },
        }
    };
</script>
<style>
    .crawlapps_css_gridview{
        width: auto;
        overflow: hidden !important;
        border-spacing: 0px;
        font-family: var(--font-family) !important;
        font-size: var(--font-size) !important;
        margin-top: var(--margin-top) !important;
        border-radius: var(--border-radius) !important;
    }
    .crawlapps_css_gridview th,
    .crawlapps_css_gridview td{
        padding: var(--padding) !important;
        border: var(--thtd-border) !important;
    }
    .crawlapps_css_gridview thead{
        overflow: hidden;
        background-color: var(--head-background-color) !important;
        color: var(--head-color) !important;
    }
    .crawlapps_css_gridview tbody{
        overflow: hidden;
        background-color: var(--tbody-background-color) !important;
        color:  var(--tbody-color) !important;
        border: var(--border-val) !important;
    }


    .crawlapps_css_gridview thead td:first-of-type{
        border-top-left-radius: var(--border-radius) !important;
    }

    .crawlapps_css_gridview thead td:last-of-type{
        border-top-right-radius: var(--border-radius) !important;
    }
    .crawlapps_css_gridview tbody tr:last-child td:first-of-type{
        border-bottom-left-radius: var(--border-radius) !important;
    }
    .crawlapps_css_gridview tbody tr:last-child td:last-of-type {
        border-bottom-right-radius: var(--border-radius) !important;
    }

    .crawlapps_css_gridview tbody tr td:not(:last-of-type){
        border-right: var(--thtdhalf-border) !important;
    }

    .crawlapps_css_gridview thead tr td:not(:last-of-type){
        border-right: var(--thtdhalf-border) !important;
    }

    .crawlapps_css_gridview tr:not(:last-of-type) td{
        border-bottom: var(--thtdhalf-border) !important;
    }

    .crawlapps_css_gridview thead tr td{
        border-bottom: var(--thtdhalf-border) !important;
    }


    /* button css */
    .crawlapps_css_gridview tbody td .tbl_gd_btn:hover{
        border-color: var(--btn-border-color-hover) !important;
    }
    .crawlapps_css_gridview tbody td .tbl_gd_btn:focus{
        outline: none !important;
        border-color: var(--btn-border-color-hover) !important;
    }
    .crawlapps_css_gridview tbody td .tbl_gd_btn{
        font-family: var(--btn-font-family) !important;
        font-size: var(--btn-font-size) !important;
        border-color: var(--btn-border-color) !important;
        border-width: var(--btn-border-width) !important;
        background-color: var(--btn-background-color) !important;
        padding: var(--btn-padding) !important;
        color: var(--btn-color) !important;
        border-radius: var(--btn-border-radius) !important;
        border-style: solid !important;
    }


</style>
