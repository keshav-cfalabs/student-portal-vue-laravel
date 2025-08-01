<script setup lang="ts">
// import { usePage } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import { ref } from 'vue';

import { router } from '@inertiajs/vue3';

defineProps({
    data: {
        type: Object,
        required: true,
        default: () => ({
            students: {
                data: []
            }
        })
    }
});

let url = ref('');

const updateList = (link) => {
    url.value = link.url;
    const pageNumber = link.url.split("=")[1];
    if (pageNumber) {
        router.visit('/students?page=' + pageNumber, {
            preserveScroll: true,
        });
    }
};


</script>

<template>
    <!-- {{ data }} -->
    <div class="flex justify-between items-center mt-4">
        <!-- Showing Text (Left) -->
        <div class="text-sm text-gray-600">
            Showing {{ data.meta.from }} to {{ data.meta.to }} of {{ data.meta.total }} results
        </div>

        <!-- Pagination Buttons (Right) -->
        <div class="flex space-x-1">
            <button v-for="link in data.meta.links" :key="link.label"
             class="px-3 py-1 rounded"
            :class="[
                link.active ? 'bg-blue-500 text-white' : 'hover:bg-gray-200',
                !link.url ? 'text-gray-400 cursor-not-allowed' : ''
            ]"
                @click="updateList(link)">
                <span v-html="link.label"></span>
            </button>
        </div>
    </div>
</template>

<style scoped></style>