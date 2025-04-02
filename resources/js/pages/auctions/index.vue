<template>
    <Head title="All current auctions" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div v-if="flash.success">
            {{ flash.success }}
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            <div v-for="auction in auctions.data" :key="auction.id" class="border-2 border-green-500 p-4">
                <Carousel :id="`gallery-${auction.id}`" v-bind="galleryConfig" v-model="auctionSlides[auction.id]">
                    <Slide v-for="slide in auction.images" :key="'gallery-' + slide.title + auction.id">
                        <img :src="slide.path" class="carousel__item" />
                    </Slide>
                </Carousel>

                <Carousel :id="`thumbnails-${auction.id}`" v-bind="thumbnailsConfig" v-model="auctionSlides[auction.id]">
                    <Slide v-for="slide in auction.images" :key="'thumbnail' + slide.title + auction.id">
                        <template #default="{ currentIndex, isActive }">
                            <div :class="['thumbnail', { 'is-active': isActive }]" @click="slideTo(auction.id, currentIndex)">
                                <img :src="slide.path" alt="Thumbnail Image" class="thumbnail-image" />
                            </div>
                        </template>
                    </Slide>

                    <template #addons>
                        <Nav />
                    </template>
                </Carousel>
                <p class="text-lg font-bold">{{ auction.title }}</p>
                <small class="text-muted text-white">Description: {{ auction.description }}</small>
                <small class="block font-bold text-muted text-white">$ {{ auction.buy_now_price.toFixed(2) }} </small>
            </div>
            <pagination :links="auctions.links" />
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import Pagination from '@/components/Pagination.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { Carousel, Navigation as Nav, Slide } from 'vue3-carousel';
import 'vue3-carousel/carousel.css';

// Create a reactive object to store the current slide for each auction
const auctionSlides = reactive({});

// Initialize the slide position for each auction when data is available
const props = defineProps({
    flash: Object,
    auctions: {
        type: [Object, undefined],
    },
});

// Initialize auction slides when component mounts
if (props.auctions?.data) {
    props.auctions.data.forEach((auction) => {
        auctionSlides[auction.id] = 0;
    });
}

const galleryConfig = {
    itemsToShow: 1,
    wrapAround: true,
    slideEffect: 'fade',
    mouseDrag: false,
    touchDrag: false,
    height: 320,
};

const thumbnailsConfig = {
    height: 80,
    itemsToShow: 6,
    wrapAround: true,
    touchDrag: false,
    gap: 10,
};

// Update to handle auction-specific slides
const slideTo = (auctionId, nextSlide) => {
    auctionSlides[auctionId] = nextSlide;
};
</script>

<style>
:root {
    background-color: #242424;
}

.carousel {
    --vc-nav-background: rgba(255, 255, 255, 0.7);
    --vc-nav-border-radius: 100%;
}

img {
    border-radius: 8px;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.gallery-image {
    border-radius: 16px;
}

#thumbnails {
    margin-top: 10px;
}

.thumbnail {
    height: 100%;
    width: 100%;
    cursor: pointer;
    opacity: 0.6;
    transition: opacity 0.3s ease-in-out;
}

.thumbnail.is-active,
.thumbnail:hover {
    opacity: 1;
}
</style>
