<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import SplitButton from "primevue/splitbutton";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const showingNavigationDropdown = ref(false);

import { useToast } from "primevue/usetoast";
const toast = useToast();

const userProfil = () => {
    router.get(route("profile.edit"), {});
};
function logout() {
    router.post(route("logout"));
}

const items = [
    {
        label: "Profil",
        command: () => {
            router.get(route("profile.edit"), {});
        },
    },
    {
        label: "Delete",
        command: () => {
            toast.add({
                severity: "warn",
                summary: "Delete",
                detail: "Data Deleted",
                life: 3000,
            });
        },
    },
    {
        separator: true,
    },
    {
        label: "Quit",
        command: () => {
            router.post(route("logout"), {});
        },
    },
];
</script>

<template>
    <header
        class="bg-white shadow dark:bg-gray-800 w-full flex justify-end h-16"
    >
        <div class="hidden sm:ms-6 sm:flex sm:items-center">
            <SplitButton
                :model="items"
                @click="userProfil"
                severity="contrast"
                outlined
            >
                <span class="flex items-center font-bold">
                    <img
                        alt="logo"
                        src="https://primefaces.org/cdn/primevue/images/logo.svg"
                        style="height: 1rem; margin-right: 0.5rem"
                    />
                    <span> {{ $page.props.auth.user.first_name }}</span>
                </span>
            </SplitButton>
        </div>
    </header>
</template>
