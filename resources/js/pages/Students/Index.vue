<script setup lang="ts">

import { computed, defineProps, ref, watch } from 'vue';

import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import Pagination from '@/components/Pagination.vue';
import { Link,router } from '@inertiajs/vue3';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const searchQuery = ref('');


const data = defineProps({
    students: {
        type: Object,
        required: true,
        default: () => ({
            data: []
        })
    }
});



const studentUrl = computed(() => {
    const url = new URL(route('students.index'));
    if (searchQuery.value) {
        url.searchParams.set('search', searchQuery.value);
         url.searchParams.set('page', 1);
    } else {
        url.searchParams.delete('search');
    }
    return url.toString();
});


watch(studentUrl, (newURL) => {
    router.visit(newURL, {
        preserveState: true,
        preserveScroll: true,
    });
});

</script>

<template>

    <Head title="Student" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-semibold">Students</h1>
                <input type="text" placeholder="Search..." name="search" class="border rounded px-4 py-2"
                    v-model="searchQuery" />
                <Link :href="route('students.create')"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                Create Student
                </Link>

            </div>
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Email</th>
                        <th class="px-4 py-2 border">Class</th>
                        <th class="px-4 py-2 border">Section</th>
                        <th class="px-4 py-2 border">Created At</th>
                        <th class="px-4 py-2 border">Actions</th>

                    </tr>
                </thead>
                <tbody>
                    <tr v-for="student in data.students.data" :key="student.id" class="hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ student.id }}</td>
                        <td class="px-4 py-2 border">{{ student.name }}</td>
                        <td class="px-4 py-2 border">{{ student.email }}</td>
                        <td class="px-4 py-2 border">{{ student.class.name }}</td>
                        <td class="px-4 py-2 border">{{ student.section.name }}</td>
                        <td class="px-4 py-2 border">{{ student.created_at }}</td>
                        <td class="px-4 py-2 border">
                            <Link :href="route('students.edit', student.id)" class="text-blue-500 hover:underline">Edit
                            </Link>

                            <!-- <button @click="editStudent(student.id)" class="text-blue-500 hover:underline">Edit</button>
                        <button @click="deleteStudent(student.id)" class="text-red-500 hover:underline">Delete</button> -->
                        </td>
                    </tr>
                </tbody>
                <tfoot class="bg-gray-100 m-4">
                    <tr>
                        <td colspan="7">
                            <Pagination :data="data.students" />
                        </td>
                    </tr>
                </tfoot>
            </table>

        </div>
    </AppLayout>

</template>


<style></style>