import {
  FETCH_PRODUCTOS,
  FETCH_PRODUCTO,
  ADD_PRODUCTO,
  FETCH_MARCAS,
  ADD_MARCA,
  FETCH_CATEGORIAS,
  ADD_CATEGORIA,
  FETCH_SUBCATEGORIAS,
  ADD_SUBCATEGORIA,
  DELETE_SUBCATEGORIA,
  FETCH_VARIANTETIPOS,
  UPDATE_PRODUCTO,
  DELETE_PRODUCTO,
  ADD_VARIANTETIPO,
  NOTIFY_USER,
  DELETE_CATEGORIA,
  UPDATE_CATEGORIA,
  UPDATE_SUBCATEGORIA,
  UPDATE_MARCA,
  DELETE_MARCA,
  NOTIFY_404
} from "./types";
import axios from "axios";

export const getProductos = () => async dispatch => {
  const res = await axios.get("/api/producto/");

  dispatch({
    type: FETCH_PRODUCTOS,
    payload: res.data
  });
};

export const deleteProducto = id => async dispatch => {
  await axios.delete(`/api/producto/${id}/delete`);
  dispatch({
    type: DELETE_PRODUCTO,
    payload: id
  });
};

export const addProducto = producto => async dispatch => {
  try {
    const res = await axios.post("/api/producto/new", producto);
    dispatch({
      type: ADD_PRODUCTO,
      payload: res.data.producto
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

export const updateProducto = producto => async dispatch => {
  try {
    const res = await axios.put(`/api/producto/${producto.id}/edit`, producto);
    dispatch({
      type: UPDATE_PRODUCTO,
      payload: res.data.producto
    });
    //Success
    dispatch({
      type: NOTIFY_USER,
      errors: null,
      message: res.data.message,
      messageType: res.data.messageType
    });
  } catch (error) {
    error.response.status === 404
      ? dispatch({
          type: NOTIFY_404,
          notFound: true
        })
      : dispatch({
          type: NOTIFY_USER,
          message: error.response.data.message,
          messageType: error.response.data.messageType,
          errors: error.response.data.errors
        });
  }
};

export const getCategorias = () => async dispatch => {
  const res = await axios.get("/api/categoria/");

  dispatch({
    type: FETCH_CATEGORIAS,
    payload: res.data
  });
};
export const addCategoria = categoria => async dispatch => {
  try {
    const res = await axios.post("/api/categoria/new", categoria);
    dispatch({
      type: ADD_CATEGORIA,
      payload: res.data.categoria
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
export const deleteCategoria = id => async dispatch => {
  await axios.delete(`/api/categoria/${id}`);
  dispatch({
    type: DELETE_CATEGORIA,
    payload: id
  });
};

export const updateCategoria = categoria => async dispatch => {
  try {
    const res = await axios.put(
      `/api/categoria/${categoria.id}/edit`,
      categoria.nombre
    );
    dispatch({
      type: UPDATE_CATEGORIA,
      payload: res.data.categoria
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

export const getSubcategorias = () => async dispatch => {
  const res = await axios.get("/api/subcategoria/");

  dispatch({
    type: FETCH_SUBCATEGORIAS,
    payload: res.data
  });
};

export const deleteSubcategoria = id => async dispatch => {
  await axios.delete(`/api/subcategoria/${id}`);
  dispatch({
    type: DELETE_SUBCATEGORIA,
    payload: id
  });
};

export const addSubCategoria = subCategoria => async dispatch => {
  try {
    const res = await axios.post("/api/subcategoria/new", subCategoria);
    dispatch({
      type: ADD_SUBCATEGORIA,
      payload: res.data.subcategoria
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

export const updateSubcategoria = subcategoria => async dispatch => {
  try {
    const res = await axios.put(
      `/api/subcategoria/${subcategoria.id}/edit`,
      subcategoria.nombre
    );
    dispatch({
      type: UPDATE_SUBCATEGORIA,
      payload: res.data.subcategoria
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
export const addMarca = marca => async dispatch => {
  try {
    const res = await axios.post("/api/marca/new", marca);
    dispatch({
      type: ADD_MARCA,
      payload: res.data.marca
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

export const deleteMarca = id => async dispatch => {
  await axios.delete(`/api/marca/${id}`);
  dispatch({
    type: DELETE_MARCA,
    payload: id
  });
};

export const updateMarca = marca => async dispatch => {
  try {
    const res = await axios.put(`/api/marca/${marca.id}/edit`, marca.nombre);
    dispatch({
      type: UPDATE_MARCA,
      payload: res.data.marca
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

export const addVarianteTipo = varianteTipo => async dispatch => {
  try {
    const res = await axios.post("/api/variante-tipo/new", varianteTipo);
    dispatch({
      type: ADD_VARIANTETIPO,
      payload: res.data.varianteTipo
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

export const getMarcas = () => async dispatch => {
  const res = await axios.get("/api/marca/");

  dispatch({
    type: FETCH_MARCAS,
    payload: res.data
  });
};

export const getProducto = id => async dispatch => {
  try {
    const res = await axios.get(`/api/producto/${id}`);
    dispatch({
      type: FETCH_PRODUCTO,
      payload: res.data
    });
  } catch (error) {
    dispatch({
      type: NOTIFY_404,
      notFound: true
    });
  }
};
export const getVarianteTipos = () => async dispatch => {
  const res = await axios.get("/api/variante-tipo/");

  dispatch({
    type: FETCH_VARIANTETIPOS,
    payload: res.data
  });
};
