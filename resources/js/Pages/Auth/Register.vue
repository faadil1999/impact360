<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ChoseRoleComponent from "@/Components/Register/ChoseRoleComponent.vue";
import MemberForm from "@/Components/Member/MemberForm.vue";
import TextInput from "@/Components/TextInput.vue";
import OrganizationForm from "@/Components/Organization/OrganizationForm.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    organizationTypes: {
        type: Array,
        default: [],
    },
    organizationRoles: {
        type: Array,
        default: [],
    },
    userRoles: {
        type: Array,
        default: [],
    },
});

const form = useForm({
    first_name: "",
    last_name: "",
    phone: "",
    email: "",
    password: "",
    password_confirmation: "",
    is_creating: false,
    is_registering: false,
    is_beneficary: false,
    organization: {
        creation: {
            name: "",
        },
        registration: {
            code: "",
        },
    },
});

function register() {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
}
// submit beneficiary
function submitBeneficiary() {
    form.is_beneficary = true;
    register();
}

//submit organization
function submit(event) {
    form.organization = event.organization;

    if (!form.is_beneficary) {
        if (form.organization.creation?.name != "") {
            form.is_creating = true;
            form.is_registering = false;
        } else if (form.organization.registration?.code != "") {
            form.is_registering = true;
            form.is_creating = false;
        }
    }
    register();
}

const showRegister = ref(false);
const showOrganization = ref(false);
const showChoiceRole = ref(true);

function choseToBeBeneficiary() {
    form.is_beneficary = true;
    showRegisterForm();
}

function showChoiceRoleForm() {
    form.is_beneficary = false;
    form.is_creating = false;
    form.is_registering = false;

    showRegister.value = false;
    showOrganization.value = false;
    showChoiceRole.value = true;
}

function showOrganizationForm() {
    showChoiceRole.value = false;
    showRegister.value = false;
    showOrganization.value = true;
}

function showRegisterForm() {
    showChoiceRole.value = false;
    showOrganization.value = false;
    showRegister.value = true;
}
</script>

<template>
    <GuestLayout>
        <Head title="Register" />
        <div class="w-full">
            <h1 class="text-center text-white font-semibold">Impact 360</h1>
        </div>

        <MemberForm
            v-if="showRegister"
            @back="showChoiceRoleForm()"
            :userRoles
        ></MemberForm>

        <!--Chose role-->
        <ChoseRoleComponent
            v-if="showChoiceRole"
            @toBeneficiary="showRegisterForm()"
            @toOrganization="showOrganizationForm()"
        />

        <OrganizationForm
            v-if="showOrganization"
            @next="showRegisterForm()"
            @back="showChoiceRoleForm()"
            :organizationTypes="organizationTypes"
            :organizationRoles="organizationRoles"
        />
    </GuestLayout>
</template>
