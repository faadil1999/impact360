<script setup>
import BeneficiayRegisterStepPages from "@/Components/Beneficiary/BeneficiaryRegisterStepPages.vue";

const props = defineProps({
    userRoles: {
        type: Array,
        default: [],
    },
});

const emit = defineEmits(["back", "submit"]);
</script>
<template>
    <div>
        <BeneficiayRegisterStepPages @back="emit('back')" :userRoles>
        </BeneficiayRegisterStepPages>
    </div>
</template>
