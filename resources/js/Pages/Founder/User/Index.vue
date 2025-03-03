<script setup>
import AuthenticatedFounderLayout from "@/Layouts/AuthenticatedFounderLayout.vue";

const props = defineProps({
    users: {
        type: Array,
        default: [],
    },
});
</script>
<template>
    <AuthenticatedFounderLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Membre de l'organisation
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100"></div>
                </div>
            </div>
        </div>
    </AuthenticatedFounderLayout>
</template>
