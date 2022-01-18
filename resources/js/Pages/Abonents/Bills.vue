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
            <inertia-link class="btn-indigo" :href="route('bills.create')">
                <span>Создать</span>
                <span class="hidden md:inline">счет</span>
            </inertia-link>
        </div>
        <div class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Номер счета</th>
                    <th class="px-6 pt-6 pb-4">Сумма (руб.)</th>
                    <th class="px-6 pt-6 pb-4">Статус оплаты</th>
                    <th class="px-6 pt-6 pb-4" colspan="2">#</th>
                </tr>
                <tr v-for="bill in bills.data" :key="bill.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <span class="px-6 py-4 flex items-center">
                        {{ bill.bill_number }}
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
                    <!--                    <td class="border-t w-px">-->
                    <!--                        <inertia-link class="px-4 flex items-center" :href="route('organizations.edit', organization.id)" tabindex="-1">-->
                    <!--                            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />-->
                    <!--                        </inertia-link>-->
                    <!--                    </td>-->
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
    },
    data() {
        return {
            form: {
                search: this.filters.search,
                trashed: this.filters.trashed,
            },
        }
    },
    watch: {
        form: {
            deep: true,
            handler: throttle(function () {
                this.$inertia.get(this.route('abonents.bills'), pickBy(this.form), {preserveState: true})
            }, 150),
        },
    },
    methods: {
        reset() {
            this.form = mapValues(this.form, () => null)
        },
    },
}
</script>

