import AppLayout from "@/layout/AppLayout.vue";
import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/",
            name: "landing",
            component: () => import("@/views/pages/Landing.vue"),
        },
        {
            path: "/admin",
            component: AppLayout,
            children: [
                {
                    path: "/admin/users",
                    name: "users",
                    component: () => import("@/views/pages/users/IndexUsers.vue"),
                },
                {
                    path: "/admin/users/:id/edit",
                    name: "users.edit",
                    component: () => import("@/views/pages/users/EditUsers.vue"),
                },
                {
                    path: "/admin/users/create",
                    name: "users.create",
                    component: () => import("@/views/pages/users/CreateUsers.vue"),
                },
                {
                    path: "/admin/users/:id",
                    name: "users.show",
                    component: () => import("@/views/pages/users/ShowUsers.vue"),
                },


                {
                    path: "/admin/invitationlinks",
                    name: "invitationlinks",
                    component: () => import("@/views/pages/invitationlinks/IndexInvitationLinks.vue"),
                },
                {
                    path: "/admin/invitationlinks/:id/edit",
                    name: "invitationlinks.edit",
                    component: () => import("@/views/pages/invitationlinks/EditInvitationLinks.vue"),
                },
                {
                    path: "/admin/invitationlinks/create",
                    name: "invitationlinks.create",
                    component: () => import("@/views/pages/invitationlinks/CreateInvitationLinks.vue"),
                },
                {
                    path: "/admin/invitationlinks/:id",
                    name: "invitationlinks.show",
                    component: () => import("@/views/pages/invitationlinks/ShowInvitationLinks.vue"),
                },


                {
                    path: "/admin/departments",
                    name: "departments",
                    component: () => import("@/views/pages/departments/IndexDepartments.vue"),
                },
                {
                    path: "/admin/departments/:id/edit",
                    name: "departments.edit",
                    component: () => import("@/views/pages/departments/EditDepartments.vue"),
                },
                {
                    path: "/admin/departments/create",
                    name: "departments.create",
                    component: () => import("@/views/pages/departments/CreateDepartments.vue"),
                },
                {
                    path: "/admin/departments/:id",
                    name: "departments.show",
                    component: () => import("@/views/pages/departments/ShowDepartments.vue"),
                },

                {
                    path: "/admin/permissions",
                    name: "permissions",
                    component: () => import("@/views/pages/permissions/IndexPermissions.vue"),
                },
                {
                    path: "/admin/permissions/create",
                    name: "permissions.create",
                    component: () => import("@/views/pages/permissions/IndexPermissions.vue"),
                    props: route => ({ openCreate: true })
                },

                {
                    path: "/admin/roles",
                    name: "roles",
                    component: () => import("@/views/pages/roles/IndexRoles.vue"),
                },
                {
                    path: "/admin/roles/create",
                    name: "roles.create",
                    component: () => import("@/views/pages/roles/IndexRoles.vue"),
                    props: route => ({ openCreate: true })
                },







                {
                    path: "/admin/dashboard",
                    name: "dashboard",
                    component: () => import("@/views/Dashboard.vue"),
                },
                {
                    path: "/admin/uikit/formlayout",
                    name: "formlayout",
                    component: () => import("@/views/uikit/FormLayout.vue"),
                },
                {
                    path: "/admin/uikit/input",
                    name: "input",
                    component: () => import("@/views/uikit/InputDoc.vue"),
                },
                {
                    path: "/admin/uikit/button",
                    name: "button",
                    component: () => import("@/views/uikit/ButtonDoc.vue"),
                },
                {
                    path: "/admin/uikit/table",
                    name: "table",
                    component: () => import("@/views/uikit/TableDoc.vue"),
                },
                {
                    path: "/admin/uikit/list",
                    name: "list",
                    component: () => import("@/views/uikit/ListDoc.vue"),
                },
                {
                    path: "/admin/uikit/tree",
                    name: "tree",
                    component: () => import("@/views/uikit/TreeDoc.vue"),
                },
                {
                    path: "/admin/uikit/panel",
                    name: "panel",
                    component: () => import("@/views/uikit/PanelsDoc.vue"),
                },

                {
                    path: "/admin/uikit/overlay",
                    name: "overlay",
                    component: () => import("@/views/uikit/OverlayDoc.vue"),
                },
                {
                    path: "/admin/uikit/media",
                    name: "media",
                    component: () => import("@/views/uikit/MediaDoc.vue"),
                },
                {
                    path: "/admin/uikit/message",
                    name: "message",
                    component: () => import("@/views/uikit/MessagesDoc.vue"),
                },
                {
                    path: "/admin/uikit/file",
                    name: "file",
                    component: () => import("@/views/uikit/FileDoc.vue"),
                },
                {
                    path: "/admin/uikit/menu",
                    name: "menu",
                    component: () => import("@/views/uikit/MenuDoc.vue"),
                },
                {
                    path: "/admin/uikit/charts",
                    name: "charts",
                    component: () => import("@/views/uikit/ChartDoc.vue"),
                },
                {
                    path: "/admin/uikit/misc",
                    name: "misc",
                    component: () => import("@/views/uikit/MiscDoc.vue"),
                },
                {
                    path: "/admin/uikit/timeline",
                    name: "timeline",
                    component: () => import("@/views/uikit/TimelineDoc.vue"),
                },
                {
                    path: "/admin/pages/empty",
                    name: "empty",
                    component: () => import("@/views/pages/Empty.vue"),
                },
                {
                    path: "/admin/pages/crud",
                    name: "crud",
                    component: () => import("@/views/pages/Crud.vue"),
                },
                {
                    path: "/admin/documentation",
                    name: "documentation",
                    component: () => import("@/views/pages/Documentation.vue"),
                },
            ],
        },

        {
            path: "/pages/notfound",
            name: "notfound",
            component: () => import("@/views/pages/NotFound.vue"),
        },

        {
            path: "/auth/login",
            name: "login",
            component: () => import("@/views/pages/auth/Login.vue"),
        },
        {
            path: "/auth/access",
            name: "accessDenied",
            component: () => import("@/views/pages/auth/Access.vue"),
        },
        {
            path: "/auth/error",
            name: "error",
            component: () => import("@/views/pages/auth/Error.vue"),
        },
    ],
});

export default router;
