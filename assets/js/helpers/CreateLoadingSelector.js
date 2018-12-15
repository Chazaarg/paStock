import _ from "lodash";
export const createLoadingSelector = actions => state => {
  // returns true only when all actions are not loading
  return _(actions).some(action => _.get(state, `loading.${action}`));
};
