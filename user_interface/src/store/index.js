import {createStore} from "vuex";
import state from './state';
import * as actions from './actions'
import * as mutations from './mutations'
import * as getters from './getters'


const store = createStore({
    relevantCountries: [
        {code: 'CZ', country: 'Česká republika'},
        {code: 'SK', country: 'Slovensko'}
    ],
    state,
    modules: {},
    mutations,
    actions,
    getters
});

export default store;