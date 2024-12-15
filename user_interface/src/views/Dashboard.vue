<script setup>

import { ref, onMounted, computed, toRaw } from 'vue';
import { FilterMatchMode } from 'primevue/api';

import { useToast } from 'primevue/usetoast';
import { reactive } from "vue";
import Dropdown from 'primevue/dropdown';

const userRole = ref({});

const nodes = ref(null);
const documents = ref();
const document_file = ref({});
let loading = ref(false);
const documentDialog = ref(false);
const authError = '';
let programError = ref(false);
const toast = useToast();
let errors = ref({});
let uploadedFile = reactive(null);
let displayEmployeeDocuments = ref(false);
let fileWasUploaded = ref(false);

const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    file_path_employee: { value: null, matchMode: FilterMatchMode.CONTAINS },
    file_path_employer: { value: null, matchMode: FilterMatchMode.CONTAINS },
});
let fileWasSelected = ref(false);

const hasAnyError = computed(() => {
    console.log("hasAnyError:");
    console.log(errors.value);
    // debug
    if(errors.value) {
        if(errors.value['personal_number_part_1']) {
            console.log("errors.value['personal_number_part_1']:");
            console.log(errors.value['personal_number_part_1'][0]);            
        }

        // this works for the nested attribute objects
        // personal_number.part_1
        if(errors.value['personal_number.part_1']) {
            console.log("errors.value.personal_number.part_1[0]:");
            console.log(errors.value['personal_number.part_1'][0]);
        }

        if(errors.value['personal_number_merged']) {
            console.log("errors.value.personal_number_merged[0]:");
            console.log(errors.value['personal_number_merged'][0]);
        }
    }

    console.log("App received following errors:");
    for (const [key, value] of Object.entries(errors.value)) {
        console.log("Received error:");
        console.log(`${key}: ${value}`);
        errorMessages.push(`${value}`);
    }
    
    return Object.keys(errors.value).length > 0;
});

const onSelectedFiles = (event) => {
    console.log("event:");
    console.log(event);
    console.log("file selected");
    //toast.add({ severity: 'info', summary: 'Success', detail: 'File Uploaded', life: 3000 });

    fileWasSelected.value = true;
};

const selectedCompany = ref();
const companies = ref([]);
const showDropdown = ref(false);

const fetchCompanies = async () => {
  try {
    await axiosClient.get('/sanctum/csrf-cookie');
    const response = await axiosClient.get('/admin/companies');
    companies.value = response.data;
    showDropdown.value = companies.value.length > 0;
  } catch (error) {
    console.error("Error fetching companies:", error);
    if (error.response && error.response.status === 403) {
      showDropdown.value = false;
      // Optionally, you can show a toast message
      toast.add({ severity: 'error', summary: 'Access Denied', detail: 'You do not have permission to view companies.', life: 3000 });
    } else {
      // Handle other types of errors
      toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to fetch companies.', life: 3000 });
    }
  }

  return response;
};

onMounted(async () => {

    await axiosClient.get('/sanctum/csrf-cookie');
    let {data} = await axiosClient.get('/api/user');
    console.log("data:");
    console.log(data);
    console.log("data.id.value:", data.id);

    const user_id = data.id;
    console.log("user_id:", user_id);

    DocumentService.getDocumentsAll(user_id).then((data) => {
        documents.value = getDocuments(data);
        console.log("documents.value:");
        console.log(documents.value);
        loading.value = false;
    });

    AttributesService.getTreeNodes().then(data => nodes.value = data);

    console.log("documents:");
    console.log(documents);

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
    
    let otherAppsLinks = ref([]);
    if(userRole) {
        console.log("userRole inside watch:");
        console.log(userRole.value.data);
        if (userRole.value.includes('see_admin_sections') || userRole.value.includes('see_superadmin_sections')) {
            displayEmployeeDocuments.value = false;
        } else {
            displayEmployeeDocuments.value = true;
        }
    }

    // TODO: Fetch comapnies only if we have the see_superadmin_sections permission in the first place 
    if (userRole.value.includes('see_superadmin_sections')) {
        otherAppsLinks = fetchCompanies();   
    }
});

const formatDate = (value) => {
    if (!value) {
        // Handle the case where the value is null, undefined or an empty string
        return '';
    }
    const date_at = new Date(value);
    if (isNaN(date_at)) {
        // Handle the case where the value is not a valid created_at string
        return 'Invalid Date';
    }
    return date_at.toLocaleDateString('cs', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
};



const hideDialog = () => {
    documentDialog.value = false;
    submitted.value = false;
};

const getDocuments = (data) => {
    return [...(data || [])].map((d) => {
            if (d.created_at) {
            d.created_at = new Date(d.created_at);
            d.updated_at = new Date(d.updated_at);
            if (isNaN(d.created_at.getTime())) {
                console.warn(`Invalid created_at for document_file ${d.id}: ${d.created_at}`);
                d.created_at = null; // or set to a default created_at
            }
            if (isNaN(d.updated_at.getTime())) {
                console.warn(`Invalid updated_at for document_file ${d.id}: ${d.updated_at}`);
                d.updated_at = null; // or set to a default updated_at
            }
        }
        return d;
    });
};


const saveDocument = async () => {

    const updateResponse = await updateDocument();
    console.log("updateResponse");
    console.log(updateResponse);
    console.log(updateResponse.value[1]);
    const responseText = updateResponse.value[0];

    if (updateResponse.value[1] === 204 || updateResponse.value[1] === 200) {
        toast.add({ severity: 'success', summary: 'Uložení úspěšné', detail: responseText,
        life: 3000 });

            // Close the dialog and reset the form
        documentDialog.value = false;

        DocumentService.getDocumentsAll().then((data) => {
        users.value = getDocuments(data);
        loading.value = false;
    });

    } else {
        toast.add({ severity: 'error', summary: 'Chyba při aktualizaci zaměstnance', detail: responseText, 
        life: 3000 });

        // Close the dialog and reset the form
        documentDialog.value = false;
    }
};

const editDocument = (documentData) => {
    console.log('editDocument called with:', documentData);
    console.log(documentData);
    document_file.value = { ...documentData };
    documentDialog.value = true;
    console.log("document_file.value:");
    console.log(document_file.value);
};

async function updateDocument() {
    // Resources: https://laraveldaily.com/post/laravel-vue-how-to-display-validation-errors

    if(fileWasSelected.value === true && fileWasUploaded.value === false) {
        fileWasUploadedError.value = true;
        return;
    }
    errorMessages = []; // empty the error message

    store.commit('setToken', null);
    store.commit('setUser', null);
    console.log(user);
    console.log("Update 18:25");

    await axiosClient.get('/sanctum/csrf-cookie').catch(error => {
        console.log(error);
        programError.value = true;
    });

    const documentData = toRaw(document_file.value);

    console.log("documentData:");
    console.log(documentData);

    await axiosClient.put('/user/documents/create/file-upload', documentData)
        .then(response => {
            console.log("Register response:");
            console.log(response);
            console.log(response.data);

            success.value = response.data.message;
            userUpdateSuccesful.value = true;
            console.log("documentData.id:");
            console.log(documentData.id);
            
            responseData.value = response.data;
            console.log("responseData:");
            console.log(responseData);
        })
        .catch(error => {
            if(error.response) {
                if (error.response.status === 422) {
                    console.log(error.response.data.errors);
                    errors.value = error.response.data.errors;
                } else {
                    programError.value = true;
                    console.log("Other error:");
                    console.log(error);
                }   
            } else {
                console.log("Error: " + error);
                programError.value = true;
            }

            responseData.value = response.data;
        });
    
    return responseData;
};

const customUpload = async (event, url, id_document) => {
  console.log("event:", event);
  console.log("custom file uploaded");
  
  uploadedFile = event.files[0];

  console.log("uploadedFile:", uploadedFile);

  // Create a new div element for the custom message
  const customMessage = document.createElement('div');
  customMessage.innerHTML = '<p style="color: green;">Soubor úspěšně nahrán.</p>';
  customMessage.classList.add('custom-message-class');

  // Locate the button bar where the buttons are located
  const buttonBar = document.querySelector('.p-fileupload-buttonbar');

  console.log("buttonBar:", buttonBar);

  // The upload itself...
  let formFileData = new FormData();

  await axiosClient.get('/sanctum/csrf-cookie');
  let {data} = await axiosClient.get('/api/user');
  console.log("data:");
  console.log(data);
  console.log("data.id.value:", data.id);
  
  const user_id = data.id;
  console.log("user_id:", user_id);

  formFileData.append('user_id', user_id);
  formFileData.append('file', uploadedFile);
  formFileData.append('id_document', id_document);

  try {
    await axiosClient.get('/sanctum/csrf-cookie');
    
    const response = await axiosClient.post(url, formFileData, {
      headers: {
        "Content-Type": "multipart/form-data"
      },
    });

    console.log("response:", response);
    
    // Now insert the custom message into the DOM, before the contentArea
    buttonBar.append(customMessage);

    fileWasUploaded.value = true;
    fileWasUploadedError.value = false;

    // Handle success (e.g., update user image path)
    if (url === '/user/profile/img-upload') {
      user.img_path = response.data.img_path;
    }

    toast.add({ severity: 'success', summary: 'Úspěch', detail: 'Soubor byl úspěšně nahrán', life: 3000 });
  } catch (error) {
    console.error("Error uploading file:", error);
    fileWasUploadedError.value = true;
    toast.add({ severity: 'error', summary: 'Chyba', detail: 'Nepodařilo se nahrát soubor', life: 3000 });
  }
};

const getCompaniesLinks = (company) => {
  return company.link || '#';
};


</script>

<template>
    <header class="bg-white shadow">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Nástěnka</h1>
        <Dropdown 
          v-if="showDropdown"
          v-model="selectedCompany" 
          :options="companies" 
          optionLabel="name" 
          placeholder="Domény" 
          class="w-full md:w-14rem"
        >
          <template #option="slotProps">
            <a :href="getCompaniesLinks(slotProps.option)" @click.stop>
              {{ slotProps.option.name }}
            </a>
          </template>
        </Dropdown>
      </div>
    </header>
</template>
