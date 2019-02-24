<template>
    <div class="container">
        <div class="row filter-form">
            <div class="col-xs-12 col-sm-6 col-md-4">
                <label class="control-label"></label>
                <el-date-picker required :editable="false" name="date" v-model="params.service_period" type="date" placeholder="Select Date" @change="changeDate(params.service_period)"></el-date-picker>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <el-button type="button" @click="getData"><i class="fa fa-search"></i></el-button>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <span @click="Export">Export Excel</span>
            </div>
        </div>
        <table class="table table-hover dataTable table-bordered width-full table-small combo-table">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Debitor</td>
                    <td>Brutto</td>
                    <td>Netto</td>
                    <td>Settings</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in data">
                    <th>{{ item.id }}</th>
                    <th>{{ item.Debitor.name }}</th>
                    <th>{{ item.brutto }}</th>
                    <th>{{ item.netto }}</th>
                    <th>
                        <router-link :to="{name: 'EditInvoice', params: { id: item.id }}" class="animsition-link" >
                            <i class="fa fa-edit"></i>
                        </router-link>
                    </th>
                </tr>
            </tbody>
        </table>

        <br>
        <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="getData()"></pagination>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getData();
        },
        data() {
            return {
                typeTitle: null,
                data:[],
                pagination: {
                    current_page: 1,
                    last_page: 1,
                    total: null,
                    per_page: 25,
                    from: null,
                    to: null
                },
                params: {
                    page: 1,
                    limit: 25,
                    orderDirection: "desc",
                    orderField: "id",
                    status: null, // Created, prepared, paid
                    debitor_id: null,
                    attendant: null,
                    billing_number: null,
                    service_period: null,
                    receipt_date: null,
                    date_paid: null,
                    balance: null, // float
                    netto: null, // float
                    brutto: null, // float
                    debitor: null, // name of the debitor
                    invoice_id: null,
                    email: null,
                },
                checkedStatuses: [],
                checkedCategories: [],
            }
        },
        watch: {
            $route (to, from) {
                if (to != from) {
                    this.getData();
                }
            },
            params(newValue, oldValue) {
                this.getData();
            },
            // In case of categories change data will be fetched from the database again
            checkedCategories: function (newValue, oldValue) {
                this.getData();
            },
            // In case of statuses change data will be fetched from the database again
            checkedStatuses: function(newValue, oldValue) {
                this.getData();
            },
        },
        methods: {
            Export() {
                this.$http.get('/admin/invoices/export', {
                    headers: { 'Accept':'application/json' }, 
                    params: {
                        data: this.data,
                    }
                }).then(response => {

                }, function(error) {
                    console.log(error);
                });
            },
            changeDate(date) {
                this.params.service_period = Vue.moment(date).format('YYYY-MM-DD, H:mm:ss');
            },
            getData() {
                this.params.page = this.pagination.current_page;
                this.$http.get('/admin/invoices/browse_invoices', {
                    headers: { 'Accept':'application/json' }, 
                    params: {
                        params: this.params,
                    }
                }).then(response => {
                    if (this.pagination.current_page == 1) {
                        this.pagination.current_page = response.data.page;
                    }
                    this.pagination.last_page = response.data.page_count;
                    this.pagination.total = response.data.total_items;
                    this.pagination.per_page = 25;
                    this.pagination.from = response.data.page;
                    this.pagination.to = response.data.page + 1;

                    this.data = response.data._embedded.list_debits;
                }, function(error) {
                    console.log(error);
                });
            }
        }
    }
</script>
