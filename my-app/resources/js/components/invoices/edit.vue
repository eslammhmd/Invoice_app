

<script setup>
// import axios from 'axios';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();
let form = ref({ id: '' })
let all_customers = ref([]);
let customer_id = ref([]);
const showModel = ref(false);
const hideModel = ref(true);
let listProducts = ref([]);


onMounted(async () => {
    getInvoice()
    getAllCustomers()
    getProducts()
})

const props = defineProps({
    id: {
        type: String,
        default: ''
    }
})

const getInvoice = async () => {
    const res = await axios.get(`/api/edit_invoice/${props.id}`)
    // console.log(res.data.invoices)
    form.value = res.data.invoices
}

// get all Customers from index and return data.
const getAllCustomers = async () => {
    let response = await axios.get('/api/customers');
    // console.log(response);
    all_customers.value = response.data.customers
}

const getProducts = async () => {
    let response = await axios.get('/api/products');
    // console.log(response);
    listProducts.value = response.data.products
}

const deleteInvoiceItem = (id, i) => {
    form.value.invoice_items.splice(i, 1)
    if (id != undefined) {
        axios.get('/api/delete_invoice_items/' + id)
    }
}


const openModel = () => {
    showModel.value = !showModel.value
}
const closeModel = () => {
    showModel.value = !hideModel.value
}


const AddCart = (item) => {
    const itemCart = {
        product_id: item.id,
        item_code: item.item_code,
        desc: item.desc,
        unit_price: item.unit_price,
        qty: item.qty,
    }
    // listCart.value.push(itemCart)
    form.value.invoice_items.push(itemCart)
    closeModel()
}



//get sup total
const SubTotal = () => {
    let total = 0

    if (form.value.invoice_items) {
        form.value.invoice_items.map((data) => {
            total = total + (data.qty * data.unit_price)
        })
    }

    return total
}


const Total = () => {
    if (form.value.invoice_items) {
        return SubTotal() - form.value.discount;
    }
}



const onEdit = (id) => {
    if (form.value.invoice_items.length >= 1) {
        // alert(JSON.stringify(form.value.invoice_items))
        let sub_total = 0
        sub_total = SubTotal()

        let total = 0
        total = Total()

        const formData = new FormData()
        formData.append('invoice_item', JSON.stringify(form.value.invoice_items))
        formData.append('customer_id', form.value.customer_id)
        formData.append('date', form.value.date)
        formData.append('due_date', form.value.due_date)
        formData.append('number', form.value.number)
        formData.append('reference', form.value.reference)
        formData.append('discount', form.value.discount)
        formData.append('sub_total', sub_total)
        formData.append('total', total)
        formData.append('terms_and_conditions', form.value.terms_and_conditions)


        axios.post(`/api/update_invoice/${form.value.id}`, formData)
        form.value.invoice_items = []
        router.push('/');
    }
}

</script>


<template>
    <div class="container">
        <div class="invoices">

            <div class="card__header">
                <div>
                    <h2 class="invoice__title">Edit Invoice</h2>
                </div>
                <div>

                </div>
            </div>

            <div class="card__content">
                <div class="card__content--header">
                    <div>
                        <p class="my-1">Customer</p>
                        <select name="" id="" class="input" v-model="form.customer_id">
                            <option disabled>Select Customer </option>

                            <option :value="customer.id" v-for="customer in all_customers" :key="customer_id">
                                {{ customer.first_name }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <p class="my-1">Date</p>
                        <input id="date" placeholder="dd-mm-yyyy" type="date" class="input" v-model="form.date"> <!---->
                        <p class="my-1">Due Date</p>
                        <input id="due_date" type="date" class="input" v-model="form.due_date">
                    </div>
                    <div>
                        <p class="my-1">Numero</p>
                        <input type="text" class="input" v-model="form.number">
                        <p class="my-1">Reference(Optional)</p>
                        <input type="text" class="input" v-model="form.reference">
                    </div>
                </div>
                <br><br>
                <div class="table">

                    <div class="table--heading2">
                        <p>Item Description</p>
                        <p>Unit Price</p>
                        <p>Qty</p>
                        <p>Total</p>
                        <p></p>
                    </div>

                    <!-- item 1 -->
                    <div class="table--items2" v-for="(itemCart, i) in form.invoice_items" :key="itemCart.id">
                        <p v-if="itemCart.product">#
                            {{ itemCart.product.item_code }} {{ itemCart.product.desc }}
                        </p>
                        <p v-else>{{ itemCart.item_code }} {{ itemCart.desc }}</p>
                        <p>
                            <input type="text" class="input" v-model="itemCart.unit_price">
                        </p>
                        <p>
                            <input type="text" class="input" v-model="itemCart.qty">
                        </p>
                        <p>
                            $ {{ itemCart.qty }}*{{ itemCart.unit_price }}
                        </p>
                        <p style="color: red; font-size: 24px;cursor: pointer;" @click="deleteInvoiceItem(itemCart, i)">
                            &times;
                        </p>
                    </div>
                    <div style="padding: 10px 30px !important;">
                        <button class="btn btn-sm btn__open--modal" @click="openModel()">Add New Line</button>
                    </div>
                </div>

                <div class="table__footer">
                    <div class="document-footer">
                        <p>Terms and Conditions</p>
                        <textarea cols="50" rows="7" class="textarea" v-model="form.terms_and_conditions">

                        </textarea>
                    </div>
                    <div>
                        <div class="table__footer--subtotal">
                            <p>Sub Total</p>
                            <span>$ {{ SubTotal() }}</span>
                        </div>
                        <div class="table__footer--discount">
                            <p>Discount</p>
                            <input type="text" class="input" v-model="form.discount">
                        </div>
                        <div class="table__footer--total">
                            <p>Grand Total</p>
                            <span>$ {{ Total() }}</span>
                        </div>
                    </div>
                </div>


            </div>
            <div class="card__header" style="margin-top: 40px;">
                <div>

                </div>
                <div>
                    <a class="btn btn-secondary" @click="onEdit(form.id)">
                        Edit
                    </a>
                </div>
            </div>

        </div>
        <!--==================== add modal items ====================-->
        <div class="modal main__modal " :class="{ show: showModel }">
            <div class="modal__content">
                <span class="modal__close btn__close--modal" @click="closeModel()">×</span>
                <h3 class="modal__title">Add Item</h3>
                <hr><br>
                <div class="modal__items">
                    <ul style="list-style-type: none;">

                        <li v-for="(item, i) in listProducts" :key="item.id" style="margin-bottom: 1rem;">
                            <span style="padding-right: 1rem;">{{ i + 1 }}</span>
                            <a href="#">{{ item.item_code }} {{ item.desc }}</a>
                            <button class="caclProduct" @click="AddCart(item)">+</button>
                        </li>
                    </ul>
                </div>
                <br>
                <hr>
                <div class="model__footer">
                    <button class="btn btn-light mr-2 btn__close--modal" @click="closeModel()">
                        Cancel
                    </button>
                    <button class="btn btn-light btn__close--modal ">save</button>
                </div>
            </div>
        </div>
    </div>
</template>