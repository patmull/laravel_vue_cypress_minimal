import { defineStore } from "pinia"

export const useCommonUserMessage = defineStore('common_user_message', {
    state: () => (
      { 
        programErrorMsg: "Programová chyba. Systém je dočasně nedostupný.", 
      }
    ),
    getters: {
      getProgramErrorMsg: (state) => state.programErrorMsg,
    }
});
