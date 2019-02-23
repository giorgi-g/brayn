<template>
    <div class="container">
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
                    <th><i class="fa fa-eye" @click="openItem(item.id)"></i></th>
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
                invoice: {
                    id:null,
                    debitor_id:null,
                    receipt_id:null,
                    attendant:null,
                    billing_number:null,
                    service_period:null,
                    term_of_credit:null,
                    no_tax:null,
                    is_payment_instructed:null,
                    Debitor: {
                        id:null,
                        contact_id:null,
                        number:null,
                        tax_number:null,
                        debit_payment:null,
                        iban:null,
                        bic:null,
                        email:null,
                        send_email_bills:null,
                        deactivated:null,
                        language:null,
                        last_invoice_number:null,
                        name:null,
                        street:null,
                        postcode:null,
                        location:null,
                        country:null,
                        crm_id:null,
                    },
                    remarks:null,
                    receipt_date:null,
                    date_paid:null,
                    balance:null,
                    file: {
                        id:null,
                        filename:null,
                        file_url:null,
                        file_exists:null,
                    },
                    excluded_reminder:null,
                    items:[{
                        id:null,
                        description:null,
                        amount:null,
                        price:null,
                        measurement:null,
                        vat_rate:null,
                        sum:null,
                    }],
                    attachment:{
                        id:null,
                        filename:null,
                        file_url:null,
                        file_exists:null,
                    },
                    netto:null,
                    brutto:null,
                    type:null,
                    due_date:null,
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
            // In case of categories change data will be fetched from the database again
            checkedCategories: function (newValue, oldValue) {
                this.getData();
            },
            // In case of statuses change data will be fetched from the database again
            checkedStatuses: function(newValue, oldValue) {
                this.getData();
            }
        },
        methods: {
            openItem(id) {
                this.$http.get('/admin/invoices/browse_invoices', {
                    headers: { 'Accept':'application/json' },
                    params: {
                        id: id,
                    } 
                }).then(response => {
                    this.invoice = response.data;
                    console.log('this.invoice', this.invoice);
                }, function(error) {
                    console.log(error);
                })
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
                })
            }
        }
    }
</script>
