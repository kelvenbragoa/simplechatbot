<script setup>
import { ref } from "vue";

import AppMenuItem from "./AppMenuItem.vue";

const model = ref([
    {
        label: "Dashboard",
        items: [
            {
                label: "Painel do Sistema",
                icon: "pi pi-chart-line",
                to: "/admin/dashboard",
            },
        ],
    },
    {
        label: "Módulos",
        items: [
            {
                label: "Credenciais",
                icon: "pi pi-id-card",
                items: [
                    {
                        label: "Pendentes",
                        icon: "pi pi-clock",
                        to: "/landing",
                    },
                    {
                        label: "Aprovados",
                        icon: "pi pi-check-circle",
                        to: "/pages/crud",
                    },
                    {
                        label: "Rejeitados",
                        icon: "pi pi-times-circle",
                        to: "/pages/notfound",
                    },
                ],
            },
            {
                label: "Internos",
                icon: "pi pi-users",
                items: [
                    {
                        label: "Listar",
                        icon: "pi pi-list",
                        to: "/landing",
                    },
                    {
                        label: "Adicionar novo",
                        icon: "pi pi-user-plus",
                        to: "/pages/crud",
                    },
                ],
            },
            {
                label: "Acesso Portuário",
                icon: "pi pi-briefcase",
                items: [
                    {
                        label: "Viaturas",
                        icon: "pi pi-car",
                        items: [
                            {
                                label: "Adicionar",
                                icon: "pi pi-plus",
                                to: "/landing",
                            },
                            {
                                label: "Lista",
                                icon: "pi pi-list",
                                to: "/pages/crud",
                            },
                            {
                                label: "Triagem",
                                icon: "pi pi-filter",
                                to: "/pages/crud",
                            },
                            {
                                label: "Aprovação de Acesso",
                                icon: "pi pi-check-square",
                                to: "/pages/crud",
                            },
                            {
                                label: "Aprovados",
                                icon: "pi pi-check-circle",
                                to: "/pages/crud",
                            },
                            {
                                label: "Rejeitados",
                                icon: "pi pi-times-circle",
                                to: "/pages/crud",
                            },
                        ],
                    },
                    {
                        label: "Utentes",
                        icon: "pi pi-user",
                        items: [
                            {
                                label: "Adicionar",
                                icon: "pi pi-user-plus",
                                to: "/landing",
                            },
                            {
                                label: "Importar",
                                icon: "pi pi-upload",
                                to: "/pages/crud",
                            },
                            {
                                label: "Lista",
                                icon: "pi pi-users",
                                to: "/pages/crud",
                            },
                            {
                                label: "Triagem",
                                icon: "pi pi-filter",
                                to: "/pages/crud",
                            },
                            {
                                label: "Aprovação de Acesso",
                                icon: "pi pi-check-square",
                                to: "/pages/crud",
                            },
                            {
                                label: "Cartões de Internos",
                                icon: "pi pi-id-card",
                                to: "/pages/crud",
                            },
                            {
                                label: "Cartões de Externos",
                                icon: "pi pi-id-card",
                                to: "/pages/crud",
                            },
                        ],
                    },
                    {
                        label: "Dasso",
                        icon: "pi pi-shield",
                        items: [
                            {
                                label: "Induções",
                                icon: "pi pi-video",
                                to: "/landing",
                            },
                            {
                                label: "Induzidos",
                                icon: "pi pi-user-check",
                                to: "/pages/crud",
                            },
                            {
                                label: "Rejeitados",
                                icon: "pi pi-user-minus",
                                to: "/pages/crud",
                            },
                            {
                                label: "Transações",
                                icon: "pi pi-exchange",
                                to: "/pages/crud",
                            },
                        ],
                    },
                ],
            },
        ],
    },
    {
        label: "Cornelder de Moçambique",
        items: [
            {
                label: "Sistema",
                icon: "pi pi-cog",
                items: [
                    {
                        label: "Pedidos",
                        icon: "pi pi-inbox",
                        to: "/pages/crud",
                    },
                    {
                        label: "Aprovados",
                        icon: "pi pi-check-circle",
                        to: "/pages/crud",
                    },
                ],
            },
            {
                label: "Veículos",
                icon: "pi pi-car",
                items: [
                    {
                        label: "Classes",
                        icon: "pi pi-tags",
                        items: [
                            {
                                label: "Novo",
                                icon: "pi pi-plus",
                                to: "/pages/crud",
                            },
                            {
                                label: "Lista",
                                icon: "pi pi-list",
                                to: "/pages/crud",
                            },
                        ],
                    },
                    {
                        label: "Marcas",
                        icon: "pi pi-briefcase",
                        items: [
                            {
                                label: "Novo",
                                icon: "pi pi-plus",
                                to: "/pages/crud",
                            },
                            {
                                label: "Lista",
                                icon: "pi pi-list",
                                to: "/pages/crud",
                            },
                        ],
                    },
                ],
            },
            {
                label: "Atividades",
                icon: "pi pi-calendar",
                items: [
                    {
                        label: "Nova",
                        icon: "pi pi-plus",
                        to: "/pages/crud",
                    },
                    {
                        label: "Lista",
                        icon: "pi pi-list",
                        to: "/pages/crud",
                    },
                    {
                        label: "Área de Atividades",
                        icon: "pi pi-map-marker",
                        items: [
                            {
                                label: "Novo",
                                icon: "pi pi-plus",
                                to: "/pages/crud",
                            },
                            {
                                label: "Lista",
                                icon: "pi pi-list",
                                to: "/pages/crud",
                            },
                        ],
                    },
                    {
                        label: "Aprovadores",
                        icon: "pi pi-check-square",
                        items: [
                            {
                                label: "Novo",
                                icon: "pi pi-user-plus",
                                to: "/pages/crud",
                            },
                            {
                                label: "Lista",
                                icon: "pi pi-users",
                                to: "/pages/crud",
                            },
                        ],
                    },
                ],
            },
        ],
    },
    {
        label: "Departamentos",
        items: [
            {
                label: "Departamentos",
                icon: "pi pi-sitemap", // estrutura organizacional
                items: [
                    {
                        label: "Novo",
                        icon: "pi pi-plus",
                        to: "/admin/departments/create",
                    },
                    {
                        label: "Lista",
                        icon: "pi pi-list",
                        to: "/admin/departments",
                    },
                    {
                        label: "Acessos Pendentes",
                        icon: "pi pi-clock",
                        to: "/pages/crud",
                    },
                    {
                        label: "Acessos Finalizados",
                        icon: "pi pi-check-square",
                        to: "/pages/crud",
                    },
                    {
                        label: "Link de Convite",
                        icon: "pi pi-link",
                        to: "/admin/invitationlinks",
                    },
                ],
            },
        ],
    },
    {
        label: "Super Administrador",
        items: [
            {
                label: "Configurações",
                icon: "pi pi-sliders-h",
                items: [
                    {
                        label: "Privilégios",
                        icon: "pi pi-lock-open",
                        items: [
                            {
                                label: "Novo",
                                icon: "pi pi-plus",
                                to: "/admin/roles/create",
                            },
                            {
                                label: "Lista",
                                icon: "pi pi-list",
                                to: "/admin/roles",
                            },
                        ],
                    },
                    {
                        label: "Permissões",
                        icon: "pi pi-shield",
                        items: [
                            {
                                label: "Novo",
                                icon: "pi pi-plus",
                                to: "/admin/permissions/create",
                            },
                            {
                                label: "Lista",
                                icon: "pi pi-list",
                                to: "/admin/permissions",
                            },
                        ],
                    },
                    {
                        label: "Utilizadores",
                        icon: "pi pi-users",
                        items: [
                            {
                                label: "Novo",
                                icon: "pi pi-user-plus",
                                to: "/admin/users/create",
                            },
                            {
                                label: "Lista",
                                icon: "pi pi-users",
                                to: "/admin/users",
                            },
                        ],
                    },
                ],
            },
        ],
    },
    {
        label: "Configurações",
        items: [
            {
                label: "Perfil",
                icon: "pi pi-user",
                to: "/admin/uikit/formlayout",
            },
            {
                label: "Senha",
                icon: "pi pi-lock",
                to: "/admin/uikit/input",
            },
        ],
    },

    // {
    //     label: "UI Components",
    //     items: [
    //         {
    //             label: "Form Layout",
    //             icon: "pi pi-fw pi-id-card",
    //             to: "/admin/uikit/formlayout",
    //         },
    //         {
    //             label: "Input",
    //             icon: "pi pi-fw pi-check-square",
    //             to: "/admin/uikit/input",
    //         },
    //         {
    //             label: "Button",
    //             icon: "pi pi-fw pi-mobile",
    //             to: "/admin/uikit/button",
    //             class: "rotated-icon",
    //         },
    //         {
    //             label: "Table",
    //             icon: "pi pi-fw pi-table",
    //             to: "/admin/uikit/table",
    //         },
    //         {
    //             label: "List",
    //             icon: "pi pi-fw pi-list",
    //             to: "/admin/uikit/list",
    //         },
    //         {
    //             label: "Tree",
    //             icon: "pi pi-fw pi-share-alt",
    //             to: "/admin/uikit/tree",
    //         },
    //         {
    //             label: "Panel",
    //             icon: "pi pi-fw pi-tablet",
    //             to: "/admin/uikit/panel",
    //         },
    //         {
    //             label: "Overlay",
    //             icon: "pi pi-fw pi-clone",
    //             to: "/admin/uikit/overlay",
    //         },
    //         {
    //             label: "Media",
    //             icon: "pi pi-fw pi-image",
    //             to: "/admin/uikit/media",
    //         },
    //         {
    //             label: "Menu",
    //             icon: "pi pi-fw pi-bars",
    //             to: "/admin/uikit/menu",
    //         },
    //         {
    //             label: "Message",
    //             icon: "pi pi-fw pi-comment",
    //             to: "/admin/uikit/message",
    //         },
    //         {
    //             label: "File",
    //             icon: "pi pi-fw pi-file",
    //             to: "/admin/uikit/file",
    //         },
    //         {
    //             label: "Chart",
    //             icon: "pi pi-fw pi-chart-bar",
    //             to: "/admin/uikit/charts",
    //         },
    //         {
    //             label: "Timeline",
    //             icon: "pi pi-fw pi-calendar",
    //             to: "/admin/uikit/timeline",
    //         },
    //         {
    //             label: "Misc",
    //             icon: "pi pi-fw pi-circle",
    //             to: "/admin/uikit/misc",
    //         },
    //     ],
    // },
    // {
    //     label: "Pages",
    //     icon: "pi pi-fw pi-briefcase",
    //     to: "/pages",
    //     items: [
    //         {
    //             label: "Landing",
    //             icon: "pi pi-fw pi-globe",
    //             to: "/landing",
    //         },
    //         {
    //             label: "Auth",
    //             icon: "pi pi-fw pi-user",
    //             items: [
    //                 {
    //                     label: "Login",
    //                     icon: "pi pi-fw pi-sign-in",
    //                     to: "/auth/login",
    //                 },
    //                 {
    //                     label: "Error",
    //                     icon: "pi pi-fw pi-times-circle",
    //                     to: "/auth/error",
    //                 },
    //                 {
    //                     label: "Access Denied",
    //                     icon: "pi pi-fw pi-lock",
    //                     to: "/auth/access",
    //                 },
    //             ],
    //         },
    //         {
    //             label: "Crud",
    //             icon: "pi pi-fw pi-pencil",
    //             to: "/pages/crud",
    //         },
    //         {
    //             label: "Not Found",
    //             icon: "pi pi-fw pi-exclamation-circle",
    //             to: "/pages/notfound",
    //         },
    //         {
    //             label: "Empty",
    //             icon: "pi pi-fw pi-circle-off",
    //             to: "/pages/empty",
    //         },
    //     ],
    // },
    // {
    //     label: "Hierarchy",
    //     items: [
    //         {
    //             label: "Submenu 1",
    //             icon: "pi pi-fw pi-bookmark",
    //             items: [
    //                 {
    //                     label: "Submenu 1.1",
    //                     icon: "pi pi-fw pi-bookmark",
    //                     items: [
    //                         {
    //                             label: "Submenu 1.1.1",
    //                             icon: "pi pi-fw pi-bookmark",
    //                         },
    //                         {
    //                             label: "Submenu 1.1.2",
    //                             icon: "pi pi-fw pi-bookmark",
    //                         },
    //                         {
    //                             label: "Submenu 1.1.3",
    //                             icon: "pi pi-fw pi-bookmark",
    //                         },
    //                     ],
    //                 },
    //                 {
    //                     label: "Submenu 1.2",
    //                     icon: "pi pi-fw pi-bookmark",
    //                     items: [
    //                         {
    //                             label: "Submenu 1.2.1",
    //                             icon: "pi pi-fw pi-bookmark",
    //                         },
    //                     ],
    //                 },
    //             ],
    //         },
    //         {
    //             label: "Submenu 2",
    //             icon: "pi pi-fw pi-bookmark",
    //             items: [
    //                 {
    //                     label: "Submenu 2.1",
    //                     icon: "pi pi-fw pi-bookmark",
    //                     items: [
    //                         {
    //                             label: "Submenu 2.1.1",
    //                             icon: "pi pi-fw pi-bookmark",
    //                         },
    //                         {
    //                             label: "Submenu 2.1.2",
    //                             icon: "pi pi-fw pi-bookmark",
    //                         },
    //                     ],
    //                 },
    //                 {
    //                     label: "Submenu 2.2",
    //                     icon: "pi pi-fw pi-bookmark",
    //                     items: [
    //                         {
    //                             label: "Submenu 2.2.1",
    //                             icon: "pi pi-fw pi-bookmark",
    //                         },
    //                     ],
    //                 },
    //             ],
    //         },
    //     ],
    // },
    // {
    //     label: "Get Started",
    //     items: [
    //         {
    //             label: "Documentation",
    //             icon: "pi pi-fw pi-book",
    //             to: "/documentation",
    //         },
    //         {
    //             label: "View Source",
    //             icon: "pi pi-fw pi-github",
    //             url: "https://github.com/primefaces/sakai-vue",
    //             target: "_blank",
    //         },
    //     ],
    // },
]);
</script>

<template>
    <ul class="layout-menu">
        <template v-for="(item, i) in model" :key="item">
            <app-menu-item
                v-if="!item.separator"
                :item="item"
                :index="i"
            ></app-menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
    </ul>
</template>

<style lang="scss" scoped></style>
