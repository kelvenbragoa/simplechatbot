<script setup>
import { CustomerService } from "@/service/CustomerService";
import { ProductService } from "@/service/ProductService";
// import { FilterMatchMode, FilterOperator } from '@primevue/core/api';
import { onBeforeMount, reactive, ref, onMounted, watch } from "vue";
import { RouterView, RouterLink, useRouter, useRoute } from "vue-router";
import axios from "axios";

// import { debounce } from 'lodash';
import { useToast } from "primevue/usetoast";
import { debounce } from "lodash-es";
// import { baseURL, storageURL } from '@/service/ApiConstant';

import moment from "moment";

const router = useRouter();
const toast = useToast();
const loading1 = ref(null);
const isLoadingDiv = ref(true);
const loadingButtonDelete = ref(false);
let dataIdBeingDeleted = ref(null);
const searchQuery = ref("");
const retriviedData = ref(null);
const currentPage = ref(1);
const rowsPerPage = ref(15);
const totalRecords = ref(0);
const displayConfirmation = ref(false);

function goBackUsingBack() {
    if (router) {
        router.back();
    }
}

const formatDate = (date) => (date ? moment(date).format("DD/MM/YYYY") : "-");
const formatDateTime = (datetime) =>
    datetime ? moment(datetime).format("DD/MM/YYYY HH:mm") : "-";

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

const getData = async (page = 1) => {
    axios
        .get(`/api/invitationlinks/${router.currentRoute.value.params.id}`, {
            params: {
                query: searchQuery.value,
            },
        })
        .then((response) => {
            retriviedData.value = response.data;
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
        .delete(`/api/invitationlinks/${dataIdBeingDeleted.value}`)
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

    <div class="flex flex-col md:flex-row gap-12" v-else>
        <div class="w-full">
            <div class="card">
                <div class="w-full mb-5">
                    <Button
                        label="Voltar"
                        class="mr-2 mb-2"
                        @click="goBackUsingBack"
                        ><i class="pi pi-angle-left"></i> Voltar</Button
                    >
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Dados pessoais -->
                    <div>
                        <h3 class="font-semibold text-lg mb-2">
                            Informações Pessoais
                        </h3>
                        <div class="mb-2">
                            <i class="pi pi-user mr-2"></i
                            ><strong>Nome completo:</strong>
                            {{ retriviedData.name }}
                        </div>
                        <div class="mb-2">
                            <i class="pi pi-calendar mr-2"></i
                            ><strong>Data de nascimento:</strong>
                            {{ formatDate(retriviedData.date_of_birth) }}
                        </div>
                        <div class="mb-2">
                            <i class="pi pi-invitationlinks mr-2"></i
                            ><strong>Gênero:</strong>
                            {{ retriviedData.gender?.name }}
                        </div>
                        <div class="mb-2">
                            <i class="pi pi-check-circle mr-2"></i
                            ><strong>Activo:</strong>
                            {{ retriviedData.is_active ? "Sim" : "Não" }}
                        </div>
                    </div>

                    <!-- Contactos e departamento -->
                    <div>
                        <h3 class="font-semibold text-lg mb-2">
                            Contacto e Organização
                        </h3>
                        <div class="mb-2">
                            <i class="pi pi-phone mr-2"></i
                            ><strong>Telefone:</strong>
                            {{ retriviedData.mobile }}
                        </div>
                        <div class="mb-2">
                            <i class="pi pi-envelope mr-2"></i
                            ><strong>Email:</strong> {{ retriviedData.email }}
                        </div>
                        <div class="mb-2">
                            <i class="pi pi-sitemap mr-2"></i
                            ><strong>Departamento:</strong>
                            {{ retriviedData.department?.name }}
                        </div>
                        <div class="mb-2">
                            <i class="pi pi-building mr-2"></i
                            ><strong>Empresa:</strong>
                            {{ retriviedData.company?.name }}
                        </div>
                        <div class="mb-2">
                            <i class="pi pi-clock mr-2"></i
                            ><strong>Data de criação:</strong>
                            {{ formatDateTime(retriviedData.created_at) }}
                        </div>
                    </div>
                </div>
                <hr>
                
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
</template>
