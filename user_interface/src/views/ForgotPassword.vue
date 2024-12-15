<script setup>
import axios from '@/axios';
import BaseBtn from '@/components/BaseBtn.vue';
import { computed } from 'vue';
import { ref } from 'vue';
import {useCommonUserMessage} from '@/store/commonMsgStore';
import router from '@/router';

console.log("ForgotPassword.vue");

const email = ref('');
let errors = ref({});
let success = ref('');

const scleroticUser = {
    email: '',   
};

const hasAnyProgramError = ref(false);
const commonUsrMessageStore = useCommonUserMessage();

// debug
// console.log("store:");
// console.log(commonUsrMessageStore.getProgramErrorMsg);

async function forgotPassword() {

    await axios.get('/sanctum/csrf-cookie')
    .catch(error => {
        console.log("error while getting csrf-cookie: " + error);
        hasAnyProgramError.value = true;    
    });
    await axios
        .post('/forgot-password', scleroticUser)
        .then(response => {
            success.value = response.data.message; // TODO: Display on the login page the success message. PRIORITY: C
            console.log("success.value:");
            console.log(success.value);
            router.push({name: 'login'});
        })
        .catch(error => {
            if(error.response) {
                if (error.response.status === 422) {
                    console.log("Error 422 while requesting /forgot-password");
                    console.log(error.response.data.errors);
                    errors.value = error.response.data.errors;
                    hasAnyProgramError.value = true;
                } else {
                    console.log("Error while requesting /forgot-password (other than 422)");
                    hasAnyProgramError.value = true;
                }
            } else {
                hasAnyProgramError.value = true;
                console.log("Other error while requesting /forgot-password:");
                console.log(error);
            }
        });
}

const hasAnyError = computed(() => {
    console.log("hasAnyError:");
    console.log(errors.value);

    return Object.keys(errors.value).length > 0;
});

const errorMsg = computed(() => {
    console.log("hasAnyError:");
    console.log(errors.value);

    let errorMsgList = [];

    // Loop over each key in the errors object
    Object.keys(errors.value).forEach((key) => {
        // Concatenate all messages from the array corresponding to the key
        errorMsgList = errorMsgList.concat(errors.value[key]);
    });

    // errorMsgList = errorMsgList.length == 1 ? errorMsgList[0] : [ errorMsgList.slice(0, errorMsgList.length - 1).join(", "), errorMsgList[errorMsgList.length - 1] ].join(" and ");

    return errorMsgList.join(', ');
});

</script>

<template>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                4events    
            </a>
            <div class="w-full p-6 bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md dark:bg-gray-800 dark:border-gray-700 sm:p-8">
                <h1 class="mb-1 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Zapomněli jste heslo?
                </h1>
                <p class="font-light text-gray-500 dark:text-gray-400">Zadejte svůj e-mail a bude vám umožněno nastavit nové heslo.</p>
                <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" @submit.prevent="forgotPassword()">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Váš e-mail:</label>
                        <input v-model="scleroticUser.email" type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="jmeno@domena.com" required="">
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms" aria-describedby="terms" type="checkbox" class="" required>
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="terms" class="font-light text-gray-500 dark:text-gray-300">Souhlasím s <a class="font-medium text-primary-600 hover:underline dark:text-primary-500" href="#">podmínkami společnosti</a></label>
                        </div>
                    </div>
                    <BaseBtn type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Odeslat</BaseBtn>
                    <div v-if="hasAnyError" style="color:red">{{ errorMsg }}</div>
                    <div v-if="hasAnyProgramError" style="color: red">{{ commonUsrMessageStore.getProgramErrorMsg }}</div>
                </form>
            </div>
        </div>
    </section>
</template>
