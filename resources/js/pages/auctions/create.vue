<template>
    <Head title="Auctions Create" />
    <AppLayout>
        <h1>Get paid as soon as today!</h1>
        <h3>Start selling now.</h3>

        <div v-if="$page.props?.flash?.message">
            {{ $page.props?.flash.message }}
        </div>
        <form @submit.prevent="submit" class="grid grid-cols-2 gap-2">
            <div>
                <label for="title"
                    >Title:
                    <Input id="title" v-model="form.title" />
                </label>
                <div class="text-red-500" v-if="errors?.title">{{ errors.title }}</div>
                <label for="description"
                    >Description:
                    <Textarea id="description" v-model="form.description" />
                </label>
                <div class="text-red-500" v-if="errors?.description">{{ errors.description }}</div>
            </div>
            <div>
                <label for="buy_now"
                    >Buy Now:
                    <input id="buy_now" v-model="form.buy_now" type="checkbox" />
                </label>
                <div class="text-red-500" v-if="errors?.buy_now">{{ errors.buy_down }}</div>
                <label for="auction_length"
                    >Auction Length:
                    <Input id="auction_length" v-model="form.auction_length" />
                </label>
                <div class="text-red-500" v-if="errors?.auction_length">{{ errors.auction_length }}</div>
            </div>

            <div>
                <label for="starting_price"
                    >Starting Price:
                    <Input id="starting_price" type="number" v-model="form.starting_price" />
                </label>
                <div class="text-red-500" v-if="errors?.starting_price">{{ errors.starting_price }}</div>
                <label for="buy_now_price"
                    >Buy Now Price:
                    <Input id="buy_now_price" type="number" v-model="form.buy_now_price" />
                </label>
                <div class="text-red-500" v-if="errors?.buy_now_price">{{ errors.buy_now_price }}</div>
            </div>
            <div>
                <label for="file"
                    >Upload picture:
                    <input type="file" @change="handleFileChange" multiple />
                </label>
                <div class="text-red-500" v-if="errors?.file">{{ errors.file }}</div>
                <div>
                    Select a category
                    <Select v-model="form.category_id">
                        <SelectTrigger>
                            <SelectValue placeholder="Select a category" />
                        </SelectTrigger>
                        <SelectContent class="bg-white dark:bg-slate-800">
                            <SelectGroup>
                                <SelectItem
                                    v-for="category in $page.props.categories"
                                    :key="category.id"
                                    :value="category.id"
                                    class="text-slate-900 data-[highlighted]:bg-slate-100 dark:text-white dark:data-[highlighted]:bg-slate-700"
                                >
                                    {{ category.name }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
                <div class="text-red-500" v-if="errors?.category_id">{{ errors.category_id }}</div>
            </div>
            <Button type="submit">Submit</Button>
        </form>
    </AppLayout>
</template>

<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { reactive } from 'vue';

defineProps({ errors: Object });

const form = reactive({
    title: '',
    description: '',
    buy_now: '',
    auction_length: '',
    starting_price: '',
    buy_now_price: '',
    file: [],
    category_id: '',
});

function handleFileChange(event: any) {
    for (const file of event.target.files) {
        form.file.push(file);
    }
    console.log(form.file);
    console.log(form.file.length);
}

function submit() {
    router.post('/', form);
}
</script>
