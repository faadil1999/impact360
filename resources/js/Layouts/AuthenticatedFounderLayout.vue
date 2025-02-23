<script setup>
import SideBarFounder from "@/Components/Organization/Founder/Menu/SideBarFounder.vue";
import HeaderFounder from "@/Components/Organization/Founder/Menu/HeaderFounder.vue";
</script>

<template>
    <div>
        <div
            class="min-h-screen bg-gray-100 dark:bg-gray-900 flex items-stretch"
        >
            <SideBarFounder />
            <div class="w-full">
                <HeaderFounder />
                <!-- Page Content -->
                <main>
                    <div class="px-10 pt-8">
                        <slot v-if="$slots.header" name="header" />
                    </div>
                    <slot />
                </main>
            </div>
            <!-- Page Heading -->
        </div>
    </div>
</template>
