<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import OrganizationForm from "@/Components/Organization/OrganizationForm.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

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

const showRegister = ref(true);
const showOrganization = ref(false);
const showChoiceRole = ref(false);

function showChoiceRoleForm() {
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
        <form v-if="showRegister">
            <!--First name-->
            <div>
                <InputLabel for="first_name" value="First name" />

                <TextInput
                    id="first_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.first_name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.first_name" />
            </div>
            <!--Last name-->

            <div>
                <InputLabel for="last_name" value="Last name" />

                <TextInput
                    id="last_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.last_name"
                    required
                    autofocus
                    autocomplete="last_name"
                />

                <InputError class="mt-2" :message="form.errors.last_name" />
            </div>
            <!--Email-->

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <!--Phone-->
            <div>
                <InputLabel for="phone" value="Phone" />

                <TextInput
                    id="phone"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    required
                    autofocus
                    autocomplete="phone"
                />

                <InputError class="mt-2" :message="form.errors.phone" />
            </div>
            <!--Password-->
            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                >
                    Already registered?
                </Link>

                <PrimaryButton class="ms-4" @click="showChoiceRoleForm()">
                    Suivant
                </PrimaryButton>
                <!-- <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Suivant
                </PrimaryButton> -->
            </div>
        </form>
        <!--Chose role-->
        <div class="flex flex-col" v-if="showChoiceRole">
            <div class="flex flex-row text-center justify-between mt-10">
                <button
                    @click="submitBeneficiary()"
                    class="p-2 rounded-lg bg-blue-400 hover:bg-blue-600 text-white"
                >
                    Beneficiaire
                </button>
                <button
                    class="p-2 rounded-lg bg-green-400 hover:bg-green-500 text-white"
                    @click="showOrganizationForm()"
                >
                    Fondateur
                </button>
            </div>
            <div class="mt-10 text-center w-full">
                <PrimaryButton @click="showRegisterForm()">Back</PrimaryButton>
            </div>
        </div>
        <OrganizationForm
            v-if="showOrganization"
            @submit="submit"
            @back="showChoiceRoleForm()"
        />
    </GuestLayout>
</template>
