<template>
    <div class="">

        <div class="oa-main">
            <div class="d-flex align-items-start justify-content-between mb-2">
                <h1 class="mb-0">RuleSets</h1>
            </div>
            <div class="oa-box">
                <div class="oa-box-header">
                    <div class="d-flex d-block-mobile align-items-center justify-content-between">
                        <a href="#" @click.prevent="redirect" class="btn btn-sm mb-xs-2"><i class="ion ion-ios-add mr-2"></i>Create Ruleset</a>
                        <div class="searchbar">

                            <input type="text" v-model="search" placeholder="Search Ruleset..." class="form-control form-control-sm">
                            <div class="input-group-append">
                                <button type="button" @click.prevent="showMore" class="btn btn-sm"><i class="ion ion-ios-search"></i></button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="oa-box-body" style="padding-left:0;padding-right: 0;padding-bottom: 0;">
                    <div class="oa-table-scroll">
                        <vuetable ref="vuetable"
                                  :api-url="url"
                                  :fields="fields"
                                  :append-params="externalParams"
                                  @vuetable:load-success="loaded"
                                  class="oa-table"
                        >
                            <template slot="status" slot-scope="props">
                                <label class="switch">
                                    <input type="checkbox" v-model="props.rowData.status" @change="buttonCallBack('status',props.rowData.id)" name="status" v-bind:id="props.rowData.id">
                                    <span class="slider round"></span>
                                </label>
                            </template>
                            <template slot="action" slot-scope="props">
                                <div class="d-flex align-items-center">
                                    <a href="#" @click.prevent="buttonCallBack('edit',props.rowData.id)" class="action-item mr-2">
                                        <img src="/images/edite-icon.png" alt=""/>
                                    </a>
                                    <a href="#" @click.prevent="buttonCallBack('delete',props.rowData.id)" class="action-item"
                                       style="">
                                        <img src="/images/delate-icon.png" alt=""/>
                                    </a>
                                </div>
                            </template>
                        </vuetable>
                        <div class="mt-5 text-center" v-show="toggals.showMore">
                            <a href="#" class="show-more" @click.prevent="showMore(1)">Show More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="oa-footer">
            <div class="text-center">
                <p class="text-gray-700 mb-20">Rulesets are groups of products that share the same subscription properties.<br />
                    Editing a ruleset’s prop-erties will affect all products within the ruleset. Learn more about rulesets</p>
                <need-help></need-help>
            </div>
        </div>
    </div>
</template>


<script>
    import Vuetable from 'vuetable-2/src/components/Vuetable';
    import NeedHelp from "../NeedHelp";
    export default {
        components: {
            Vuetable,
            NeedHelp
        },
        props: ['propsTrans', 'propsUrl', 'propsData'],
        data() {
            let that = this;
            return {
                varPropsData: JSON.parse(this.propsData),
                varPropsUrl: JSON.parse(this.propsUrl),
                varPropsTrans: JSON.parse(this.propsTrans),
                entity: {perPage: 10},
                externalParams: {},
                fields: [
                    {
                        name: "ruleset_name",
                        sortField: "ruleset_name",
                        title: 'Name',
                        dataClass: 'name',
                    },
                    {
                        name: "products_count",
                        title: 'Product Count',
                        sortField: "products_count",
                    },
                    {
                        name: "created_at",
                        title: 'Created At',
                        sortField: "created_at"
                    },
                    {
                        name: "__slot:status",
                        title: 'Status',
                    },
                    {
                        name: "__slot:action",
                        title: 'Actions',
                        dataClass: 'action',
                    },
                ],
                url: '',
                search: '',
                toggals: {
                    showMore: true,
                }
            }
        },
        methods: {
            loaded(data) {
                let that = this;
                if (data.data.to >= data.data.total) {
                    this.toggals.showMore = false;
                }
            },
            showMore(value = 0) {
                if (value == 1) {
                    this.entity.perPage = this.entity.perPage + 10;
                }
                this.externalParams = {
                    per_page: this.entity.perPage,
                    search: this.search
                };
                Vue.nextTick(() => this.$refs.vuetable.refresh());
            },
            copyTestingCode() {
                let testingCodeToCopy = document.querySelector('#short_code');
                testingCodeToCopy.value = `<div data-code="crawlapps_offers"></div>`;
                testingCodeToCopy.setAttribute('type', 'text')
                testingCodeToCopy.select()
                var successful = document.execCommand('copy');
                window.ShopifyApp.flashNotice("Copied...!");
                /* unselect the range */
                testingCodeToCopy.setAttribute('type', 'hidden');
                window.getSelection().removeAllRanges()
            },
            buttonCallBack(value, id = null) {
                let that = this;
                if (value == 'edit') {
                    let url = that.varPropsUrl.edit.replace('__', id);
                    window.location.href = url;
                }else if(value == 'status'){
                    window.ShopifyApp.Bar.loadingOn();
                    let url = that.varPropsUrl.status.replace('__', id);
                    return new Promise((resolve, reject) => {
                        axios({
                            method: 'POST',
                            url: url,
                        }).then(response => {
                            window.ShopifyApp.flashNotice(response.data.data);
                            window.ShopifyApp.Bar.loadingOff();
                        }).catch(error => {

                        });
                    });
                } else {
                    window.ShopifyApp.Modal.confirm("Are you sure you want to delete?", function (result) {
                        if (result) {
                            let url = that.varPropsUrl.delete.replace('__', id);
                            return new Promise((resolve, reject) => {
                                axios({
                                    method: 'DELETE',
                                    url: url,
                                }).then(response => {
                                    that.showMore();
                                }).catch(error => {

                                });
                            });
                        }
                    });
                }
            },
            redirect() {
                window.location.href = this.varPropsUrl.create;
            },
        },
        created() {
            this.url = this.varPropsUrl.index + "?page=1";
        }
    }
</script>
<style>

</style>
