import { NOTIFY_USER, NOTIFY_404 } from "../actions/types";

const initialState = {
  errors: null,
  message: null,
  messageType: null,
  notFound: false
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
    case NOTIFY_404:
      return {
        ...state,
        notFound: action.notFound
      };
    default:
      return state;
  }
}
