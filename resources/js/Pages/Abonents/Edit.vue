<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('meters')">Показания</inertia-link>
            <span class="text-indigo-400 font-medium">/</span> Edit
        </h1>
        <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="update">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input type="Number" v-model.number="form.meters_previous" :error="form.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Прошлые показания"/>
                    <text-input type="Number" v-model.number="form.meters_last" :error="form.errors.email" class="pr-6 pb-8 w-full lg:w-1/2" label="Последние показания"/>
                </div>
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
                    <loading-button :loading="form.processing" class="btn-indigo mr-5" type="submit">Удалить</loading-button>
                    <loading-button :loading="form.processing" class="btn-indigo" type="submit">Обновить</loading-button>
                </div>
            </form>
        </div>
    </div>


</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
    metaInfo() {
        return { title: this.form.name }
    },
    components: {
        Icon,
        LoadingButton,
        SelectInput,
        TextInput,
        TrashedMessage,
    },
    layout: Layout,
    props: {
        abonents: Object,
    },
    remember: 'form',
    data() {

        return {
            form: this.$inertia.form({
                meters_previous: this.meters.meters_previous,
                meters_last: this.meters.meters_last,
            }),
        }
    },
    methods: {
        update() {
            this.form.put(this.route('meters.update', this.meters.meters.id))
        },
    },
}
</script>
