<script setup>
const emit = defineEmits(["toBeneficiary", "toOrganization"]);
</script>
<template>
    <div class="flex flex-col mb-10">
        <div
            class="flex flex-row text-center justify-between mt-10 space-x-12 w-full"
        >
            <div
                @click="emit('toBeneficiary')"
                class="p-2 rounded-lg bg-blue-400 hover:bg-blue-600 text-white w-1/2 cursor-pointer"
            >
                <h2 class="font-bold">Beneficiaire/Contributeur</h2>
                <p class="mt-2">
                    En tant que beneficiaire, vous avez la capacitee de ...
                </p>
            </div>
            <div
                class="p-2 rounded-lg bg-green-400 hover:bg-green-500 text-white w-1/2 cursor-pointer"
                @click="emit('toOrganization')"
            >
                <h2 class="font-bold">Organisation</h2>
                <p>Dans cette partie vous avez la capacitee de ....</p>
            </div>
        </div>
    </div>
</template>
