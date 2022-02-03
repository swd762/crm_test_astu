<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('abonents.bills', account.id)">Счета</inertia-link>
            <span class="text-indigo-400 font-medium">/</span>Новый счет
        </h1>
        <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="store">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input type="Number" v-model.number="form.amount" :error="form.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Сумма"/>
                </div>
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
                    <loading-button :loading="form.processing" class="btn-indigo" type="submit">Создать счет</loading-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'

export default {
    name: "Create",
    metaInfo: {title: 'Создание счета'},
    components: {
        LoadingButton,
        SelectInput,
        TextInput,
    },
    layout: Layout,
    remember: 'form',
    props: {
        account: Object,
    },
    data() {
        return {
            form: this.$inertia.form({
                amount:null
            }),
        }
    },
    methods: {
        store() {
            this.form.post(this.route('bills.store', this.account.id))
        },
    },
}
</script>

<style scoped>

</style>
