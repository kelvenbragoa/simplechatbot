<script setup>
import { ProductService } from "@/service/ProductService";
import {
    onBeforeMount,
    reactive,
    ref,
    onMounted,
    watch,
    defineProps,
} from "vue";
import { RouterView, RouterLink, useRouter, useRoute } from "vue-router";
import { useForm } from "vee-validate";
import * as yup from "yup";
// import { debounce } from 'lodash';
import { useToast } from "primevue/usetoast";
import { debounce } from "lodash-es";
// import { baseURL, storageURL } from '@/service/ApiConstant';

import moment from "moment";
import axios from "axios";

const props = defineProps({ openCreate: Boolean });
const menu = ref(null);
const router = useRouter();
const toast = useToast();
const loading1 = ref(null);
const isLoadingDiv = ref(true);
const loadingButtonDelete = ref(false);
let dataIdBeingUsed = ref(null);
let dataBeingUsed = ref(null);
const searchRoleQuery = ref("");
const retriviedRoleData = ref(null);
const currentRolePage = ref(1);
const rowsPerPage = ref(0);
const totalRoleRecords = ref(0);
const displayConfirmation = ref(false);
const displayAccountSetting = ref(false);
const createRoleDialog = ref(false);
const showRoleDialog = ref(false);
const updateRoleDialog = ref(false);
const currentRowId = ref(null);
const isLoadingButton = ref(false);
const permissionsData = ref([]);

const schema = yup.object({
    name: yup.string().required().trim().label("Name"),
    description: yup.string().required().trim().label("Description"),
    permissions: yup.array().min(1, "Selecione pelo menos uma permissão").label("Permissões"),
});
const { defineField, handleSubmit, resetForm, errors, setErrors } = useForm({
    validationSchema: schema,
});
const [description] = defineField("description");
const [name] = defineField("name");
const [permissions] = defineField("permissions");

function goBackUsingBack() {
    if (router) {
        router.back();
    }
}
function toggleMenu(event, id, data) {
    currentRowId.value = id;
    dataIdBeingUsed.value = id;
    dataBeingUsed.value = data;

    menu.value.toggle(event);
}
const closeShowRoleDialog = () => {
    showRoleDialog.value = false;
};
const openShowRoleDialog = (data) => {
    dataBeingUsed.value = data;
    showRoleDialog.value = true;
};

const closeCreateRoleDialog = () => {
    createRoleDialog.value = false;
};
const openCreateRoleDialog = () => {
    name.value = "";
    description.value = "";
    permissions.value = [];
    createRoleDialog.value = true;
};

const closeUpdateRoleDialog = () => {
    updateRoleDialog.value = false;
};
const openUpdateRoleDialog = (data) => {
    dataBeingUsed.value = data;
    name.value = data.name;
    description.value = data.description;
    permissions.value = data.permissions.map(p => p.id);
    currentRowId.value = data.id;
    updateRoleDialog.value = true;
    console.log(data.permissions)
};

const closeAccountSetting = () => {
    displayAccountSetting.value = false;
};
const confirmAccountSetting = (id) => {
    displayAccountSetting.value = true;
    dataIdBeingUsed.value = id;
};

const closeConfirmation = () => {
    displayConfirmation.value = false;
};
const confirmDeletion = (id) => {
    displayConfirmation.value = true;
    dataIdBeingUsed.value = id;
};
const overlayMenuItems = ref([
    {
        label: "Excluir",
        icon: "pi pi-trash",
        command: () => confirmDeletion(currentRowId.value),
    },
]);

function getSeverityStatus(status) {
    switch (status) {
        case 1:
            return "success";

        case 0:
            return "danger";

        case "renewal":
            return null;
    }
}

const onSubmit = handleSubmit((values) => {
    isLoadingButton.value = true;
    axios
        .post(`/api/roles`, values)
        .then((response) => {
            retriviedRoleData.value.push(response.data);
            closeCreateRoleDialog();
            toast.add({
                severity: "success",
                summary: `Successo`,
                detail: "Role criado com sucesso",
                life: 3000,
            });
        })
        .catch((error) => {
            isLoadingButton.value = false;
            toast.add({
                severity: "error",
                summary: `Erro ao criar Role`,
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

const onSubmitEdit = handleSubmit((values) => {
    isLoadingButton.value = true;
    axios
        .put(`/api/roles/${currentRowId.value}`, values)
        .then((response) => {
            const index = retriviedRoleData.value.findIndex(
                (p) => p.id === currentRowId.value,
            );
            if (index !== -1) {
                retriviedRoleData.value[index] = response.data;
            }
            closeUpdateRoleDialog();
            toast.add({
                severity: "success",
                summary: `Successo`,
                detail: "Role atualizada com sucesso",
                life: 3000,
            });
        })
        .catch((error) => {
            isLoadingButton.value = false;
            toast.add({
                severity: "error",
                summary: `Erro`,
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

const getRoleData = async (page = 1) => {
    axios
        .get(`/api/roles?page=${page}`, {
            params: {
                query: searchRoleQuery.value,
            },
        })
        .then((response) => {
            retriviedRoleData.value = response.data.data;
            totalRoleRecords.value = response.data.totalItems;
            rowsPerPage.value = response.data.per_page;
            isLoadingDiv.value = false;
        })
        .catch((error) => {
            isLoadingDiv.value = false;
            toast.add({
                severity: "error",
                summary: `${error.message}`,
                detail: "Message Detail",
                life: 3000,
            });
            goBackUsingBack();
        });
    axios
        .get(`/api/permissions?page=${page}`)
        .then((response) => {
            permissionsData.value = response.data.data;
        })
        .catch((error) => {
            isLoadingDiv.value = false;
            toast.add({
                severity: "error",
                summary: `${error.message}`,
                detail: "Message Detail",
                life: 3000,
            });
        });
};

const deleteData = () => {
    loadingButtonDelete.value = true;

    axios
        .delete(`/api/roles/${dataIdBeingUsed.value}`)
        .then(() => {
            retriviedRoleData.value = retriviedRoleData.value.filter(
                (data) => data.id !== dataIdBeingUsed.value,
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

const onPageChangeRole = (event) => {
    currentRolePage.value = event.page + 1;
    rowsPerPage.value = event.rows;
    getRoleData(currentRolePage.value);
};

const debouncedrolesearch = debounce(() => {
    getRoleData(currentRolePage.value);
}, 300);

watch(searchRoleQuery, debouncedrolesearch);

onMounted(() => {
    getRoleData();
    if (props.openCreate) {
        openCreateRoleDialog();
    }
});
</script>

<template>
    <div class="grid" v-if="isLoadingDiv">
        <div class="col-12 flex justify-content-center">
            <ProgressSpinner
                style="width: 50px; height: 50px"
                strokeWidth="8"
                fill="var(--surface-ground)"
                animationDuration=".5s"
                aria-label="Custom ProgressSpinner"
            />
        </div>
    </div>
    <div class="grid" v-else>
        <div class="col-12">
            <div class="card">
                <DataTable
                    :value="retriviedRoleData"
                    :paginator="true"
                    :rows="rowsPerPage"
                    :totalRecords="totalRoleRecords"
                    dataKey="id"
                    :lazy="true"
                    :rowHover="true"
                    :loading="isLoadingDiv"
                    :first="(currentRolePage - 1) * rowsPerPage"
                    :onPage="onPageChangeRole"
                    showGridlines
                >
                    <template #header>
                        <div class="flex justify-between flex-col sm:flex-row">
                            <Button
                                label=""
                                class="mr-2 mb-2"
                                @click="openCreateRoleDialog()"
                                >Novo Registro<i class="pi pi-plus"></i
                            ></Button>
                            <IconField>
                                <InputIcon>
                                    <i class="pi pi-search" />
                                </InputIcon>
                                <InputText
                                    v-model="searchRoleQuery"
                                    placeholder="Pesquisa"
                                />
                            </IconField>
                        </div>
                    </template>
                    <template #empty>Nenhuma registro encontrado. </template>
                    <template #loading>
                        Carregando, por favor espere.
                    </template>
                    <Column header="ID" style="min-width: 2rem">
                        <template #body="{ data }"> #{{ data.id }} </template>
                    </Column>
                    <Column header="Name" style="min-width: 12rem">
                        <template #body="{ data }">
                            {{ data.name }}
                        </template>
                    </Column>
                    <Column header="Descricao" style="min-width: 12rem">
                        <template #body="{ data }">
                            {{ data.description }}
                        </template>
                    </Column>
                    <Column
                        header="Data"
                        dataType="date"
                        style="min-width: 10rem"
                    >
                        <template #body="{ data }">
                            {{
                                moment(data.createdAt).format("DD-MM-YYYY H:mm")
                            }}
                        </template>
                    </Column>
                    <Column header="Ações" style="min-width: 12rem">
                        <template #body="{ data }">
                            <a
                                class="m-3"
                                href="#"
                                @click.prevent="openUpdateRoleDialog(data)"
                                ><i class="pi pi-file-edit"></i
                            ></a>

                            <a
                                class="m-3"
                                href="#"
                                @click.prevent="openShowRoleDialog(data)"
                                ><i class="pi pi-eye"></i
                            ></a>

                            <a
                                class="m-3"
                                href="#"
                                @click="toggleMenu($event, data.id, data)"
                            >
                                <Menu
                                    ref="menu"
                                    :model="overlayMenuItems"
                                    :popup="true" />
                                <i
                                    class="pi pi-ellipsis-v"
                                    style="font-size: 1rem"
                                ></i
                            ></a>
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </div>
    <Dialog
        header="Confirmação"
        v-model:visible="displayConfirmation"
        :style="{ width: '350px' }"
        :modal="true"
    >
        <div class="flex align-items-center justify-content-center">
            <i
                class="pi pi-exclamation-triangle mr-3"
                style="font-size: 2rem"
            />
            <span>Tem certeza que deseja proceder?</span>
        </div>
        <template #footer>
            <Button
                label="Não"
                icon="pi pi-times"
                @click="closeConfirmation"
                class="p-button-text"
            />
            <Button
                label="Sim"
                icon="pi pi-check"
                @click="deleteData"
                class="p-button-text"
                autofocus
            />
        </template>
    </Dialog>

    <Dialog
        header="Criar Previlegio"
        v-model:visible="createRoleDialog"
        :style="{ width: '640px' }"
        :modal="true"
    >
        <form @submit.prevent="onSubmit">
            <div class="flex flex-col gap-2">
                <label for="name">Nome</label>
                <InputText
                    v-model="name"
                    id="name"
                    placeholder="Nome"
                    :class="{ 'p-invalid': errors.name }"
                />
                <small id="name-help" class="p-error">{{ errors.name }}</small>
            </div>
            <div class="flex flex-col gap-2">
                <label for="description">Descricao</label>
                <Textarea
                    v-model="description"
                    placeholder="Descricao"
                    rows="5"
                    cols="30"
                    :class="{ 'p-invalid': errors.description }"
                />
                <small id="description-help" class="p-error">{{
                    errors.description
                }}</small>
            </div>
            <div class="flex flex-col gap-2">
                <label for="permissions">Permissoes</label>
                <MultiSelect
                    v-model="permissions"
                    :options="permissionsData"
                    optionLabel="name"
                    filter
                    placeholder="Selecionar Permissões"
                    :maxSelectedLabels="1"
                />
                <small id="permissions-help" class="p-error">{{
                    errors.permissions
                }}</small>
            </div>
        </form>
        <template #footer>
            <Button
                label="Cancelar"
                icon="pi pi-times"
                @click="closeCreateRoleDialog"
                class="p-button-text"
            />
            <Button
                label="Submeter"
                icon="pi pi-check"
                @click="onSubmit"
                :disabled="isLoadingButton"
                class="p-button-text"
                autofocus
            />
            <i
                class="pi pi-spin pi-spinner"
                style="font-size: 2rem"
                v-if="isLoadingButton"
            ></i>
        </template>
    </Dialog>

    <Dialog
        header="Previlegio"
        v-model:visible="showRoleDialog"
        :style="{ width: '640px' }"
        :modal="true"
    >
        <p><strong>Role</strong>: {{ dataBeingUsed.name }}</p>
        <p><strong>Descricao</strong>: {{ dataBeingUsed.description }}</p>
        <p><strong>Permissoes</strong>: {{ dataBeingUsed.permissions.map(p => p.name).join(', ') }}</p>
        <template #footer>
            <Button
                label="Cancelar"
                icon="pi pi-times"
                @click="closeShowRoleDialog"
                class="p-button-text"
            />
        </template>
    </Dialog>

    <Dialog
        header="Atualizar Previlegios"
        v-model:visible="updateRoleDialog"
        :style="{ width: '640px' }"
        :modal="true"
    >
        <form @submit.prevent="onSubmitEdit">
            <div class="flex flex-col gap-2">
                <label for="name">Nome</label>
                <InputText
                    v-model="name"
                    id="name"
                    placeholder="Nome"
                    :class="{ 'p-invalid': errors.name }"
                />
                <small id="name-help" class="p-error">{{ errors.name }}</small>
            </div>
            <div class="flex flex-col gap-2">
                <label for="description">Descricao</label>
                <Textarea
                    v-model="description"
                    placeholder="Descricao"
                    rows="5"
                    cols="30"
                    :class="{ 'p-invalid': errors.description }"
                />
                <small id="description-help" class="p-error">{{
                    errors.description
                }}</small>
            </div>
            <div class="flex flex-col gap-2">
                <label for="permissions">Permissoes</label>
                <MultiSelect
                    v-model="permissions"
                    :options="permissionsData"
                    optionLabel="name"
                    optionValue="id"
                    filter
                    placeholder="Selecionar Permissões"
                    :maxSelectedLabels="1"
                />
                <small id="permissions-help" class="p-error">{{
                    errors.permissions
                }}</small>
            </div>
        </form>
        <template #footer>
            <Button
                label="Cancelar"
                icon="pi pi-times"
                @click="closeUpdateRoleDialog"
                class="p-button-text"
            />
            <Button
                label="Submeter"
                icon="pi pi-check"
                @click="onSubmitEdit"
                :disabled="isLoadingButton"
                class="p-button-text"
                autofocus
            />
            <i
                class="pi pi-spin pi-spinner"
                style="font-size: 2rem"
                v-if="isLoadingButton"
            ></i>
        </template>
    </Dialog>
</template>
