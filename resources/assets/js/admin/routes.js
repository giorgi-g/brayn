import DashboardBrowser from '../components/admin/DashboardBrowser.vue';
import InvoicesBrowser from '../components/admin/invoices/InvoicesBrowser.vue';
import CreateInvoice from '../components/admin/invoices/CreateInvoice.vue';

let _routes = [
        {
            path: '/admin',
            name: 'DashboardBrowser',
            component: DashboardBrowser
        },
        {
            path: '/admin/invoices',
            name: 'InvoicesBrowser',
            component: InvoicesBrowser
        },
        {
            path: '/admin/invoices/create',
            name: 'CreateInvoice',
            component: CreateInvoice
        },
        {
            path: '/admin/invoices/:id/edit',
            name: 'EditInvoice',
            component: CreateInvoice
        },
    ];
export const routes = _routes;