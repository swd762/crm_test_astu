<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">Показания счетчика</h1>
        <div class="mb-6 flex justify-between items-center">
            <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
                <label class="block text-gray-700">Trashed:</label>
                <select v-model="form.trashed" class="mt-1 w-full form-select">
                    <option :value="null"/>
                    <option value="with">With Trashed</option>
                    <option value="only">Only Trashed</option>
                </select>
            </search-filter>
            <inertia-link class="btn-indigo" :href="route('meters.create')">
                <span>Создать</span>
                <span class="hidden md:inline">показания</span>
            </inertia-link>
        </div>
        <div class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Номер</th>
                    <th class="px-6 pt-6 pb-4">Предыдущие показания</th>
                    <th class="px-6 pt-6 pb-4">Последние показания</th>
                    <th class="px-6 pt-6 pb-4">Фактически израсходовано (кв * ч)</th>
                    <th class="px-6 pt-6 pb-4">Дата</th>
                </tr>
                <tr v-for="meter in meters.data" :key="meter.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('meters.edit', meter.id)">
                            {{ meter.id }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('meters.edit', meter.id)" tabindex="-1">
                            {{ meter.meters_previous }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('meters.edit', meter.id)" tabindex="-1">
                            {{ meter.meters_last }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('meters.edit', meter.id)" tabindex="-1">
                            {{ meter.meters_last - meter.meters_previous }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('meters.edit', meter.id)" tabindex="-1">
                            {{ meter.date | moment().format('DD-MM-YYYY') }}
                        </inertia-link>
                    </td>
                    <td class="border-t w-px">
                        <inertia-link class="px-4 flex items-center" :href="route('meters.edit', meter.id)" tabindex="-1">
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
                this.$inertia.get(this.route('user.meters'), pickBy(this.form), {preserveState: true})
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
