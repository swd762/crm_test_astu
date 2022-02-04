<template>
    <div>
        <div class="mb-4">
            <inertia-link  class="flex items-center group py-3" :href="route('dashboard')">
                <icon name="dashboard" class="w-4 h-4 mr-2" :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
                <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Личный кабинет</div>
            </inertia-link>
        </div>
        <div class="mb-4">
            <inertia-link v-if="$page.props.auth.user.role==='user'" class="flex items-center group py-3" :href="route('bills')">
                <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('bills') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
                <div :class="isUrl('bills') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Счета</div>
            </inertia-link>
        </div>
        <div class="mb-4">
            <inertia-link v-if="$page.props.auth.user.role==='user'" class="flex items-center group py-3" :href="route('meters')">
                <icon name="users" class="w-4 h-4 mr-2" :class="isUrl('meters') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
                <div :class="isUrl('meters') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Показания счетчика</div>
            </inertia-link>
        </div>
        <div class="mb-4">
            <inertia-link v-if="$page.props.auth.user.role==='user'" class="flex items-center group py-3" :href="route('reports')">
                <icon name="printer" class="w-4 h-4 mr-2" :class="isUrl('reports') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
                <div :class="isUrl('reports') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Отчеты</div>
            </inertia-link>
        </div>
        <div class="mb-4">
            <inertia-link v-if="$page.props.auth.user.role==='admin'" class="flex items-center group py-3" :href="route('abonents')">
                <icon name="printer" class="w-4 h-4 mr-2" :class="isUrl('abonents') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
                <div :class="isUrl('abonents') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Абоненты</div>
            </inertia-link>
        </div>

    </div>
</template>

<script>
import Icon from '@/Shared/Icon'

export default {
    components: {
        Icon,
    },
    methods: {
        isUrl(...urls) {
            let currentUrl = this.$page.url.substr(1)
            if (urls[0] === '') {
                return currentUrl === ''
            }
            return urls.filter(url => currentUrl.startsWith(url)).length
        },
    },
}
</script>
