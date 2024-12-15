<script>
export default {
  data() {
    return {
      pageTitle: ''
    };
  }
};

</script>

<script setup>
import { computed, ref } from "vue";

import BaseInput from "@/components/BaseInput.vue";
import BaseBtn from "@/components/BaseBtn.vue";
import LogoTitle from "@/components/pieces/LogoTitle.vue";
import { useRouter, useRoute } from "vue-router";
import {useStore} from "vuex";
import {userStore} from "@/store/userStore";
import {useGlobalErrorStore} from "@/store/globalErrorStore";
import { useCommonUserMessage } from "@/store/commonMsgStore";
import { onMounted } from "vue";
// import axios from "@/axios";
import axios from "axios";

const userData = userStore();
const globalError = useGlobalErrorStore();
const store = useStore();

const pageTitle = ref('Login Page');
let errors = ref({});
let programErrors = ref([]);
const route = useRoute(); // Retrieve the current route object
const successMessage = ref(''); // Define a ref to hold the success message

onMounted(() => {

  // Check if there is a success message in the query parameters
  if (route.query.success) {
    successMessage.value = route.query.success;
  }
});

console.log("VITE_APP_URL:" + import.meta.env.VITE_APP_URL);
console.log("VITE_APP_API_URL:" + import.meta.env.VITE_APP_API_URL);

const user = {
    email: '',
    password: '',
    remember: false
}

let router = useRouter();

async function login() 
{  
  console.log("user:");
  console.log(user);

  console.log("clearing old cookies");
  // manually removing cookies
  // removeCookies();

  await axios.get('/sanctum/csrf-cookie').catch(error => {
    console.log("error while getting csrf-cookie: " + error);
    console.log(error);
    let newError = {message: "Systém je dočasně nedostupný. Prosím, zkuste později nebo nás kontaktuje pro více informací.", type: "other_than_422"};
    programErrors.value.push(newError); // .value needs to be there since "ref" is used!!!
    throw new Error(error);
  });
  console.log("sanctum cookie received.");
}

const hasAnyError = computed(() => {

    const commonUsrMessageStore = useCommonUserMessage();

    // debug
    console.log("hasAnyError:");
    console.log(errors.value);
    console.log("programErrors.value:");
    console.log(programErrors);

    if (Object.keys(programErrors.value).length > 0) {
        console.log("programErrors.value:");
        console.log(programErrors.value);
        if(programErrors.value[0]['message']) {
          console.log("programErrors['message']");
          console.log(programErrors.value[0]['message']);
          return programErrors.value[0]['message'];
        }
    }

    console.log("globalError.isProgramErrorSet:");
    console.log(globalError.isProgramErrorSet);

    if (sessionStorage.getItem('global_program_error') === true || globalError.isProgramErrorSet) {
      console.log("commonUsrMessageStore:");
      console.log(commonUsrMessageStore.getProgramErrorMsg);
      return commonUsrMessageStore.getProgramErrorMsg;
    }

    if(Object.keys(errors.value).length > 0){
        console.log("errors.value:");  
        console.log(errors.value);

        if (errors.value['email']) {
            return errors.value['email'][0];
        } else if (errors.value['password']) {
          return errors.value['password'][0];
        }
        else {
          throw new Error('Unexpected error when reading credential response.');
        }
    }

    return false;
});

</script>


<template>
  <LogoTitle :title="pageTitle"></LogoTitle>

  <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" action="#" method="POST" @submit.prevent="login">
        <BaseInput
          type="email"
          label="E-mail"
          name="email"
          v-model="user.email"
          autocomplete="email"
          placeholder="Váš e-mail použitý pro registraci"
          class="mb-2"
          required
        />
        <BaseInput
          type="password"
          label="Password"
          name="password"
          v-model="user.password"
          class=""
          autocomplete
          required
        />
        <div>
          <BaseBtn id="login-btn" type="submit" text="Přihlásit" />
        </div>
        <div v-if="hasAnyError" class="text-red-600" id="has-any-error-div">
          {{ hasAnyError }}
        </div>
      </form>

      <!-- ... (your other template code) -->
      <div id="success-registration" v-if="successMessage" class="text-green-600">
        {{ successMessage }}
      </div>
      <!-- ... (the rest of your template code) -->
    </div>
  </div>
</template>


<style scoped>

</style>

