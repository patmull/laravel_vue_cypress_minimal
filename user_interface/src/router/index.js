import Dashboard from "@/views/Dashboard.vue";
import {createRouter, createWebHistory} from 'vue-router';
import Login from "../views/Login.vue";
import DefaultLayout from "@/components/DefaultLayout.vue";
import ForgotPassword from "@/views/ForgotPassword.vue";
import NoPermission from "@/views/errors/NoPermission.vue";
import { ref } from "vue";
import { userStore } from "@/store/userStore";

const userRole = ref({});

const guard = async function(to, from, next) {

    // check for valid auth token
    await axiosClient.get('/sanctum/csrf-cookie').then(response => {
        console.log("sanctum cookie received.");
        console.log("response:");
        console.log(response);
    });
    await axiosClient.get('/get-permissions')
    .then(response => {
        if(response.data.includes('see_admin_sections') || response.data.includes('see_superadmin_sections')) {
            next();
        } else {
            next({name: 'noPermission'});
        }
    }).catch(error => {
        // There was an error so redirect
        console.log("Error in get-permissions");
        console.log(error);
        next({name: 'noPermission'});
    });
  };

const routes = [
{
        path: '/',
        name: 'home',
        component: DefaultLayout,
        meta: {requiresAuth: true},
        children: [
            {
                path: '/dashboard',
                name: 'dashboard',
                meta: { requiresAuth: true },
                component: Dashboard
            },
            {
                path: '/no-permission',
                name: 'noPermission',
                meta: { requiresAuth: true },
                component: NoPermission
            },
        ]
    },
    {
        path: "/login",
        name: "login",
        component: Login,
        meta: { requiresAuth: false },
    },
    {
        path: "/forgot-password",
        name: "forgotPassword",
        component: ForgotPassword,
        meta: { requiresAuth: false },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});
    
router.beforeEach((to, from, next) => {
    const userData = userStore();

    console.log("router.beforeEach: ");
    console.log("to: ");
    console.log(to);
    console.log("from: ");
    console.log(from);
    console.log("next: ");
    console.log(next);

    if (to.meta.requiresAuth && !userData.getToken) {
        console.log("No store.state.user.token found, redirecting to login...");
        next({name: 'login'});
    } else if (to.meta.requiresGuest && userData.getToken) {
        console.log("store.state.user.token found, redirecting to dashboard...");
        next({name: 'dashboard'});
    } else {
        console.log("else in beforeEach router: ");
        next();
    }
});

  
export default router;
