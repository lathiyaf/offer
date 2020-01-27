<template>
    <div>

        <div class="oa-main">
            <div class="d-flex d-block-mobile align-items-start justify-content-between mb-4">
                <div class="mr-6 mr-xs-0 mb-xs-2">
                    <h1 class="mb-0">Dashboard</h1>
                </div>
                <div class="align-items-center dashboard-date">
                    <date-picker
                        ref="picker"
                        :opens="datepicker.open"
                        :autoApply="datepicker.autoApply"
                        :locale-data="datepicker.localData"
                        :ranges="datepicker.ranges"
                        :date-range="datepicker.date_range"
                        :autoUpdateInput="true"
                        :showCustomRangeLabel="datepicker.showCustomRangeLabel"
                    @update="checkdate"
                        :linkedCalendars="datepicker.linkedCalendars"
                        :alwaysShowCalendar="false"
                    >
                        <div slot="input" slot-scope="picker">
                            {{ picker.startDate | date }} - {{ picker.endDate | date }}
                        </div>
                    </date-picker>
                    <p :class="date_error.error" v-if="date_error.show">The date range should be lessthan equals to 31 days</p>
                    <select class="form-control form-control-new ml-2" @change="onRulesetChange($event)" v-model="selected_ruleset">
                        <option value="">All Rulesets</option>
                        <option v-for="item in ruleset_option" :value="item.code">{{ item.ruleset_name }}</option>
                    </select>
                </div>
            </div>
            <div class="mobile-padd">
                <div class="oa-row oa-box mb-20" style="min-height: auto;">
                    <div class="w-25 da-item">
                        <div class="d-flex align-items-center">
                            <img src="/images/sale.png" class="item-img">
                            <div>
                                <p>Total Sales</p>
                                <h1>{{ sale }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="w-25 da-item">
                        <div class="d-flex align-items-center">
                            <img src="/images/second.png" class="item-img">
                            <div>
                                <p>Total Revenue</p>
                                <h1>{{ revenue }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="w-25 da-item">
                        <div class="d-flex align-items-center">
                            <img src="/images/third.png" class="item-img">
                            <div>
                                <p>Average Cart</p>
                                <h1>{{ average }} </h1>
                            </div>
                        </div>
                    </div>
                    <div class="w-25 da-item" style="background-color: #00a9a2;color: #fff;">
                        <div class="d-flex align-items-center">
                            <img src="/images/forth.png" class="item-img">
                            <div>
                                <p>Total extra amount</p>
                                <h1>{{ total_extra_amount }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="oa-row">
                <div class="w-50 mb-20">
                    <div class="oa-box mb-20">
                        <div class="oa-box-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h2 class="text-primary">Sales :</h2>
                            </div>
                        </div>
                        <div class="oa-box-body">
                            <line-chart class="myChart" :chart-data="datacollection.sales" :options="options.sales"></line-chart>
                        </div>
                    </div>
                </div>
                <div class="w-50  mb-20">
                    <div class="oa-box mb-20">
                        <div class="oa-box-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h2 class="text-primary">Revenue :</h2>
                            </div>
                        </div>
                        <div class="oa-box-body">
                            <line-chart class="myChart" :chart-data="datacollection.revenue" :options="options.revenue"></line-chart>
                        </div>
                    </div>
                </div>
                <div class="w-100 mb-20">
                    <div class="oa-box mb-20">
                        <div class="oa-box-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h2 class="text-primary">Average Cart :</h2>
                            </div>
                        </div>
                        <div class="oa-box-body">
                            <line-chart refs="chart" :chart-data="datacollection.average" :options="options.average"></line-chart>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="oa-footer">
            <div class="text-center">
                <need-help></need-help>
            </div>
        </div>
    </div>
</template>


<script>

    import DatePicker from 'vue2-daterange-picker';
    import LineChart from "./LineChart.js";
    import NeedHelp from "../NeedHelp";
    import 'vue2-daterange-picker/dist/vue2-daterange-picker.css';
    export default {
        props: ['propsTrans', 'propsUrl', 'propsData'],
        components: {
            DatePicker,
            'line-chart': LineChart,
            NeedHelp,
        },
        data() {
            let that = this;
            return {
                varPropsData: JSON.parse(this.propsData),
                varPropsUrl: JSON.parse(this.propsUrl),
                varPropsTrans: '',
                firstsaledate: 0,
                datepicker:{
                    date_range: {
                        startDate:moment().startOf('month').format("YYYY-MM-DD 00:01:01"),
                        endDate:moment().format("YYYY-MM-DD 23:59:59"),
                    },
                    autoApply:false,
                    linkedCalendars:true,
                    open:"left",
                    localData:{
                        direction: 'ltr',
                        applyLabel: 'Update',
                        cancelLabel: 'Cancel',
                        customRangeLabel: "Custom Range",
                    },
                    showCustomRangeLabel: true,
                    ranges:{},
                },
                ruleset_option:{},
                date_error:{
                    error:'',
                    show:false,
                },
                selected_ruleset:'',
                type:'revenue',
                currency:'$',
                sale:0,
                revenue:'$0',
                average:'$0',
                total_extra_amount:'$0',
                options:{
                    sales:{
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: {
                            display: false,
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min:0,
                                    beginAtZero: true,
                                    userCallback: function(label, index, labels) {
                                        if (Math.floor(label) === label) {
                                            return that.currency + label;
                                        }
                                    },
                                }
                            }]
                        },
                    },
                    revenue:{
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: {
                            display: false,
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min:0,
                                    beginAtZero: true,
                                    userCallback: function(label, index, labels) {
                                        if (Math.floor(label) === label) {
                                            return that.currency + label;
                                        }
                                    },
                                }
                            }]
                        },
                    },
                    average:{
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: {
                            display: false,
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min:0,
                                    beginAtZero: true,
                                    userCallback: function(label, index, labels) {
                                        if (Math.floor(label) === label) {
                                            return that.currency + label;
                                        }
                                    },
                                }
                            }]
                        },
                    },
                },
                datacollection: {
                    sales:{},
                    revenue:{},
                    average:{},
                },
                confirm:true,
                dateType:'thismonth',
                init:0,
                gradient:null,
            }
        },
        filters: {
            date: function (value) {
                return moment(value).format("MMM DD, YYYY");
            }
        },
        methods: {
            setFormat: function (value,type) {
                return moment(value).format("MMM DD, YYYY");
            },
            checkdate(value){
                this.datepicker.date_range = {
                    startDate: moment(value.startDate).format("YYYY-MM-DD 00:01:01"),
                    endDate: moment(value.endDate).format("YYYY-MM-DD 23:59:59"),
                };
                this.getData('sales');
                this.getData('revenue');
                this.getData('average');
            },
            onRulesetChange(event){
                this.selected_ruleset = event.target.value;
                this.getData('sales');
                this.getData('revenue');
                this.getData('average');
            },
            getData(type = 'revenue'){
                let that= this;
                that.type = type;
                let url = that.varPropsUrl.index;
                window.ShopifyApp.Bar.loadingOn();
                return new Promise((resolve, reject) => {
                    axios({
                        method: 'Get',
                        url: url,
                        params:{
                            "api":1,
                            "date_type":that.dateType,
                            "type":type,
                            "ruleset":that.selected_ruleset,
                            "date_range":that.datepicker.date_range,
                        },
                    }).then(response => {
                        let overview = response.data.overview;
                        let graph_data = response.data.graph_data;
                        that.currency = overview.currency;
                        that.sale = overview.sale;
                        that.revenue = that.currency+overview.revenue;
                        that.average = that.currency+overview.average;
                        that.total_extra_amount = that.currency+overview.total_extra_amount;
                        let datasetLabel = '';
                        if(type=='sales'){
                            that.datacollection.sales = {
                                labels: graph_data.dates,
                                datasets: [
                                    {
                                        label: datasetLabel,
                                        backgroundColor: that.gradient,
                                        data: graph_data.data,
                                    }
                                ]
                            }
                            that.currency = '';
                            that.options.sales.scales.yAxes[0].ticks.max = graph_data.max_value;
                        }else if(type=='revenue'){
                            that.datacollection.revenue = {
                                labels: graph_data.dates,
                                datasets: [
                                    {
                                        label: datasetLabel,
                                        backgroundColor: that.gradient,
                                        data: graph_data.data,
                                    }
                                ]
                            }
                            that.options.revenue.scales.yAxes[0].ticks.max = graph_data.max_value;
                        }else if(type=='average') {
                            that.datacollection.average = {
                                labels: graph_data.dates,
                                datasets: [
                                    {
                                        label: datasetLabel,
                                        backgroundColor: that.gradient,
                                        data: graph_data.data,
                                    }
                                ]
                            }
                            that.options.average.scales.yAxes[0].ticks.max = graph_data.max_value;
                            that.$refs.chart.update();
                        }
                    }).catch(error => {

                    }).finally(function () {
                        window.ShopifyApp.Bar.loadingOff();
                    });
                });
            },
            getRulesets(){
                let that= this;
                let url = that.varPropsUrl.index_offer+"?page=1&api=1";
                return new Promise((resolve, reject) => {
                        axios({
                            method: 'Get',
                            url: url,
                        }).then(response => {
                            that.ruleset_option = response.data;
                        });
                });
            }
        },
        mounted() {
            let that = this;
            this.firstsaledate = parseInt(this.varPropsData.firstsaledate);
            this.datepicker.ranges = {
                'Lifetime':[moment().subtract(that.firstsaledate, 'years'), moment()],
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'This Week': [moment().startOf('week'), moment()],
                'Past Week': [moment().subtract(1, 'weeks').startOf('weeks'), moment().subtract(1, 'weeks').endOf('weeks')],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Past month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            };
            //this.defaultDateRange;
            this.getRulesets();
            this.getData('sales');
            this.getData('revenue');
            this.getData('average');
            this.init = 1;

            that.gradient    = document.getElementById('line-chart').getContext('2d');
            that.gradient = that.gradient.createLinearGradient(0, 0, 0, 450);
            that.gradient.addColorStop(0, 'rgba(0, 169,162, 0.5)');
            that.gradient.addColorStop(0.5, 'rgba(0, 169,162, 0.25)');
            that.gradient.addColorStop(1, 'rgba(0, 169,162, 0)');

        }
    }
</script>
<style lang="scss">

</style>
