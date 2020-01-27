<template>
    <div>
        <div class="oa-main">
            <div class="d-flex align-items-start mb-4">
                <h1 class="mb-0">Uninstall App</h1>
            </div>
            <div class="oa-row">
                <div class="w-50">
                    <div class="oa-box mb-20">
                        <div class="oa-box-header">
                            <div class="d-flex align-items-center">
                                <h2 class="text-primary">Pick a Theme :</h2>
                            </div>
                        </div>
                        <div class="oa-box-body">
                            <p class="text-gray-700 mb-3">Please reverify the uninstallation steps to remove the application completely. Please check here: <a href="#" class="line-link">Uninstallation Guide</a>.</p>
                            <div class="mb-3">
                                <select class="form-control" style="max-width: 300px;" v-model="form.theme">
                                    <option v-for="item in themeOption" :value="item.value">{{item.label}}</option>
                                </select>
                            </div>
                            <a href="#" @click.prevent="sendForm" class="btn">Uninstall</a>
                        </div>
                    </div>

                </div>
                <div class="w-50">
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <img src="/images/uninstall.png" />
                    </div>
                </div>

            </div>
        </div>
        <div class="oa-footer">
            <div class="text-center">
                <div class="offer-create-footer">
                    <i class="ion ion-ios-alert"></i>Need help? Visit <a href="#">our Support center</a>
                </div>
            </div>
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
                            url: that.varPropsUrl.uninstall,
                            data: data,
                        }).then(response => {
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
        }
    }
</script>
<style>

</style>
