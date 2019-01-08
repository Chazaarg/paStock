import {
  FETCH_USER,
  LOG_OUT,
  LOG_IN,
  NOTIFY_USER,
  REGISTER_USER
} from "../actions/types.js";
import axios from "axios";

export const login = user => async dispatch => {
  try {
    const res = await axios.post("/api/login", user);
    dispatch({
      type: LOG_IN,
      payload: res.data
    });
  } catch (error) {
    dispatch({
      type: NOTIFY_USER,
      errors: [],
      message: "El usuario y contraseña ingresados no coinciden.",
      messageType: "error"
    });
  }
};

export const logOut = () => async dispatch => {
  const res = await axios.get("/api/logout");

  dispatch({
    type: LOG_OUT,
    payload: res.data
  });
};

export const registerUser = user => async dispatch => {
  try {
    const res = await axios.post("/api/registration", user);
    dispatch({
      type: REGISTER_USER,
      payload: res.data.user
    });
    /* TODO: puedo mostrar un mensaje tras ser redireccionado.
    dispatch({
      type: NOTIFY_USER,
      errors: [],
      message: res.data.message,
      messageType: res.data.messageType
    });
    */
  } catch (error) {
    dispatch({
      type: NOTIFY_USER,
      message: error.response.data.message,
      messageType: error.response.data.messageType,
      errors: error.response.data.errors
    });
  }
};

export const getUsuario = () => async dispatch => {
  const res = await axios.get("/api/user");

  dispatch({
    type: FETCH_USER,
    payload: res.data
  });
};

export const sendEmail = mail => async dispatch => {
  try {
    const res = await axios.post("/api/contact", mail);
    dispatch({
      type: NOTIFY_USER,
      message: res.data.message,
      messageType: res.data.messageType,
      errors: res.data.errors
    });
  } catch (error) {
    dispatch({
      type: NOTIFY_USER,
      message: error.response.data.message,
      messageType: error.response.data.messageType,
      errors: error.response.data.errors
    });
  }
};

export const recoverPassword = email => async dispatch => {
  try {
    const res = await axios.post("/api/recover-password", email);
    dispatch({
      type: NOTIFY_USER,
      message: res.data.message,
      messageType: res.data.messageType,
      errors: res.data.errors
    });
  } catch (error) {
    dispatch({
      type: NOTIFY_USER,
      message: error.response.data.message,
      messageType: error.response.data.messageType,
      errors: error.response.data.errors
    });
  }
};
export const sendPasswordCode = code => async dispatch => {
  try {
    const res = await axios.post("/api/recover-password-code", code);
    dispatch({
      type: NOTIFY_USER,
      message: res.data.message,
      messageType: res.data.messageType,
      errors: res.data.errors
    });
  } catch (error) {
    dispatch({
      type: NOTIFY_USER,
      message: error.response.data.message,
      messageType: error.response.data.messageType,
      errors: error.response.data.errors
    });
  }
};
export const changePassword = password => async dispatch => {
  try {
    const res = await axios.post("/api/recover-password-change", password);
    dispatch({
      type: NOTIFY_USER,
      message: res.data.message,
      messageType: res.data.messageType,
      errors: res.data.errors
    });
  } catch (error) {
    dispatch({
      type: NOTIFY_USER,
      message: error.response.data.message,
      messageType: error.response.data.messageType,
      errors: error.response.data.errors
    });
  }
};
