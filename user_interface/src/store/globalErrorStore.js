import { defineStore } from "pinia"

export const useGlobalErrorStore = defineStore('global_errors', {
    state: () => (
        { errorValue: false, }
    ),
    getters: {
        isProgramErrorSet: (state) => state.errorValue,
    },
    actions: {
        setError() {
            this.errorValue = true;
        },
        removeError() {
            this.errorValue = false;
        },
    }
});
