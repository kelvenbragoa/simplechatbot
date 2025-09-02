<script setup>
import { CustomerService } from '@/service/CustomerService';
import { ProductService } from '@/service/ProductService';
// import { FilterMatchMode, FilterOperator } from '@primevue/core/api';
import { onBeforeMount, reactive, ref, onMounted, watch } from 'vue';
import { RouterView, RouterLink, useRouter, useRoute } from 'vue-router';
import { useForm } from 'vee-validate';
// import { debounce } from 'lodash';
import { useToast } from 'primevue/usetoast';
import { debounce } from 'lodash-es';
import moment from 'moment';
// import { object, string, number, date } from 'yup';
import * as yup from 'yup';
// import { baseURL, storageURL } from '@/service/ApiConstant';
import axios from 'axios';
import { format } from 'date-fns';




const router = useRouter();
const toast = useToast();
const loading1 = ref(null);
const isLoadingDiv = ref(FontFaceSetLoadEvent);
const loadingButtonDelete = ref(false);
let dataIdBeingDeleted = ref(null);
const searchQuery = ref('');
const retriviedData = ref(null);
const currentPage = ref(1);
const rowsPerPage = ref(15);
const totalRecords = ref(0);
const displayConfirmation = ref(false);
const departments = ref(null);
const isLoadingButton = ref(false);
const departmentItems = ref(null);
const genderItems = ref(null);
const userItems = ref(null);


const schema = yup.object({
    name: yup.string().required().trim().label("First Name"),
    code: yup.string().required().trim().label("Last Name"),
    location: yup.string().required().trim().label("Emal"),
    description: yup.string().required().label("Description"),
    responsible_user_id: yup.string().required().label("Responsavel"),
    
});
const { defineField, handleSubmit, resetForm, errors, setErrors } = useForm({
    validationSchema: schema
});
const [location] = defineField("location");
const [name] = defineField("name");
const [code] = defineField("code");
const [description] = defineField("description");
const [responsible_user_id] = defineField("responsible_user_id");
const [_method] = defineField('_method');
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
        case 'unqualified':
            return 'danger';

        case 'qualified':
            return 'success';

        case 'new':
            return 'info';

        case 'negotiation':
            return 'warn';

        case 'renewal':
            return null;
    }
}

const onSubmit = handleSubmit((values) => {
    if (image.value != null) {
        values.image = image.value;
    }
    // const formattedDate = format(date_of_birth.value, 'yyyy-MM-dd');

    isLoadingButton.value = true;
    axios
        .put(`/api/departments/${router.currentRoute.value.params.id}`, values)
        .then((response) => {
            // resetForm();
            router.back();
            toast.add({ severity: 'success', summary: `Successo`, detail: 'Departamento atualizado com sucesso', life: 3000 });
        })
        .catch((error) => {
            isLoadingButton.value = false;
            toast.add({ severity: 'error', summary: `Erro`, detail: `${error.response.data.message}`, life: 3000 });
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
        .get(`/api/departments/${router.currentRoute.value.params.id}/edit`, {
            params: {
                query: searchQuery.value
            }
        })
        .then((response) => {
            retriviedData.value = response.data.department;
            userItems.value = response.data.userItems;
            name.value = retriviedData.value.name;
            code.value = retriviedData.value.code;
            location.value = retriviedData.value.location;
            description.value = retriviedData.value.description;
            responsible_user_id.value = retriviedData.value.responsible_user_id;
            _method.value = 'put';
            isLoadingDiv.value = false;
        })
        .catch((error) => {
            isLoadingDiv.value = false;
            toast.add({ severity: 'error', summary: `${error}`, detail: 'Message Detail', life: 3000 });
            goBackUsingBack();
        });
};

const deleteData = () => {
    loadingButtonDelete.value = true;

    axios
        .delete(`/api/departments/${dataIdBeingDeleted.value}`)
        .then(() => {
            retriviedData.value.data = retriviedData.value.data.filter((data) => data.id !== dataIdBeingDeleted.value);
            closeConfirmation();
            toast.add({ severity: 'success', summary: `Sucesso`, detail: 'Sucesso ao apagar', life: 3000 });
        })
        .catch((error) => {
            toast.add({ severity: 'error', summary: `Erro`, detail: `${error}`, life: 3000 });
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

watch(searchQuery,debouncedSearch);

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
                <div class="font-semibold text-xl">Departamentos</div>
                <small class="p-error"
                    >Os campos marcados * sao considerados campos
                    obrigatorios.</small
                >
                                <form @submit.prevent="onSubmit">
                    <div class="flex flex-row gap-4">
                        <div class="flex flex-col gap-2 w-1/2">
                            <label for="name">Nome *</label>
                            <InputText
                                v-model="name"
                                id="name"
                                placeholder="Nome"
                                :class="{ 'p-invalid': errors.name }"
                            />
                            <small class="p-error">{{
                                errors.name
                            }}</small>
                        </div>

                        <div class="flex flex-col gap-2 w-1/2">
                            <label for="code">Codigo *</label>
                            <InputText
                                v-model="code"
                                id="lastName"
                                placeholder="Codigo"
                                :class="{ 'p-invalid': errors.code }"
                            />
                            <small class="p-error">{{
                                errors.code
                            }}</small>
                        </div>

                        <div class="flex flex-col gap-2 w-1/2">
                            <label for="location">Localizacao *</label>
                            <InputText
                                v-model="location"
                                id="location"
                                placeholder="Localizacao"
                                :class="{ 'p-invalid': errors.location }"
                            />
                            <small class="p-error">{{ errors.location }}</small>
                        </div>
                    </div>

                    <div class="flex flex-row gap-4">
                        <div class="flex flex-col gap-2 w-1/2">
                            <label for="responsible_user_id">Reponsavel *</label>
                            <Select
                                id="responsible_user_id"
                                v-model="responsible_user_id"
                                :options="userItems"
                                filter
                                optionLabel="name"
                                optionValue="id"
                                placeholder="Select One"
                                :class="{ 'p-invalid': errors.responsible_user_id }"
                            ></Select>

                            <small class="p-error">{{
                                errors.responsible_user_id
                            }}</small>
                        </div>
                        
                        <div class="flex flex-col gap-2 w-1/2">
                            <label for="description">Descricao *</label>
                            <InputText
                                type="text"
                                v-model="description"
                                id="description"
                                placeholder="Descricao"
                                :class="{ 'p-invalid': errors.description }"
                            />
                            <small class="p-error">{{ errors.description }}</small>
                        </div>
                        
                    </div>
                    <Button class="mt-5" type="button" label="Submeter" icon="pi pi-save" :loading="isLoadingButton" @click="onSubmit" />
                </form>
            </div>
        </div>
    </div>
    
    <Dialog header="Confirmação" v-model:visible="displayConfirmation" :style="{ width: '350px' }" :modal="true">
        <div class="flex align-items-center justify-content-center">
            <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
            <span>Tem certeza que deseja proceder?</span>
        </div>
        <template #footer>
            <Button label="Não" icon="pi pi-times" @click="closeConfirmation" class="p-button-text" />
            <Button label="Sim" icon="pi pi-check" @click="deleteData" class="p-button-text" autofocus />
        </template>
    </Dialog>
</template>


