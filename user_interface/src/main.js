import { createApp, markRaw } from 'vue';
import App from './App.vue';

import './style.css';

import './input.css';
import 'primeflex/primeflex.css' 

import vSelect from "vue-select";
import router from "./router/index.js";
import { createPinia } from "pinia";
import 'primevue/resources/themes/aura-light-indigo/theme.css';
import "primeicons/primeicons.css";
import ToastService from 'primevue/toastservice';
import Tree from 'primevue/tree';
import store from './store';
import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs';

import PrimeVue from 'primevue/config';
import DisableAutocomplete from 'vue-disable-autocomplete';

const pinia = createPinia();
const app = createApp(App);

app.use(store);
app.use(router);
app.use(pinia);
app.use(LaravelPermissionToVueJS)
app.use(PrimeVue, {
    locale: {
        "accept": "Ano",
        "addRule": "Přidat pravidlo",
        "am": "dopoledne",
        "apply": "Použít",
        "cancel": "Zrušit",
        "choose": "Vybrat",
        "chooseDate": "Vyberte datum",
        "chooseMonth": "Vyberte měsíc",
        "chooseYear": "Vyberte rok",
        "clear": "Vyčistit",
        "completed": "Dokončeno",
        "contains": "Obsahuje",
        "custom": "Vlastní",
        "dateAfter": "Datum je po",
        "dateBefore": "Datum je před",
        "dateFormat": "dd.mm.rrrr",
        "dateIs": "Datum je",
        "dateIsNot": "Datum není",
        "dayNames": [
        "Neděle",
        "Pondělí",
        "Úterý",
        "Středa",
        "Čtvrtek",
        "Pátek",
        "Sobota"
        ],
        "dayNamesMin": [
        "Ne",
        "Po",
        "Út",
        "St",
        "Čt",
        "Pá",
        "So"
        ],
        "dayNamesShort": [
        "Ned",
        "Pon",
        "Úte",
        "Stř",
        "Čtv",
        "Pát",
        "Sob"
        ],
        "emptyFilterMessage": "Nebyly nalezeny žádné výsledky",
        "emptyMessage": "Žádné dostupné možnosti",
        "emptySearchMessage": "Nebyly nalezeny žádné výsledky",
        "emptySelectionMessage": "Žádná vybraná položka",
        "endsWith": "Končí na",
        "equals": "Rovná se",
        "fileSizeTypes": [
        "B",
        "KB",
        "MB",
        "GB",
        "TB",
        "PB",
        "EB",
        "ZB",
        "YB"
        ],
        "filter": "Filtr",
        "firstDayOfWeek": 1,
        "gt": "Větší než",
        "gte": "Větší než nebo rovno",
        "lt": "Menší než",
        "lte": "Menší než nebo rovno",
        "matchAll": "Odpovídá všem",
        "matchAny": "Odpovídá jakémukoli",
        "medium": "Střední",
        "monthNames": [
        "Leden",
        "Únor",
        "Březen",
        "Duben",
        "Květen",
        "Červen",
        "Červenec",
        "Srpen",
        "Září",
        "Říjen",
        "Listopad",
        "Prosinec"
        ],
        "monthNamesShort": [
        "Led",
        "Úno",
        "Bře",
        "Dub",
        "Kvě",
        "Čer",
        "Čvc",
        "Srp",
        "Zář",
        "Říj",
        "Lis",
        "Pro"
        ],
        "nextDecade": "Následující desetiletí",
        "nextHour": "Následující hodina",
        "nextMinute": "Následující minuta",
        "nextMonth": "Následující měsíc",
        "nextSecond": "Následující sekunda",
        "nextYear": "Následující rok",
        "noFilter": "Bez filtru",
        "notContains": "Neobsahuje",
        "notEquals": "Nerovná se",
        "now": "Teď",
        "passwordPrompt": "Zadejte heslo",
        "pending": "Čekající na nahrání. Stiskněte Nahrát.",
        "pm": "odpoledne",
        "prevDecade": "Předchozí desetiletí",
        "prevHour": "Předchozí hodina",
        "prevMinute": "Předchozí minuta",
        "prevMonth": "Předchozí měsíc",
        "prevSecond": "Předchozí sekunda",
        "prevYear": "Předchozí rok",
        "reject": "Ne",
        "removeRule": "Odstranit pravidlo",
        "searchMessage": "Je k dispozici {0} výsledků",
        "selectionMessage": "Vybráno {0} položek",
        "showMonthAfterYear": false,
        "startsWith": "Začíná na",
        "strong": "Silné",
        "today": "Dnes",
        "upload": "Nahrát",
        "weak": "Slabé",
        "weekHeader": "Týd.",
        "aria": {
        "cancelEdit": "Zrušit úpravu",
        "close": "Zavřít",
        "collapseLabel": "Kolaps",
        "collapseRow": "Sbalit řádek",
        "editRow": "Upravit řádek",
        "expandLabel": "Rozšířit",
        "expandRow": "Rozbalit řádek",
        "falseLabel": "Nepravda",
        "filterConstraint": "Omezení filtru",
        "filterOperator": "Operátor filtru",
        "firstPageLabel": "První strana",
        "gridView": "Zobrazení mřížky",
        "hideFilterMenu": "Skrýt filtr menu",
        "jumpToPageDropdownLabel": "Přejít na stránku Dropdown",
        "jumpToPageInputLabel": "Přejít na stránku Input",
        "lastPageLabel": "Poslední strana",
        "listView": "Zobrazení seznamu",
        "moveAllToSource": "Přesunout vše ke zdroji",
        "moveAllToTarget": "Přesunout vše na cíl",
        "moveBottom": "Přesunout dolů",
        "moveDown": "Přesunout dolů",
        "moveTop": "Přesunout nahoru",
        "moveToSource": "Přesunout ke zdroji",
        "moveToTarget": "Přesunout na cíl",
        "moveUp": "Přesunout nahoru",
        "navigation": "Navigace",
        "next": "Další",
        "nextPageLabel": "Další strana",
        "nullLabel": "Nevybráno",
        "otpLabel": "Zadejte jednorázový znak hesla {0}",
        "pageLabel": "Strana {page}",
        "passwordHide": "Skrýt heslo",
        "passwordShow": "Zobrazit heslo",
        "previous": "Předchozí",
        "previousPageLabel": "Předchozí strana",
        "rotateLeft": "Otočit doleva",
        "rotateRight": "Otočit doprava",
        "rowsPerPageLabel": "Řádků na stranu",
        "saveEdit": "Uložit úpravu",
        "scrollTop": "Posunout nahoru",
        "selectAll": "Všechny položky vybrány",
        "selectLabel": "Vybrat",
        "selectRow": "Vybrat řádek",
        "showFilterMenu": "Zobrazit filtr menu",
        "slide": "Snímek",
        "slideNumber": "{slideNumber}",
        "star": "1 hvězda",
        "stars": "{star} hvězd",
        "trueLabel": "Pravda",
        "unselectAll": "Všechny položky zrušeny",
        "unselectLabel": "Zrušte výběr",
        "unselectRow": "Zrušit výběr řádku",
        "zoomImage": "Přiblížit obrázek",
        "zoomIn": "Přiblížit",
        "zoomOut": "Oddálit"
      }
    },
});

app.use(ToastService);
app.use(DisableAutocomplete);
app.component('Tree', Tree);
app.component("v-select", vSelect);
app.mount('#app');