import React, { Component } from "react";
import { Link } from "react-router-dom";
import { connect } from "react-redux";
import PropTypes from "prop-types";
import { getProducto } from "../../actions/productosActions";
import { createLoadingSelector } from "../../helpers/CreateLoadingSelector";
import Loader from "react-loader";

class ShowProducto extends Component {
  state = {};
  componentDidMount() {
    const { id } = this.props.match.params;
    this.props.getProducto(id);
  }

  static getDerivedStateFromProps(props, state) {
    const { loading } = props;
    //Cuando se sale, le asigno false a FETCH_PRODUCTO, para que vuelva a cargar la página al volver.
    if (loading.FETCH_PRODUCTO) {
      return (loading["FETCH_PRODUCTO"] = false);
    }
    return state;
  }

  render() {
    const { producto, isFetching } = this.props;
    return (
      <div>
        <Loader loaded={isFetching}>
          {//Cuando cargue el producto, le cambio el título a la página
          producto.nombre
            ? (document.title = producto.nombre + " " + producto.marca)
            : null}
          <div className="row">
            <div className="col-9">
              <h1>
                {producto.nombre}{" "}
                {producto.marca ? "- " + producto.marca.nombre : null}
              </h1>
              <h6 className="text-muted mt-2">
                {producto.categoria ? producto.categoria.nombre : null}{" "}
                {producto.sub_categoria
                  ? ">" + producto.sub_categoria.nombre
                  : null}
              </h6>
            </div>
            <div className="col-3 float-right">
              <Link
                to={`/producto/${producto.id}/edit`}
                className="btn btn-success float-right mb-0"
              >
                Editar
              </Link>
            </div>
          </div>
          {producto.descripcion ? (
            <div className="card border-light mt-5">
              <div className="card-header">Descripción</div>
              <div className="card-body">
                <p className="card-text">{producto.descripcion}</p>
              </div>
            </div>
          ) : null}
          {!producto.variantes ? (
            <React.Fragment>
              <div className="card border-light mb-3 mt-5">
                <div className="card-header">Precios</div>
                <div className="card-body d-flex justify-content-start">
                  <div className="col-4">
                    <h5 className="card-title text-center">Precio</h5>
                    <p className="card-text text-center">
                      ${parseFloat(producto.precio).toFixed(2)}
                    </p>
                  </div>
                  {producto.precio_compra ? (
                    <div className="col-4">
                      <h5 className="card-title text-center">Precio compra</h5>
                      <p className="card-text text-center">
                        ${parseFloat(producto.precio_compra).toFixed(2)}
                      </p>
                    </div>
                  ) : null}

                  {producto.precio_real ? (
                    <div className="col-4">
                      <h5 className="card-title text-center">Precio real</h5>
                      <p className="card-text text-center">
                        ${parseFloat(producto.precio_real).toFixed(2)}
                      </p>
                    </div>
                  ) : null}
                </div>
              </div>

              <div className="card border-light mb-3">
                <div className="card-header">Detalles</div>
                <div className="card-body d-flex justify-content-start">
                  <div className="col-4">
                    <h5 className="card-title text-center">Cantidad</h5>
                    <p className="card-text text-center">{producto.cantidad}</p>
                  </div>
                  <div className="col-4">
                    <h5 className="card-title text-center">Id</h5>
                    <p className="card-text text-center">{producto.id}</p>
                  </div>
                  {producto.codigo_de_barras ? (
                    <div className="col-4">
                      <h5 className="card-title text-center">
                        Código de barras
                      </h5>
                      <p className="card-text text-center">
                        {producto.codigo_de_barras}
                      </p>
                    </div>
                  ) : null}
                </div>
              </div>
            </React.Fragment>
          ) : (
            <div className="card border-light mt-5">
              <div className="card-header">Variantes</div>
              <div className="card-body">
                <div className="row d-flex justify-content-around">
                  <div className="col-3">
                    <h5 className="card-title text-center">Nombre</h5>
                  </div>
                  <div className="col-3">
                    <h5 className="card-title text-center">Cantidad</h5>
                  </div>
                  <div className="col-3">
                    <h5 className="card-title text-center">Precio</h5>
                  </div>
                  <div className="col-3">
                    <h5 className="card-title text-center">Código de Barras</h5>
                  </div>
                </div>
                {producto.variantes
                  ? producto.variantes.map(variante => (
                      <div
                        key={variante.id}
                        className="row d-flex justify-content-around mt-3"
                      >
                        <hr />
                        <div className="col-3">
                          <p className="card-title text-center">
                            {variante.nombre}
                          </p>
                        </div>
                        <div className="col-3">
                          <p className="card-title text-center">
                            {variante.cantidad}
                          </p>
                        </div>
                        <div className="col-3">
                          <p className="card-title text-center">
                            {variante.precio}
                          </p>
                        </div>
                        <div className="col-3">
                          <p className="card-title text-center">
                            {variante.codigo_de_barras}
                          </p>
                        </div>
                        <hr />
                      </div>
                    ))
                  : null}
              </div>
            </div>
          )}
          <div className="row-12 mt-5 pt-5">
            <hr />
            {//Este IF quizás no esté cuando espere a que se hagan las querys para renderizar.
            producto.created_at && producto.updated_at ? (
              <p className="float-left text-secondary">
                <small>
                  Fecha de creación:
                  {" " + producto.created_at.date.substring(0, 16) + " "}
                  <br />
                  Última edición:
                  {" " + producto.updated_at.date.substring(0, 16) + " "}
                </small>
              </p>
            ) : null}{" "}
            <Link to={`/producto`} className="btn btn-secondary float-right">
              Volver
            </Link>
          </div>
        </Loader>
      </div>
    );
  }
}

const loadingSelector = createLoadingSelector(["FETCH_PRODUCTO"]);

ShowProducto.propTypes = {
  producto: PropTypes.object.isRequired,
  getProducto: PropTypes.func.isRequired,
  isFetching: PropTypes.bool.isRequired
};

const mapStateToProps = state => ({
  producto: state.producto.producto,
  loading: state.loading,
  isFetching: loadingSelector(state)
});

export default connect(
  mapStateToProps,
  { getProducto }
)(ShowProducto);
