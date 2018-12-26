import React, { Component } from "react";
import ClienteVendedor from "./ClienteVendedor";
import ProductosCaja from "./ProductosCaja";
import VentaCaja from "./VentaCaja";
import { connect } from "react-redux";
import { getProductos } from "../../actions/productosActions";
import { notifyUser } from "../../actions/notifyActions";
import {
  getClientes,
  getVendedores,
  addVenta
} from "../../actions/ventaActions";
import PropTypes from "prop-types";

class Caja extends Component {
  state = {
    productos: [
      {
        id: "",
        codigoDeBarras: "",
        nombre: "",
        cantidad: 0,
        precio: 0,
        variante: ""
      }
    ],
    total: 0,
    descuento: 0,
    ventaTipo: "",
    cliente: "",
    vendedor: JSON.parse(localStorage.getItem("vendedor"))
      ? JSON.parse(localStorage.getItem("vendedor"))
      : ""
  };

  componentDidMount() {
    this.props.getProductos();
    this.props.getVendedores();
    this.props.getClientes();
  }
  //Descuento, ventaTipo
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
          setProducto = {
            id: dbProducto.id,
            nombre: dbProducto.nombre,
            precio: dbProducto.precio,
            codigoDeBarras: dbProducto.codigo_de_barras,
            cantidad: dbProducto.cantidad,
            variante: false
          };
        else if (dbProducto.variantes) {
          dbProducto.variantes.forEach(variante => {
            if (e.target.value === variante.codigo_de_barras) {
              setProducto = {
                id: variante.id,
                nombre: variante.nombre,
                precio: variante.precio,
                codigoDeBarras: variante.codigo_de_barras,
                cantidad: variante.cantidad,
                variante: true
              };
            }
          });
        }
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
  onProductoSelectChange = idx => e => {
    const newProducto = this.state.productos.map((producto, sidx) => {
      if (idx !== sidx) return producto;
      let setProducto;
      this.props.productos.map(dbProducto => {
        if (e.nombre === "individual") {
          if (e.value === dbProducto.id)
            setProducto = {
              id: dbProducto.id,
              nombre: dbProducto.nombre,
              precio: dbProducto.precio,
              codigoDeBarras: dbProducto.codigo_de_barras,
              cantidad: dbProducto.cantidad,
              variante: false
            };
        } else if (e.nombre === "variante") {
          let varId = e.value.replace("var", "");
          varId = Number(varId);
          if (dbProducto.variantes) {
            dbProducto.variantes.forEach(variante => {
              if (varId === variante.id) {
                setProducto = {
                  id: variante.id,
                  nombre: variante.nombre,
                  precio: variante.precio,
                  codigoDeBarras: variante.codigo_de_barras,
                  cantidad: variante.cantidad,
                  variante: true
                };
              }
            });
          }
        }
      });

      if (setProducto) {
        return setProducto;
      } else {
        return { ...producto, producto: e.value };
      }
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
      e.target.parentElement.previousSibling === null &&
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
  };

  onClienteVendedorChange = item => {
    //Asigno al vendedor al LocalStorage
    if (item.nombre === "vendedor") {
      localStorage.setItem(
        "vendedor",
        JSON.stringify({ id: item.value, nombre: item.label })
      );
    }
    this.setState({ [item.nombre]: { id: item.value, nombre: item.label } });
  };
  onSubmit = e => {
    const totalInput = document.getElementById("total").value;
    this.setState({ total: totalInput });
    e.preventDefault();
    const {
      productos,
      total,
      descuento,
      ventaTipo,
      cliente,
      vendedor
    } = this.state;
    let ventaDetalle = [];
    productos.forEach(producto => {
      ventaDetalle = [
        ...ventaDetalle,
        {
          producto: producto.id,
          cantidad: producto.cantidad,
          precio: producto.precio,
          variante: producto.variante
        }
      ];
    });
    const venta = {
      cliente: cliente.id,
      vendedor: vendedor.id,
      formaDePago: ventaTipo,
      descuento: descuento ? descuento : 0,
      total
    };
    const data = { venta, ventaDetalle };
    this.props.addVenta(data).then(() => {
      //Clear state if success
      if (this.props.notify.messageType === "success") {
        this.setState({
          productos: [
            {
              id: "",
              codigoDeBarras: "",
              nombre: "",
              cantidad: 0,
              precio: 0
            }
          ],
          total: 0,
          descuento: 0,
          ventaTipo: "",
          cliente: ""
        });
      }
      window.scrollTo(0, 0);
      //Luego de unos segundos borro el mensaje
      setTimeout(() => {
        this.props.notifyUser(null, null, null);
      }, 10000);
    });
  };

  render() {
    document.title = "Caja";
    const { productos, descuento, ventaTipo, cliente, vendedor } = this.state;
    const inputs = Array.from(document.getElementsByClassName("form-control"));

    if (inputs) {
      inputs.forEach(input => {
        if (input.name === "precio") {
          input.addEventListener("blur", this.onTab);
          input.addEventListener("keydown", this.onTab);
        }
      });
    }

    //Habilitar el Select para elegir el producto.

    document.querySelectorAll("input.productoInput").forEach(productoInput => {
      productoInput.addEventListener("dblclick", e => {
        e.target.classList.add("d-none");
        e.target.parentElement.firstChild.classList.remove("d-none");
      });
    });

    return (
      <React.Fragment>
        <ClienteVendedor
          clientes={this.props.clientes}
          vendedores={this.props.vendedores}
          cliente={cliente}
          vendedor={vendedor}
          onClienteVendedorChange={this.onClienteVendedorChange.bind(this)}
        />

        <ProductosCaja
          onProductoChange={this.onProductoChange.bind(this)}
          onProductoSelectChange={this.onProductoSelectChange.bind(this)}
          onCodigoDeBarrasChange={this.onCodigoDeBarrasChange.bind(this)}
          productos={productos}
          dbProductos={this.props.productos}
          handleRemoveProducto={this.handleRemoveProducto.bind(this)}
        />

        <VentaCaja
          notify={this.props.notify}
          onSubmit={this.onSubmit.bind(this)}
          descuento={descuento}
          onChange={this.onChange.bind(this)}
          productos={productos}
          ventaTipo={ventaTipo}
        />
      </React.Fragment>
    );
  }
}

Caja.propTypes = {
  productos: PropTypes.array.isRequired,
  getProductos: PropTypes.func.isRequired,
  getClientes: PropTypes.func.isRequired,
  getVendedores: PropTypes.func.isRequired,
  addVenta: PropTypes.func.isRequired,
  notifyUser: PropTypes.func.isRequired
};

const mapStateToProps = state => ({
  productos: state.producto.productos,
  clientes: state.venta.clientes,
  vendedores: state.venta.vendedores,
  notify: state.notify
});

export default connect(
  mapStateToProps,
  { getProductos, getClientes, getVendedores, addVenta, notifyUser }
)(Caja);
