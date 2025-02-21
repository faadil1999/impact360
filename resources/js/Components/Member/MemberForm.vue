<script setup>
import MemberRegisterStepPages from "@/Components/Member/MemberRegisterStepPages.vue";

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
        <MemberRegisterStepPages @back="emit('back')" :userRoles>
        </MemberRegisterStepPages>
    </div>
</template>
