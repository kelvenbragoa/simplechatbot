<script setup>
import { CustomerService } from "@/service/CustomerService";
import { ProductService } from "@/service/ProductService";
import { onBeforeMount, reactive, ref, onMounted, watch } from "vue";
import { RouterView, RouterLink, useRouter, useRoute } from "vue-router";
import { useForm } from "vee-validate";
import { useToast } from "primevue/usetoast";
import { debounce } from "lodash-es";
import moment from "moment";
import * as yup from "yup";
import axios from "axios";
import { format } from 'date-fns';

const router = useRouter();
const toast = useToast();
const loading1 = ref(null);
const isLoadingDiv = ref(false);
const loadingButtonDelete = ref(false);
let dataIdBeingDeleted = ref(null);
const searchQuery = ref("");
const retriviedData = ref(null);
const currentPage = ref(1);
const rowsPerPage = ref(15);
const totalRecords = ref(0);
const displayConfirmation = ref(false);
const departmentItems = ref(null);
const genderItems = ref(null);
const isLoadingButton = ref(false);

const schema = yup.object({
    mobile: yup.string().required().trim().label("Mobile"),
    first_name: yup.string().required().trim().label("First Name"),
    last_name: yup.string().required().trim().label("Last Name"),
    email: yup.string().required().trim().label("Emal"),
    date_of_birth: yup.string().required().label("Date Of Birth"),
    gender_id: yup.string().required().label("Gender"),
    department_id: yup.string().required().label("Department"),
    password: yup
        .string()
        .required("Password é obrigatório")
        .trim()
        .label("Password"),
    password_confirmation: yup
        .string()
        .required("Confirmação de senha é obrigatória")
        .oneOf([yup.ref("password")], "As senhas não coincidem")
        .trim()
        .label("Confirmação de Senha"),
});
const { defineField, handleSubmit, resetForm, errors, setErrors } = useForm({
    validationSchema: schema,
});
const [mobile] = defineField("mobile");
// const [name] = defineField("name");
const [email] = defineField("email");
const [password] = defineField("password");
const [first_name] = defineField("first_name");
const [last_name] = defineField("last_name");
const [date_of_birth] = defineField("date_of_birth");
const [gender_id] = defineField("gender_id");
const [department_id] = defineField("department_id");
const [company_id] = defineField("company_id");
const [password_confirmation] = defineField("password_confirmation");

const image = ref();

function goBackUsingBack() {
    if (router) {
        router.back();
    }
}

const closeConfirmation = () => {
    displayConfirmation.value = false;
};
const confirmDeletion = (id) => {
    displayConfirmation.value = true;
    dataIdBeingDeleted.value = id;
};

function getSeverity(status) {
    switch (status) {
        case "unqualified":
            return "danger";

        case "qualified":
            return "success";

        case "new":
            return "info";

        case "negotiation":
            return "warn";

        case "renewal":
            return null;
    }
}

const onSubmit = handleSubmit((values) => {
    if (image.value != null) {
        values.image = image.value;
    }
    const formattedDate = format(date_of_birth.value, 'yyyy-MM-dd');
    isLoadingButton.value = true;
    axios
        .post(`/api/users`, { ...values, date_of_birth: formattedDate })
        .then((response) => {
            // resetForm();
            router.back();
            toast.add({
                severity: "success",
                summary: `Successo`,
                detail: "Utilizador criado com sucesso",
                life: 3000,
            });
        })
        .catch((error) => {
            isLoadingButton.value = false;
            toast.add({
                severity: "error",
                summary: `Erro ao criar utilizador`,
                detail: `${error.response.data.message}`,
                life: 3000,
            });
            if (error.response.data.errors) {
                setErrors(error.response.data.errors);
            }
        })
        .finally(() => {
            isLoadingButton.value = false;
        });
});

const getData = async (page = 1) => {
    axios
        .get(`/api/users/create`, {
            params: {
                query: searchQuery.value,
            },
        })
        .then((response) => {
            genderItems.value = response.data.genderItems;
            departmentItems.value = response.data.departmentItems;

            isLoadingDiv.value = false;
        })
        .catch((error) => {
            isLoadingDiv.value = false;
            toast.add({
                severity: "error",
                summary: `${error}`,
                detail: "Message Detail",
                life: 3000,
            });
            goBackUsingBack();
        });
};

const deleteData = () => {
    loadingButtonDelete.value = true;

    axios
        .delete(`/api/users/${dataIdBeingDeleted.value}`)
        .then(() => {
            retriviedData.value.data = retriviedData.value.data.filter(
                (data) => data.id !== dataIdBeingDeleted.value,
            );
            closeConfirmation();
            toast.add({
                severity: "success",
                summary: `Sucesso`,
                detail: "Sucesso ao apagar",
                life: 3000,
            });
        })
        .catch((error) => {
            toast.add({
                severity: "error",
                summary: `Erro`,
                detail: `${error}`,
                life: 3000,
            });
            loadingButtonDelete.value = false;
        })
        .finally(() => {
            loadingButtonDelete.value = false;
        });
};

const onPageChange = (event) => {
    currentPage.value = event.page + 1;
    rowsPerPage.value = event.rows;
    getData(currentPage.value);
};

const debouncedSearch = debounce(() => {
    getData(currentPage.value);
}, 300);

watch(searchQuery, debouncedSearch);

onMounted(() => {
    getData();
});
</script>

<template>
    <div
        class="flex flex-col gap-4 min-h-screen items-center justify-center text-center"
        v-if="isLoadingDiv"
    >
        <ProgressSpinner
            style="width: 50px; height: 50px"
            strokeWidth="8"
            fill="var(--surface-ground)"
            animationDuration=".5s"
            aria-label="Custom ProgressSpinner"
        />
        <p>Por favor aguarde...</p>
    </div>

    <div class="flex flex-col md:flex-row gap-12" v-else>
        <div class="w-full">
            <div class="card flex flex-col gap-4">
                <div class="w-full">
                    <Button
                        label="Voltar"
                        class="mr-2 mb-2"
                        @click="goBackUsingBack"
                        ><i class="pi pi-angle-left"></i> Voltar</Button
                    >
                </div>
                <div class="font-semibold text-xl">Utilizadores</div>
                <small class="p-error"
                    >Os campos marcados * sao considerados campos
                    obrigatorios.</small
                >
                <form @submit.prevent="onSubmit">
                    <div class="flex flex-row gap-4">
                        <div class="flex flex-col gap-2 w-1/2">
                            <label for="first_name">Nome *</label>
                            <InputText
                                v-model="first_name"
                                id="first_name"
                                placeholder="Nome"
                                :class="{ 'p-invalid': errors.first_name }"
                            />
                            <small class="p-error">{{
                                errors.first_name
                            }}</small>
                        </div>

                        <div class="flex flex-col gap-2 w-1/2">
                            <label for="last_name">Apelido *</label>
                            <InputText
                                v-model="last_name"
                                id="lastName"
                                placeholder="Apelido"
                                :class="{ 'p-invalid': errors.last_name }"
                            />
                            <small class="p-error">{{
                                errors.last_name
                            }}</small>
                        </div>

                        <div class="flex flex-col gap-2 w-1/2">
                            <label for="email">Email *</label>
                            <InputText
                                v-model="email"
                                id="email"
                                placeholder="Email"
                                :class="{ 'p-invalid': errors.email }"
                            />
                            <small class="p-error">{{ errors.email }}</small>
                        </div>
                    </div>

                    <div class="flex flex-row gap-4">
                        <div class="flex flex-col gap-2 w-1/2">
                            <label for="gender_id">Sexo *</label>
                            <Select
                                id="gender_id"
                                v-model="gender_id"
                                :options="genderItems"
                                filter
                                optionLabel="name"
                                optionValue="id"
                                placeholder="Select One"
                                :class="{ 'p-invalid': errors.gender_id }"
                            ></Select>
                            <!-- <Dropdown v-model="gender_id" :options="genderItems" filter optionLabel="name" placeholder="Select"  :class="{ 'p-invalid': errors.gender_id }"></Dropdown> -->

                            <small class="p-error">{{
                                errors.gender_id
                            }}</small>
                        </div>
                        <div class="flex flex-col gap-2 w-1/2">
                            <label for="first_name">Departamento *</label>
                            <Select
                                id="state"
                                v-model="department_id"
                                :options="departmentItems"
                                filter
                                optionLabel="name"
                                optionValue="id"
                                placeholder="Select One"
                                :class="{ 'p-invalid': errors.department_id }"
                            ></Select>
                            <!-- <Dropdown v-model="department_id" :options="departmentItems" filter optionLabel="name" placeholder="Select" :class="{ 'p-invalid': errors.department_id }"></Dropdown> -->
                            <small class="p-error">{{
                                errors.department_id
                            }}</small>
                        </div>

                        <div class="flex flex-col gap-2 w-1/2">
                            <label for="last_name">Telefone *</label>
                            <InputText
                                type="text"
                                v-model="mobile"
                                id="mobile"
                                placeholder="Telefone"
                                :class="{ 'p-invalid': errors.mobile }"
                            />
                            <small class="p-error">{{ errors.mobile }}</small>
                        </div>

                        <div class="flex flex-col gap-2 w-1/2">
                            <label for="last_name">Data de Nascimento *</label>
                            <DatePicker
                                v-model="date_of_birth"
                                id="date_of_birth"
                                placeholder="Data de Nascimento"
                                :pt="{
                                    input: {
                                        class: errors.date_of_birth
                                            ? 'p-invalid'
                                            : '',
                                    },
                                }"
                            />
                            <small class="p-error">{{
                                errors.date_of_birth
                            }}</small>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="name1">Palavra passe</label>
                        <InputText
                            type="password"
                            v-model="password"
                            id="password"
                            placeholder="Palavra passe"
                            :class="{ 'p-invalid': errors.password }"
                        />
                        <small id="name-help" class="p-error">{{
                            errors.password
                        }}</small>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="name1">Repetir a palavra passe *</label>
                        <InputText
                            v-model="password_confirmation"
                            id="password_confirmation"
                            placeholder="Repetir a palavra passe"
                            :class="{
                                'p-invalid': errors.password_confirmation,
                            }"
                            type="password"
                        />
                        <small
                            id="password_confirmation-help"
                            class="p-error"
                            >{{ errors.password_confirmation }}</small
                        >
                    </div>
                    <Button class="mt-5" type="button" label="Submeter" icon="pi pi-save" :loading="isLoadingButton" @click="onSubmit" />
                </form>
            </div>
        </div>
    </div>
</template>
