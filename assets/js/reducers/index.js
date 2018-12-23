import { combineReducers } from "redux";
import productoReducer from "./productoReducer";
import usuarioReducer from "./usuarioReducer";
import notifyReducer from "./notifyReducer";
import loadingReducer from "./loadingReducer";
import ventaReducer from "./ventaReducer";

export default combineReducers({
  producto: productoReducer,
  usuario: usuarioReducer,
  notify: notifyReducer,
  loading: loadingReducer,
  venta: ventaReducer
});
