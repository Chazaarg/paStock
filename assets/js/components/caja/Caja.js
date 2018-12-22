import React, { Component } from "react";
import ClienteVendedor from "./ClienteVendedor";
import ProductosCaja from "./ProductosCaja";
import VentaCaja from "./VentaCaja";
import { connect } from "react-redux";
import { getProductos } from "../../actions/productosActions";
import PropTypes from "prop-types";

class Caja extends Component {
  state = {
    productos: [
      {
        codigoDeBarras: "",
        nombre: "",
        cantidad: 0,
        precio: 0
      }
    ],
    total: 0,
    descuento: 0,
    ventaTipo: ""
  };

  componentDidMount() {
    this.props.getProductos();
  }

  onChange = e => {
    this.setState({
      [e.target.name]: e.target.value
    });
  };

  onCodigoDeBarrasChange = idx => e => {
    const newProducto = this.state.productos.map((producto, sidx) => {
      if (idx !== sidx) return producto;
      let setProducto;
      this.props.productos.map(dbProducto => {
        if (e.target.value === dbProducto.codigo_de_barras)
          setProducto = dbProducto;
      });

      if (setProducto) {
        return setProducto;
      } else {
        return { ...producto, [e.target.name]: e.target.value };
      }
    });

    this.setState({ productos: newProducto });
  };

  onProductoChange = idx => e => {
    const newProducto = this.state.productos.map((producto, sidx) => {
      if (idx !== sidx) return producto;
      return { ...producto, [e.target.name]: e.target.value };
    });

    this.setState({ productos: newProducto });
  };

  handleAddProducto = () => {
    this.setState({
      productos: this.state.productos.concat([
        {
          codigoDeBarras: "",
          nombre: "",
          cantidad: 0,
          precio: 0
        }
      ])
    });
  };
  handleRemoveProducto = idx => e => {
    //Si es la única fila, entonces vacía la seleccionada.
    if (
      e.target.parentElement.previousSibling.previousSibling === null &&
      e.target.parentElement.nextSibling === null
    ) {
      this.setState({
        productos: [
          {
            codigoDeBarras: "",
            nombre: "",
            cantidad: 0,
            precio: 0
          }
        ]
      });
    }

    //Si hay otras filas, entonces elimina la seleccionada.
    else {
      this.setState({
        productos: this.state.productos.filter((s, sidx) => idx !== sidx)
      });
    }
  };

  onTab = e => {
    //Si se pulsa TAB y si se trata de la última fila.
    if (
      e.which === 9 &&
      e.target.parentElement.parentElement.nextSibling === null
    ) {
      this.handleAddProducto();
    }

    let total = 0;
    this.state.productos.map(producto => {
      total += Math.round(Number(producto.precio)) * producto.cantidad;
    });
    if (this.state.ventaTipo === "Efectivo") {
      total = Math.round(total / 1.15);
    }

    this.setState({ total });
  };

  aplicarDescuento = e => {
    let input = document.getElementById("descuento");

    //Al total le sumo el descuento anterior.
    let total = Number(this.state.total) + Number(this.state.descuento);

    //Y le resto el nuevo.
    total = total - input.value;

    this.setState({
      total,
      descuento: input.value
    });
  };

  render() {
    document.title = "Caja";
    const { productos, total, descuento, ventaTipo } = this.state;
    const inputs = Array.from(document.getElementsByClassName("form-control"));

    if (inputs) {
      inputs.forEach(input => {
        if (input.name === "precio") {
          input.addEventListener("blur", this.onTab);
          input.addEventListener("keydown", this.onTab);
        }
      });
    }

    return (
      <React.Fragment>
        <ClienteVendedor />

        <ProductosCaja
          onProductoChange={this.onProductoChange.bind(this)}
          onCodigoDeBarrasChange={this.onCodigoDeBarrasChange.bind(this)}
          productos={productos}
          handleRemoveProducto={this.handleRemoveProducto.bind(this)}
        />

        <VentaCaja
          total={total}
          descuento={descuento}
          onChange={this.onChange.bind(this)}
          ventaTipo={ventaTipo}
          aplicarDescuento={this.aplicarDescuento.bind(this)}
        />
      </React.Fragment>
    );
  }
}

Caja.propTypes = {
  productos: PropTypes.array.isRequired,
  getProductos: PropTypes.func.isRequired
};

const mapStateToProps = state => ({
  productos: state.producto.productos
});

export default connect(
  mapStateToProps,
  { getProductos }
)(Caja);
