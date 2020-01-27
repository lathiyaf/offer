<template>
            <div class="">
                <div class="head mb-5">
                    <h3 class="font-weight-bold">Your preferred theme</h3>
                </div>
                <div class="Auto-Install-select">
                    <select class="form-control errorr common" v-model="form.theme">
                        <option v-for="item in themeOption" :value="item.value">{{item.label}}</option>
                    </select>
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" style="margin: -7px 0;">
                            <g id="Icon" transform="translate(2.369 2.369)">
                                <path id="Mask-2" data-name="Mask" d="M7,14a7,7,0,1,1,7-7A7.008,7.008,0,0,1,7,14ZM7,1.4A5.6,5.6,0,1,0,12.6,7,5.606,5.606,0,0,0,7,1.4Zm.7,9.1H7a.7.7,0,0,1-.7-.7V7.7a.7.7,0,1,1,0-1.4H7a.7.7,0,0,1,.7.7V9.1a.7.7,0,0,1,0,1.4ZM7,4.969a.77.77,0,1,1,.77-.77A.771.771,0,0,1,7,4.969Z" transform="translate(0 0)" fill="#919eab"></path>
                            </g>
                        </svg>Please create a backup of the theme you are selecting before the installation starts
                    </p>
                </div>
                <div class="first-step-btn my-4">
                    <button class="btn btn-block btn-layout-learn" type="button" @click.prevent="sendForm" id="auto-install-btn">Install</button>
                </div>
            </div>
</template>


<script>


    export default {
        props: ['propsTrans', 'propsUrl', 'propsData'],
        components: {
        },
        data() {
            return {
                varPropsData: JSON.parse(this.propsData),
                varPropsUrl: JSON.parse(this.propsUrl),
                varPropsTrans: '',
                form: {
                    theme:'',
                },
                themeOption: null,
                processing:false,
            }
        },
        methods: {
            sendForm() {
                let that = this;
                if(that.form.theme.length <=0 ){
                    window.ShopifyApp.flashError("Please select the theme");
                    return false;
                }
                if (this.processing == false) {
                    let data = that.form;
                    return new Promise((resolve, reject) => {
                        axios({
                            method: 'POST',
                            url: that.varPropsUrl.store,
                            data: data,
                        }).then(response => {
                            this.$parent.show2Popup();
                            window.ShopifyApp.flashNotice(response.data.data);
                        }).catch(error => {

                        }).finally(function () {
                            that.processing = false;
                        });
                    });
                }
            },
        },
        created() {
            this.themeOption = this.varPropsData.theme;
            console.log(this.themeOption);
        }
    }
</script>
<style>

</style>
