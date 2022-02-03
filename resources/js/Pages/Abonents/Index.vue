<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">Список абонентов</h1>
        <div class="mb-6 flex justify-between items-center">
            <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
                <label class="block text-gray-700">Trashed:</label>
                <select v-model="form.trashed" class="mt-1 w-full form-select">
                    <option :value="null"/>
                    <option value="with">With Trashed</option>
                    <option value="only">Only Trashed</option>
                </select>
            </search-filter>
        </div>
        <div class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">id</th>
                    <th class="px-6 pt-6 pb-4">Лицевой счет</th>
                    <th class="px-6 pt-6 pb-4">Фамилия</th>
                    <th class="px-6 pt-6 pb-4">Имя</th>
                    <th class="px-6 pt-6 pb-4">#</th>
                </tr>
                <tr v-for="abonent in abonents.data" :key="abonent.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <span class="px-6 py-4 flex items-center focus:text-indigo-500">
                            {{ abonent.id }}
                        </span>
                    </td>
                    <td class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            {{ abonent.account.account_num }}
                        </span>
                    </td>
                    <td class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            {{ abonent.last_name }}
                        </span>
                    </td>
                    <td class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            {{ abonent.first_name }}
                        </span>
                    </td>
                    <td class="border-t">
                        <inertia-link class="btn-indigo" :href="route('abonents.meters', abonent.account_id)" >
                            <span>Показания</span>
                        </inertia-link>
                        <inertia-link class="btn-indigo" :href="route('abonents.bills',abonent.account_id)">
                            <span>Счета</span>
                        </inertia-link>
<!--                        <inertia-link class="flex items-center" :href="route('abonents.meters', abonent.account_id)" tabindex="-1">-->
<!--                            <span class="px-6 py-4 flex items-center">Показания</span>-->
<!--                            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400"/>-->
<!--                        </inertia-link>-->
<!--                        <inertia-link class="flex items-center" :href="route('abonents.bills',abonent.account_id)">-->
<!--                            <span class="px-6 py-4 flex items-center">Счета</span>-->
<!--                            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400"/>-->
<!--                        </inertia-link>-->
                    </td>
                </tr>
                <tr v-if="abonents.data.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">Показаний не найдено</td>
                </tr>
            </table>
        </div>
        <pagination class="mt-6" :links="abonents.links"/>
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
    metaInfo: {title: 'Список абонентов'},
    components: {
        Icon,
        Pagination,
        SearchFilter,
    },
    layout: Layout,
    props: {
        filters: Object,
        abonents: Object,
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
                this.$inertia.get(this.route('abonents'), pickBy(this.form), {preserveState: true})
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

