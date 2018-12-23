import React, { Component } from "react";
import ProductoCaja from "./ProductoCaja";

class ProductosCaja extends Component {
  render() {
    const {
      onProductoChange,
      onCodigoDeBarrasChange,
      productos,
      handleRemoveProducto
    } = this.props;

    return (
      <div className="row-12">
        <div className="row-11 pb-3 d-flex justify-content-start ml-1">
          <div className="col-3">
            <h4 style={{ fontSize: "1.4rem" }}>&nbsp;&nbsp;Código de Barras</h4>
          </div>
          <div className="col-5">
            <h4 style={{ fontSize: "1.4rem" }}>&nbsp;&nbsp;Producto</h4>
          </div>
          <div className="col-2">
            <h4 style={{ fontSize: "1.4rem" }}>&nbsp;&nbsp;Cantidad</h4>
          </div>
          <div className="col-2">
            <h4 style={{ fontSize: "1.4rem" }}>&nbsp;&nbsp;Precio</h4>
          </div>
        </div>

        {productos.map((producto, idx) => (
          <ProductoCaja
            handleRemoveProducto={handleRemoveProducto}
            key={idx}
            idx={idx}
            producto={producto}
            onProductoChange={onProductoChange}
            onCodigoDeBarrasChange={onCodigoDeBarrasChange}
          />
        ))}
      </div>
    );
  }
}

export default ProductosCaja;