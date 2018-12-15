import { NOTIFY_USER } from "./types";

export const notifyUser = (message, messageType, errors) => {
  return {
    type: NOTIFY_USER,
    errors,
    message,
    messageType
  };
};
