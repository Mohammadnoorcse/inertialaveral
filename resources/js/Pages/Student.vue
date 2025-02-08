<script setup>
import { Link, router } from "@inertiajs/vue3";
import { ref, watch } from "vue";
const props = defineProps({
    students: Object,
    flash: String, // Receive success message
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
</script>

<template>
    <div class="student">
        <div class="content">
            <div class="main">
                <!-- Success Message -->
                <div
                    v-if="successMessage"
                    class="bg-green-500 w-full text-white p-2 rounded-md mb-2 text-center"
                >
                    {{ successMessage }}
                </div>
                <!-- header -->
                <div class="header-item border-b border-red-800">
                    <div class="searching">
                        <form action="">
                            <input type="text" placeholder="searching" />
                            <button>search</button>
                        </form>
                    </div>
                    <div class="create-button">
                        <Link :href="route('student.create')">Create</Link>
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
                                v-for="(item, index) in props.students"
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
            </div>
        </div>
    </div>
</template>

<style>
.student {
    width: 100vw;
    height: 100vh;
    background: #0f172a;
    display: flex;
    align-items: center;
    justify-content: center;
}

.content {
    width: 70rem;
    height: 50rem;
    background-color: aliceblue;
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.main {
    width: 68rem;
    height: 48rem;
    background-color: white;
    border-radius: 1rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.header-item {
    width: 100%;
    height: 4rem;
    display: flex;
    justify-content: end;
    align-items: center;
    gap: 1rem;
}
.searching {
    width: 16rem;
    height: 2rem;
    display: flex;
    align-items: center;
    background: #1f2937;
    border-radius: 5px;
}
.searching form {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
}
.searching form input {
    width: 85%;
    height: 100%;
    outline: none !important;
    border: none !important;
    background: #1f2937;
    border-radius: 5px;
    font-size: 14px;
    color: white;
}
.searching form button {
    color: gray;
    font-size: 14px;
    padding-right: 5px;
}
.create-button a {
    padding: 0.4rem 1.5rem;
    background-color: #1f2937;
    color: white;
    border-radius: 5px;
}
</style>
