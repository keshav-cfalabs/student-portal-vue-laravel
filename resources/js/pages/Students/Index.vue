<script setup lang="ts">

import { defineProps } from 'vue';

import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import Pagination from '@/components/Pagination.vue';
import { Link } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];


const data = defineProps({
    students: {
        type: Object,
        required: true,
        default: () => ({
            data: []
        })
    }
});
const editStudent = (id) => {
    console.log('Edit student with ID:', id);
};
const deleteStudent = (id) => {
    console.log('Delete student with ID:', id);
};
</script>

<template>

    <Head title="Student" />

     <AppLayout :breadcrumbs="breadcrumbs">

    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold">Students</h1>
            <Link :href="route('students.create')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
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
                        <button @click="editStudent(student.id)" class="text-blue-500 hover:underline">Edit</button>
                        <button @click="deleteStudent(student.id)" class="text-red-500 hover:underline">Delete</button>
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