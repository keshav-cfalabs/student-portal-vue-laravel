<script setup lang="ts">
// import { usePage } from '@inertiajs/vue3';
import { defineProps } from 'vue';

import {router} from '@inertiajs/vue3';

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


const updateList = (link) => {
    const pageNumber = link.url.split("=")[1];
    if (pageNumber) {
        router.visit('/students?page=' + pageNumber,{
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
            <button v-for="link in data.meta.links" :key="link.label" :class="['px-3', 'py-1', 'bg-gray-200', 'text-gray-700', 'rounded', 'hover:bg-gray-300', { 'bg-blue-500': link.url==null }]"
                    @click="updateList(link)">
               <span v-html="link.label"></span>
            </button>
        </div>
    </div>
</template>

<style scoped></style>