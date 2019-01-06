import { Link } from "react-router-dom";
import { connect } from "react-redux";
import PropTypes from "prop-types";
import {
  getMarcas,
  getCategorias,
  getSubcategorias,
  getVarianteTipos,
  getProducto,
  addProducto,
  updateProducto,
  deleteProducto
} from "../../actions/productosActions";
import React, { Component } from "react";
import ProductoDefault from "./ProductoDefault";
import ProductoIndividual from "./ProductoIndividual";
import ProductoVariantes from "./ProductoVariantes";
import { createLoadingSelector } from "../../helpers/CreateLoadingSelector";
import Loader from "react-loader";
import ProductoAlert from "../alert/ProductoAlert";
import { notifyUser } from "../../actions/notifyActions";

class EditProducto extends Component {
  constructor(props) {
    super(props);
    this.state = {
      nombre: "",
      descripcion: "",
      marca: { id: undefined, nombre: undefined },
      categoria: { id: undefined, nombre: undefined },
      sub_categoria: { id: undefined, nombre: undefined },
      precio: 0,
      codigo_de_barras: "",
      cantidad: 0,
      precio_compra: "",
      precio_real: "",
      variantes: [],
      varianteTipoId: "",
      tieneVariante: false
    };
  }

  componentWillUnmount() {
    //Esto hace un clear a notify cada vez que cambie de ruta.
    const { message } = this.props.notify;
    const { notifyUser } = this.props;

    message && notifyUser(null, null, null);

    const { loading } = this.props;
    //Cuando se sale, le asigno false a FETCH_PRODUCTO, para que vuelva a cargar la página al volver.
    if (loading.FETCH_PRODUCTO) {
      return (loading["FETCH_PRODUCTO"] = false);
    }
  }

  componentDidMount() {
    const { id } = this.props.match.params;
    this.props.getMarcas();
    this.props.getVarianteTipos();
    this.props.getCategorias();
    this.props.getSubcategorias();
    this.props.getProducto(id).then(() => {
      //LUEGO DE CARGAR EL PRODUCTO, ASIGNO LOS DATOS AL STATE.

      const {
        nombre,
        descripcion,
        marca,
        categoria,
        sub_categoria,
        precio,
        codigo_de_barras,
        cantidad,
        precio_compra,
        precio_real,
        variantes
      } = this.props.producto;

      this.setState({
        nombre,
        descripcion,
        marca: marca ? marca : { id: undefined, nombre: undefined },
        categoria: categoria ? categoria : { id: undefined, nombre: undefined },
        sub_categoria: sub_categoria
          ? sub_categoria
          : { id: undefined, nombre: undefined },
        precio,
        codigo_de_barras,
        cantidad,
        precio_compra,
        precio_real,
        variantes
      });

      if (!variantes) {
        this.setState({
          variantes: []
        });
        //Si no tiene variantes le agrega la clase 'show' al collapse
        if (document.getElementById("collapseOne")) {
          document.getElementById("collapseOne").classList.add("show");
        }
      } else {
        this.setState({
          tieneVariante: true,
          varianteTipoId: this.state.variantes[0]
            ? this.state.variantes[0].variante_tipo.id
            : null
        });
        //Si tiene variantes le agrega la clase 'show' al collapse
        if (document.getElementById("collapseTwo")) {
          document.getElementById("collapseTwo").classList.add("show");
        }
      }
    });
  }

  onSubmit = e => {
    e.preventDefault();

    const {
      nombre,
      descripcion,
      marca,
      categoria,
      sub_categoria,
      precio,
      codigo_de_barras,
      cantidad,
      precio_compra,
      precio_real,
      tieneVariante,
      varianteTipoId,
      variantes
    } = this.state;

    const { id } = this.props.match.params;

    let editProducto = {};

    if (tieneVariante) {
      editProducto = {
        id,
        nombre,
        descripcion,
        marca: marca.id ? marca.id : null,
        categoria: categoria.id ? categoria.id : null,
        sub_categoria: sub_categoria.id ? sub_categoria.id : null,
        precio_compra,
        precio_real,
        variantes: variantes
      };

      editProducto.variantes.forEach(function(obj) {
        obj.variante_tipo = parseInt(varianteTipoId, 0);
      });
    } else {
      editProducto = {
        id,
        nombre,
        descripcion,
        marca: marca.id ? marca.id : null,
        categoria: categoria.id ? categoria.id : null,
        sub_categoria: sub_categoria.id ? sub_categoria.id : null,
        precio: precio,
        codigo_de_barras: codigo_de_barras,
        cantidad: cantidad,
        precio_compra,
        precio_real
      };
    }
    this.props.updateProducto(editProducto).then(() => {
      //Me lleva al gridview si develve "success".
      //TODO: Quizás quiera que aparezca un cartel de que el producto fue importado con éxito en el gridview
      if (this.props.notify.messageType === "success") {
        this.props.history.push("/producto");
      } else {
        //Si hay algún error, dejo el state tal y como estaba ya que componentWillReceiveProps lo reinicia.
        this.setState({
          nombre,
          descripcion,
          marca,
          categoria,
          sub_categoria,
          precio,
          codigo_de_barras,
          cantidad,
          precio_compra,
          precio_real,
          tieneVariante,
          varianteTipoId,
          variantes
        });
        window.scrollTo(0, 0);
      }
    });
  };

  //Hice un controlador para cada uno de los selects porque el atributo puede ser directamente NULL y no hay forma de diferenciarlos.
  handleMarcaChange = item => {
    this.setState({
      marca: {
        id: item ? item.value : undefined,
        nombre: item ? item.label : undefined
      }
    });
  };

  handleCategoriaChange = item => {
    this.setState({
      categoria: {
        id: item ? item.value : undefined,
        nombre: item ? item.label : undefined
      },
      sub_categoria: { id: undefined, nombre: undefined }
    });
  };
  handleSubcategoriaChange = item => {
    this.setState({
      sub_categoria: {
        id: item ? item.value : undefined,
        nombre: item ? item.label : undefined
      }
    });
  };

  varianteOnChange = idx => e => {
    const newVariante = this.state.variantes.map((variante, sidx) => {
      if (idx !== sidx) return variante;
      return { ...variante, [e.target.name]: e.target.value };
    });

    this.setState({ variantes: newVariante });
  };

  varianteTipoOnChange = e => {
    this.setState({ varianteTipoId: e.target.value });
    if (this.state.variantes.length === 0 || this.state.variantes === null) {
      this.handleAddVariante();
    }
  };

  handleAddVariante = () => {
    this.setState({
      variantes: this.state.variantes.concat([
        {
          nombre: "",
          precio: 0,
          cantidad: 0,
          codigo_de_barras: ""
        }
      ])
    });
  };

  handleRemoveVariante = idx => () => {
    this.setState({
      variantes: this.state.variantes.filter((s, sidx) => idx !== sidx)
    });
  };

  onChange = e => {
    this.setState({
      [e.target.name]: e.target.value
    });
  };

  toggle = b => {
    this.setState({
      tieneVariante: b
    });
  };
  newProp = (val, categoriaId) => {
    //Cuando se crea una nueva propiedad, se la selecciona en el input, buscando el último valor en el array que corresponda.
    switch (val) {
      case "marca":
        this.setState({
          marca: {
            id: this.props.marcas[0].id,
            nombre: this.props.marcas[0].nombre
          }
        });
        break;
      case "categoria":
        if (categoriaId) {
          this.setState({
            categoria: { id: categoriaId.id, nombre: categoriaId.label }
          });
        } else {
          this.setState({
            categoria: {
              id: this.props.categorias[0].id,
              nombre: this.props.categorias[0].nombre
            }
          });
        }

        break;
      case "sub_categoria":
        this.setState({
          sub_categoria: {
            id: this.props.subcategorias[0].id,
            nombre: this.props.subcategorias[0].nombre
          }
        });

        break;
      default:
        break;
    }
  };

  render() {
    const {
      nombre,
      cantidad,
      precio,
      codigo_de_barras,
      descripcion,
      marca,
      categoria,
      sub_categoria,
      variantes,
      varianteTipoId
    } = this.state;
    const { id } = this.props.match.params;
    const {
      categorias,
      marcas,
      subcategorias,
      varianteTipos,
      isFetching,
      notify
    } = this.props;
    return (
      <div>
        <div className="row-12">
          <div className="col-3 float-right">
            <button
              type="button"
              style={{ position: "inherit", zIndex: "99" }}
              className="btn btn-danger float-right mb-0"
              onClick={() => {
                this.props.deleteProducto(id);
                this.props.history.push("/producto");
              }}
            >
              Eliminar
            </button>
          </div>
        </div>
        <div className="row-12">
          <div className="col-12">
            <h1>Editar producto</h1>
            {//Si hay un mensaje, entonces lo muestro en la alerta.
            notify.message ? (
              <ProductoAlert
                message={notify.message}
                messageType={notify.messageType}
                errors={notify.errors}
              />
            ) : null}
          </div>
        </div>

        <Loader loaded={isFetching}>
          {//Cuando cargue el nombre del producto, lo pongo como título de la página. Si tiene marca, entonces pongo los dos.
          nombre
            ? marca.nombre
              ? (document.title = nombre + " " + marca.nombre)
              : (document.title = nombre)
            : null}
          <form onSubmit={this.onSubmit}>
            <ProductoDefault
              nombre={nombre}
              marca={marca}
              categoria={categoria}
              sub_categoria={sub_categoria}
              descripcion={descripcion}
              categorias={categorias}
              marcas={marcas}
              subcategorias={subcategorias}
              onChange={this.onChange.bind(this)}
              newProp={this.newProp.bind(this)}
              notify={notify}
              handleCategoriaChange={this.handleCategoriaChange.bind(this)}
              handleMarcaChange={this.handleMarcaChange.bind(this)}
              handleSubcategoriaChange={this.handleSubcategoriaChange.bind(
                this
              )}
            />

            <div id="accordion">
              <ProductoIndividual
                cantidad={cantidad}
                precio={precio}
                codigo_de_barras={codigo_de_barras}
                toggle={this.toggle.bind(this)}
                onChange={this.onChange.bind(this)}
              />
              <ProductoVariantes
                variantes={variantes}
                varianteTipos={varianteTipos}
                varianteTipoId={varianteTipoId}
                toggle={this.toggle.bind(this)}
                varianteTipoOnChange={this.varianteTipoOnChange.bind(this)}
                varianteOnChange={this.varianteOnChange.bind(this)}
                handleRemoveVariante={this.handleRemoveVariante.bind(this)}
                handleAddVariante={this.handleAddVariante.bind(this)}
                notify={notify}
              />
            </div>

            <div className="row-12 mt-5 pt-5 pb-5 mb-5">
              <hr />
              <Link to={`/producto`} className="btn btn-secondary">
                Volver
              </Link>
              <button type="submit" className="btn btn-success float-right">
                Editar Producto
              </button>
            </div>
          </form>
        </Loader>
      </div>
    );
  }
}

const loadingSelector = createLoadingSelector(["FETCH_PRODUCTO"]);

EditProducto.propTypes = {
  producto: PropTypes.object.isRequired,
  getProducto: PropTypes.func.isRequired,
  updateProducto: PropTypes.func.isRequired,
  categorias: PropTypes.array.isRequired,
  marcas: PropTypes.array.isRequired,
  subcategorias: PropTypes.array.isRequired,
  varianteTipos: PropTypes.array.isRequired,
  addProducto: PropTypes.func.isRequired,
  deleteProducto: PropTypes.func.isRequired,
  isFetching: PropTypes.bool.isRequired,
  notify: PropTypes.object.isRequired
};

const mapStateToProps = state => ({
  notify: state.notify,
  producto: state.producto.producto,
  categorias: state.producto.categorias,
  marcas: state.producto.marcas,
  subcategorias: state.producto.subcategorias,
  varianteTipos: state.producto.varianteTipos,
  loading: state.loading,
  isFetching: loadingSelector(state),
  notifyUser: PropTypes.func.isRequired
});

export default connect(
  mapStateToProps,
  {
    notifyUser,
    getMarcas,
    getCategorias,
    getSubcategorias,
    addProducto,
    getVarianteTipos,
    getProducto,
    updateProducto,
    deleteProducto
  }
)(EditProducto);
