<script setup>
import dayjs from 'dayjs';
import { Link, router, useForm, usePage } from '@inertiajs/vue3'
import { ref } from 'vue'

defineProps({
   orders: Object,
 })

const searchValue = ref('');

function toHumanReadableTime(timestamp) {
    const date = dayjs(timestamp);
    return date.format('YYYY-MM-DD');
}

function search() {
    router.visit('/?searchParam=' + searchValue.value,{ preserveState: true,});
}
function clear() {
    router.visit('/');
}
</script>


<template>

    <div class="container px-md-3 py-5" v-if="orders==null">
        <h1 class="text-center display-2 border p-4">No Orders Yet!</h1>
    </div>
  <div class="container-fluid px-md-3 py-5">
    <form @submit.prevent="search" class="">
        <input type="text" v-model="searchValue" placeholder="Search by username, product name or order #" 
        class="border px-2 py-2 mr-2 w-25" style="font-size: small;">
        <button type="button" class="btn btn-dark rounded-none mr-1" @click="search">Search</button>
        <button type="button" class="btn btn-outline-dark rounded-none" @click="clear">Clear</button>
    </form>
    <br>
 <table class="table ">
  <thead>
    <tr>
      <th scope="col">ORDER ID</th>
      <th scope="col">ORDER #</th>
      <th scope="col">USERNAME</th>
      <th scope="col">PRODUCT</th>
      <th scope="col">QTY</th>
      <th scope="col">AMOUNT</th>
      <th scope="col">DATE</th>
    </tr>
  </thead>
  <tbody class="">
    <tr v-for="order in orders.data">
      <td>
        <span class="fs-9">{{ order.id }}</span>
      </td>
      <td>
        <span class="fs-9">{{ order.order_number }}</span>
      </td>
      <td>
        <span class="fs-9">{{ order.user.fullname }}</span>
      </td>
      <td>
        <span class="fs-9">{{ order.product.name }}</span>
      </td>
      <td>
        <span class="fs-9">{{ order.quantity }}</span>
      </td>
      <td>
        <span class="fs-9">{{ order.amount }}</span>
      </td>
      <td>
        <span class="fs-8">{{ toHumanReadableTime(order.created_at) }}</span>
      </td>
    </tr>
  </tbody>

  </table>

  <div class="container position-absolute border-bottom py-3 border-black" v-if="orders.prev_page_url || orders.next_page_url"> 
        <div class="d-flex justify-content-between">
        <div class="p-1" >
              <Link v-if="orders.prev_page_url" :href="orders.prev_page_url"
               class="btn btn-outline-secondary rounded-0 mt-2 px-4">
                PREVIOUS PAGE
                </Link>
        </div>
        <div class="p-1">
          <h6 class="fw-light py-2 text-light">Showing {{ orders.from }} - {{ orders.to }} of {{ orders.total }} orders</h6>
        </div>
        <div class="p-1" >
            <Link v-if="orders.next_page_url" :href="orders.next_page_url" 
            class="btn btn-outline-secondary rounded-0 mt-2 px-4 fs-8">
              NEXT PAGE
              </Link>
        </div>
      </div>
      </div>
</div>
</template>
