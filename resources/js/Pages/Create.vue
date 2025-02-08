<script setup>
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

const form = useForm({
    name: "",
    address: "",
    class: "",
    section: "",
    contact: "",
});

function submit() {
    router.post("/create", form);
}
</script>

<template>
    <div class="w-full h-screen bg-[#0F172A] flex justify-center items-center">
        <div class="w-[50rem] bg-white rounded-md p-4">
            <h1 class="text-base font-bold text-center border-b border-red-600">
                Create
            </h1>
            <div class="mt-4">
                <form action="" @submit.prevent="submit">
                    <div class="flex flex-col">
                        <span>Name</span>
                        <input
                            v-model="form.name"
                            type="text"
                            placeholder="Enter the Name"
                            class="w-full h-[2rem] rounded-md text-sm"
                        />
                        <!-- <InputError class="mt-2" :message="router.errors.name" /> -->
                    </div>
                    <div class="flex flex-col">
                        <span>class</span>
                        <input
                            v-model="form.class"
                            type="text"
                            placeholder="Enter the class"
                            class="w-full h-[2rem] rounded-md text-sm"
                        />
                    </div>
                    <div class="flex flex-col">
                        <span>section</span>
                        <input
                            v-model="form.section"
                            type="text"
                            placeholder="Enter the section"
                            class="w-full h-[2rem] rounded-md text-sm"
                        />
                    </div>
                    <div class="flex flex-col">
                        <span>contact</span>
                        <input
                            v-model="form.contact"
                            type="text"
                            placeholder="Enter the contact"
                            class="w-full h-[2rem] rounded-md text-sm"
                        />
                    </div>
                    <div class="flex flex-col">
                        <span>address</span>
                        <input
                            v-model="form.address"
                            type="text"
                            placeholder="Enter the address"
                            class="w-full h-[2rem] rounded-md text-sm"
                        />
                    </div>
                    <div class="w-full flex justify-center items-center mt-4">
                        <button
                            class="py-1 px-5 bg-[#E82561] text-white rounded-md"
                        >
                            submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
