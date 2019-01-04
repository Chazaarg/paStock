import {
  FETCH_CLIENTES,
  FETCH_VENDEDORES,
  ADD_CLIENTE,
  ADD_VENDEDOR,
  ADD_VENTA,
  FETCH_VENTAS,
  NOTIFY_USER
} from "../actions/types.js";
import axios from "axios";

export const addCliente = cliente => async dispatch => {
  try {
    const res = await axios.post("/api/cliente/new", cliente);
    dispatch({
      type: ADD_CLIENTE,
      payload: res.data.cliente
    });
    //Success
    dispatch({
      type: NOTIFY_USER,
      errors: null,
      message: res.data.message,
      messageType: res.data.messageType
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
export const addVendedor = vendedor => async dispatch => {
  try {
    const res = await axios.post("/api/vendedor/new", vendedor);
    dispatch({
      type: ADD_VENDEDOR,
      payload: res.data.vendedor
    });
    //Success
    dispatch({
      type: NOTIFY_USER,
      errors: null,
      message: res.data.message,
      messageType: res.data.messageType
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
export const addVenta = venta => async dispatch => {
  try {
    const res = await axios.post("/api/venta/new", venta);
    dispatch({
      type: ADD_VENTA,
      payload: res.data.venta
    });
    //Success
    dispatch({
      type: NOTIFY_USER,
      errors: null,
      message: res.data.message,
      messageType: res.data.messageType
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

export const getVentas = sort => async dispatch => {
  const res = await axios.post("/api/venta/", sort);
  dispatch({
    type: FETCH_VENTAS,
    payload: res.data
  });
};
export const getClientes = () => async dispatch => {
  const res = await axios.get("/api/cliente/");

  dispatch({
    type: FETCH_CLIENTES,
    payload: res.data
  });
};

export const getVendedores = () => async dispatch => {
  const res = await axios.get("/api/vendedor/");

  dispatch({
    type: FETCH_VENDEDORES,
    payload: res.data
  });
};
