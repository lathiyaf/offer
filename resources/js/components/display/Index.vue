<template>
    <div class="oa-main">

        <div class="d-flex align-items-start justify-content-between mb-4">
            <div class="mr-6">
                <h1 class="mb-0">Display Settings</h1>
            </div>
            <a href="#" class="btn" @click.prevent="sendForm()">Save</a>
        </div>
        <div class="oa-display mb-20">
            <div class="oa-tab">
                <ul class="list-unstyled d-flex align-items-center justify-content-center oa-tab-list mb-20">
                    <li><a href="#accoridan-dropdown" v-bind:class="{ 'active': icon.dropdown, '': !icon.dropdown }" @click="toggalAccordian('accoridan-dropdown')" class="text-black-700">Dropdown View</a></li>
                    <li><a href="#accoridan-swatch" v-bind:class="{ 'active': icon.swatch, '': !icon.swatch }" @click="toggalAccordian('accoridan-swatch')" class="text-black-700">Swatch View</a></li>
                    <li><a href="#accoridan-gridview" v-bind:class="{ 'active': icon.gridview, '': !icon.gridview }" @click="toggalAccordian('accoridan-gridview')" class="text-black-700">Grid View</a></li>
                </ul>
                <div id="accoridan-dropdown" class="oa-tab-content" v-bind:class="{ 'show': icon.dropdown, '': !icon.dropdown }">
                    <DropDown v-if="showcomponents" :values="form.dropdown"
                              :demoContents="demo_contents" @restorDefault="restorDefault"></DropDown>
                </div>

                <div id="accoridan-swatch" class="oa-tab-content" v-bind:class="{ 'show': icon.swatch, '': !icon.swatch }">
                    <Swatch v-if="showcomponents" :values="form.swatch" :demoContents="demo_contents" @restorDefault="restorDefault"></Swatch>
                </div>

                <div id="accoridan-gridview" class="oa-tab-content" v-bind:class="{ 'show': icon.gridview, '': !icon.gridview }">
                    <GridView v-if="showcomponents" :values="form.gridview"
                              :demoContents="demo_contents" @restorDefault="restorDefault"></GridView>
                </div>
            </div>
        </div>
        <div class="oa-display-css mb-20">
            <div class="oa-box">
                <div class="oa-box-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h2 class="text-primary">Advanced Customization :</h2>
                    </div>
                </div>
                <div class="oa-box-body">
                    <div class="mb-4">
                        <p class="font-size-lg mb-1 text-black-700">Custom JS :</p>
                        <textarea class="form-control" v-model="form.gs.advanced_js" placeholder="Enter Custom JS" rows="5"></textarea>
                        <p class="text-gray-700">&lt;script&gt; tags are NOT required.</p>
                    </div>
                    <div class="mb-2">
                        <p class="font-size-lg mb-1 text-black-700">Custom CSS :</p>
                        <textarea class="form-control" v-model="form.gs.advanced_css" placeholder="Enter Custom CSS" rows="5"></textarea>
                        <p class="text-gray-700">&lt;style&gt; tags are NOT required.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between">
            <a href="#" class="btn btn-light" @click.prevent="redirect">Back</a>
            <a href="#" class="btn" @click.prevent="sendForm()">Save</a>
        </div>

        <div class="oa-footer">
            <div class="text-center">
                <p class="text-gray-700 mb-20">You can read more about setting up rulesets in our knowledge base, otherwise you can reach out to our support team directly here.</p>
                <need-help></need-help>
            </div>
        </div>
    </div>
</template>

<script>
    import DropDown from "./DropDown";
    import GridView from "./GridView";
    import Swatch from "./Swatch";
    import NeedHelp from "../NeedHelp";

    export default {
        components: {
            DropDown,
            GridView,
            Swatch,
            NeedHelp,
        },
        data() {
            return {
                showcomponents: false,
                processing: false,
                demo_contents: [
                    {id: 1, qty: 'X', get: 'Y', type: {type:'percentage', text:'Off', symbol:'%'}},
                    {id: 2, qty: 'X', get: 'Y', type: {type:'fixed', text:'Off', symbol:'$'}},
                    {id: 3, qty: 'X', get: 'Y', type: {type:'free', text:'free',symbol:''}},
                ],
                form: {},
                icon: {
                    dropdown: true,
                    swatch: false,
                    gridview: false,
                }
            }
        },
        created() {
            this.initForm();
            this.getData();
        },
        watch: {
            form: {
                handler(value) {

                },
                deep: true,
            }
        },
        methods: {
            initForm() {
              this.form = {
                  gs: {
                      advanced_js: '',
                      advanced_css: '',
                      display_customize_text: '',
                  },
                  dropdown: {
                      type: {
                          percentage: {text:'Off',symbol:'%'},
                          fixed: {text:'Off',symbol:'$'},
                          free: {text:'Free',symbol:''},
                      },
                      text: {
                          display_headline_text: 'Buy More & Save More',
                          selectText_before: 'Buy',
                          selectText_after: '',
                          selectText: 'Buy 1',
                          before_qty: 'Buy',
                          after_qty: 'Get',
                          before_price: '',
                          after_price: '',
                          is_buy_1_enabled:false,
                      },
                      style: {
                          padding_area: { top:10, right:10,bottom:10, left:10 },
                          padding: '10px 10px 10px 10px',
                          font_size_display_headline_text: 15,
                          color_display_headline_text: '#000000',
                          font_family: '',
                          font_size: 15,
                          border_size: 1,
                          border_radius: '5',
                          text_color: '',
                          bg_color: '#00000000',
                          border_color: '',
                      },
                      style_final_string: '',
                  },
                  gridview: {
                      type: {
                          percentage: {text:'Off',symbol:'%'},
                          fixed: {text:'Off',symbol:'$'},
                          free: {text:'Free',symbol:''},
                      },
                      text: {
                          display_headline_text: 'Buy More & Save More',
                          headerText1: 'Quantity',
                          headerText2: 'Discount',
                          headerText3: 'Action',
                          before_qty: 'Buy',
                          after_qty: 'Get',
                          before_price: '',
                          after_price: '',
                      },
                      style: {
                          font_size_display_headline_text: 15,
                          color_display_headline_text: '#000000',
                          td_padding_area: { top:10, right:10,bottom:10, left:10 },
                          td_padding: '10px 10px 10px 10px',
                          th_padding_area: { top:10, right:10,bottom:10, left:10 },
                          th_padding: '10px 10px 10px 10px',
                          font_family: '',
                          font_size: 15,
                          border_size: 1,
                          text_color: '',
                          border_color: '',
                          body_bg_color: "#00000000",
                          header_bg_color: "#00000000",
                          header_color: '',
                          border_radius:'5',
                      },
                      button: {
                          padding_area: { top:10, right:10,bottom:10, left:10 },
                          padding:'10px 10px 10px 10px',
                          text: 'Add',
                          is_add_btn_enabled:false,
                          font_family: '',
                          font_size: 15,
                          border_size: 1,
                          border_radius:'5',
                          text_color: '',
                          border_color: '#00000042',
                          bg_color: '#DDDDDD',
                          border_color_on_hover: '',
                      },
                      style_final_string: '',
                  },
                  swatch: {
                      type: {
                          percentage: {text:' Off',symbol:'%'},
                          fixed: {text:' Off',symbol:'$'},
                          free: {text:' Free',symbol:''},
                      },
                      text: {
                          selectText_before: 'Buy',
                          selectText_after: '',
                          selectText: 'Buy 1',
                          display_headline_text: 'Buy More & Save More',
                          before_qty: 'Buy',
                          after_qty: 'Get',
                          before_price: '',
                          after_price: '',
                          is_buy_1_enabled:false,
                          display_type_option:{ 'inline-block':'Horizontal','list-item':'Vertical'},
                      },
                      style: {
                          font_size_display_headline_text: 15,
                          color_display_headline_text: '#000000',
                          padding_area: { top:10, right:10,bottom:10, left:10 },
                          padding: '10px 10px 10px 10px',
                          font_family: '',
                          font_size: 15,
                          border_size: 1,
                          border_radius: '5',
                          text_color: '',
                          border_color: '#00000042',
                          border_color_on_hover: '',
                          bg_color: "#00000000",
                          display_type: 'inline-block',
                      },
                      style_final_string: '',
                  },
              } ;
            },
            restorDefault(type) {
                let that = this;
                 window.ShopifyApp.Modal.confirm("Are you sure you want to restore?", async function (result) {
                    if (result) {

                        that.initForm();

                        window.ShopifyApp.Bar.loadingOn();
                        await axios({
                            method: 'POST',
                            url: '/settings/restore',
                            data: {type:type},
                        }).then(response => {
                            window.ShopifyApp.flashNotice("Successfully restored.");
                            window.location.reload();
                        }).catch(error => {
                            window.ShopifyApp.flashError(error);
                        }).finally(function () {
                            that.processing = false;
                            window.ShopifyApp.Bar.loadingOff();
                        });
                    }
                });

            },
            redirect() {
                window.location.href = '/';
            },
            toggalAccordian(id){
                //this.init();
                if(id == 'accoridan-dropdown'){
                    this.icon= {
                        dropdown: true,
                        swatch: false,
                        gridview: false,
                    }
                }
                if(id == 'accoridan-gridview'){
                    this.icon= {
                        dropdown: false,
                        swatch: false,
                        gridview: true,
                    }
                }
                if(id == 'accoridan-swatch'){
                    this.icon= {
                        dropdown: false,
                        swatch: true,
                        gridview: false,
                    }
                }
            },
            sendForm(showToast = 1) {
                if (this.processing == false) {
                    let that = this;
                    let data = that.form;
                    window.ShopifyApp.Bar.loadingOn();
                    return new Promise((resolve, reject) => {
                        axios({
                            method: 'POST',
                            url: '/settings/store',
                            data: that.form,
                        }).then(response => {
                            if (showToast)
                                window.ShopifyApp.flashNotice("Successfully Saved.");
                        }).catch(error => {
                            let errors = error.response.data;
                            let pushError = '';
                            for (let error in errors) {
                                pushError = pushError + errors[error]
                            }
                            window.ShopifyApp.flashError(pushError);
                        }).finally(function () {
                            that.processing = false;
                            window.ShopifyApp.Bar.loadingOff();
                        });
                    });
                }
            },
            async getData() {
                window.ShopifyApp.Bar.loadingOn();
                let that = this;
                await axios({
                    method: 'get',
                    url: '/settings?api=1',
                }).then(response => {

                    if(response.data.displaySettings != false){
                        if (response.data.displaySettings.dropdown.updated_at == 1 ) {
                            that.form.dropdown = response.data.displaySettings.dropdown;
                        }

                        if (response.data.displaySettings.gridview.updated_at == 1) {
                            that.form.gridview = response.data.displaySettings.gridview;
                        }

                        if (response.data.displaySettings.swatch.updated_at == 1) {
                            that.form.swatch = response.data.displaySettings.swatch;
                        }
                    }

                    if (response.data.gsd) {
                        that.form.gs = response.data.gsd;
                    } else {
                        that.form.gs = {
                            advanced_js: '',
                            advanced_css: '',
                            display_customize_text: '',
                        };
                        that.sendForm(0);
                    }

                    that.showcomponents = true;
                }).catch(error => {
                }).finally(function () {
                    window.ShopifyApp.Bar.loadingOff();
                });

            }
        }
    };
</script>

