<script setup>
import Stepper from "primevue/stepper";
import StepList from "primevue/steplist";
import StepPanels from "primevue/steppanels";
import StepItem from "primevue/stepitem";
import Checkbox from "primevue/checkbox";
import FloatLabel from "primevue/floatlabel";
import InputText from "primevue/inputtext";
import Select from "primevue/select";
import Step from "primevue/step";
import StepPanel from "primevue/steppanel";
import Password from "primevue/password";
import { useForm } from "@inertiajs/vue3";
import { Button } from "primevue";
import { computed } from "vue";
import { trans } from "laravel-vue-i18n";

const props = defineProps({
    userRoles: {
        type: Array,
        default: [],
    },
});

const form = useForm({
    is_member: true,
    register: {
        first_name: "",
        last_name: "",
        phone: "",
        email: "",
        password: "",
        password_confirmation: "",
        roles: [],
    },
});
const emit = defineEmits(["back"]);

function backToChoice() {
    form.register = null;
    emit("back");
}

function register() {
    form.post(route("member.register"), {
        onFinish: () =>
            form.reset(
                "organization.founder.password",
                "organization.founder.password_confirmation"
            ),
    });
}
</script>
<template>
    <Stepper value="1" linear>
        <StepList>
            <Step value="1">{{
                $t("fields.register.user.account_creation")
            }}</Step>
            <Step value="2"> {{ $t("fields.register.user.role_user") }}</Step>
        </StepList>

        <StepPanels>
            <StepPanel
                v-slot="{ activateCallback }"
                value="1"
                class="rounded-lg"
            >
                <div class="flex flex-col h-full">
                    <div
                        class="rounded flex-col flex justify-center items-center font-medium pt-8"
                    >
                        <h3>{{ $t("fields.register.user.label") }}</h3>
                        <div class="grid grid-cols-1 gap-4 mt-3">
                            <!--First name-->
                            <FloatLabel variant="on">
                                <InputText
                                    id="first_name"
                                    v-model="form.register.first_name"
                                    variant="filled"
                                    fluid
                                />
                                <label for="username">{{
                                    $t("fields.register.user.first_name")
                                }}</label>
                            </FloatLabel>
                            <!--last name-->
                            <FloatLabel variant="on">
                                <InputText
                                    id="first_name"
                                    v-model="form.register.last_name"
                                    variant="filled"
                                    fluid
                                />
                                <label for="username">{{
                                    $t("fields.register.user.last_name")
                                }}</label>
                            </FloatLabel>

                            <!--email-->
                            <FloatLabel variant="on">
                                <InputText
                                    id="email"
                                    v-model="form.register.email"
                                    variant="filled"
                                    fluid
                                />
                                <label for="username">{{
                                    $t("fields.register.user.email")
                                }}</label>
                            </FloatLabel>

                            <!--phone-->
                            <FloatLabel variant="on">
                                <InputText
                                    id="phone"
                                    v-model="form.register.phone"
                                    variant="filled"
                                    fluid
                                />
                                <label for="username">{{
                                    $t("fields.register.user.phone")
                                }}</label>
                            </FloatLabel>

                            <!--Password-->
                            <FloatLabel variant="on">
                                <Password
                                    v-model="form.register.password"
                                    :feedback="false"
                                    toggleMask
                                />
                                <label for="password">
                                    {{ $t("fields.register.user.password") }}
                                </label>
                            </FloatLabel>

                            <!--Confirmation Password-->
                            <FloatLabel variant="on">
                                <Password
                                    v-model="
                                        form.register.password_confirmation
                                    "
                                    :feedback="false"
                                    toggleMask
                                />
                                <label for="confirm_password">
                                    {{
                                        $t(
                                            "fields.register.user.confirm_password"
                                        )
                                    }}
                                </label>
                            </FloatLabel>
                        </div>
                    </div>
                </div>
                <div class="flex pt-6 justify-between">
                    <Button
                        label="Back"
                        severity="secondary"
                        icon="pi pi-arrow-left"
                        @click="backToChoice()"
                    />
                    <Button
                        label="Next"
                        icon="pi pi-arrow-right"
                        @click="activateCallback('2')"
                        iconPos="right"
                    />
                </div>
            </StepPanel>

            <StepPanel
                v-slot="{ activateCallback }"
                value="2"
                class="rounded-lg"
            >
                <div class="flex flex-col h-48">
                    <div
                        class="rounded flex-auto flex justify-center items-center font-medium"
                    >
                        <div
                            class="card flex flex-row justify-center gap-4 px-4"
                        >
                            <div v-for="role in userRoles" :key="role">
                                <div class="flex gap-2">
                                    <Checkbox
                                        v-model="form.register.roles"
                                        :inputId="role"
                                        name="role"
                                        :value="role"
                                        size="large"
                                    />
                                    <label for="role" class="text-lg">
                                        {{ $t(`enum.${role}`) }}<br />
                                        <span class="italic text-sm font-light">
                                            ({{
                                                role === userRoles[3]
                                                    ? $t(
                                                          "fields.register.user.details_about_beneficiary"
                                                      )
                                                    : $t(
                                                          "fields.register.user.details_about_contributor"
                                                      )
                                            }})
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex pt-6 justify-between">
                    <Button
                        label="Back"
                        severity="secondary"
                        icon="pi pi-arrow-left"
                        @click="activateCallback('1')"
                    />
                    <Button
                        label="Enregistrer"
                        icon="pi pi-arrow-right"
                        iconPos="right"
                        @click="register()"
                    />
                </div>
            </StepPanel>
        </StepPanels>
    </Stepper>
</template>
