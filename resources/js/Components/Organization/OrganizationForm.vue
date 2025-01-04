<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const emit = defineEmits(["back", "submit"]);

const form = useForm({
    organization: {
        creation: {
            name: "",
        },
        registration: {
            code: "",
        },
    },
});
const showCreationForm = ref(true);
const showRegisterCodeForm = ref(false);
function toggleAction() {
    if (showCreationForm.value == true) {
        form.creation = null;
    }
    if (showRegisterCodeForm.value == true) {
        form.register = null;
    }
    showCreationForm.value = !showCreationForm.value;
    showRegisterCodeForm.value = !showRegisterCodeForm.value;
}
</script>
<template>
    <div>
        <div class="w-full mt-10">
            <h1 class="text-center text-white font-semibold">Organisation</h1>
        </div>
        <div v-if="showCreationForm">
            <InputLabel for="name" value="Name" />

            <TextInput
                id="name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.organization.creation.name"
                required
                autofocus
                autocomplete="name"
            />

            <InputError
                class="mt-2"
                :message="form.errors.organization?.creation.name"
            />
            <div class="mt-4 flex items-center justify-end">
                <p
                    @click="toggleAction()"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800 cursor-pointer"
                >
                    Avez vous un code d'inscription pour une organisation?
                </p>
            </div>
        </div>

        <div v-if="showRegisterCodeForm">
            <InputLabel for="name" value="Code d'inscription" />
            <TextInput
                id="name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.organization.registration.code"
                required
                autofocus
                autocomplete="name"
            />
            <InputError
                class="mt-2"
                :message="form.errors.organization?.registration.name"
            />
            <div class="mt-4 flex items-center justify-end">
                <p
                    @click="toggleAction()"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800 cursor-pointer"
                >
                    Voulez vous creer une organisation?
                </p>
            </div>
        </div>
        <div class="flex flex-row justify-between my-10">
            <PrimaryButton @click="emit('back')">Retour</PrimaryButton>
            <PrimaryButton @click="emit('submit', form)"
                >Enregistrer</PrimaryButton
            >
        </div>
    </div>
</template>
