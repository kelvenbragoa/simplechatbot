<script setup>
import { ProductService } from "@/service/ProductService";
import { onBeforeMount, reactive, ref, onMounted, watch } from "vue";
import { RouterView, RouterLink, useRouter, useRoute } from "vue-router";

// import { debounce } from 'lodash';
import { useToast } from "primevue/usetoast";
import { debounce } from "lodash-es";
// import { baseURL, storageURL } from '@/service/ApiConstant';

import moment from "moment";
import axios from "axios";

const menu = ref(null);
const router = useRouter();
const toast = useToast();
const loading1 = ref(null);
const isLoadingDiv = ref(true);
const loadingButtonDelete = ref(false);
let dataIdBeingUsed = ref(null);
let dataBeingUsed = ref(null);
const searchCostumerQuery = ref("");
const retriviedCostumerData = ref(null);
const currentCostumerPage = ref(1);
const rowsPerPage = ref(0);
const totalCostumerRecords = ref(0);
const displayConfirmation = ref(false);
const displayAccountSetting = ref(false);
const currentRowId = ref(null);

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
        label: 'Excluir',
        icon: 'pi pi-trash',
        command: () => confirmDeletion(currentRowId.value),
    },
    {
        label: 'Desativar/Ativar Conta',
        icon: 'pi pi-user-minus',
        command: () => confirmAccountSetting(currentRowId.value),
    },
    {
        label: 'Previlegios',
        icon: 'pi pi-shield'
    },
    // {
    //     label: 'Historico de Login',
    //     icon: 'pi pi-clock'
    // },
    // {
    //     separator: true
    // },
    // {
    //     label: 'Notificar',
    //     icon: 'pi pi-envelope'
    // }
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

const getDepartmentData = async (page = 1) => {
    axios
        .get(`/api/departments?page=${page}`, {
            params: {
                query: searchCostumerQuery.value,
            },
        })
        .then((response) => {
            retriviedCostumerData.value = response.data.data;
            totalCostumerRecords.value = response.data.totalItems;
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

const activateUserData = () => {
    loadingButtonDelete.value = true;

    axios
        .put(`/api/departments/${dataIdBeingUsed.value}/activate`)
        .then((response) => {
            const updatedUser = response.data.user; // assume que a API retorna o usuário atualizado
            const index = retriviedCostumerData.value.findIndex(
                (data) => data.id === dataIdBeingUsed.value
            );
            if (index !== -1) {
                retriviedCostumerData.value[index] = updatedUser;
            }
            closeAccountSetting();
            toast.add({
                severity: "success",
                summary: `Sucesso`,
                detail: "Sucesso ao atualizar o estado da conta",
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
}

const deleteData = () => {
    loadingButtonDelete.value = true;

    axios
        .delete(`/api/departments/${dataIdBeingUsed.value}`)
        .then(() => {
            retriviedCostumerData.value = retriviedCostumerData.value.filter(
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

const onPageChangeCostumer = (event) => {
    currentCostumerPage.value = event.page + 1;
    rowsPerPage.value = event.rows;
    getDepartmentData(currentCostumerPage.value);
};

const debounceddepartmentsearch = debounce(() => {
    getDepartmentData(currentCostumerPage.value);
}, 300);


watch(searchCostumerQuery, debounceddepartmentsearch);


onMounted(() => {
    getDepartmentData();
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
                    :value="retriviedCostumerData"
                    :paginator="true"
                    :rows="rowsPerPage"
                    :totalRecords="totalCostumerRecords"
                    dataKey="id"
                    :lazy="true"
                    :rowHover="true"
                    :loading="isLoadingDiv"
                    :first="(currentCostumerPage - 1) * rowsPerPage"
                    :onPage="onPageChangeCostumer"
                    showGridlines
                >
                    <template #header>
                        <div class="flex justify-between flex-col sm:flex-row">
                            <router-link to="/admin/departments/create">
                                <Button label="Voltar" class="mr-2 mb-2"
                                    >Novo Registro<i class="pi pi-plus"></i
                                ></Button>
                            </router-link>
                            <IconField>
                                <InputIcon>
                                    <i class="pi pi-search" />
                                </InputIcon>
                                <InputText
                                    v-model="searchCostumerQuery"
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
                        <template #body="{ data }">
                            #{{ data.id }}
                        </template>
                    </Column>
                    <Column header="Name" style="min-width: 12rem">
                        <template #body="{ data }">
                            {{ data.name }}
                        </template>
                    </Column>
                    <Column header="Codigo" style="min-width: 12rem">
                        <template #body="{ data }">
                            {{ data.code }}
                        </template>
                    </Column>
                    <Column header="Localizacao" style="min-width: 12rem">
                        <template #body="{ data }">
                            {{ data.location }}
                        </template>
                    </Column>
                    <Column header="Responsavel" style="min-width: 12rem">
                        <template #body="{ data }">
                            {{ data.user ? data.user.name : 'N/A' }}
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
                            <router-link
                                class="m-3"
                                :to="'/admin/departments/' + data.id + '/edit'"
                                ><i class="pi pi-file-edit"></i
                            ></router-link>
                            <router-link class="m-3" :to="'/admin/departments/' + data.id"
                                ><i class="pi pi-eye"></i
                            ></router-link>
                            <!-- <a
                                class="m-3"
                                href="#"
                                @click.prevent="confirmDeletion(data.id)"
                                ><i class="pi pi-trash"></i
                            ></a> -->
                            
                            <!-- <a
                                class="m-3"
                                href="#"
                                @click="toggleMenu($event, data.id, data)"
                                >
                                <Menu ref="menu" :model="overlayMenuItems" :popup="true" />
                                <i class="pi pi-ellipsis-v" style="font-size: 1rem"></i></a> -->
                            
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
        header="Configuracao da conta"
        v-model:visible="displayAccountSetting"
        :style="{ width: '350px' }"
        :modal="true"
    >
        <div class="flex align-items-center justify-content-center">
            <i
                class="pi pi-exclamation-triangle mr-3"
                style="font-size: 2rem"
            />

            <span> A conta encontra-se atualmente <Tag :value="dataBeingUsed.is_active === 1 ? 'Ativo' : 'Inativo'" :severity="getSeverityStatus(dataBeingUsed.is_active)" /> <br> Tem certeza que deseja proceder para {{ dataBeingUsed.is_active === 1 ? 'Inativar' : 'Ativar' }} esta conta?</span>
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
                @click="activateUserData"
                class="p-button-text"
                autofocus
            />
        </template>
    </Dialog>
</template>
