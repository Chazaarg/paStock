import { NOTIFY_USER, NOTIFY_404 } from "./types";

export const notifyUser = (message, messageType, errors) => {
  return {
    type: NOTIFY_USER,
    errors,
    message,
    messageType
  };
};

export const notify404 = notFound => {
  return {
    type: NOTIFY_404,
    notFound
  };
};
