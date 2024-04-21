<script setup>

import UserLayout from "@/Pages/User/Layouts/UserLayout.vue";
import {computed, reactive} from "vue";
import {router, usePage} from "@inertiajs/vue3";

//const props = defineProps({})
const carts = computed(() =>usePage().props.cart.data.items);
const products = computed(() =>usePage().props.cart.data.products);
//console.log(products)
const total = computed(() =>usePage().props.cart.data.total);
const itemId = (id) => carts.value.findIndex((item) => item.product_id === id);

defineProps({
    userAddress :Object
})

/**Update from the cart*/
const update = (product, quantity) => {
  router.patch(route("cart.update", product) , {
      quantity: quantity
  })
}

/**Remove from the cart*/
const remove = (product) => {
    router.delete(route("cart.delete", product) , {

    })
}
/**form data  reactive*/
const form  = reactive({
    address1 : null,
    state: null,
    city: null,
    zipcode:null,
    province:null,
    country_code:null,
    country:null,
    type:null
})


/**validating */
const formFilled = computed(()=>{
    return (form.address1 !== null &&
        form.state !== null &&
        form.city !== null &&
        form.zipcode !== null &&
        form.province !== null &&
        form.country_code !== null &&
        form.country !== null &&
        form.type !== null )
})
/**Confirm Order*/
const submit = () => {
    router.visit(route('checkout.store'),{
        method: 'post',
        data: {
            carts:usePage().props.cart.data.items,
            products:usePage().props.cart.data.products,
            total:usePage().props.cart.data.total,
            address:form
        },
    })
}
</script>

<template>
<UserLayout>
    <section class="text-gray-600 body-font relative">
        <div class="container px-5 py-24 mx-auto flex sm:flex-nowrap flex-wrap">
            <!----- List of Cart Item overflow-hidden flex items-end justify-start relative ----->
            <div class="lg:w-2/3 md:w-1/2 rounded-lg  sm:mr-10 p-10 ">
                <!----- List of Cart Item  ----->

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-16 py-3">
                                <span class="sr-only">Image</span>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Product
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Qty
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Price
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="product in products"  :key="product.id"

                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <!-- product.product_images &&     -->
                            <td class="p-4">
                                <img

                                    v-if="product.product_images.length > 0"
                                    :src="`/${product.product_images[0].image}`"

                                    class="w-16 md:w-32 max-w-full max-h-full" alt="Apple Watch">

                                <img  v-else
                                    src="data:image/png;base64,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"

                                    class="w-16 md:w-32 max-w-full max-h-full" alt="Apple Watch">
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                {{ product.title }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <button
                                        @click.prevent="update(product , carts[itemId(product.id)].quantity  - 1)"
                                        :disabled="carts[itemId(product.id)].quantity <= 1"
                                        :class="[carts[itemId(product.id)].quantity > 1 ? 'cursor-pointer text-purple-600' : 'cursor-not-allowed text-gray-300 dark:text-gray-500', 'inline-flex items-center justify-center p-1 text-sm font-medium h-6 w-6 text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700']"
                                        type="button">
                                        <span class="sr-only">Quantity button</span>
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                                        </svg>
                                    </button>
                                    <div>
                                        <input
                                            v-model="carts[itemId(product.id)].quantity"
                                            type="number"
                                            id="first_product"
                                            class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="1" required />
                                    </div>
                                    <button
                                        @click.prevent="update(product , carts[itemId(product.id)].quantity  + 1)"
                                        class="inline-flex items-center justify-center h-6 w-6 p-1 ms-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                                        <span class="sr-only">Quantity button</span>
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                $ {{  product.price }}
                            </td>
                            <td class="px-6 py-4">
                                <a
                                    @click="remove(product)"
                                    href="#"
                                   class="font-medium text-red-600 dark:text-red-500 hover:underline">Remove</a>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <!----- End of Cart Item  ----->
            </div>
            <div class="lg:w-1/3 md:w-1/2 bg-white flex flex-col md:ml-auto w-full md:py-8 mt-8 md:mt-0">
                <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Summary</h2>
                <p class="leading-relaxed mb-5 text-gray-600">Total : $ {{ total }}</p>

                <div  v-if="userAddress">
                    <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Shipping  Address</h2>
                    <p class="leading-relaxed mb-5 text-gray-600">{{ userAddress.address1}} , {{ userAddress.city}} {{ userAddress.zipcode}}   </p>
                    <p class="leading-relaxed mb-5 text-gray-600">1234 st examplle , usa , ny , 122333 </p>
                </div>
                <div else>
                    <p class="leading-relaxed mb-5 text-gray-600">Add the shipping Address to continue</p>
                </div>


                <form  @submit.prevent="submit" action="">
                    <div class="relative mb-4">
                        <label for="address" class="leading-7 text-sm text-gray-600">Address 1</label>
                        <input
                            v-model="form.address1"
                            type="text"
                            id="address1"
                            name="address1" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <div class="relative mb-4">
                        <label for="city" class="leading-7 text-sm text-gray-600">City </label>
                        <input
                            v-model="form.city"
                            type="text"
                            id="city"
                            name="city"
                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <div class="relative mb-4">
                        <label for="state" class="leading-7 text-sm text-gray-600">State</label>
                        <input
                            v-model="form.state"
                            type="text"
                            id="state"
                            name="state"
                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <div class="relative mb-4">
                        <label for="zipcode" class="leading-7 text-sm text-gray-600">ZipCode</label>
                        <input
                            v-model="form.zipcode"
                            type="text"
                            id="zipcode"
                            name="zipcode"
                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <div class="relative mb-4">
                        <label for="zipcode" class="leading-7 text-sm text-gray-600">Province</label>
                        <input
                            v-model="form.province"
                            type="text"
                            id="province"
                            name="province"
                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <div class="relative mb-4">
                        <label for="country" class="leading-7 text-sm text-gray-600">Country Code</label>
                        <input
                            v-model="form.country_code"
                            type="text"
                            id="country"
                            name="country_code"
                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <div class="relative mb-4">
                        <label for="country" class="leading-7 text-sm text-gray-600">Country</label>
                        <input
                            v-model="form.country"
                            type="text"
                            id="country"
                            name="country"
                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <div class="relative mb-4">
                        <label for="type" class="leading-7 text-sm text-gray-600">Adddress Type</label>
                        <input
                            v-model="form.type"
                            type="text"
                            id="type"
                            name="type"
                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>

                    <button
                        v-if="formFilled  || userAddress"
                        type="submit"
                            class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                        Checkout
                    </button>

                    <button
                        v-else
                        type="submit"
                        class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                        Add Address to continue
                    </button>
                </form>

                <p class="text-xs text-gray-500 mt-3">Continue Shopping with us</p>
            </div>
        </div>
    </section>
</UserLayout>
</template>

<style scoped>

</style>


<!--<div class="relative mb-4">-->
<!--<label for="message" class="leading-7 text-sm text-gray-600">Message</label>-->
<!--<textarea id="message" name="message" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>-->
<!--</div>-->
