<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link, router } from "@inertiajs/vue3";
import { ref, watch } from "vue";
const props = defineProps({
    students: Object,
    flash: String,
    searchQuery: String
});

const successMessage = ref(props.flash);

const deleteStudent = (id) => {
    // router.delete(route("student.destroy", id));
    router.delete(route("student.destroy", id), {
        onSuccess: () => {
            successMessage.value = "Student deleted successfully!";
        },
    });
};



const goToPage = (page) => {
    console.table(props);
    if (page < 1 || page > props.students.last_page) return;
    router.get(route("student.index"), { page: page }, { preserveState: true });
};

const search = ref(props.searchQuery || "");

const handleSearch = () => {
    router.get(route("student.index"), { search: search.value }, { preserveState: true });
};



</script>

<template>
<Head title="Student" />
<AuthenticatedLayout>
    <div class="w-full h-screen bg-[#0f172a] flex items-center justify-center">
        <div class="w-2/3 h-2/3 bg-[aliceblue] rounded-md p-4">
            <div class="w-full h-full flex flex-col gap-4">
                <!-- Success Message -->
                <div
                    v-if="successMessage"
                    class="bg-green-500 w-full text-white p-2 rounded-md mb-2 text-center"
                >
                    {{ successMessage }}
                </div>

                <!-- header -->
                <div class="w-full h-[4rem] flex justify-end items-center gap-4 border-b border-red-800">
                    <div class="w-[16rem] h-[2rem] flex items-center bg-[#1f2937] rounded-md">
                        <form action="" @submit.prevent="handleSearch" class="w-full h-full flex items-center">
                            <input v-model="search" type="text" placeholder="searching" class="w-[80%] h-full bg-[#1f2937] text-white placeholder:text-gray-400 rounded-tl-md px-3 outline-none focus:ring-0"/>
                            <button class="text-sm text-gray-400 cursor-pointer">search</button>
                        </form>


                    </div>
                    <div class="create-button">
                        <Link :href="route('student.create')" class="py-[0.4rem] px-[1.5rem] bg-[#1f2937] text-white rounded-md">Create</Link>
                    </div>
                </div>
                <!-- table -->
                <div class="w-full">
                    <table class="w-full">
                        <thead class="bg-[#27445D] text-white text-base">
                            <tr>
                                <th class="py-1">Id</th>
                                <th class="py-1">Name</th>
                                <th class="py-1">Class</th>
                                <th class="py-1">Section</th>
                                <th class="py-1">Contact</th>
                                <th class="py-1">Address</th>
                                <th class="py-1">..</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(item, index) in props.students?.data"
                                :key="index"
                                class="odd:bg-[#BCCCDC]"
                            >
                                <td
                                    class="border border-[#A1E3F9] py-1 text-center"
                                >
                                    {{ index + 1 }}
                                </td>
                                <td class="border border-[#A1E3F9] py-1">
                                    {{ item.name }}
                                </td>
                                <td
                                    class="border border-[#A1E3F9] py-1 text-center"
                                >
                                    {{ item.class }}
                                </td>
                                <td
                                    class="border border-[#A1E3F9] py-1 text-center"
                                >
                                    {{ item.section }}
                                </td>
                                <td class="border border-[#A1E3F9] py-1">
                                    {{ item.contact }}
                                </td>
                                <td class="border border-[#A1E3F9] py-1">
                                    {{ item.address }}
                                </td>
                                <td
                                    class="border border-[#A1E3F9] py-1 text-center"
                                >
                                    <div
                                        class="flex gap-1 items-center justify-center"
                                    >
                                        <Link
                                            :href="route('student.show', item.id)"
                                            class="px-2 bg-green-700 rounded-md text-white"
                                        >
                                            Edit
                                        </Link>
                                        <button
                                            @click="deleteStudent(item.id)"
                                            class="px-2 bg-red-700 rounded-md text-white"
                                        >
                                            Del
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                 <!-- Pagination Controls -->
                 <div class="pagination flex justify-center items-center gap-2 my-4">
                    <button
                        v-if="props.students.current_page > 1"
                        @click="goToPage(props.students.current_page - 1)"
                        class="px-4 py-1 bg-gray-700 text-white rounded"
                    >
                        Previous
                    </button>

                    <span class="text-gray-800">
                        Page {{ props.students.current_page }} of {{ props.students.last_page }}
                    </span>

                    <button
                        v-if="props.students.current_page < props.students.last_page"
                        @click="goToPage(props.students.current_page + 1)"
                        class="px-4 py-1 bg-gray-700 text-white rounded"
                    >
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
</AuthenticatedLayout>
</template>


