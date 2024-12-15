import { useRouter } from "vue-router";
import axios from "../axios";
import store from "../store";
import { setToken } from "./mutations";
import router from "@/router";
import { userStore } from "./userStore";


export async function logout() {
  const userData = userStore();

  await axios.get('/sanctum/csrf-cookie');  
  return axios.post('/logout')
    .then((response) => {
      setToken(null);
      store.state.user.token = null;
      sessionStorage.removeItem('user_email');
      sessionStorage.removeItem('user_fullname');

      userData.setUserToken(null);
      userData.setUserData('', '');

      router.push({name: 'login'});
    })
    .catch(error => {
      console.log(error);
    });
}

export async function redirectToAdminPasswordReset() {
  router.push({name: 'adminResetPassword'});
}

export async function redirectToUserPasswordReset() {
  router.push({name: 'resetUserPassword'});
}
