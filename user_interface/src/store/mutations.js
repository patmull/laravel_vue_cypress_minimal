import store from ".";

export function setUser(state, userData) {
  state.user.data = userData;
}

export function setToken(token) {
  console.log("token: ", token);
  store.state.user.token = token;
  if (token) {
    sessionStorage.setItem('TOKEN', token);
  } else {
    sessionStorage.removeItem('TOKEN');
  }
}
