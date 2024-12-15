import store from ".";



export function getErrorMsg() {
  return store.state.programErrorMsg;
}

export default getErrorMsg;
