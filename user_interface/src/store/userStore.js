import { defineStore } from "pinia"

export const userStore = defineStore('user_store', {
    state: () => (
        { 
            fullname: '',
            email: '',
            token: null,
            id: null
        }
    ),
    getters: {
      isUserAdmin: (state) => state.is_admin,
      getEmail: (state) => state.email,
      getFullName: (state) => state.fullname,
      getToken: (state) => state.token,
      getId: (state) => state.id
    },
    actions: {
        setUserData(fullname, email) {
            this.fullname = fullname;
            this.email = email;
        },
        setUserToken(token) {
            this.token = token;
        },
        setId(id) {
            this.id = id;
        }
    }
});
