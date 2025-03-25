<template>
    <Head title="All current auctions" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div v-if="flash.success">
            {{ flash.success }}
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            <div v-for="auction in auctions.data" :key="auction.id" class="border-2 border-green-500 p-4">
                <p>Title: {{ auction.title }}</p>
                <p>Description: {{ auction.description }}</p>
                <img :src="auction.image_path" />
            </div>
            <pagination :links="auctions.links" />
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import Pagination from '@/components/Pagination.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    flash: Object,
    auctions: {
        type: [Object, undefined],
    },
});
</script>
