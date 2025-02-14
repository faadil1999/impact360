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
    organizationTypes: {
        type: Array,
        default: [],
    },
    organizationRoles: {
        type: Array,
        default: [],
    },
});

const emit = defineEmits(["back"]);

const form = useForm({
    organization: {
        creation: {
            name: "",
            type_organization: "",
            sub_type_organization: "",
            organization_role: "",
        },
        founder: {
            first_name: "",
            last_name: "",
            email: "",
            phone: "",
            password: "",
            password_confirmation: "",
        },
    },
});

const dataOrganizationTypes = computed(() =>
    props.organizationTypes.map((type) => ({
        id: type.id,
        trans_name: trans(`model.organization.types.${type.name}`),
        name: type.name,
    }))
);

const organizationSubTypes = computed(() => {
    const selectedTypeName =
        form.organization.creation.type_organization?.name ?? "private";

    const selectedType = props.organizationTypes.find(
        (type) => type.name === selectedTypeName
    );

    return selectedType
        ? selectedType.sub_types.map((sub_type) => ({
              id: sub_type.id,
              trans_name: trans(`model.organization.subTypes.${sub_type.name}`),
              name: sub_type.name,
          }))
        : [];
});

function backToChoice() {
    form.organization = null;
    emit("back");
}

function register() {
    form.transform((data) => {
        data.is_founder = true;
        data.organization.creation.type_organization_id =
            data.organization.creation.type_organization.id;
        data.organization.creation.sub_type_organization_id =
            data.organization.creation.sub_type_organization.id;

        return data;
    }).post(route("register"), {
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
                $t("fields.register.organization.steps.type_organization")
            }}</Step>
            <Step value="2">{{
                $t("fields.register.organization.steps.role_organization")
            }}</Step>
            <Step value="3">{{
                $t("fields.register.organization.steps.founder_account")
            }}</Step>
        </StepList>
        <StepPanels>
            <!--Chose type and subtype organization step 1-->
            <StepPanel
                v-slot="{ activateCallback }"
                value="1"
                class="rounded-lg"
            >
                <div class="flex flex-col h-full">
                    <div class="flex flex-col px-7 pt-10 space-y-2">
                        <label for="username">{{
                            $t("fields.register.organization.organization_name")
                        }}</label>
                        <InputText
                            id="name"
                            :placeholder="
                                trans(
                                    `fields.register.organization.organization_name`
                                )
                            "
                            v-model="form.organization.creation.name"
                            aria-describedby="username-help"
                        />
                        <Message
                            size="small"
                            severity="secondary"
                            variant="simple"
                            class="text-red-500"
                        ></Message>
                    </div>
                    <div class="flex flex-col pt-7 px-7 space-y-2">
                        <label>
                            {{
                                $t(
                                    "fields.register.organization.type_organization"
                                )
                            }}
                        </label>
                        <Select
                            v-model="
                                form.organization.creation.type_organization
                            "
                            name="name"
                            :options="dataOrganizationTypes"
                            optionLabel="trans_name"
                            :placeholder="
                                trans(
                                    'fields.register.organization.select_type_organization'
                                )
                            "
                            fluid
                        />
                    </div>

                    <div
                        class="flex flex-col px-7 pt-7 space-y-2"
                        v-if="form.organization.creation.type_organization"
                    >
                        <label>
                            {{
                                $t(
                                    "fields.register.organization.sub_type_organization"
                                )
                            }}
                        </label>
                        <Select
                            v-model="
                                form.organization.creation.sub_type_organization
                            "
                            name="name"
                            :options="organizationSubTypes"
                            optionLabel="trans_name"
                            :placeholder="
                                trans(
                                    'fields.register.organization.select_sub_type_organization'
                                )
                            "
                            fluid
                        />
                    </div>
                </div>
                <div class="flex pt-10 justify-between">
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
                    />
                </div>
            </StepPanel>
            <!--Step 2 -->
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
                            <div v-for="role in organizationRoles" :key="role">
                                <div class="flex gap-2">
                                    <Checkbox
                                        v-model="
                                            form.organization.creation
                                                .organization_role
                                        "
                                        :inputId="role"
                                        name="role"
                                        :value="role"
                                        size="large"
                                    />
                                    <label for="role" class="text-lg">
                                        {{ $t(`enum.${role}`) }}<br />
                                        <span class="italic text-sm font-light">
                                            ({{
                                                role === organizationRoles[4]
                                                    ? $t(
                                                          "fields.register.organization.details_about_actor"
                                                      )
                                                    : $t(
                                                          "fields.register.organization.details_about_contributor"
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
                        label="Next"
                        icon="pi pi-arrow-right"
                        iconPos="right"
                        @click="activateCallback('3')"
                    />
                </div>
            </StepPanel>

            <!--Step 3 -->
            <StepPanel
                v-slot="{ activateCallback }"
                value="3"
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
                                    v-model="
                                        form.organization.founder.first_name
                                    "
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
                                    v-model="
                                        form.organization.founder.last_name
                                    "
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
                                    v-model="form.organization.founder.email"
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
                                    v-model="form.organization.founder.phone"
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
                                    v-model="form.organization.founder.password"
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
                                        form.organization.founder
                                            .password_confirmation
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
                        @click="activateCallback('2')"
                    />

                    <Button
                        label="Submit"
                        icon="pi pi-arrow-right"
                        iconPos="right"
                        @click="register()"
                    />
                </div>
            </StepPanel>
        </StepPanels>
    </Stepper>
</template>
