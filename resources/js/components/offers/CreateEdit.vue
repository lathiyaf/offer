<template>
    <div class="oa-main">


        <form @submit.prevent ref="form_product" enctype="multipart/form-data">

            <div class="d-flex d-block-mobile align-items-start justify-content-between mb-4">
                <div class="mr-6 mr-xs-0">
                    <h1 class="mb-1">{{pageTitle}}</h1>
                    <p class="text-gray-700 mb-xs-2">This is where the magic happens! Here, you will be creating a Ruleset, by choosing which custom offers you want to display on your product page(s). There are three different display types to choose from to showcase your unique tier priced offer. </p>
                </div>
                <a href="#" @click.prevent="sendForm()" class="btn">Save</a>
            </div>
            <div class="alert alert-danger fade in alert-dismissible" role="alert" v-if="Object.keys(errors).length > 0">
                <div v-for="(item,index) in errors"> {{ item[0] }} </div>
            </div>
            <div class="oa-row">
                <div class="w-50">
                    <div class="oa-box mb-20">
                        <div class="oa-box-header">
                            <h2 class="text-primary">Ruleset Name :</h2>
                        </div>
                        <div class="oa-box-body">
                            <p class="text-gray-700 mb-20">For your own internal reference. Only you can see it.</p>
                            <input type="text" v-model="form.ruleset_name" placeholder="Enter Ruleset Name" class="form-control" />
                        </div>
                    </div>
                    <div class="oa-box mb-20">
                        <div class="oa-box-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h2 class="text-primary">Products :</h2>
                                <a href="#" class="btn btn-sm" @click.prevent="productPicker"><i class="ion ion-ios-add mr-2"></i>Add Product</a>
                            </div>
                        </div>
                        <div class="oa-box-body">
                            <p class="text-gray-700 mb-20">Select the product(s) that you want to apply a tiered pricing structure on.</p>
                            <div  v-if="form.selectedDesign.data">
                                <div class="offer-product-item" v-for="(item, index) in form.selectedDesign.data">
                                    <div class="offer-product-img">
                                        <img :src="item.image"/>
                                        {{item.title}}
                                    </div>
                                    <a href="#" class="action-item" @click.prevent="buttonCallBack([item.id,index])">
                                        <img src="/images/delate-icon.png" alt="">
                                    </a>
                                </div>
                            </div>
                            <p v-else class="font-size-sm text-gray-400 mb-4 text-center">You haven’t added any products yet.</p>
                        </div>
                    </div>
                </div>
                <div class="w-50 mb-xs-20">
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <img src="/images/main.png" style="max-width: 100%;" />
                    </div>
                </div>
                <div class="w-50 mb-20">
                    <div class="oa-box h-100">
                        <div class="oa-box-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h2 class="text-primary">Display Type :</h2>
                            </div>
                        </div>
                        <div class="oa-box-body">
                            <p class="text-gray-700 mb-20">Choose the way you want the offers to be displayed on your product page. These options can be customized inside the <a href="/settings" class="line-link">Display Settings</a> page.</p>
                            <select class="form-control" style="max-width: 300px;" @change="changeImage"  v-model="form.display_type">
                                <option value="dropdown">Dropdown</option>
                                <option value="swatch">Swatch</option>
                                <option value="gridview">Grid</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="w-50 mb-20">
                    <div class="oa-box h-100">
                        <div class="oa-box-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h2 class="text-primary">Ruleset preview :</h2>
                            </div>
                        </div>
                        <div class="oa-box-body">
                            <div class="text-center" align="center">
                                <img v-if="image_display_types.dropdown" src="/images/types/dropdown.png" align="center">
                                <img v-if="image_display_types.swatch" src="/images/types/swatch.png" align="center">
                                <img v-if="image_display_types.gridview" src="/images/types/grid.png" align="center">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-100">
                    <div class="oa-box mb-20">
                        <div class="oa-box-header">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h2 class="text-primary">Tier Pricing :</h2>
                                <a href="#" class="btn btn-sm" @click.prevent="addRow"><i class="ion ion-ios-add mr-2"></i>Add Tier</a>
                            </div>
                            <p class="text-gray-700 mb-20">Motivate your customers to buy more by setting up conditions for tiered pricing. You can apply discounts in percentage, as a fixed amount or give an X number of units
                                for free according to your set conditions.   </p>
                        </div>
                        <div class="oa-box-body" style="padding-left:0;padding-right: 0;padding-bottom: 0;">
                            <div class="oa-table-scroll">
                                <table class="oa-table">
                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Quantity</th>
                                        <th>Discount</th>
                                        <th>Type</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(name, index) in form.tier_pricing" :key="index">
                                        <td>Tier {{ inc(index) }}</td>
                                        <td><input type="number" min="1" pattern="[1-9]+" @focusout="checkLevelValue(index)" :name="'value'+index" v-model="name.buy" class="form-control form-control-sm text-center" style="max-width: 130px;"></td>
                                        <td><input type="number" min="1" pattern="[1-9]+" class="form-control form-control-sm text-center" value="0.0" @change.native="showDiscountText(index,name.get)" :name="'value'+index" v-model="name.get" style="max-width: 130px;"></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <select class="form-control form-control-sm mr-2" style="width: 130px;" :name="'column'+index"
                                                        :options="productOption" v-model="name.offer_type" :selectedOption="selectedDiscountTypeVal">
                                                    <option value="percentage">% Off</option>
                                                    <option value="fixed">Fixed Price</option>
                                                    <option value="free">Free</option>
                                                </select>
                                                <div v-if="form.tier_pricing.length > 1 && index !=0"> <a href="#" class="action-item"  @click.prevent="deleteRow(index)">
                                                    <img src="/images/delate-icon.png" alt="">
                                                </a> </div>

                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
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

        </form>
    </div>
</template>

<script>
    import NeedHelp from "../NeedHelp";
    export default {
        props: ['propsTrans', 'propsUrl', 'propsData'],
        components: {
            NeedHelp,
        },
        data() {
            return {
                colors:'',
                varPropsData: JSON.parse(this.propsData),
                varPropsUrl: JSON.parse(this.propsUrl),
                varPropsTrans: '',
                axiosUrl: null,
                image_display_types:{
                    dropdown:true,
                    swatch:false,
                    gridview:false,
                },
                form: {
                    ruleset_name: '',
                    selectedDesign: [],
                    tier_pricing: [
                        {buy: 1, get:5, offer_type:'percentage',id:''},
                        {buy: 2, get:10, offer_type:'percentage',id:''},
                        {buy: 3, get:15, offer_type:'percentage',id:''}
                    ],
                    status:true,
                    display_type:'dropdown',
                },
                Option: [
                    {label: '% Off ', value: 'percentage'}, {label: 'Fixed Price', value: 'fixed'}, {
                        label: 'Free',
                        value: 'free'
                    }
                ],
                processing: false,
                selectedDiscountTypeVal:'free',
                successBanner: false,
                criticalBanner: false,
                successMsg: null,
                errorMsg: null,
                columns: [
                    {type: 'image', label: '', field: 'image'},
                    {type: 'name', label: '', field: 'title'},
                    {
                        type: 'button', label: '', field: 'product_id',
                        button_props: [{
                            button_HTML: '<span class="Polaris-Button__Content">\n' +
                                '<span class="Polaris-Button__Text">\n' +
                                '<img src="../../images/polaris/icons/delete-icon.svg" width="16">\n' +
                                '</span>' ,action_type : 'delete' , button_type:''
                        }]
                    }
                ],
                rows: [],
                tags: [],
                searchParam:'',
                searchResponse: [],
                showDesign: false,
                scroll: true,
                page:1,
                productOption: [
                    {label: '% Off ', value: 'percentage'}, {label: 'Fixed Price', value: 'fixed'}, {
                        label: 'Free',
                        value: 'free'
                    }
                ],
                pageTitle:'',
                is_create_page:1,
                errors:{},
            }
        },
        methods: {
            inc(index){
                return ++index;
            },
            checkLevelValue(index) {
                let propertyName = 'buy';
                var seenDuplicate = false,testObject = {};
                let inputArray = this.form.tier_pricing;
                let currentvalue = this.form.tier_pricing[index][propertyName];
                inputArray.map(function(item) {
                    var itemPropertyName = item[propertyName];
                    if (itemPropertyName in testObject) {
                        testObject[itemPropertyName].duplicate = true;
                        item.duplicate = true;
                        seenDuplicate = true;
                    }
                    else {
                        testObject[itemPropertyName] = item;
                        delete item.duplicate;
                    }
                });

                if(seenDuplicate){
                    window.ShopifyApp.flashError("The quantity "+ currentvalue +" already exists...!");
                    this.form.tier_pricing[index][propertyName] = 0;
                }
            },
            checkKeepDisabled(index){
                if(this.form.display_type == 'gridview'){
                    return false;
                }
                if(index == 0){
                    if(this.form.display_type != 'gridview'){
                        this.form.tier_pricing[0].buy = 1;
                        return true;
                    }
                }
                return false;
            },
            changeImage(){
                if(this.form.display_type == 'dropdown'){
                    this.image_display_types ={
                        dropdown:true,
                        swatch:false,
                        gridview:false,
                    };
                }else if(this.form.display_type == 'swatch'){
                    this.image_display_types ={
                        dropdown:false,
                        swatch:true,
                        gridview:false,
                    };
                }else if(this.form.display_type == 'gridview'){
                    this.image_display_types ={
                        dropdown:false,
                        swatch:false,
                        gridview:true,
                    };
                }
                this.checkKeepDisabled(0);
                this.checkLevelValue(0);
            },
            updateValue(value){
              this.colors = value;
            },
            showDiscountText(index,name){
                console.log(index);
                //this.form.tier_pricing[index].ruleset_id = name;
            },
            addRow() {
                this.form.tier_pricing.push({buy: 0, get:0, offer_type:'free'});
            },
            addDesigns() {
                //this.rows = this.form.selectedDesign;
                this.showDesign = false;
            },
            handleScrolled() {
                if (this.scroll) {
                    this.page = this.page == 1 ? this.page + 1 : 1;
                    this.productPicker(this.page);
                }
            },
            closeDesignModal() {
                let that = this;
                that.showDesign = false;
                // that.form.tier_pricing.filter(function(item , index){
                that.form.tier_pricing = [];
                // });
                that.addRow();
            },
            buttonCallBack(value){
                let that = this;
                window.ShopifyApp.Modal.confirm("Are you sure you want to delete?", function(result){
                    if(!result)
                        return false;
                    if(typeof value[0] == 'number'){
                        that.form.selectedDesign.data.splice(value[1],1);
                        if(that.form.selectedDesign.data.length == 0){
                            that.form.selectedDesign = [];
                        }
                    }else{
                        window.ShopifyApp.Bar.loadingOn();
                        let url = that.varPropsUrl.deleteProduct;
                        return new Promise((resolve, reject) => {
                            axios({
                                method: 'DELETE',
                                url: url,
                                data:{'id':value[0]},
                            }).then(response => {
                                that.form.selectedDesign = {data:response.data};
                                window.ShopifyApp.flashNotice("Successfully Deleted.");
                            }).catch(error => {

                            }).finally(function () {
                                window.ShopifyApp.Bar.loadingOff();
                            });
                        });
                    }

                });
            },
            productPicker() {
                var productPickerOptions = {
                    'selectMultiple': true,
                };
                let that = this;
                window.ShopifyApp.Modal.productPicker(productPickerOptions, function (success, data) {
                    if (!success) {
                        return;
                    }
                    if (data.products.length > 0) {
                        let products = data.products;
                        that.checkPush(products);
                    }

                    if (data.errors) {
                        console.error(data.errors);
                    }
                });
            },
            checkPush(products){
                let that = this;
                return new Promise((resolve, reject) => {
                    axios({
                        method: 'POST',
                        url: that.varPropsUrl.check,
                        data: {data:products},
                    }).then(response => {
                        if (that.varPropsData.currentRoute == 'offers/{ruleset}/edit'){
                            that.form.selectedDesign.data = that.form.selectedDesign.data.concat(response.data.data);
                        }else{
                            if(typeof that.form.selectedDesign.length == 'undefined'){
                                that.form.selectedDesign.data = that.form.selectedDesign.data.concat(response.data.data);
                            }else{
                                that.form.selectedDesign = response.data;
                            }
                        }
                        let unselected = response.data.total_selected - response.data.total_added;
                        if(unselected > 0){
                            window.ShopifyApp.flashNotice(unselected+" product already added in other rulesets");
                        }
                    }).catch(error => {
                        let errors = error.response.data;
                        let pushError = '';
                        for (let error in errors) {
                            pushError = pushError + errors[error] + '<br/>'
                        }
                        that.errorMsg = pushError;
                        that.criticalBanner = true;
                    });
                });
            },
            sendForm() {
                if (this.processing == false) {
                    let that = this;
                    let data = that.form;
                    window.ShopifyApp.Bar.loadingOn();
                    return new Promise((resolve, reject) => {
                        axios({
                            method: 'POST',
                            url: that.axiosUrl,
                            data: data,
                        }).then(response => {
                            window.ShopifyApp.flashNotice("Successfully Saved.");
                            if(that.is_create_page == 1){
                                setInterval(function(){ that.redirect() }, 2000);
                            }

                        }).catch(error => {
                            that.errors = error.response.data;
                            window.scrollTo(0,0);
                        }).finally(function () {
                            that.processing = false;
                            window.ShopifyApp.Bar.loadingOff();
                        });
                    });
                }
            },
            getProductData() {
                if (this.varPropsData.currentRoute == 'offers/{ruleset}/edit') {
                    let that = this;
                    let entity = that.varPropsData.entity;
                    that.form.ruleset_name = entity.ruleset_name;
                    that.form.tier_pricing = entity.settings;
                    that.form.display_type = entity.display_type;
                    that.form.selectedDesign =  that.form.selectedDesign = {data:entity.products};
                    that.form.status =  entity.status;
                    that.axiosUrl = this.varPropsUrl.update.replace('__', entity.id);
                    that.pageTitle= entity.ruleset_name;
                    that.is_create_page = 0;
                    that.changeImage();
                } else {
                    this.axiosUrl = this.varPropsUrl.store;
                    this.pageTitle = 'Create Ruleset';
                }
            },
            bannerCloseEvent(type) {
                this[type] = false;
            },

//          Design Modal
            deleteRow(index) {
                console.log("sss", index);
                console.log(this.form.tier_pricing);
                //this.form.tier_pricing.splice(index, 1);

                this.$delete(this.form.tier_pricing,index);
                console.log(this.form.tier_pricing);
                console.log("----------------------------------------");
            },
            addDesigns() {
                this.showDesign = false;
            },
            removeProduct(key, value) {
                console.log(this.form.selectedDesign);
                this.form.selectedDesign.splice(key, 1)
            },
            /*
                Datatable
             */
            setSearch(event){
                this.searchParam = event.target.value;
            },
            onPrevious(){
                let url = this.form.selectedDesign.prev_page_url+ "&search="+this.searchParam;
                this.fetchData(url);
            },
            onNext(){
                let url = this.form.selectedDesign.next_page_url+ "&search="+this.searchParam;
                this.fetchData(url);
            },
            filterRecords(){
                let page = this.form.selectedDesign.current_page;
                let url = this.varPropsUrl.index + "?page="+page+"&search="+this.searchParam;
                this.fetchData(url);
            },
            fetchData(url) {
                let that = this;
                return new Promise((resolve, reject) => {
                    axios({
                        method: 'GET',
                        url: url,
                    }).then(response => {
                        that.form.selectedDesign = response.data;
                    }).catch(error => {

                    });
                });
            },
            redirect() {
                window.location.href = this.varPropsUrl.index;
            },
        },
        created() {
            this.getProductData();
        },
    }
</script>
<style>
    .text-center img{
        display: inline-block;
    }
</style>
