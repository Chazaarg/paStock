import {
  FETCH_PRODUCTOS,
  FETCH_PRODUCTO,
  ADD_PRODUCTO,
  FETCH_MARCAS,
  ADD_MARCA,
  FETCH_CATEGORIAS,
  ADD_CATEGORIA,
  DELETE_CATEGORIA,
  FETCH_SUBCATEGORIAS,
  ADD_SUBCATEGORIA,
  DELETE_SUBCATEGORIA,
  FETCH_VARIANTETIPOS,
  UPDATE_PRODUCTO,
  DELETE_PRODUCTO,
  ADD_VARIANTETIPO,
  UPDATE_CATEGORIA,
  UPDATE_SUBCATEGORIA,
  UPDATE_MARCA,
  DELETE_MARCA,
  DELETE_VARIANTETIPO
} from "../actions/types.js";

const initState = {
  productos: [],
  producto: {},
  marcas: [],
  categorias: [],
  subcategorias: [],
  varianteTipos: []
};

export default function(state = initState, action) {
  switch (action.type) {
    case FETCH_PRODUCTOS:
      return {
        ...state,
        productos: action.payload
      };

    case FETCH_PRODUCTO:
      return {
        ...state,
        producto: action.payload
      };
    case ADD_PRODUCTO:
      return {
        ...state,
        productos: [action.payload, ...state.productos]
      };
    case DELETE_PRODUCTO:
      return {
        ...state,
        productos: state.productos.filter(
          producto => producto.id !== action.payload
        )
      };
    case UPDATE_PRODUCTO:
      return {
        ...state,
        productos: state.productos.map(producto =>
          producto.id === action.payload.id
            ? (producto = action.payload)
            : producto
        )
      };
    case ADD_MARCA:
      return {
        ...state,
        marcas: [action.payload, ...state.marcas]
      };
    case DELETE_MARCA:
      return {
        ...state,
        marcas: state.marcas.filter(marca => marca.id !== action.payload)
      };
    case UPDATE_MARCA:
      return {
        ...state,
        marcas: state.marcas.map(marca =>
          marca.id === action.payload.id ? (marca = action.payload) : marca
        )
      };
    case ADD_VARIANTETIPO:
      return {
        ...state,
        varianteTipos: [action.payload, ...state.varianteTipos]
      };
    case DELETE_VARIANTETIPO:
      return {
        ...state,
        varianteTipos: state.varianteTipos.filter(
          varianteTipo => varianteTipo.id !== Number(action.payload)
        )
      };
    case FETCH_MARCAS:
      return {
        ...state,
        marcas: action.payload
      };
    case ADD_CATEGORIA:
      return {
        ...state,
        categorias: [action.payload, ...state.categorias]
      };
    case FETCH_CATEGORIAS:
      return {
        ...state,
        categorias: action.payload
      };
    case DELETE_CATEGORIA:
      return {
        ...state,
        categorias: state.categorias.filter(
          categoria => categoria.id !== action.payload
        )
      };
    case UPDATE_CATEGORIA:
      return {
        ...state,
        categorias: state.categorias.map(categoria =>
          categoria.id === action.payload.id
            ? (categoria = action.payload)
            : categoria
        )
      };
    case FETCH_SUBCATEGORIAS:
      return {
        ...state,
        subcategorias: action.payload
      };
    case ADD_SUBCATEGORIA:
      return {
        ...state,
        subcategorias: [action.payload, ...state.subcategorias]
      };
    case DELETE_SUBCATEGORIA:
      return {
        ...state,
        subcategorias: state.subcategorias.filter(
          subcategoria => subcategoria.id !== action.payload
        )
      };
    case UPDATE_SUBCATEGORIA:
      return {
        ...state,
        subcategorias: state.subcategorias.map(subcategoria =>
          subcategoria.id === action.payload.id
            ? (subcategoria = action.payload)
            : subcategoria
        )
      };
    case FETCH_VARIANTETIPOS:
      return {
        ...state,
        varianteTipos: action.payload
      };
    default:
      return state;
  }
}
