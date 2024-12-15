export const getError = (error) => {
  if (error.name === "Fetch User") {
    return error.message;
  }

  if (!error.response) {
    console.info(`API: ${error.config?.url} not found`);
    console.info(error);
    return "API Request Error, please try again";
  }

  if(error.response.data.exception != null) {
    console.info("error.response.data.exception:");
    if(error.response.data.exception.includes('UniqueConstraintViolationException')) {
      return "Uživatel s tímto e-mailem již existuje.";
    }
  }

  if (import.meta.env.DEV) {
    console.group("dev error info");
    console.info("[DATA]", error.response.data);
    console.info(error.response.data.exception)
    console.info(`[STATUS] ${error.response.status}`);
    console.info("[HEADERS]", error.response.headers);
    console.groupEnd();
  }
  if (error.response.data && error.response.data.errors) {
    return error.response.data.errors;
  }
  if (error.response.data && error.response.status === 403) {
    return error.response.data.message;
  }
  return null;
};