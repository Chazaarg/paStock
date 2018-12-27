import {
  FETCH_CLIENTES,
  FETCH_VENDEDORES,
  ADD_CLIENTE,
  ADD_VENDEDOR,
  ADD_VENTA,
  FETCH_VENTAS
} from "../actions/types.js";

const initState = {
  ventas: [],
  clientes: [],
  vendedores: []
};

export default function(state = initState, action) {
  switch (action.type) {
    case FETCH_VENTAS:
      return {
        ...state,
        ventas: action.payload
      };
    case FETCH_CLIENTES:
      return {
        ...state,
        clientes: action.payload
      };
    case FETCH_VENDEDORES:
      return {
        ...state,
        vendedores: action.payload
      };
    case ADD_CLIENTE:
      return {
        ...state,
        clientes: [action.payload, ...state.clientes]
      };
    case ADD_VENDEDOR:
      return {
        ...state,
        vendedores: [action.payload, ...state.vendedores]
      };
    case ADD_VENTA:
      return {
        ...state,
        ventas: [action.payload, ...state.ventas]
      };
    default:
      return state;
  }
}
