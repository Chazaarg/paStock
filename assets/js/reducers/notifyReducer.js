import { NOTIFY_USER } from "../actions/types";

const initialState = {
  errors: null,
  message: null,
  messageType: null
};

export default function(state = initialState, action) {
  switch (action.type) {
    case NOTIFY_USER:
      return {
        ...state,
        errors: action.errors,
        message: action.message,
        messageType: action.messageType
      };
    default:
      return state;
  }
}
