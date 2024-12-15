
<template>
    <div class="min-h-full">
        <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div id="menu" class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-8"
                                 src="https://www.adaptivewfs.com/wp-content/uploads/2020/07/logo-placeholder-image.png"
                                 alt="Company Logo" />
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <router-link
                                    v-for="item in navigation"
                                    :key="item.name"
                                    :to="item.to"
                                    active-class="bg-grey-900 text-white"
                                    :class="[
                                        route.name === item.to.name
                                        ? '' // =ELSE
                                        : 'text-gray-300 hover:bg-gray-700 hover:text-white', // =IF
                                        'block rounded-md px-3 py-2 text-base font-medium'
                                    ]">
                                    {{ item.name }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <button type="button" class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                <span class="absolute -inset-1.5" />
                                <span class="sr-only">View notifications</span>
                                <BellIcon class="h-6 w-6" aria-hidden="true" />
                            </button>

                            <!-- Profile dropdown -->
                            <Menu as="div" class="relative ml-3">
                                <div>
                                    <MenuButton id="menu-button" class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                        <div class="ml-10">
                                            <div class="text-base font-medium leading-none text-white">{{ userData.fullname || 'Loading...' }}</div>
                                            <div class="text-sm font-medium leading-none text-gray-400">{{ userData.email || 'Loading...' }}</div>
                                            <div v-if="isAdmin" class="text-sm font-medium leading-none text-gray-400">Administrátor</div>
                                            <div v-else class="text-sm font-medium leading-none text-gray-400">Uživatel</div>
                                        </div>
                                        <div class="ml-10">
                                            <span class="absolute -inset-1.5" />
                                            <span class="sr-only">Open user menu</span>
                                            <img class="h-8 rounded-full" :src="userData.imageUrl" alt="" />
                                        </div>
                                    </MenuButton>
                                </div>
                                <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                <MenuItems class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <MenuItem v-slot="{ active }">
                                        <a @click="redirectToUserPasswordReset"
                                        :class="[
                                            active ? 'bg-gray-100' : '',
                                            'user-menu-item block px-4 py-2 text-sm text-gray-700 cursor-pointer'
                                        ]"
                                        >
                                            Změna uživatelského hesla
                                        </a>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                        <a @click="logout"
                                        :class="[
                                            active ? 'bg-gray-100' : '',
                                            'block px-4 py-2 text-sm text-gray-700 cursor-pointer'
                                        ]"
                                        >
                                            Odhlásit
                                        </a>
                                    </MenuItem>
                                </MenuItems>
                                </transition>
                            </Menu>
                        </div>
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <!-- Mobile menu button -->
                        <DisclosureButton id="hamburger-menu" class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                            <span class="absolute -inset-0.5" />
                            <span class="sr-only">Open main menu</span>
                            <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true"  />
                            <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
                        </DisclosureButton>
                    </div>
                </div>
            </div>

            <DisclosurePanel class="md:hidden">
                <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
                    <router-link
                        v-for="item in navigation"
                        :key="item.name"
                        :to="item.to"
                        active-class="bg-grey-900 text-white"
                        :class="[
                            route.name === item.to.name
                            ? ''
                            : 'text-gray-300 hover:bg-gray-700 hover:text-white',
                            'block rounded-md px-3 py-2 text-base font-medium'
                        ]">
                        {{ item.name }}
                    </router-link>
                </div>

                <div class="border-t border-gray-700 pb-3 pt-4">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" :src="userData.imageUrl" alt="" />
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium leading-none text-white">{{ userData.getFullName }}</div>
                            <div class="text-sm font-medium leading-none text-gray-400">{{ userData.getEmail }}</div>
                            <div v-if="isAdmin" class="text-sm font-medium leading-none text-gray-400">Administrátor</div>
                            <div v-else class="text-sm font-medium leading-none text-gray-400">Uživatel</div>
                        </div>
                        <button type="button" class="relative ml-auto flex-shrink-0 rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                            <span class="absolute -inset-1.5" />
                            <span class="sr-only">View notifications</span>
                            <BellIcon class="h-6 w-6" aria-hidden="true" />
                        </button>
                    </div>
                    <DisclosureButton
                        as="a"
                        @click="logout"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700
                            hover:text-white cursor-pointer"
                    >
                        Odhlásit
                    </DisclosureButton>
                    <!-- Full nav:-->
                    <!--
                    <div class="mt-3 space-y-1 px-2">
                        <DisclosureButton
                            v-for="item in useruserNavigation"
                            :key="item.name" as="a"
                            :href="item.href"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700
                            hover:text-white"
                        >{{ item.name }}</DisclosureButton>
                    </div>
                    -->
                </div>
            </DisclosurePanel>
        </Disclosure>

        <router-view></router-view>
    </div>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon, BellIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import {computed} from "vue";

import {useRoute} from "vue-router";
import { logout, redirectToAdminPasswordReset, redirectToUserPasswordReset } from '@/store/actions';
import { useStore } from 'vuex';
import { onMounted } from 'vue';
import { ref } from 'vue';
import { reactive } from 'vue';
import { watch } from 'vue';
import { userStore } from '@/store/userStore';


const store = useStore();

const userData = userStore();
let navigation = reactive([]);

console.log("userData:");
console.log(userData.getEmail);

const userRole = ref({});
let isAdmin = ref(false);

// TODO? Investigate whether the onMounted / watch can be avoided, see: https://stackoverflow.com/questions/73796808/why-vue-reactive-variable-update-value-property-instead-of-value-property

onMounted(async() => {
    await axiosClient.get('/get-permissions')
        .then((response) => {
            console.log("response:");
            console.log(response);
            if(response.data.length === 0) {
                userRole.value = "user";
            } else {
                userRole.value = response.data;
            }
        }).catch((error) => {
            console.log("Error in get-permissions");
            console.log(error);
        }
    );
    console.log("userRole:");
    console.log(userRole.value);
    
    let resetPasswordLink = '';
    if(userRole) {
        console.log("userRole inside watch:");
        console.log(userRole.value.data);
        if (userRole.value.includes('see_admin_sections') || userRole.value.includes('see_superadmin_sections')) {
            console.log("userRole.value === 'see_admin_sections':");
            isAdmin.value = true;
            resetPasswordLink = '/reset-admin-password';
        } else {
            console.log("userRole.value !== 'see_admin_sections':");
            isAdmin.value = false;
            resetPasswordLink = '/reset-password';
        }
    }

    console.log("isAdmin.value:");
    console.log(isAdmin.value);

    if (isAdmin.value === true) {            
        navigation.splice(0, navigation.length, 
            { name: 'Nástěnka', to: { name: 'dashboard' } },
            { name: 'Zaměstnanci', to: { name: 'employeesManagement' } },
            { name: 'Správa akcí', to: { name: 'eventsManagement' } },
            { name: 'Pozvánky na směny', to: { name: 'invitationsManagement' } }
        );
    } else {
        navigation.splice(0, navigation.length,
            { name: 'Nástěnka', to: { name: 'dashboard' } },
            { name: 'Moje směny', to: { name: 'myEvents' } },
            { name: 'Moje dokumenty', to: { name: 'myDocuments' } }
        );
    }
});

userData.setUserData(sessionStorage.getItem('user_full_name'), sessionStorage.getItem('user_email'));

const route = useRoute();

console.log("userRole:");
console.log(userRole.value);


console.log("store.state.user.email:");
console.log(store.state.user.email);

</script>
