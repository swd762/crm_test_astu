<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('abonents')">Список абонентов</inertia-link>
            <span class="text-indigo-400 font-medium">/</span> Счет по показаниям
        </h1>
        <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="store">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input type="Number" disabled v-model.number="form.previous" :error="form.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Прошлые показания"/>
                    <text-input type="Number" disabled v-model.number="form.last" :error="form.errors.email" class="pr-6 pb-8 w-full lg:w-1/2" label="Последние показания"/>
                </div>
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input type="Number" v-model.number="form.tarif" :error="form.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Тариф"/>
                </div>
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input type="Number" disabled v-model.number="form.amount" :error="form.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Сумма"/>
                </div>
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
                    <loading-button :loading="form.processing" class="btn-indigo" type="submit">Создать счет</loading-button>
                </div>
            </form>
        </div>

    </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TextInput from '@/Shared/TextInput'

export default {
    name: "CreateFromMeters",
    metaInfo: {title: 'Счет по показаниям'},
    components: {
        Icon,
        Pagination,
        // SearchFilter,
        SelectInput,
        LoadingButton,
        TextInput
    },
    layout: Layout,
    props: {
        meters: Object,
    },
    data() {
        return {
            form: this.$inertia.form({
                previous: this.meters.previous,
                last: this.meters.last,
                amount:null ,
                tarif: 5
            }),
        }
    },
    created() {
        this.getData();
    },
    watch: {
        'form.tarif': function (val) {
            this.form.amount = (this.form.last - this.form.previous) * val;
        },
    },
    methods: {
        getData() {
            this.form.amount = (this.form.last - this.form.previous) * this.form.tarif;
        },
        store() {
            this.form.post(this.route('bills.store.meters', this.meters.id))
        },
    },
}
</script>

<style scoped>

</style>
