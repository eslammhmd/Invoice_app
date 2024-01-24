import { createRouter , createWebHistory } from "vue-router";
import InvoiceIndex from '../components/invoices/index.vue';
import notFound from '../components/NotFound.vue';
import newInvoice from '../components/invoices/newInvoice.vue';
import showInvoice from '../components/invoices/show.vue';
import editInvoice from '../components/invoices/edit.vue';

const routes = [
    {
        path : '/',
        component : InvoiceIndex,
    },
    {
        path : '/:pathMatch(.*)*',
        component : notFound,
    },
    {
        // take params :
        path : '/invoice/show/:id',
        component : showInvoice,
        props : true,
    },
    {
        path : '/invoice/new',
        component : newInvoice,
    },
    {
        // take params :
        path : '/invoice/edit/:id',
        component : editInvoice,
        props : true,
    },
   
]

const router = createRouter({
    history : createWebHistory(),
    routes
})

export default router