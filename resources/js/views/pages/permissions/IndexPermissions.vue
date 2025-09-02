<script setup>
import { ProductService } from "@/service/ProductService";
import { onBeforeMount, reactive, ref, onMounted, watch, defineProps } from "vue";
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
const searchPermissionQuery = ref("");
const retriviedPermissionData = ref(null);
const currentPermissionPage = ref(1);
const rowsPerPage = ref(0);
const totalPermissionRecords = ref(0);
const displayConfirmation = ref(false);
const displayAccountSetting = ref(false);
const createPermissionDialog = ref(false);
const showPermissionDialog = ref(false);
const updatePermissionDialog = ref(false);
const currentRowId = ref(null);
const isLoadingButton = ref(false);

const schema = yup.object({
    name: yup.string().required().trim().label("Name"),
    description: yup.string().required().trim().label("Description"),
});
const { defineField, handleSubmit, resetForm, errors, setErrors } = useForm({
    validationSchema: schema,
});
const [description] = defineField("description");
const [name] = defineField("name");

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
const closeShowPermissionDialog = () => {
    showPermissionDialog.value = false;
};
const openShowPermissionDialog = (data) => {
    dataBeingUsed.value = data;
    showPermissionDialog.value = true;
};

const closeCreatePermissionDialog = () => {
    createPermissionDialog.value = false;
};
const openCreatePermissionDialog = () => {
    name.value = "";
    description.value = "";
    createPermissionDialog.value = true;
};

const closeUpdatePermissionDialog = () => {
    updatePermissionDialog.value = false;
};
const openUpdatePermissionDialog = (data) => {
    dataBeingUsed.value = data;
    name.value = data.name;
    description.value = data.description;
    currentRowId.value = data.id;
    updatePermissionDialog.value = true;
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
    // {
    //     label: "Desativar/Ativar Conta",
    //     icon: "pi pi-user-minus",
    //     command: () => confirmAccountSetting(currentRowId.value),
    // },
    // {
    //     label: "Previlegios",
    //     icon: "pi pi-shield",
    // },
    // {
    //     label: "Historico de Login",
    //     icon: "pi pi-clock",
    // },
    // {
    //     separator: true,
    // },
    // {
    //     label: "Notificar",
    //     icon: "pi pi-envelope",
    // },
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
        .post(`/api/permissions`, values)
        .then((response) => {
            retriviedPermissionData.value.push(response.data);
            closeCreatePermissionDialog();
            toast.add({
                severity: "success",
                summary: `Successo`,
                detail: "Permissao criado com sucesso",
                life: 3000,
            });
        })
        .catch((error) => {
            isLoadingButton.value = false;
            toast.add({
                severity: "error",
                summary: `Erro ao criar Permissao`,
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
        .put(`/api/permissions/${currentRowId.value}`, values)
        .then((response) => {
            const index = retriviedPermissionData.value.findIndex(p => p.id === currentRowId.value);
            if (index !== -1) {
                retriviedPermissionData.value[index] = response.data;
            }
            closeUpdatePermissionDialog();
            toast.add({ severity: 'success', summary: `Successo`, detail: 'Permissao atualizada com sucesso', life: 3000 });
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

const getPermissionData = async (page = 1) => {
    axios
        .get(`/api/permissions?page=${page}`, {
            params: {
                query: searchPermissionQuery.value,
            },
        })
        .then((response) => {
            retriviedPermissionData.value = response.data.data;
            totalPermissionRecords.value = response.data.totalItems;
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
};

const deleteData = () => {
    loadingButtonDelete.value = true;

    axios
        .delete(`/api/permissions/${dataIdBeingUsed.value}`)
        .then(() => {
            retriviedPermissionData.value =
                retriviedPermissionData.value.filter(
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

const onPageChangePermission = (event) => {
    currentPermissionPage.value = event.page + 1;
    rowsPerPage.value = event.rows;
    getPermissionData(currentPermissionPage.value);
};

const debouncedpermissionsearch = debounce(() => {
    getPermissionData(currentPermissionPage.value);
}, 300);

watch(searchPermissionQuery, debouncedpermissionsearch);

onMounted(() => {
    getPermissionData();
    if (props.openCreate) {
        openCreatePermissionDialog();
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
                    :value="retriviedPermissionData"
                    :paginator="true"
                    :rows="rowsPerPage"
                    :totalRecords="totalPermissionRecords"
                    dataKey="id"
                    :lazy="true"
                    :rowHover="true"
                    :loading="isLoadingDiv"
                    :first="(currentPermissionPage - 1) * rowsPerPage"
                    :onPage="onPageChangePermission"
                    showGridlines
                >
                    <template #header>
                        <div class="flex justify-between flex-col sm:flex-row">
                            <Button
                                label=""
                                class="mr-2 mb-2"
                                @click="openCreatePermissionDialog()"
                                >Novo Registro<i class="pi pi-plus"></i
                            ></Button>
                            <IconField>
                                <InputIcon>
                                    <i class="pi pi-search" />
                                </InputIcon>
                                <InputText
                                    v-model="searchPermissionQuery"
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
                                @click.prevent="openUpdatePermissionDialog(data)"
                                ><i class="pi pi-file-edit"></i
                            ></a>

                            <a
                                class="m-3"
                                href="#"
                                @click.prevent="openShowPermissionDialog(data)"
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
        header="Criar Permissão"
        v-model:visible="createPermissionDialog"
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
        </form>
        <template #footer>
            <Button
                label="Cancelar"
                icon="pi pi-times"
                @click="closeCreatePermissionDialog"
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
        header="Permissão"
        v-model:visible="showPermissionDialog"
        :style="{ width: '640px' }"
        :modal="true"
    >
        <p><strong>Permissao</strong>: {{ dataBeingUsed.name }}</p>
        <p><strong>Descricao</strong>: {{ dataBeingUsed.description }}</p>
        <template #footer>
            <Button
                label="Cancelar"
                icon="pi pi-times"
                @click="closeShowPermissionDialog"
                class="p-button-text"
            />
        </template>
    </Dialog>

    <Dialog
        header="Atualizar Permissão"
        v-model:visible="updatePermissionDialog"
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
        </form>
        <template #footer>
            <Button
                label="Cancelar"
                icon="pi pi-times"
                @click="closeUpdatePermissionDialog"
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
