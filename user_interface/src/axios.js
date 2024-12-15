import axiosLib from "axios";

console.log("import.meta.env.VITE_APP_API_URL: ", import.meta.env.VITE_APP_API_URL);

const axios = axiosLib.create({
  baseURL: import.meta.env.VITE_APP_API_URL,
  timeout: 60000,
  withCredentials: true,
  xsrfCookieName: "XSRF-TOKEN",
  xsrfHeaderName: "X-XSRF-TOKEN",
  headers: {
    // Accept: "application/json",
    'X-Requested-With': 'XMLHttpRequest',
  }
});

axios.interceptors.response.use(null, err => {
  const error = {
    status: err.response?.status,
    original: err,
    validation: {},
    message: null,
  };

  if (err.response?.status === 422) {
    for (let field in err.response.data.errors) {
      error.validation[field] = err.response.data.errors[field][0];
    }
  } else {
    error.message = "Something went wrong. Please try again later.";
  }

  return Promise.reject(error);
});

export default axios;
