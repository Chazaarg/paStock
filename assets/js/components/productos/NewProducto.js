import { Link } from "react-router-dom";
import { connect } from "react-redux";
import PropTypes from "prop-types";
import {
  getMarcas,
  getCategorias,
  getSubcategorias,
  getVarianteTipos,
  addProducto
} from "../../actions/productosActions";
import React, { Component } from "react";
import ProductoDefault from "./ProductoDefault";
import ProductoIndividual from "./ProductoIndividual";
import ProductoVariantes from "./ProductoVariantes";
import { createLoadingSelector } from "../../helpers/CreateLoadingSelector";
import Loader from "react-loader";
import { notifyUser } from "../../actions/notifyActions";
import ProductoAlert from "../layout/ProductoAlert";

class NewProducto extends Component {
  componentDidMount() {
    this.props.getMarcas();
    this.props.getVarianteTipos();
    this.props.getCategorias();
    this.props.getSubcategorias();
  }

  state = {
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

  componentWillUnmount() {
    //Esto hace un clear a notify cada vez que cambie de ruta.
    const { message } = this.props.notify;
    const { notifyUser } = this.props;

    message && notifyUser(null, null, null);
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

    let nuevoProducto = {};

    if (tieneVariante) {
      nuevoProducto = {
        nombre,
        descripcion,
        marca: marca.id ? marca.id : null,
        categoria: categoria.id ? categoria.id : null,
        sub_categoria: sub_categoria.id ? sub_categoria.id : null,
        precio_compra,
        precio_real,
        variantes: variantes
      };

      nuevoProducto.variantes.forEach(function(obj) {
        obj.variante_tipo = varianteTipoId;
      });
    } else {
      nuevoProducto = {
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

    this.props.addProducto(nuevoProducto).then(() => {
      //Clear state if success
      if (this.props.notify.messageType === "success") {
        this.setState({
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
          variantes: []
        });
      }
      //Luego de unos segundos borro el mensaje
      setTimeout(() => {
        this.props.notifyUser(null, null, null);
      }, 10000);
      window.scrollTo(0, 0);
    });
  };

  handleChange = (item, nombre) => {
    this.setState({ [nombre]: { id: item.value, nombre: item.label } });
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
    if (this.state.variantes.length === 0) {
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
        <h1>Nuevo Producto</h1>
        {//Si hay un mensaje, entonces lo muestro en la alerta.
        notify.message ? (
          <ProductoAlert
            message={notify.message}
            messageType={notify.messageType}
            errors={notify.errors}
          />
        ) : null}
        <Loader loaded={isFetching}>
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
              handleChange={this.handleChange.bind(this)}
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
                newProp={this.newProp.bind(this)}
                notify={notify}
              />
            </div>
            <div className="row-12 mt-5 pt-5 pb-5 mb-5">
              <hr />
              <Link to={`/producto`} className="btn btn-secondary">
                Volver
              </Link>
              <button type="submit" className="btn btn-success float-right">
                Agregar producto
              </button>
            </div>
          </form>
        </Loader>
      </div>
    );
  }
}
const loadingSelector = createLoadingSelector(["FETCH_CATEGORIAS"]);

NewProducto.propTypes = {
  categorias: PropTypes.array.isRequired,
  marcas: PropTypes.array.isRequired,
  subcategorias: PropTypes.array.isRequired,
  varianteTipos: PropTypes.array.isRequired,
  addProducto: PropTypes.func.isRequired,
  isFetching: PropTypes.bool.isRequired,
  notifyUser: PropTypes.func.isRequired,
  notify: PropTypes.object.isRequired
};

const mapStateToProps = state => ({
  notify: state.notify,
  categorias: state.producto.categorias,
  marcas: state.producto.marcas,
  subcategorias: state.producto.subcategorias,
  varianteTipos: state.producto.varianteTipos,
  loading: state.loading,
  isFetching: loadingSelector(state)
});

export default connect(
  mapStateToProps,
  {
    notifyUser,
    getMarcas,
    getCategorias,
    getSubcategorias,
    addProducto,
    getVarianteTipos
  }
)(NewProducto);
