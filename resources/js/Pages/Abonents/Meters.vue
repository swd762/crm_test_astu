<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('abonents')">Список абонентов</inertia-link>
            <span class="text-indigo-400 font-medium">/</span> Показания счетчика абонента
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
            <!--            <inertia-link class="btn-indigo" :href="route('meters.create')">-->
            <!--                <span>Создать</span>-->
            <!--                <span class="hidden md:inline">показания</span>-->
            <!--            </inertia-link>-->
        </div>
        <div class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="px-3 pt-2 pb-2">Номер</th>
                    <th class="px-3 pt-2 pb-2">Предыдущие показания</th>
                    <th class="px-3 pt-2 pb-2">Последние показания</th>
                    <th class="px-3 pt-2 pb-2">Фактически израсходовано (кв * ч)</th>
                    <th class="px-3 pt-2 pb-2">Дата</th>
                    <th class="px-3 pt-2 pb-2">#</th>
                </tr>
                <tr v-for="meter in meters.data" :key="meter.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <span class="px-4 py-2 flex items-center">
                            {{ meter.id }}
                        </span>
                    </td>
                    <td class="border-t">
                         <span class="px-4 py-2 flex items-center">
                            {{ meter.meters_previous }}
                         </span>
                    </td>
                    <td class="border-t">
                         <span class="px-4 py-2 flex items-center">
                            {{ meter.meters_last }}
                         </span>
                    </td>
                    <td class="border-t">
                         <span class="px-4 py-2 flex items-center">
                            {{ meter.meters_last - meter.meters_previous }}
                         </span>
                    </td>
                    <td class="border-t">
                         <span class="px-4 py-2 flex items-center">
                            {{ meter.date | moment().format('DD-MM-YYYY') }}
                         </span>
                    </td>
                    <td class="border-t w-px">
                        <inertia-link class="flex items-center" :href="route('bills.create.meters',meter.id)" tabindex="-1">
                            <span class="px-2 py-2 flex items-center">выставить счет</span>
                            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400"/>
                        </inertia-link>
                    </td>
                </tr>
                <tr v-if="meters.data.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">Показаний не найдено</td>
                </tr>
            </table>
        </div>
        <pagination class="mt-6" :links="meters.links"/>
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
    metaInfo: {title: 'Показания счетчика'},
    components: {
        Icon,
        Pagination,
        SearchFilter,
    },
    layout: Layout,
    props: {
        filters: Object,
        meters: Object,
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
                this.$inertia.get(this.route('abonents.meters'), pickBy(this.form), {preserveState: true})
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

