<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('abonents')">Список абонентов</inertia-link>
            <span class="text-indigo-400 font-medium">/</span> Счета абонента
        </h1>
        <div class="mb-6 flex justify-between items-center">
            <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
                <label class="block text-gray-700">Trashed:</label>
                <select v-model="form.trashed" class="mt-1 w-full form-select">
                    <option :value="null"/>
                    <option value="with">With Trashed</option>
                    <option value="only">Only Trashed</option>
                </select>
            </search-filter>
            <inertia-link class="btn-indigo" :href="route('bills.create', account.id)">
                <span>Создать</span>
                <span class="hidden md:inline">счет</span>
            </inertia-link>
        </div>
        <div class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Номер счета</th>
                    <th class="px-6 pt-6 pb-4">Дата</th>
                    <th class="px-6 pt-6 pb-4">Сумма (руб.)</th>
                    <th class="px-6 pt-6 pb-4">Статус оплаты</th>
                    <th class="px-6 pt-6 pb-4 text-center" colspan="2">#</th>
                </tr>
                <tr v-for="bill in bills.data" :key="bill.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <span class="px-6 py-4 flex items-center">
                        {{ bill.id }}
                        </span>
                    </td>
                    <td class="border-t">
                        <span class="px-6 py-4 flex items-center">
                        {{ bill.created_at | moment().format('DD-MM-YYYY') }}
                        </span>
                    </td>
                    <td class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            {{ bill.amount }}
                        </span>
                    </td>
                    <td class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            {{ bill.is_paid ? 'Оплачен' : 'Не оплачен' }}
                        </span>
                    </td>
                    <td class="border-t w-px px-2">
                        <inertia-link class="btn-indigo" :href="route('abonents.bills.delete', [account.id, bill.id])">
                            <span>Удалить</span>
                        </inertia-link>
                    </td>
                </tr>
                <tr v-if="bills.data.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">Счетов не найдено</td>
                </tr>
            </table>
        </div>
        <pagination class="mt-6" :links="bills.links"/>
    </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import SearchFilter from '@/Shared/SearchFilter'

export default {
    metaInfo: {title: 'Счета абонента'},
    components: {
        Icon,
        Pagination,
        SearchFilter,
    },
    layout: Layout,
    props: {
        filters: Object,
        bills: Object,
        account: Object
    },
    data() {
        return {
            form: {
                search: this.filters.search,
                trashed: this.filters.trashed,
            },
        }
    },
    watch: {},
    methods: {
        reset() {
            this.form = mapValues(this.form, () => null)
        },
        delete() {

        },
    },
}
</script>

