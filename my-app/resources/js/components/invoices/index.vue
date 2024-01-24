<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();

let invoices = ref([]);

onMounted(async () => {
    getInvoices();
})


// get all invoices and return data.
const getInvoices = async () => {
    let response = await axios.get('/api/get_all_invoice')
    // console.log(response)
    invoices.value = response.data.invoices
}


//get one new invoice
const newInvoice = async () => {
    let form = await axios.get('/api/create_invoice')
    // console.log(form.data)
    router.push('/invoice/new')
}


const onShow = (id) => {
    router.push('/invoice/show/' + id);
}

</script>





<template>
    <div class="container">
        <div class="invoices">

            <div class="card__header">
                <div>
                    <h2 class="invoice__title">Invoices</h2>
                </div>
                <div>
                    <a class="btn btn-secondary" @click="newInvoice()">
                        New Invoice
                    </a>
                </div>
            </div>

            <div class="table card__content">
                <div class="table--filter">
                    <span class="table--filter--collapseBtn ">
                        <i class="fas fa-ellipsis-h"></i>
                    </span>
                    <div class="table--filter--listWrapper">
                        <ul class="table--filter--list">
                            <li>
                                <p class="table--filter--link table--filter--link--active">
                                    All
                                </p>
                            </li>
                            <li>
                                <p class="table--filter--link ">
                                    Paid
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table--heading">
                    <p>ID</p>
                    <p>Date</p>
                    <p>Number</p>
                    <p>Customer</p>
                    <p>Due Date</p>
                    <p>Total</p>
                </div>

                <!----------------------------insert invoices in table--------------- 1 -->
                <div class="table--items" v-for="item in invoices" :key="item.id" v-if="invoices.length > 0">
                    <a href="#" @click="onShow(item.id)" class="table--items--transactionId">{{ item.id }}</a>
                    <p>{{ item.date }}</p>
                    <p>{{ item.number }}</p>
                    <!-- this column =>relationship between [] -->
                    <p v-if="item.customer">
                        {{ item.customer.first_name }}
                    </p>
                    <p v-else></p>
                    <p>{{ item.due_date }}</p>
                    <p>{{ item.total }}</p>
                </div>

                <!-- --------------if there is no invoices------------- -->
                <div class="table--items" v-else>
                    No Invoices Found!
                </div>
            </div>

        </div>
    </div>
</template>