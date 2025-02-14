<script setup>
import { ref } from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import OrganizationRegisterStepPages from "@/Components/Organization/OrganizationRegisterStepPages.vue";

const emit = defineEmits(["back", "submit"]);
const props = defineProps({
    organizationTypes: {
        type: Array,
        default: [],
    },
    organizationRoles: {
        type: Array,
        default: [],
    },
});
</script>
<template>
    <div>
        <div class="w-full mt-10">
            <h1 class="text-center text-white font-semibold">Organisation</h1>
        </div>
        <OrganizationRegisterStepPages
            @back="emit('back')"
            :organizationTypes="organizationTypes"
            :organizationRoles="organizationRoles"
        ></OrganizationRegisterStepPages>
    </div>
</template>
