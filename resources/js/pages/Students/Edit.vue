<script setup lang="ts">


import AppLayout from '@/layouts/AppLayout.vue';
import { defineProps, onMounted, ref, watch } from 'vue';
import InputError from '@/components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';


const props = defineProps<{
    classes: object,
    student: {
        data: {
            name: string,
            email: string,
            class: { id: number },
            section: { id: number }
        }
    }
}>();
let sections = ref([]);

const form = useForm({
    name: props.student.data.name,
    email: props.student.data.email,
    class_id: props.student.data.class.id,
    section_id: props.student.data.section.id,
});


onMounted(()=> {
    fetchSections(props.student.data.class.id);
})

watch(() => form.class_id,async (newClassId : number) => {
    if (newClassId) {
        await fetchSections(newClassId);
    } else {
        sections.value = [];
    }
});

const fetchSections = async (classId : number) => {
   try
   {
    console.log(`Fetching sections for class ID: ${classId}`);
    
        const response = await axios.get(`/api/sections?class_id=${classId}`);
       sections.value = response.data.data;
   }
   catch (error)
   {
       console.error('Error fetching sections:', error);
   }
};


const updateStudent = () => {
    form.put(route('students.update', props.student.data.id), {
        onSuccess: () => {
            if (form.errors.length === 0) {
                form.reset();
            }
            console.log('FORM ERROR', form.errors);
        },
        onError: (errors) => {
            console.log(errors);
        }
    });
};

</script>

<template>
    <AppLayout>
        <div class="max-w-4xl mx-auto p-6 bg-white shadow rounded-lg mt-10">
            <h2 class="text-2xl font-semibold mb-6">Edit Student</h2>
            <form @submit.prevent="updateStudent" method="POST" class="grid grid-cols-2 md:grid-cols-2 gap-6">
                <!-- Name -->

                <div class="col-span-1">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" v-model="form.name" name="name" id="name" :class="[
                        'w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500',
                        form.errors.name ? 'border-red-500' : 'border-gray-300'
                    ]">
                    <InputError :message="form.errors.name" />
                </div>

                <!-- Email -->
                <div class="col-span-1">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" v-model="form.email" name="email" id="email" :class="[
                        'w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500',
                        form.errors.email ? 'border-red-500' : 'border-gray-300'
                    ]">
                    <InputError :message="form.errors.email" />
                </div>

                <!-- Class -->
                <div class="col-span-1">
                    <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">Class</label>
                    <select name="class_id" id="class_id" v-model="form.class_id" :class="[
                        'w-full px-4 py-2 border rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500',
                        form.errors.class_id ? 'border-red-500' : 'border-gray-300'
                    ]">
                        <option value="">Select Class</option>
                        <option v-for="classItem in classes.data" :key="classItem.id" :value="classItem.id">
                            {{ classItem.name }}
                        </option>
                    </select>
                    <InputError :message="form.errors.class_id" />
                </div>

                <!-- Section -->
                <div class="col-span-1">
                    <label for="section_id" class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                    <select name="section_id" v-model="form.section_id" :class="[
                        'w-full px-4 py-2 border rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500',
                        form.errors.section_id ? 'border-red-500' : 'border-gray-300'
                    ]">
                        <option value="">Select Section</option>
                        <option v-for="section in sections" :key="section.id" :value="section.id">
                            {{ section.name }}
                        </option>
                        <InputError :message="form.errors.section_id" />
                    </select>
                </div>

                <!-- Submit Button (Full Width) -->
                <div class="col-span-1 md:col-span-2">
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300">
                        Create Student
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
