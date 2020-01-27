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
                            <vue-slider v-model="style.font_size"  :min="0" :max="25"/>
                            <div class="d-flex justify-content-end">
                                <span class="px-tag">{{style.font_size || 0 }}px</span>
                            </div>
                        </div>
                        <div class="w-25 mb-4">
                            <p class="text-black-700 mb-1">Border Size :</p>
                            <vue-slider v-model="style.border_size"  :min="0" :max="25"/>
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

                        <ColorPicker class="text-black-700" label="Headline Text Color:" :color="style.color_display_headline_text"
                                     v-model="style.color_display_headline_text"/>
                        <ColorPicker class="text-black-700" label="Border Color:" :color="style.border_color" v-model="style.border_color"/>
                        <ColorPicker class="text-black-700" label="Background Color:" :color="style.bg_color" v-model="style.bg_color"/>
                        <ColorPicker class="text-black-700" label="Text Color:" :color="style.text_color" v-model="style.text_color"/>
                        <div class="w-25 mb-4">
                            <p class="text-black-700 mb-1">Font Family :</p>
                            <input type="text" v-model="style.font_family" placeholder="Font Family" class="form-control form-control-sm fancy-input">
                        </div>
                    </div>
                </div>
            </div>

            <div class="">
                <div class="oa-box-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h2 class="text-primary">Dropdown Preview :</h2>
                        <button type="button" align="right" @click="restorDefault" class="btn btn-sm">Restore Defaults</button>
                    </div>
                </div>
                <div class="oa-box-body">
                    <div class="text-center mb-20">
                        <p class="text-black-700 mb-1 display_headline_text"
                           :style="'font-size:'+style.font_size_display_headline_text+'px;color:'+style.color_display_headline_text"
                        > {{ text.display_headline_text }}</p>
                        <select class="form-control-preview" :style="'width:auto;'+values.style_final_string">
                            <option value="" v-if="text.is_buy_1_enabled" selected>{{text.selectText}}</option>
                            <option v-for="item in demoContents" :value="item.id">
                                {{ renderOption(item) }}
                            </option>
                        </select>
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
        props: ['values', 'demoContents'],
        components: {
            ColorPicker,
            VueSlider
        },
        data() {
            return {
                style: {},
                text: {},
                type: {},
                style_final_string: '',
                toggle: {
                    text: true,
                    style: false,
                }
            }
        },
        watch: {
            /*Style Td padding*/
            'values.style.padding_area.top'(newValue, oldValue) {
                let padding = this.style.padding_area;
                this.style.padding = newValue + 'px ' + padding.right + 'px ' + padding.bottom + 'px ' + padding.left + 'px';
            },
            'values.style.padding_area.right'(newValue, oldValue) {
                let padding = this.style.padding_area;
                this.style.padding = padding.top + 'px calc(20px + '+newValue+'px)' + padding.bottom + 'px ' + padding.left + 'px';
            },
            'values.style.padding_area.bottom'(newValue, oldValue) {
                let padding = this.style.padding_area;
                this.style.padding = padding.top + 'px ' + padding.right + 'px ' + newValue + 'px ' + padding.left + 'px';
            },
            'values.style.padding_area.left'(newValue, oldValue) {
                let padding = this.style.padding_area;
                this.style.padding = padding.top + 'px ' + padding.right + 'px ' + padding.bottom + 'px ' + newValue + 'px';
            },

            'values.text.selectText_before'(newValue, oldValue) {
                this.text.selectText = newValue + ' 1 ' + this.text.selectText_after;
            },
            'values.text.selectText_after'(newValue, oldValue) {
                this.text.selectText = this.text.selectText_before + ' 1 ' + newValue;
            },
            style: {
                handler(val) {
                    let array = [];
                    array.push('font-family:' + val.font_family);
                    array.push('font-size:' + val.font_size + 'px');
                    array.push('border-width:' + val.border_size + 'px');
                    array.push('border-radius:' + val.border_radius + 'px');
                    array.push('color:' + val.text_color);
                    array.push('background-color:' + val.bg_color);
                    array.push('border-color:' + val.border_color);
                    array.push('padding:' + val.padding);

                    let separator = ';';
                    this.values.style_final_string = array.join(separator);
                },
                deep: true,
            },
        },
        created() {
            this.init();
        },
        methods: {
            restorDefault(){
              this.$emit('restorDefault','dropdown');
            },
            toggalAccordian(id){

                if(id == 'text-setting'){
                    this.toggle.text = !this.toggle.text;
                }
                else if(id == 'style-setting'){
                    this.toggle.style = !this.toggle.style;
                }
            },
            renderOption(object) {
                let space = ' ';
                let string = '';
                let type = this.type;
                let text = this.text;
                if (object.type.type == 'free') {
                    string =
                        text.before_qty +
                        space +
                        object.qty +
                        space +
                        text.after_qty +
                        space +
                        text.before_price +
                        space +
                        object.get +
                        space +
                        text.after_price +
                        space +
                        type.free.text;
                } else if (object.type.type == 'fixed') {
                    string =
                        text.before_qty +
                        space +
                        object.qty +
                        space +
                        text.after_qty +
                        space +
                        text.before_price +
                        space +
                        type.fixed.symbol +
                        object.get +
                        space +
                        text.after_price +
                        space +
                        type.fixed.text;
                } else if (object.type.type == 'percentage') {
                    string =
                        text.before_qty +
                        space +
                        object.qty +
                        space +
                        text.after_qty +
                        space +
                        text.before_price +
                        space +
                        object.get +
                        type.percentage.symbol +
                        space +
                        text.after_price +
                        space +
                        type.percentage.text;
                }
                return string;
            },
            init() {
                this.style = this.values.style;
                this.text = this.values.text;
                this.type = this.values.type;
            },
        }
    };
</script>
<style>
    select.form-control-preview:focus{
        outline: none;
    }
</style>
